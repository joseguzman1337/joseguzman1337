<?php
session_start();
include_once(realpath(dirname(__FILE__)).'/../../../../../utilidades/ValidarSesion.php');
$ValidarSesion = new ValidarSesion();     $ValidarSesion->Validar($_SESSION);

/************************************************
+-----------------------------------------------+
|		PROYECTO: ADMINISTRAR SUBGRUPOS			|
+-----------------------------------------------+
|												|
| 	PARTE 1: VERIFICA SI HAY POST Y GUARDA 		|
|	LOS DATOS.									|
|												|
|	PARTE 2: ELIMINAR SUBGRUPO.					|
|												|
|	PARTE 3: ACTUALIZAR SUBGRUPO INTERFAZ.		|
|												|
|	PARTE 3.5: GUARDAR ACTUALIZACION.			|
|												|
|	PARTE 4: OBTENER ID SUBGRUPO, ESTUDIANTES  	|
|	MATRICULADOS Y CARGAR LA VISTA  			|
|	PARA CREAR NUEVOS + VISUALIZAR LOS 	  		|
|	YA EXISTENTES.								|
|												|
+-----------------------------------------------+
 ************************************************/

$rutaVistas = "../view"; /*carpeta donde se guardaran las vistas (html) de la aplicación */
require_once(realpath(dirname(__FILE__))."/../../../../../../Mustache/load.php"); /*Ruta a /html/Mustache */
$template_index = $mustache->loadTemplate('subgrupos'); /*carga la plantilla index*/
$template_update = $mustache->loadTemplate('update'); /*carga la plantilla para actualizar*/
$template_listas = $mustache->loadTemplate('listas'); /*carga la plantilla para actualizar*/
$template_pdfs = $mustache->loadTemplate('pdfs'); /*carga la plantilla del pdf*/
$template_updaterotacion = $mustache->loadTemplate('updaterotacion'); /*carga la plantilla del pdf*/

session_start();
include_once (realpath(dirname(__FILE__)).'/../../../../../EspacioFisico/templates/template.php');
$db = getBD();
$idgrupo = $_REQUEST['idgrupo'];
$periodo = $_SESSION['codigoperiodosesion'];
$codigomateria = $_REQUEST['materia'];


$codigomateria = filter_var($codigomateria,FILTER_SANITIZE_NUMBER_INT);

/*busqueda en multiples array*/
function in_array_r($needle, $haystack, $strict = false) {
    foreach ($haystack as $item) {
        if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_array_r($needle, $item, $strict))) {
            return true;
        }
    }
    return false;
}


/* INICIO PARTE 1 */
if(isset($_REQUEST['save']))
{
    $SQL_User="SELECT idusuario as id FROM usuario WHERE usuario='".$_SESSION['MM_Username']."'";
    $Usario_id=$db->GetRow($SQL_User);

    $userid=$Usario_id['id'];
    $sizeSub = $_POST['sizeSub'];
    $codigomateria = $_POST['codigomateria'];
    $sizeSub = filter_var($sizeSub,FILTER_SANITIZE_NUMBER_INT);

    if($sizeSub!=0 || $sizeSub!='0')
    {
        $SQL1 = "INSERT INTO Subgrupos (idgrupo, codigomateria, NombreSubgrupo, MaximoCupo, codigoestado, UsuarioCreacion, FechaCreacion,UsuarioUltimaModificacion,FechaUltimaModificacion, codigoperiodo) VALUES ('".$idgrupo."', '".$codigomateria."','".$_POST['nombre']."','".$sizeSub."', '100', '".$userid."', NOW(),'".$userid."', NOW(),'".$periodo."')";
        $db->Execute($SQL1);
        $idsubgrupo = $db->Insert_ID();
        $cantidadestudiantes = 0;
        foreach($_POST['estudiantes'] as $e)
        {
            $SQL = "INSERT INTO SubgruposEstudiantes (idestudiantegeneral, SubgrupoId, codigoestado, UsuarioCreacion, FechaCreacion) VALUES ('".$e."', '".$idsubgrupo."', '100', '".$userid."', NOW())";
            $db->Execute($SQL);
            $cantidadestudiantes++;
        }
        //si la cantidad de estudiantes agregados es diferente al numero maximo del grupo, el numero maximo del grupo se modificará.
        if($cantidadestudiantes <> $sizeSub)
        {
            $sqlupdate = "UPDATE Subgrupos SET MaximoCupo='".$cantidadestudiantes."' WHERE (SubgrupoId='".$idsubgrupo."')";
            $db->Execute($sqlupdate);
        }
        // se muestra la alterta de modificacion correcta.
        echo "<script>alert('Registro insertado correctamente'); 
            location.href='subgrupos.php?materia=".$codigomateria."&idgrupo=".$idgrupo."';</script>";
    }//!=0
}
/* FIN PARTE 1*/

/* INICIO PARTE 2 */

if(isset($_REQUEST['delete'])){
    $periodo = $_SESSION['codigoperiodosesion'];
    $SubgrupoId = $_REQUEST[SubgrupoId];
    $codigomateria = $_REQUEST[materia];

    $SQL_User="SELECT idusuario as id FROM usuario WHERE usuario='".$_SESSION['MM_Username']."'";
    $Usario_id=$db->GetRow($SQL_User);
    $userid=$Usario_id['id'];

    $rotacion = "select count(*) as id from RotacionEstudiantes where codigomateria = '".$codigomateria."' and codigoperiodo ='".$periodo."' and SubgrupoId = '".$SubgrupoId."' and codigoestado = '100'";
    $cantidadrotacion = $db->GetRow($rotacion);

    if($cantidadrotacion['id'] > '0')
    {
        echo "<script>alert('No se puede eliminar el subgrupo por que tiene rotaciones activas.')</script>";
    }else
    {
        $SQL = "UPDATE Subgrupos SET codigoestado = '200', UsuarioUltimaModificacion = '".$userid."', FechaUltimaModificacion = NOW() WHERE SubgrupoId = '".$_REQUEST['SubgrupoId']."';";
        $ejecutar = $db->Execute($SQL);
        $SQL = "UPDATE SubgruposEstudiantes SET codigoestado = '200', UsuarioUltimaModificacion = '".$userid."', FechaUltimaModificacion = NOW() WHERE SubgrupoId = '".$_REQUEST['SubgrupoId']."';";
        $ejecutar = $db->Execute($SQL);
        echo "<script>alert('Registro borrado correctamente');location.href='subgrupos.php?materia=".$codigomateria."&idgrupo=".$idgrupo."';</script>";
    }
}

/* FIN PARTE 2 */

/* INICIO PARTE 3 */

if(isset($_REQUEST['update'])){
    $SQL = "SELECT NombreSubgrupo, MaximoCupo
				FROM
					Subgrupos
				WHERE
					SubgrupoId = '".$_REQUEST['SubgrupoId']."'";
    $nombre=$db->GetRow($SQL);
    $nombreSubgrupo = $nombre['NombreSubgrupo'];
    $MaximoCupo = $nombre['MaximoCupo'];

    $SQL = "SELECT *
            	FROM SubgruposEstudiantes
				WHERE
					codigoestado = '100'
				AND SubgrupoId = '".$_REQUEST['SubgrupoId']."'";
    $estudiantesEnSubgrupo=$db->GetAll($SQL);

    $sqlmateria = "select g.codigomateria from grupo g where g.idgrupo = '".$_REQUEST['idgrupo']."'";
    $numeromateria = $db->GetRow($sqlmateria);

    $SQL = 'SELECT
				eg.idestudiantegeneral,
				CONCAT(
					eg.apellidosestudiantegeneral,
					" ",
					eg.nombresestudiantegeneral,
					" - ",
					eg.numerodocumento
				) AS datos_estudiante
			FROM
				prematricula p
			INNER JOIN detalleprematricula d ON d.idprematricula = p.idprematricula
			INNER JOIN estudiante e ON p.codigoestudiante = e.codigoestudiante
			INNER JOIN estudiantegeneral eg ON e.idestudiantegeneral = eg.idestudiantegeneral
            
			WHERE
			     p.codigoestadoprematricula IN (40, 41)
			AND d.codigoestadodetalleprematricula = 30
            and d.codigomateria = '.$codigomateria.' and p.codigoperiodo = '.$periodo.'
			
            GROUP BY eg.idestudiantegeneral
			ORDER BY
				eg.apellidosestudiantegeneral';
    $info_estudiantes = $db->GetAll($SQL);

    $select = '<select data-placeholder="Escojer estudiantes..." class="chosen-select" multiple name="estudiantes[]">';
    foreach($info_estudiantes as $ie){
        if(in_array_r($ie['idestudiantegeneral'], $estudiantesEnSubgrupo)){
            $select .= '<option selected value="'.$ie['idestudiantegeneral'].'">'.$ie['datos_estudiante'].'</option>';
        }else{
            $select .= '<option value="'.$ie['idestudiantegeneral'].'">'.$ie['datos_estudiante'].'</option>';
        }
    }
    $select .= '</select>';

    echo $template_update->render(array(
            'title' => 'Administrar Subgrupos',
            'select' => $select,
            'idgrupo' => $idgrupo,
            'materia' => $codigomateria,
            'nombreSubgrupo' => $nombreSubgrupo,
            'MaximoCupo' => $MaximoCupo,
            'SubgrupoId' => $_REQUEST['SubgrupoId']
        )
    );
    die;
}

/* FIN PARTE 3 */

/* INICIO PARTE 3.5 */

if(isset($_REQUEST['update_save'])){

    $SQL_User="SELECT idusuario as id FROM usuario WHERE usuario='".$_SESSION['MM_Username']."'";
    $Usario_id=$db->GetRow($SQL_User);
    $userid=$Usario_id['id'];

    $periodo = $_SESSION['codigoperiodosesion'];
    $SubgrupoId = $_REQUEST[SubgrupoId];
    $codigomateria = $_REQUEST[materia];

    $rotacion = "select count(*) as id from RotacionEstudiantes where codigomateria = '".$codigomateria."' and codigoperiodo ='".$periodo."' and SubgrupoId = '".$SubgrupoId."' and codigoestado = '100'";
    $cantidadrotacion = $db->GetRow($rotacion);
    if($cantidadrotacion['id'] > '0')
    {
        $sqlSubgrupo = "select s.NombreSubgrupo, s.MaximoCupo from Subgrupos s where s.SubgrupoId = '".$SubgrupoId."'";
        $subgrupodatos = $db->GetRow($sqlSubgrupo);

        if($subgrupodatos['NombreSubgrupo'] != $_REQUEST['nombre'])
        {
            $SQL = "UPDATE Subgrupos 
					SET NombreSubgrupo = '".$_REQUEST['nombre']."', 
					UsuarioUltimaModificacion = '".$userid."', 
					FechaUltimaModificacion = NOW() 
					WHERE SubgrupoId = '".$_REQUEST['SubgrupoId']."'";
            $db->Execute($SQL);

            echo '<script>alert("registro modificado correctamente");</script>';

        }else
        {
            echo '<script>alert("No es posible actualizar el Subgrupo, porque actualmente tiene rotaciones ya activas");</script>';

        }
    }else
    {
        /* ACTUALIZACION DE ESTUDIANTES PERTENECIENTES AL SUBGRUPO */

        $SQL = "UPDATE SubgruposEstudiantes SET codigoestado = '200', UsuarioUltimaModificacion = '".$userid."', FechaUltimaModificacion = NOW() WHERE SubgrupoId = '".$_REQUEST['SubgrupoId']."'";
        $db->Execute($SQL);
        $numero_estudiantes=0;
        foreach($_REQUEST['estudiantes'] as $e){
            $SQL = "SELECT * FROM SubgruposEstudiantes WHERE idestudiantegeneral = '".$e."' AND SubgrupoId = '".$_REQUEST['SubgrupoId']."' LIMIT 1";
            $Resultado=$db->Execute($SQL);
            if($Resultado->_numOfRows == 0){

                $SQL = 'INSERT INTO SubgruposEstudiantes (idestudiantegeneral, SubgrupoId, codigoestado, UsuarioCreacion, FechaCreacion) VALUES ("'.$e.'", "'.$_REQUEST['SubgrupoId'].'", 100, "'.$userid.'", NOW());';
                $db->Execute($SQL);
            }else{
                $SQL = 'UPDATE SubgruposEstudiantes SET codigoestado = 100, UsuarioUltimaModificacion = '.$userid.', FechaUltimaModificacion = NOW() WHERE SubgrupoId = '.$_REQUEST['SubgrupoId'].' AND idestudiantegeneral = '.$e;
                $db->Execute($SQL);
            }
            $numero_estudiantes++;
        }

        if($numero_estudiantes != $_REQUEST['sizeSub'])
        {
            $_REQUEST['sizeSub']=  $numero_estudiantes;
        }

        $SQL = "UPDATE Subgrupos 
					SET NombreSubgrupo = '".$_REQUEST['nombre']."', 
                    MaximoCupo = '".$_REQUEST['sizeSub']."',
					UsuarioUltimaModificacion = '".$userid."', 
					FechaUltimaModificacion = NOW() 
					WHERE SubgrupoId = '".$_REQUEST['SubgrupoId']."'";
        $db->Execute($SQL);


        /* FIN DE ACTUALIZACION DE ESTUDIANTES PERTENECIENTES AL SUBGRUPO */
        echo '<script>alert("registro modificado correctamente");</script>';
    }
}
/*INICIO PARTE 3.6*/
if(isset($_REQUEST['updaterotacion']))
{
    $codigomateria = $_REQUEST['materia'];
    $institucion = $_REQUEST['institucion'];
    $SqlDatosrotaciones = "SELECT ma.nombremateria, ma.codigomateria, ma.codigocarrera, re.FechaIngreso, re.FechaEgreso, re.codigomateria, re.codigoperiodo, re.TotalDias, re.IdInstitucion, re.idsiq_convenio, er.NombreEstado, re.TotalHoras, sg.NombreSubgrupo, re.JornadaId, jr.Jornada, re.EstadoRotacionId, re.RotacionEstudianteId, eg.numerodocumento, CONCAT(eg.nombresestudiantegeneral, ' ', eg.apellidosestudiantegeneral) as nombre FROM RotacionEstudiantes re INNER JOIN Subgrupos sg ON sg.SubgrupoId = re.SubgrupoId INNER JOIN materia ma ON ma.codigomateria = re.codigomateria INNER JOIN EstadoRotaciones er ON er.EstadoRotacionId = re.EstadoRotacionId INNER JOIN UbicacionInstituciones ui ON ui.IdUbicacionInstitucion = re.IdUbicacionInstitucion INNER JOIN InstitucionConvenios ic ON ic.InstitucionConvenioId = ui.InstitucionConvenioId INNER JOIN JornadaRotaciones jr ON jr.JornadaRotacionesId = re.JornadaId INNER JOIN estudiante e ON e.codigoestudiante = re.codigoestudiante INNER JOIN estudiantegeneral eg ON eg.idestudiantegeneral = e.idestudiantegeneral WHERE sg.codigomateria = '".$codigomateria."' and re.SubgrupoId = '".$_REQUEST['SubgrupoId']."' and re.IdInstitucion = '".$institucion."' ORDER BY re.FechaIngreso";
    $DatosRotacion = $db->GetRow($SqlDatosrotaciones);

    $sqljornada = "select JornadaRotacionesId as id, Jornada from JornadaRotaciones where CodigoEstado='100'";
    $datosjornadas = $db->GetAll($sqljornada);

    switch($DatosRotacion['EstadoRotacionId'])
    {
        case '1':{$Estados[] = array('idestado'=>'1', 'estado'=>'Activo', 'selected'=>'selected');$Estados[] = array('idestado'=>'2', 'estado'=>'Finalizado', 'selected'=>' ');$Estados[] = array('idestado'=>'3', 'estado'=>'Desactivado', 'selected'=>' ');}break;
        case '2':{$Estados[] = array('idestado'=>'1', 'estado'=>'Activo', 'selected'=>' ');$Estados[] = array('idestado'=>'2', 'estado'=>'Finalizado', 'selected'=>'selected');$Estados[] = array('idestado'=>'3', 'estado'=>'Desactivado', 'selected'=>' ');}break;
        case '3':{$Estados[] = array('idestado'=>'1', 'estado'=>'Activo', 'selected'=>' ');$Estados[] = array('idestado'=>'2', 'estado'=>'Finalizado', 'selected'=>' ');$Estados[] = array('idestado'=>'3', 'estado'=>'Desactivado', 'selected'=>'selected');}break;
    }
    $servicios = "SELECT ec.EspecialidadCarreraId, ec.Especialidad FROM EspecialidadCarrera ec WHERE ec.codigocarrera = '".$DatosRotacion['codigocarrera']."' and CodigoEstado ='100';";
    $datosservicios = $db->GetAll($servicios);
    $r=1;
    foreach($datosservicios as $serviciosd)
    {
        $sqlEspeciliadades = "select CodigoEstado from RotacionEspecialidades re where  re.EspecialidadCarreraId = '".(int)$serviciosd['EspecialidadCarreraId']."' and RotacionEstudianteId = '".$DatosRotacion['RotacionEstudianteId']."';";
        $estado = $db->GetRow($sqlEspeciliadades);

        if($estado['CodigoEstado']=='100'){$check='checked';}else{$check=' ';}
        $EspecialidadData[] = array('id'=>(int)$serviciosd['EspecialidadCarreraId'], 'Especialidad' => $serviciosd['Especialidad'], 'numero'=> $r, 'check'=>$check);
        $r++;
    }

    $estudiantes = "SELECT  re.RotacionEstudianteId as id, eg.numerodocumento as Cedula, CONCAT(eg.nombresestudiantegeneral, ' ', eg.apellidosestudiantegeneral) as Nombre FROM RotacionEstudiantes re INNER JOIN Subgrupos sg ON sg.SubgrupoId = re.SubgrupoId INNER JOIN estudiante e ON e.codigoestudiante = re.codigoestudiante INNER JOIN estudiantegeneral eg ON eg.idestudiantegeneral = e.idestudiantegeneral WHERE sg.idgrupo = '".$idgrupo."' AND re.SubgrupoId = '".$_REQUEST['SubgrupoId']."' ORDER BY re.FechaIngreso;";
    $estudiantesdata = $db->GetAll($estudiantes);

    $sqldetallerotacion = "select NombreDocenteCargo, EmailDocente, TelefonoDocente, CodigoDia from DetalleRotaciones where RotacionEstudianteId = '".$estudiantesdata[0]['id']."' and codigoEstado= '100'";
    $detallesrotacion = $db->GetAll($sqldetallerotacion);

    foreach($detallesrotacion as $dias)
    {
        switch($dias['CodigoDia'])
        {
            case '1':{$dia1='checked';}break;
            case '2':{$dia2='checked';}break;
            case '3':{$dia3='checked';}break;
            case '4':{$dia4='checked';}break;
            case '5':{$dia5='checked';}break;
            case '6':{$dia6='checked';}break;
            case '7':{$dia7='checked';}break;
        }
    }
    $convenios = "select c.ConvenioId as id, c.NombreConvenio as Nombre from Convenios c where c.idsiq_estadoconvenio = '1';";
    $conveniosdata=$db->GetAll($convenios);

    $convenio = "SELECT c.ConvenioId AS id, c.NombreConvenio AS Nombre, ic.InstitucionConvenioId as idinstitucion, ic.NombreInstitucion as NombreInstitucion, re.IdUbicacionInstitucion as ubicacion, u.NombreUbicacion
        FROM Convenios c INNER JOIN RotacionEstudiantes re ON re.idsiq_convenio = c.ConvenioId 
        INNER JOIN InstitucionConvenios ic ON ic.InstitucionConvenioId = c.InstitucionConvenioId
        INNER JOIN UbicacionInstituciones u ON u.IdUbicacionInstitucion = re.IdUbicacionInstitucion 
        WHERE c .idsiq_estadoconvenio = '1' AND re.RotacionEstudianteId = '".$estudiantesdata[0]['id']."' ;";
    $convenioactivo=$db->GetRow($convenio);

    $ubicaciones = "SELECT u.IdUbicacionInstitucion, u.NombreUbicacion from UbicacionInstituciones u where u.InstitucionConvenioId = '".$convenioactivo['idinstitucion']."'";
    $listaubicaciones = $db->GetAll($ubicaciones);

    echo $template_updaterotacion->render(array(
            'title' => 'Detalles rotaciones Subgrupos',
            'idgrupo' => $idgrupo,
            'Carrera' => $DatosRotacion['codigocarrera'],
            'SubgrupoId' => $_REQUEST['SubgrupoId'],
            'codigoperiodo' => $DatosRotacion['codigoperiodo'],
            'FechaIngreso' => $DatosRotacion['FechaIngreso'],
            'FechaEgreso' => $DatosRotacion['FechaEgreso'],
            'nombremateria' => $DatosRotacion['nombremateria'],
            'codigomateria' => $codigomateria,
            'TotalDias' => (int)$DatosRotacion['TotalDias'],
            'TotalHoras' => (int)$DatosRotacion['TotalHoras'],
            'NombreSubgrupo' => $DatosRotacion['NombreSubgrupo'],
            'Jornada' => $DatosRotacion['Jornada'],
            'JornadaId' => $DatosRotacion['JornadaId'],
            'Docente' => $detallesrotacion[0]['NombreDocenteCargo'],
            'Docenteemail' => $detallesrotacion[0]['EmailDocente'],
            'Docentetelefono' => $detallesrotacion[0]['TelefonoDocente'],
            'dia1' => $dia1,
            'dia2' => $dia2,
            'dia3' => $dia3,
            'dia4' => $dia4,
            'dia5' => $dia5,
            'dia6' => $dia6,
            'dia7' => $dia7,
            'estado' => $Estados,
            'JornadaData' => $datosjornadas,
            'EspcialidaData' => $EspecialidadData,
            'Estudiantes' => $estudiantesdata,
            'Conveniosdata' => $conveniosdata,
            'Convenio' => $convenioactivo['Nombre'],
            'IdConvenio' => $convenioactivo['id'],
            'idinstitucion' => $convenioactivo['idinstitucion'],
            'NombreUbicacion'=> $convenioactivo['NombreUbicacion'],
            'ubicacion' => $convenioactivo['ubicacion'],
            'listaubicaciones' =>$listaubicaciones
        )
    );
    die;
}


/*FIN PARTE 3.6*/

if(isset($_REQUEST['lista'])){

    $SQL_User="SELECT idusuario as id FROM usuario WHERE usuario='".$_SESSION['MM_Username']."'";
    $Usario_id=$db->GetRow($SQL_User);

    $SQL = 'SELECT
					NombreSubgrupo,
                    MaximoCupo
				FROM
					Subgrupos
				WHERE
					SubgrupoId = '.$_REQUEST['SubgrupoId'];
    if($nombre=&$db->Execute($SQL)===false){
        echo 'Error en el SQL Userid...<br />';
        die;
    }

    $SqlDatosrotaciones = "Select (@row:=@row+1) AS row, re.RotacionEstudianteId, ma.nombremateria, eg.idestudiantegeneral, re.FechaIngreso, re.FechaEgreso, re.codigomateria,	re.codigoperiodo, re.TotalDias,  eg.nombresestudiantegeneral, eg.apellidosestudiantegeneral, eg.numerodocumento, re.IdInstitucion, re.idsiq_convenio, er.NombreEstado, CONCAT( 	ic.NombreInstitucion, '-', 	ui.NombreUbicacion) as lugarRotacion, re.TotalHoras from (SELECT @ROW:=0) r,RotacionEstudiantes re INNER JOIN Subgrupos sg ON sg.SubgrupoId = re.SubgrupoId INNER JOIN estudiante e ON e.codigoestudiante = re.codigoestudiante INNER JOIN estudiantegeneral eg ON eg.idestudiantegeneral = e.idestudiantegeneral INNER JOIN materia ma ON ma.codigomateria = re.codigomateria INNER JOIN EstadoRotaciones er ON er.EstadoRotacionId = re.EstadoRotacionId INNER JOIN UbicacionInstituciones ui ON ui.IdUbicacionInstitucion = re.IdUbicacionInstitucion INNER JOIN InstitucionConvenios ic ON ic.InstitucionConvenioId = ui.InstitucionConvenioId where sg.codigomateria = '".$codigomateria."' and re.SubgrupoId = '".$_REQUEST['SubgrupoId']."' and re.codigoperiodo = '".$_SESSION['codigoperiodosesion']."' ORDER BY row;";
    $listaRotaciones = $db->GetAll($SqlDatosrotaciones);

    $lugar ='';
    $c=0;
    $i=0;
    $rotaciones = array();
    foreach($listaRotaciones as $consultas)
    {
        if($lugar=='')
        {
            $lugar = $consultas['lugarRotacion'];
            $rotaciones[$i]['datos']['IdInstitucion'] = $consultas['IdInstitucion'];
            $rotaciones[$i]['rotacion'][$c]['row'] = $consultas['row'];
            $rotaciones[$i]['rotacion'][$c]['lugarRotacion'] = $consultas['lugarRotacion'];
            $rotaciones[$i]['rotacion'][$c]['RotacionEstudianteId'] = $consultas['RotacionEstudianteId'];
            $rotaciones[$i]['rotacion'][$c]['nombremateria'] = $consultas['nombremateria'];
            $rotaciones[$i]['rotacion'][$c]['idestudiantegeneral'] = $consultas['idestudiantegeneral'];
            $rotaciones[$i]['rotacion'][$c]['FechaIngreso'] = $consultas['FechaIngreso'];
            $rotaciones[$i]['rotacion'][$c]['FechaEgreso'] = $consultas['FechaEgreso'];
            $rotaciones[$i]['rotacion'][$c]['codigomateria'] = $consultas['codigomateria'];
            $rotaciones[$i]['rotacion'][$c]['codigoperiodo'] = $consultas['codigoperiodo'];
            $rotaciones[$i]['rotacion'][$c]['TotalDias'] = $consultas['TotalDias'];
            $rotaciones[$i]['rotacion'][$c]['nombresestudiantegeneral'] = $consultas['nombresestudiantegeneral'];
            $rotaciones[$i]['rotacion'][$c]['apellidosestudiantegeneral'] = $consultas['apellidosestudiantegeneral'];
            $rotaciones[$i]['rotacion'][$c]['numerodocumento'] = $consultas['numerodocumento'];
            $rotaciones[$i]['rotacion'][$c]['IdInstitucion'] = $consultas['IdInstitucion'];
            $rotaciones[$i]['rotacion'][$c]['idsiq_convenio'] = $consultas['idsiq_convenio'];
            $rotaciones[$i]['rotacion'][$c]['NombreEstado'] = $consultas['NombreEstado'];
            $rotaciones[$i]['rotacion'][$c]['TotalHoras'] = $consultas['TotalHoras'];
        }
        else
        {
            if($lugar == $consultas['lugarRotacion'])
            {
                $rotaciones[$i]['rotacion'][$c]['row'] =  $consultas['row'];
                $rotaciones[$i]['rotacion'][$c]['lugarRotacion'] =  $lugar;
                $rotaciones[$i]['rotacion'][$c]['RotacionEstudianteId'] = $consultas['RotacionEstudianteId'];
                $rotaciones[$i]['rotacion'][$c]['nombremateria'] = $consultas['nombremateria'];
                $rotaciones[$i]['rotacion'][$c]['idestudiantegeneral'] = $consultas['idestudiantegeneral'];
                $rotaciones[$i]['rotacion'][$c]['FechaIngreso'] = $consultas['FechaIngreso'];
                $rotaciones[$i]['rotacion'][$c]['FechaEgreso'] = $consultas['FechaEgreso'];
                $rotaciones[$i]['rotacion'][$c]['codigomateria'] = $consultas['codigomateria'];
                $rotaciones[$i]['rotacion'][$c]['codigoperiodo'] = $consultas['codigoperiodo'];
                $rotaciones[$i]['rotacion'][$c]['TotalDias'] = $consultas['TotalDias'];
                $rotaciones[$i]['rotacion'][$c]['nombresestudiantegeneral'] = $consultas['nombresestudiantegeneral'];
                $rotaciones[$i]['rotacion'][$c]['apellidosestudiantegeneral'] = $consultas['apellidosestudiantegeneral'];
                $rotaciones[$i]['rotacion'][$c]['numerodocumento'] = $consultas['numerodocumento'];
                $rotaciones[$i]['rotacion'][$c]['IdInstitucion'] = $consultas['IdInstitucion'];
                $rotaciones[$i]['rotacion'][$c]['idsiq_convenio'] = $consultas['idsiq_convenio'];
                $rotaciones[$i]['rotacion'][$c]['NombreEstado'] = $consultas['NombreEstado'];
                $rotaciones[$i]['rotacion'][$c]['TotalHoras'] = $consultas['TotalHoras'];
            }else
            {
                $i++;
                $c=0;
                $lugar = $consultas['lugarRotacion'];
                $rotaciones[$i]['datos']['IdInstitucion'] = $consultas['IdInstitucion'];
                $rotaciones[$i]['rotacion'][$c]['row'] =  $consultas['row'];
                $rotaciones[$i]['rotacion'][$c]['lugarRotacion'] =  $consultas['lugarRotacion'];
                $rotaciones[$i]['rotacion'][$c]['RotacionEstudianteId'] = $consultas['RotacionEstudianteId'];
                $rotaciones[$i]['rotacion'][$c]['nombremateria'] = $consultas['nombremateria'];
                $rotaciones[$i]['rotacion'][$c]['idestudiantegeneral'] = $consultas['idestudiantegeneral'];
                $rotaciones[$i]['rotacion'][$c]['FechaIngreso'] = $consultas['FechaIngreso'];
                $rotaciones[$i]['rotacion'][$c]['FechaEgreso'] = $consultas['FechaEgreso'];
                $rotaciones[$i]['rotacion'][$c]['codigomateria'] = $consultas['codigomateria'];
                $rotaciones[$i]['rotacion'][$c]['codigoperiodo'] = $consultas['codigoperiodo'];
                $rotaciones[$i]['rotacion'][$c]['TotalDias'] = $consultas['TotalDias'];
                $rotaciones[$i]['rotacion'][$c]['nombresestudiantegeneral'] = $consultas['nombresestudiantegeneral'];
                $rotaciones[$i]['rotacion'][$c]['apellidosestudiantegeneral'] = $consultas['apellidosestudiantegeneral'];
                $rotaciones[$i]['rotacion'][$c]['numerodocumento'] = $consultas['numerodocumento'];
                $rotaciones[$i]['rotacion'][$c]['IdInstitucion'] = $consultas['IdInstitucion'];
                $rotaciones[$i]['rotacion'][$c]['idsiq_convenio'] = $consultas['idsiq_convenio'];
                $rotaciones[$i]['rotacion'][$c]['NombreEstado'] = $consultas['NombreEstado'];
                $rotaciones[$i]['rotacion'][$c]['TotalHoras'] = $consultas['TotalHoras'];
            }
        }
        $c++;
    }

    $nombreSubgrupo = $nombre->fields['NombreSubgrupo'];
    $MaximoCupo = $nombre->fields['MaximoCupo'];

    echo $template_listas->render(array(
            'title' => 'Lista e rotaciones Subgrupos',
            'idgrupo' => $idgrupo,
            'materia' =>$codigomateria,
            'nombreSubgrupo' => $nombreSubgrupo,
            'MaximoCupo' => $MaximoCupo,
            'SubgrupoId' => $_REQUEST['SubgrupoId'],
            'user' => $Usario_id['id'],
            'ListaRotacionesSubgruposData' => $rotaciones
        )
    );
    die;
}

/* FIN PARTE 3.5 */


/* INICIO PARTE 4*/

/* OBTENER MATERIA Y GRUPO */

$SQL = "SELECT
				m.nombremateria, g.nombregrupo
			FROM
				grupo g
			INNER JOIN materia m ON g.codigomateria = m.codigomateria
			WHERE
			g.codigomateria = '".$codigomateria."'
            AND
            g.codigoperiodo='".$periodo."'
            AND
            g.matriculadosgrupo>=1
            and g.codigoestadogrupo = 10";
$info_grupo=$db->GetAll($SQL);

$SQL='SELECT
g.codigomateria,
s.SubgrupoId
FROM
Subgrupos s  INNER JOIN grupo g ON g.idgrupo=s.idgrupo AND s.codigomateria=1
ORDER BY s.SubgrupoId';

$Datos= $db->GetAll($SQL);

for($i=0;$i<count($Datos);$i++){
    $Update='UPDATE Subgrupos
             SET    codigomateria="'.$Datos[$i]['codigomateria'].'"
             WHERE  SubgrupoId="'.$Datos[$i]['SubgrupoId'].'"';

    $Cambio= $db->Execute($Update);
}

/* OBTENER ESTUDIANTES QUE PERTENECEN A ESE GRUPO Y QUE NO ESTAN EN SUBGRUPOS*/
$SQL = "SELECT
            	eg.idestudiantegeneral,
            	CONCAT(
            		eg.apellidosestudiantegeneral,
            		' ',
            		eg.nombresestudiantegeneral,
            		' - ',
            		eg.numerodocumento
            	) AS datos_estudiante, p.codigoperiodo,
            	e2.nombreestadodetalleprematricula
            FROM
            	prematricula p
            INNER JOIN detalleprematricula d ON d.idprematricula = p.idprematricula and  d.codigoestadodetalleprematricula = 30
            INNER JOIN estudiante e ON p.codigoestudiante = e.codigoestudiante
            INNER JOIN estudiantegeneral eg ON e.idestudiantegeneral = eg.idestudiantegeneral
            INNER JOIN ordenpago o on d.numeroordenpago = o.numeroordenpago
            inner join estadodetalleprematricula e2 on d.codigoestadodetalleprematricula = e2.codigoestadodetalleprematricula
			WHERE
			 p.codigoestadoprematricula IN (40, 41)
            AND d.codigomateria = '".$codigomateria."' AND p.codigoperiodo = '".$periodo."'             
            and o.codigoestadoordenpago = 40
            ORDER BY
            	eg.apellidosestudiantegeneral";
$info_estudiantes = $db->GetAll($SQL);
$numeroestudiantes = count($info_estudiantes);

$c=0;
foreach($info_estudiantes as $rotando)
{
    $sqlrotando = "select RotacionEstudianteId from RotacionEstudiantes r INNER JOIN estudiante e on e.codigoestudiante = r.codigoestudiante
                        where e.idestudiantegeneral = '".$rotando['idestudiantegeneral']."' and r.codigoestado = '100' and r.codigoperiodo = '".$periodo."'";
    $estado = $db->GetRow($sqlrotando);
    if($estado['RotacionEstudianteId'])
    {
        $c++;
    }
}


/* OBTENER LOS SUBGRUPOS YA CREADOS PARA ESTE GRUPO */
$SQL = "SELECT s.NombreSubgrupo, s.SubgrupoId, s.MaximoCupo FROM Subgrupos s 
WHERE  s.idgrupo = '".$idgrupo."' AND s.codigoestado = '100'";
$info_subgrupo=$db->GetAll($SQL);

echo $template_index->render(array(
        'title' => 'Administrar Subgrupos',
        'info_grupo' => $info_grupo,
        'idgrupo' => $idgrupo,
        'codigomateria' => $codigomateria,
        'info_estudiantes' => $info_estudiantes,
        'info_subgrupo' => $info_subgrupo,
        'numeroestudiantes' => $numeroestudiantes,
        'estudiantesrotando' => $c
    )
);
/* FIN PARTE 4 */
?>
