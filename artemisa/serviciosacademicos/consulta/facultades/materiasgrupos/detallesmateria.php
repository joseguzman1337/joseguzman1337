<?php
/**
 * @modified Andres Ariza <arizaandres@unbosque.edu.do>
 * Se agregan los archivos de configuracion y conexion a bases de datos utilizados en /sala para unificar conexiones
 * y trabajar con bases de datos persistentes
 * @since Julio 19, 2018
*/
require(realpath(dirname(__FILE__)."/../../../../sala/config/Configuration.php"));
$Configuration = Configuration::getInstance();
if($Configuration->getEntorno()=="local"||$Configuration->getEntorno()=="pruebas"){
//    @error_reporting(1023); // NOT FOR PRODUCTION SERVERS!
//    @ini_set('display_errors', '1'); // NOT FOR PRODUCTION SERVERS!
    require_once (PATH_ROOT.'/kint/Kint.class.php');
}

require (PATH_SITE.'/lib/Factory.php');

$db = Factory::createDbo();
$variables = new stdClass();

if(!empty($_REQUEST)){
    $keys_post = array_keys($_REQUEST);
    foreach ($keys_post as $key_post) {
        $variables->$key_post = strip_tags(trim($_REQUEST[$key_post]));
        //d($key_post);
        switch($key_post){
            case 'option':
                @$option = $_REQUEST[$key_post];
                break;
            case 'task':
                @$task = $_REQUEST[$key_post];
                break;
            case 'action':
                @$action = $_REQUEST[$key_post];
                break;
            case 'layout':
                @$layout = $_REQUEST[$key_post];
                break;
                break;
            case 'itemId':
                @$itemId = $_REQUEST[$key_post];
                break;
        }
    }
}
//d($variables);
Factory::validateSession($variables);

$codigoperiodo = Factory::getSessionVar('codigoperiodosesion');
$codigoestadoperiodosesion = Factory::getSessionVar('codigoestadoperiodosesion');
$username = Factory::getSessionVar('MM_Username');
$codigofacultad = Factory::getSessionVar('codigofacultad');

require_once(PATH_ROOT.'/serviciosacademicos/Connections/sala2.php');

// Variables usadas: $_SESSION['dirini1'], $_SESSION['dir1']
mysql_select_db($database_sala, $sala);

/**
 * @modified Andres Ariza <arizaandres@unbosque.edu.do>
 * Se quita el llamado al archivo seguridadmateriasgrupos que no contiene nada y solo hace una validacion
 * de session que ya se esta ejecuntando
 * @since Julio 19, 2018
*/
//require_once('seguridadmateriasgrupos.php');



function solicitudvalidacion($idgrupo, $carrera, $fechainicio, $fechafin){
    $db = Factory::createDbo();
    $sqlhorario = "SELECT codigodia, horainicial, horafinal "
            . " FROM horario "
            . " WHERE idgrupo= '".$idgrupo."' "
            . " ORDER BY codigodia";
    //d($sqlhorario);
    $datoshorario = $db->Execute($sqlhorario);
    $total_rows_horario = $datoshorario->rowCount();
    //d($total_rows_horario);
    if($total_rows_horario!= 0){
        $i=0;
        while($row_horario = $datoshorario->FetchRow()){
            $sqlvalida = "SELECT ae.AsignacionEspaciosId, ae.SolicitudAsignacionEspacioId, se.idgrupo,  aso.SolicitudPadreId "
                    . " FROM SolicitudAsignacionEspacios sa "
                    . " INNER JOIN AsociacionSolicitud aso ON (aso.SolicitudAsignacionEspaciosId = sa.SolicitudAsignacionEspacioId) "
                    . " INNER JOIN AsignacionEspacios ae ON (ae.SolicitudAsignacionEspacioId = sa.SolicitudAsignacionEspacioId) "
                    . " INNER JOIN SolicitudEspacioGrupos se ON (se.SolicitudAsignacionEspacioId = sa.SolicitudAsignacionEspacioId) "
                    . " INNER JOIN SolicitudPadre sp ON (sp.SolicitudPadreId=aso.SolicitudPadreId) "
                    . " WHERE sa.codigodia = '".$row_horario['codigodia']."' "
                    . " AND sa.codigocarrera = '".$carrera."' "
                    . " AND ae.HoraInicio = '".$row_horario['horainicial']."' "
                    . " AND ae.HoraFin = '".$row_horario['horafinal']."' "
                    . " AND sa.FechaInicio = '".$fechainicio."' "
                    . " /*AND sa.FechaFinal = '".$fechafin."' */ "
                    . " AND se.idgrupo = '".$idgrupo."' "
                    . " AND ae.codigoestado = '100' "
                    . " AND sa.codigoestado=100 "
                    . " AND sp.CodigoEstado=100 "
                    . " ORDER BY AsignacionEspaciosId ASC "
                    . " LIMIT 0,1";
            
            $datosvalidar = $db->Execute($sqlvalida);
            $row_validar = $datosvalidar->FetchRow();
            
            if($row_validar['AsignacionEspaciosId'] != null){
                $return['id'] = '1' ;
                $return['asignacion'.$i] = $row_validar['AsignacionEspaciosId'] ;
                $return['solicitud'.$i] = $row_validar['SolicitudAsignacionEspacioId'];
                $return['grupo'] = $row_validar['idgrupo'];
                $return['padre'] = $row_validar['SolicitudPadreId'];
            }else{
                $return['id'] = '2';
                $return['grupo'] = $idgrupo;
                $return['padre'] = null;
            }
            $i++;
        }
    }else{
        $return['id'] = '3';
        $return['grupo'] = $idgrupo;
        $return['padre'] = null;
    }
    return $return;
}

$pendiente = false;
$codigomateria = $variables->codigomateria1;
//$carrera = $_GET['carrera1'];
$carrera = str_replace(" ","_",$variables->carrera1);
$dirini = "?codigomateria1=$codigomateria&carrera1=$carrera";

$puedeeditargrupo = false;
$query_selperiodoactivo = "SELECT p.codigoperiodo "
        . " FROM periodo p "
        . " WHERE (p.codigoestadoperiodo = '1' OR p.codigoestadoperiodo = '3' OR p.codigoestadoperiodo = '4') "
        . " ORDER BY p.codigoperiodo DESC "
        . " LIMIT 0,1 ";
$selperiodoactivo =  $db->Execute($query_selperiodoactivo);
$row_selperiodoactivo = $selperiodoactivo->FetchRow();
                         
?>
<html>
<head>
    <title>Información de la materia</title><?php
    /**
     * @modified Andres Ariza <arizaandres@unbosque.edu.do>
     * Se utilizan las funciones de inclusion de librerias js y css para manejo de cache
     * @since Julio 19, 2018
    */
    echo Factory::printImportJsCss("css",HTTP_ROOT."/assets/css/normalize.css");
    echo Factory::printImportJsCss("css",HTTP_ROOT."/assets/css/font-page.css");
    echo Factory::printImportJsCss("css",HTTP_ROOT."/assets/css/font-awesome.css");
    echo Factory::printImportJsCss("css",HTTP_ROOT."/assets/css/bootstrap.css");
    echo Factory::printImportJsCss("css",HTTP_ROOT."/assets/css/general.css");
    echo Factory::printImportJsCss("css",HTTP_ROOT."/assets/css/chosen.css");

    echo Factory::printImportJsCss("js",HTTP_ROOT."/assets/js/bootstrap.js");
    echo Factory::printImportJsCss("js",HTTP_ROOT."/serviciosacademicos/js/jquery.js");
    echo Factory::printImportJsCss("js",HTTP_ROOT."/serviciosacademicos/js/jquery.dataTables.js");
    echo Factory::printImportJsCss("js",HTTP_ROOT."/serviciosacademicos/js/jquery-ui-1.8.21.custom.min.js");
    echo Factory::printImportJsCss("js",HTTP_ROOT."/serviciosacademicos/js/jquery-1.9.1.js");
    echo Factory::printImportJsCss("js",HTTP_ROOT."/serviciosacademicos/js/jquery-ui.js");
    echo Factory::printImportJsCss("js",HTTP_ROOT."/serviciosacademicos/consulta/estadisticas/riesgos/data/media/js/jquery.dataTables.js");
    ?>
    <style>
        .ui-dialog {
        border: 1px solid #CCC;
        background-color: #E0E0E0;
        padding: .5em;
        overflow: hidden;
        position: absolute;
        top: 0;
        }
        .ui-dialog-titlebar-close {
        visibility: hidden;
        }
    </style>
    <script type="text/javascript">
        function funcionObservacion(id){
            $("#dialog").dialog({
                autoOpen: true,
                modal: true,
                buttons: {
                    "Aceptar": function () {
                        var txtobservacion = observacion.value;
                        var txtcampus = campus.value;
                        var nombreid = "#"+ id ;
                        var funcion2 =  $(nombreid).val();
                        var datos = funcion2.split(",");

                        $.ajax({
                            type:'POST',
                            url:'detallemateria_ajax.php',
                            async: false,
                            dataType: 'json',
                            data:({grupo:datos[0], usuario:datos[1], carrera:datos[2], fechaini:datos[3], fechafin:datos[4], observacion:txtobservacion, campus:txtcampus}),
                            error:function(objeto, quepaso, otroobj){
                                alert("Error de Conexión , Favor Vuelva a Intentar");
                            },
                            success: function(data){
                                if(data.idpadre!= null){
                                    location.reload(true);
                                }else{
                                    alert("Se produjo un error al generar la solicitud.");
                                }
                            }//data
                        });// AJAX
                        $(this).dialog("close");
                    },
                    "Cerrar": function () {
                        $(this).dialog("close");
                    }
                }
            });
            $("#generacionsolicitud").button().click(function (){
                $("#dialog").dialog("option", "width", 300);
                $("#dialog").dialog("option", "height", 200);
                $("#dialog").dialog({ position: 'top' });

                $("#dialog").dialog("open");
            });
        }
        
        function cancelar(){
            window.location.href="materiasgrupos.php";
        }
    </script>
    <?php
    if (isset($variables->visualizado)){
        if (!isset($variables->lineaenfasis)){
            $idplanestudio = $variables->planestudio;
            echo'<script language="javascript">
                function recargar(dir){
                    window.location.href="detallesmateria.php"+dir+"&planestudio=' . $idplanestudio . '&visualizado";
                }
                </script>';
        }else{
            $idplanestudio = $variables->planestudio;
            $idlineaenfasis = $variables->lineaenfasis;

            echo'<script language="javascript">
                function recargar(dir){
                    window.location.href="detallesmateria.php"+dir+"&planestudio=' . $idplanestudio . '&lineaenfasis=' . $idlineaenfasis . '&visualizado";
                }        
                </script>';
        } 
        ?>
        <script language="javascript">
            function recargar(dir){
                window.location.href="detallesmateria.php"+dir+"&origenplanestudio";
                history.go();
            }
        </script>
         <?php
    }else{
        ?>
        <script language="javascript">
            function recargar(dir){
                document.location.reload();
            }
        </script>
        <?php
    }
    ?>
    <script language="javascript">
        function recargar1(dir){
            window.location.href=dir;
        }
    </script>
</head>
<body>
    <div id="dialog" style="display: none;" title="Generacion de solicitudes">
        <form>
            Observacion: <input type="text" name="observacion" id="observacion"/>
            <br /><br />
            <?php
            $sqlcampus = "SELECT ClasificacionEspaciosId, Nombre "
                    . " FROM ClasificacionEspacios "
                    . " WHERE ClasificacionEspacionPadreId = '1' "
                    . " AND EspaciosFisicosId = '3'";
            
            $scampus = $db->Execute($sqlcampus);
            ?>
            Campus:
            <select name="campus" id="campus">
                <option value="0">Seleccionar...</option>
                <?php
                while ($row_campus = $scampus->FetchRow()){
                    ?>
                    <option value="<?php echo $row_campus['ClasificacionEspaciosId']?>"><?php echo $row_campus['Nombre']?></option>    
                    <?php
            	}
                ?>
            </select>
        </form>        
    </div>
    <?php
    $query_mat = "SELECT mat.nombremateria, mat.codigotipomateria, mat.numerohorassemanales, mat.numerocreditos, "
            . " c.codigotipocosto, c.codigomodalidadacademica, c.codigocarrera "
            . " FROM materia mat "
            . " INNER JOIN carrera c ON (c.codigocarrera = mat.codigocarrera) "
            . " WHERE mat.codigomateria = '".$codigomateria."' ";
    
    $mat = $db->Execute($query_mat);
    $row_mat = $mat->FetchRow();
    $totalRows_mat = $mat->rowCount();
    
    $tipocosto = $row_mat['codigotipocosto'];
    $nombremateria = $row_mat['nombremateria'];
    $codigotipomateria = $row_mat['codigotipomateria'];
    $numerohorassemanales = $row_mat['numerohorassemanales'];
    $numerocreditos = $row_mat['numerocreditos'];
    $codigomodalidadacademica = $row_mat['codigomodalidadacademica'];
    $codigocarrera = $row_mat['codigocarrera'];
    ?>
    <div align="center"></div>
    <p align="center">
        <font size="2">
            <strong>
                <font face="Tahoma">INFORMACI&Oacute;N DE LA MATERIA</font>
            </strong>
            <font face="Tahoma">
                <br>
            </font>
        </font>
    </p>
    <div align="center">
        <table width="600" border="1" align="center" cellpadding="2" cellspacing="1" bordercolor="#003333">
            <tr bgcolor="#C5D5D6">
                <td align="center"><font size="2" face="Tahoma"><strong>Nombre</strong></font></td>
                <td align="center"><font size="2" face="Tahoma"><strong>Código</strong></font></td>
                <td align="center"><font size="2" face="Tahoma"><strong>Carrera</strong></font></td>
                <td align="center"><font size="2" face="Tahoma"><strong>Créditos</strong></font></td>
                <td align="center"><font size="2" face="Tahoma"><strong>Horas <br> Semanales</strong></font></td>
            </tr>
            <tr>
                <td><div align="center"><font size="2" face="Tahoma"><?php echo $nombremateria; ?></font></div></td>
                <td><div align="center"><font size="2" face="Tahoma"><?php echo $codigomateria; ?></font></div></td>
                <td><div align="center"><font size="2" face="Tahoma"><?php echo $carrera; ?></font></div></td>
                <td><div align="center"><font size="2" face="Tahoma"><?php echo $numerocreditos; ?></font></div></td>
                <td><div align="center"><font size="2" face="Tahoma"><?php echo $numerohorassemanales; ?></font></div></td>
            </tr>
        </table>
        <br>
    </div>
        
    <form action="detallesmateria.php" method="get">
        <div align="center"><br></div>
        <?php
        if (isset($variables->eliminardocente)){
            require("eliminardocente.php");
        }
        
        $numobj = 0;
        
        /*
         * Seleccion de los datos del grupo, docente para el periodo actual y pertenecientes a una materia
         */
        $query_detallesmateria = "SELECT gru.idgrupo, gru.nombregrupo, i.nombreindicadorhorario, "
                . " i.codigoindicadorhorario, gru.maximogrupoelectiva, gru.fechainiciogrupo, "
                . " gru.fechafinalgrupo,  doc.numerodocumento, gru.nombregrupo, "
                . " gru.maximogrupo, gru.codigogrupo, doc.nombredocente, doc.apellidodocente "
                . " FROM materia mat "
                . " INNER JOIN grupo gru ON (gru.codigomateria = mat.codigomateria) "
                . " INNER JOIN indicadorhorario i ON (gru.codigoindicadorhorario = i.codigoindicadorhorario) "
                . " LEFT JOIN docente doc ON (gru.numerodocumento = doc.numerodocumento) "
                . " WHERE mat.codigomateria = gru.codigomateria "
                . " AND mat.codigoestadomateria = '01' "
                . " AND gru.codigoperiodo = '$codigoperiodo' "
                . " AND doc.codigoestado = '100' "
                . " AND gru.codigomateria = '$codigomateria' "
                . " AND gru.codigoestadogrupo = '10' ";
        //d($query_detallesmateria);
        $detallesmateria = $db->Execute($query_detallesmateria);
        $totalRows_detallesmateria = $detallesmateria->rowCount();
        
        if ($totalRows_detallesmateria != 0){
            $numobj = 1;
            $botones = 1;
            while ($row_detallesmateria = $detallesmateria->FetchRow()){
                $idgrupo = $row_detallesmateria['idgrupo'];
                $nombregrupo = $row_detallesmateria['nombregrupo'];
                $nombreindicadorhorario = $row_detallesmateria['nombreindicadorhorario'];
                $codigoindicadorhorario = $row_detallesmateria['codigoindicadorhorario'];
                $maximogrupoelectiva = $row_detallesmateria['maximogrupoelectiva'];
                $fechaini = $row_detallesmateria['fechainiciogrupo'];
                $fechafin = $row_detallesmateria['fechafinalgrupo']; 
                
                $numerodocumento = $row_detallesmateria['numerodocumento'];
                $nombregrupo = $row_detallesmateria['nombregrupo'];
                $maximogrupo = $row_detallesmateria['maximogrupo'];
                $codigogrupo = $row_detallesmateria['codigogrupo'];
                $nombredocente = $row_detallesmateria['nombredocente'];
                $apellidodocente = $row_detallesmateria['apellidodocente'];                   
                
                // Cuenta el numero de estudiantes prematriculados y matriculados en un grupo
                $query_numeromatriculados = "SELECT COUNT(p.codigoestudiante) AS numeromatriculados "
                        . " FROM detalleprematricula d "
                        . " INNER JOIN prematricula p ON (d.idprematricula = p.idprematricula) "
                        . " INNER JOIN estudiante e ON (p.codigoestudiante = e.codigoestudiante) "
                        . " WHERE p.codigoestadoprematricula IN (10, 11, 40, 41) "
                        . " AND d.codigoestadodetalleprematricula IN (10, 30) "
                        . " AND d.idgrupo = '".$idgrupo."' "
                        . " AND p.codigoperiodo = '".$codigoperiodo."'";
                //d($query_numeromatriculados);
                $numeromatriculados = $db->Execute($query_numeromatriculados);
                $row_numeromatriculados = $numeromatriculados->FetchRow();
                $totalRows_numeromatriculados = $numeromatriculados->rowCount();
                
                $matriculadosgrupo = $row_numeromatriculados['numeromatriculados'];
                
                if ($tipocosto <> 100) {
                    $query_orden_interna = "SELECT fechainicionumeroordeninternasap,fechavencimientonumeroordeninternasap,"
                            . " numeroordeninternasap "
                            . " FROM numeroordeninternasap "
                            . " WHERE idgrupo = '".$idgrupo."'";
                    
                    $orden_interna = $db->Execute($query_orden_interna);
                    $row_orden_interna = $orden_interna->FetchRow();
                    $totalRows_orden_interna = $orden_interna->rowCount();
                }
                ?>
                <hr><br>
                <p align="center">
                    <strong>
                        <font size="2" face="Tahoma">
                            GRUPO <?php echo $nombregrupo; ?>
                        </font>
                    </strong>
                </p>
                <table width="600" border="1" align="center" cellpadding="2" cellspacing="1" bordercolor="#003333">
                    <tr bgcolor="#C5D5D6">
                        <td align="center"><font size="2" face="Tahoma"><strong>Id Grupo</strong></font></td>
                        <td align="center"><font size="2" face="Tahoma"><strong>Cupo</strong></font></td>
                        <td align="center"><font size="2" face="Tahoma"><strong>Matriculados</strong></font></td>
                        <td align="center"><font size="2" face="Tahoma"><strong>Prematriculados</strong></font></td>
                        <td align="center"><font size="2" face="Tahoma"><strong>Matriculados Electiva</strong></font></td>
                        <td align="center"><font size="2" face="Tahoma"><strong>Prematriculados Electiva</strong></font></td>
                        <td align="center"><font size="2" face="Tahoma"><strong>Docente</strong></font></td>
                        <?php
                        $datosvalidacion = solicitudvalidacion($idgrupo, $codigocarrera, $fechaini, $fechafin);
                        
                        if($datosvalidacion['grupo']==$idgrupo && $datosvalidacion['id']=='1'){
                            ?>
                            <td align="center"><font size="2" face="Tahoma"><strong>Id Solicitud_P</strong></font></td>
                            <?php 
                        }
                        ?>
                    </tr>
                    <?php
                    //ivan quintero
                    /*
                     * @modified Andres Ariza <arizaandres@unbosque.edu.co>
                     * Es necesario diferenciar matriculas y prematriculas, se va a abrir en 2 consultas  y se sumaran para 
                     * el proceso normal
                     * @since  Julio 19, 2018
                     */
                    //consulta el total de matriculados para el grupo especifico
                    $query_matriculados = "SELECT COUNT(1) AS 'matriculados' "
                            . " FROM detalleprematricula "
                            . " WHERE idgrupo ='".$idgrupo."' "
                            . " AND codigomateriaelectiva = '0' "
                            . " AND `codigoestadodetalleprematricula` = ";
                    
                    $resmatriculados = $db->Execute($query_matriculados." 30 ");
                    $row_matriculados = $resmatriculados->FetchRow();	
                    $matriculadosprematricula = $row_matriculados['matriculados'];
                    
                    $resmatriculados = $db->Execute($query_matriculados." 10 ");
                    $row_matriculados = $resmatriculados->FetchRow();	
                    $prematriculadosprematricula = $row_matriculados['matriculados'];
                    
                    
                    $matriculadosdetalleprematricula = $matriculadosprematricula + $prematriculadosprematricula;
                    $matriculadosgrupo = $matriculadosdetalleprematricula;
                    //$totalRows_matriculados = mysql_num_rows($resmatriculados);
                    
                    /*
                     * @modified Andres Ariza <arizaandres@unbosque.edu.co>
                     * Es necesario diferenciar matriculas y prematriculas, se va a abrir en 2 consultas  y se sumaran para 
                     * el proceso normal
                     * @since  Julio 19, 2018
                     */
                    //consulta el total de matriculados por electiva para el grupo especifico
                    $query_matriculadoselectivas = "SELECT COUNT(1) AS 'matriculadoselectivas' "
                            . " FROM detalleprematricula "
                            . " WHERE idgrupo ='".$idgrupo."' "
                            . " AND codigomateriaelectiva <> '0' "
                            . " AND `codigoestadodetalleprematricula` = ";
                    $resmatriculadoselectiva = $db->Execute($query_matriculadoselectivas." 30 ");
                    $row_matriculadoselectiva = $resmatriculadoselectiva->FetchRow();
                    $matriculadosmatriculaelectiva = $row_matriculadoselectiva['matriculadoselectivas'];
                    
                    $resmatriculadoselectiva = $db->Execute($query_matriculadoselectivas." 10 ");
                    $row_matriculadoselectiva = $resmatriculadoselectiva->FetchRow();
                    $prematriculadosmatriculaelectiva = $row_matriculadoselectiva['matriculadoselectivas'];
                    
                    
                    $matriculadosdetalleprematriculaelectiva = $matriculadosmatriculaelectiva + $prematriculadosmatriculaelectiva;
                    //$totalRows_matriculadoselectiva = mysql_num_rows($resmatriculadoselectiva);		

                    //consulta el total de matriculados de electiva tiene el grupo registrados
                    $sqlmatriculadosgrupo = "SELECT g.matriculadosgrupoelectiva, g.matriculadosgrupo "
                            . " FROM grupo g "
                            . " WHERE g.idgrupo = '".$idgrupo."'";

                    $resmatriculadosgrupo = $db->Execute($sqlmatriculadosgrupo);
                    $row_matriculadosgrupo = $resmatriculadosgrupo->FetchRow();
                    $totalRows_matriculadosgrupo = $resmatriculadosgrupo->rowCount();
                    $matriculadosgrurpo = $row_matriculadosgrupo['matriculadosgrupo'];
                    $matriculadoselectivas = $row_matriculadosgrupo['matriculadosgrupoelectiva'];

                    //si la cantidad de estudaintes matriculados del grupo es diferente a la cantidad de matriculados se debe actualizar
                    if($matriculadosdetalleprematricula < $matriculadosgrurpo || $matriculadosdetalleprematricula > $matriculadosgrurpo){
                        $query_matriculadosgrupoupdate = "UPDATE grupo g SET g.matriculadosgrupo ='".$matriculadosdetalleprematricula."' "
                                . " WHERE g.idgrupo ='".$idgrupo."'";

                        $resultadogrupo = $db->Execute($query_matriculadosgrupoupdate);

                        if($username == 'admintecnologia'){
                            echo "<center>SE ACTUALIZO LA CANTIDAD DE MATRICULADOS OBLIGATORIOS</center>";	
                        }
                    }

                    //si la cantidad de estudaintes matriculados electiva del grupo es diferente a la cantidad de matriculados electiva se debe actualizar
                    if($matriculadosdetalleprematriculaelectiva< $matriculadoselectivas || $matriculadosdetalleprematriculaelectiva > $matriculadoselectivas){
                        $query_matriculadosgrupoupdate = "UPDATE grupo g SET g.matriculadosgrupoelectiva ='".$matriculadoselectivas."' "
                                . " WHERE g.idgrupo ='".$idgrupo."'";

                        $resultadogrupo = $db->Execute($query_matriculadosgrupoupdate);

                        if($username == 'admintecnologia'){
                            echo "<center>SE ACTUALIZO LA CANTIDAD DE MATRICULADOS ELECTIVOS</center>";
                        }
                    }
                    ?>
                    <tr>
                        <td>
                            <div align="center">
                                <font size="2" face="Tahoma">
                                    <?php echo $idgrupo; ?>
                                </font>
                            </div>
                        </td>
                        <td>
                            <div align="center">
                                <font size="2" face="Tahoma">
                                    <?php echo $maximogrupo; ?>
                                </font>
                            </div>
                        </td>
                        <td>
                            <div align="center">
                                <font size="2" face="Tahoma">
                                    <?php echo $matriculadosprematricula; ?>
                                </font>
                            </div>
                        </td> 	
                        <td>
                            <div align="center">
                                <font size="2" face="Tahoma">
                                    <?php echo $prematriculadosprematricula; ?>
                                </font>
                            </div>
                        </td> 	
                        <td>
                            <div align="center">
                                <font size="2" face="Tahoma">
                                    <?php echo $matriculadosmatriculaelectiva; ?>
                                </font>
                            </div>
                        </td>
                        <td>
                            <div align="center">
                                <font size="2" face="Tahoma">
                                    <?php echo $prematriculadosmatriculaelectiva; ?>
                                </font>
                            </div>
                        </td>
                        <td>
                            <div align="center">
                                <font size="2" face="Tahoma">
                                    <?php echo $nombredocente . " " . $apellidodocente; ?>
                                </font>
                            </div>
                        </td>
                        <?php
                        if($datosvalidacion['grupo']==$idgrupo && $datosvalidacion['id']=='1'){
                            ?>
                            <td>
                                <div align="center">
                                    <font size="2" face="Tahoma">
                                        <?php echo $datosvalidacion['padre']; ?>
                                    </font>
                                </div>
                            </td>
                            <?php
                        }
                        ?>
                    </tr>
                    <tr>
                        <td colspan="8">
                            <table width="100%" border="1" align="center" cellpadding="2" cellspacing="1" bordercolor="#FF9900">
                                <tr>
                                    <td bgcolor="#C5D5D6" class="Estilo2" align="center">
                                        <font size="2" face="Tahoma">
                                            <strong>Fecha de Inicio</strong>
                                        </font>
                                    </td>
                                    <td class="Estilo1" align="center">
                                        <font size="2" face="Tahoma">
                                            <?php echo $row_detallesmateria['fechainiciogrupo']; ?>
                                        </font>
                                    </td>
                                    <td bgcolor="#C5D5D6" class="Estilo2" align="center">
                                        <font size="2" face="Tahoma">
                                            <strong>Fecha de Vencimiento</strong>
                                        </font>
                                    </td>
                                    <td class="Estilo1" align="center">
                                        <font size="2" face="Tahoma">
                                            <?php echo $row_detallesmateria['fechafinalgrupo']; ?>
                                        </font>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <?php
                    if($tipocosto <> 100){
                        ?>
                        <tr bgcolor="#C5D5D6">
                            <td align="center" colspan="8">
                                <font size="2" face="Tahoma">
                                    <strong>Número Orden Interna</strong>
                                </font>
                            </td>
                        </tr>
                        <?php     
                        if(!empty($row_orden_interna)){
                            ?>
                            <tr bgcolor="#C5D5D6">
                                <td align="center" colspan="4">
                                    <font size="2" face="Tahoma">
                                        <strong>Número</strong>
                                    </font>
                                </td>
                                <td align="center" colspan="2">
                                    <font size="2" face="Tahoma">
                                        <strong>Fecha Inicio</strong>
                                    </font>
                                </td>
                                <td align="center" colspan="2">
                                    <font size="2" face="Tahoma">
                                        <strong>Fecha Final</strong>
                                    </font>
                                </td>
                            </tr>
                            <tr>
                                <td align="center" colspan="4">
                                    <font size="2" face="Tahoma">
                                        <?php echo $row_orden_interna['numeroordeninternasap']; ?>
                                    </font>
                                </td>
                                <td align="center" colspan="2">
                                    <font size="2" face="Tahoma">
                                        <?php echo $row_orden_interna['fechainicionumeroordeninternasap']; ?>
                                    </font>
                                </td>
                                <td align="center" colspan="2">
                                    <font size="2" face="Tahoma">
                                        <?php echo $row_orden_interna['fechavencimientonumeroordeninternasap']; ?>
                                    </font>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                        <tr>
                            <td align="center" colspan="8">
                                <font size="2" face="Tahoma">
                                    <strong>
                                        <input type="button" name="Submit" onClick="<?php echo "window.open('ordeninterna.php?idgrupo=$idgrupo','miventana','width=650,height=300,top=100,left=100,scrollbars=yes')"; ?>" value="Orden Interna">
                                    </strong>
                                </font>
                            </td>
                        </tr>
                        <?php
                        //}
                    }
                    ?>
                    <tr>
                        <td colspan="8" align="center">
                            <font size="2" face="Tahoma">
                            <?php
                            // Deja modificar el grupo solamente cuando el periodo se encuentre Vigente=1
                            if (isset($codigofacultad) && ($codigoestadoperiodosesion <> 2 OR $codigoperiodo >= $row_selperiodoactivo['codigoperiodo']) && $username != "adminplantafisica"){
                                $codigocarrera = $row_mat['codigocarrera'];
                                $codigomateria = $variables->codigomateria1;

                                $datosvalidacion = solicitudvalidacion($idgrupo, $codigocarrera, $fechaini, $fechafin);
                                $dirini .= "&grupo1=".$codigogrupo."&idgrupo1=".$idgrupo;
                                $finLinea100 = "','miventana','width=600,height=400,left=150,top=100,scrollbars=yes')";
                                $finLinea200 = "','miventana','width=500,height=400,left=200,top=200,scrollbars=yes')";
                                ?>
                                <input type="button" name="Cupo" value="Editar Grupo" onClick="<?php 
                                    echo "window.open('editarcupo.php".$dirini
                                            . "&maximogrupo1=".$maximogrupo."&nombregrupo1=".$nombregrupo
                                            . "&nombreindicadorhorario1=".$nombreindicadorhorario."&codigoindicadorhorario1=".$codigoindicadorhorario 
                                            . "&maximogrupoelectiva1=".$maximogrupoelectiva."&fechaini=".$fechaini."&fechafin=".$fechafin 
                                            . "&matriculados=".$matriculadosgrupo."&padre=".$datosvalidacion['padre']
                                            . "','miventana','width=700,height=200,top=200,left=150')"; ?>">

                                <input type="button" name="Editar_Docente" value="Editar Docente Coordinador" onClick="<?php
                                    echo "window.open('editardocente.php".$dirini.$finLinea100; ?>">

                                <input type="button" name="Editar_Docente" value="Agregar Otro Docente" onClick="<?php
                                    echo "window.open('agregardocente.php".$dirini.$finLinea100; ?>">

                                <input type="button" name="Eliminar_Docente" value="Eliminar Docente" onClick="<?php
                                    echo "window.open('eliminardocente.php".$dirini.$finLinea200; ?>">

                                <input type="button" name="Submit" onClick="<?php
                                    echo "window.open('../creardocentes/creardocente.php'"
                                        . " ,'miventana','width=850,height=500,top=100,left=100,scrollbars=yes')"; ?>" value="Crear Docente">

                                <?php
                                if($datosvalidacion['grupo']==$idgrupo){
                                    switch($datosvalidacion['id']){
                                        case '1':
                                            ?>
                                            <input type="button" name="Submit" value="Editar Solicitud" onclick="<?php echo "window.open('"."../../../EspacioFisico/Interfas/InterfazSolicitud_html.php?actionID=EditarSolicitud&id=".$datosvalidacion['padre']."', 'miventana','width=850,height=500,top=100,left=100,scrollbars=yes')";?>"  />
                                            <?php 
                                            break;
                                        case '2':
                                            ?>
                                            <input type="button" name="Submit" id="generacionsolicitud" value="Generar Solicitud" onclick="funcionObservacion('crearsolicitudespacio_<?php echo $botones;?>')">
                                            <input type="hidden" id="crearsolicitudespacio_<?php echo $botones;?>" value="<?php echo "'".$idgrupo."','".$username."','".$codigocarrera ."','"   .$fechaini."','".$fechafin."'";?>"/>
                                            <?php                                          
                                            break;
                                    }
                                }
                                ?>
                                <hr>
                                <input type="button"  name="ira" onClick="<?php
                                    echo "window.open('cambiodegrupo.php?materia=".$codigomateria."&grupo=".$idgrupo 
                                            . "','miventana','width=700,height=500,top=100,left=100,scrollbars=yes')";?>" value="Traslado de Estudiantes a Otro Grupo">

                                <?php
                                if(!empty($total_permisoboton) && $total_permisoboton>0){
                                    ?>
                                    <input type="button" id="f" name="DistEstuRotacion" value="Distribucion Estudiante rotacion" onclick="location.href='rotaciones/Rotaciones_html.php?actionID=VwASignacionRotacionGrupo&idgrupo=<?php echo $idgrupo;?>&codigoperiodo=<?php echo $codigoperiodo;?>'" />                                
                                    <input type="button" id="f" name="DistEstuRotacion" value="Reporte de rotaciones" onclick="location.href='rotaciones/ReporteRotacionesgrupos.php?idgrupo=<?php echo $idgrupo;?>&codigoperiodo=<?php echo $codigoperiodo;?>&codigomateria1=<?php echo $_GET["codigomateria1"];?>&carrera1=<?php echo $_GET["carrera1"];?>'" />
                                    <?php                                
                                }

                                if($codigomodalidadacademica == 400){
                                    ?>
                                    <input type="button"  name="fechaseducacion" onClick="<?php
                                        echo "window.open('asociarfechaeducacioncontinuada.php?codigomodalidadacademica=$codigomodalidadacademica"
                                                . "&codigocarrera=$codigocarrera&codigomateria=$codigomateria&idgrupo=$idgrupo',"
                                                . "'miventana','width=700,height=500,top=100,left=100,scrollbars=yes')"; ?>" value="Fechas de Pago">
                                    <?php
                                }
                            }
                            ?>
                            </font>
                        </td>
                    </tr>
                </table>
                <?php
                if (ereg("^1+", $codigoindicadorhorario)){
                    ?>
                    <font size="2" face="Tahoma"><br></font>
                    <table width="707" border="1" align="center" cellpadding="2" cellspacing="1" bordercolor="#003333">
                        <tr bgcolor="#C5D5D6">
                            <td colspan="8" align="center">
                                <font size="2" face="Tahoma">
                                    <strong>Horario</strong>
                                </font>
                            </td>
                        </tr>
                        <?php
                        // Mira si el objeto grupo tiene horario asignado                                    
                        $query_horarios = "SELECT h.codigodia, h.horainicial, h.horafinal, d.nombredia, "
                                . " se.nombresede, s.nombresalon, s.codigosalon, h.codigotiposalon, t.nombretiposalon "
                                . " FROM horario h "
                                . " INNER JOIN dia d ON (h.codigodia = d.codigodia) "
                                . " INNER JOIN salon s ON (h.codigosalon = s.codigosalon) "
                                . " INNER JOIN tiposalon t ON (h.codigotiposalon = t .codigotiposalon) "
                                . " INNER JOIN sede se ON (s.codigosede = se.codigosede) "
                                . " WHERE h.idgrupo = '".$idgrupo."' "
                                . " order by h.codigodia, h.horainicial, h.horafinal, d.nombredia";

                        $horarios = $db->Execute($query_horarios);                                                                              
                        $totalRows_horarios = $horarios->rowCount();
                        // verifica que no si hay estudiantes en el grupo
                        // echo "$query_matriculadosgrupo <br>";
                        // echo $row_matriculadosgrupo['matriculaditos'];                            
                        if(!empty($totalRows_horarios)){
                            ?>
                            <tr bgcolor="#C5D5D6">
                                <td align="center">
                                    <font size="2" face="Tahoma">
                                        <strong>Día</strong>
                                    </font>
                                </td>
                                <td align="center">
                                    <font size="2" face="Tahoma">
                                        <strong>Hora Inicial</strong>
                                    </font>
                                </td>
                                <td align="center">
                                    <font size="2" face="Tahoma">
                                        <strong>Hora Final</strong>
                                    </font>
                                </td>
                                <td align="center">
                                    <font size="2" face="Tahoma">
                                        <strong>Sede</strong>
                                    </font>
                                </td>
                                <td align="center">
                                    <font size="2" face="Tahoma">
                                        <strong>Sal&oacute;n</strong>
                                    </font>
                                </td>
                                <td align="center">
                                    <font size="2" face="Tahoma">
                                        <strong>Tipo</strong>
                                    </font>
                                </td>
                                <td align="center">
                                    <font size="2" face="Tahoma">
                                        <strong>Estado</strong>
                                    </font>
                                </td>
                            </tr>
                            <?php 
                            if($datosvalidacion['id']=='1' && $datosvalidacion['grupo']==$idgrupo){
                                $r=0;

                                while ($row_horarios_uno = $horarios->FetchRow()){
                                    $sqlsolicitud = "SELECT s.codigodia, a.HoraInicio, a.HoraFin, c.Nombre, "
                                            . " s.ClasificacionEspaciosId, d.nombredia, a.ClasificacionEspaciosId as numerosalon,  "
                                            . " t.nombretiposalon, s.SolicitudAsignacionEspacioId "
                                            . " FROM AsignacionEspacios a "
                                            . " INNER JOIN ClasificacionEspacios c ON (c.ClasificacionEspaciosId = a.ClasificacionEspaciosId) "
                                            . " INNER JOIN SolicitudAsignacionEspacios s ON (s.SolicitudAsignacionEspacioId = a.SolicitudAsignacionEspacioId) "
                                            . " INNER JOIN dia d ON (d.codigodia = s.codigodia) "
                                            . " INNER JOIN SolicitudAsignacionEspaciostiposalon ts ON (ts.SolicitudAsignacionEspacioId = a.SolicitudAsignacionEspacioId) "
                                            . " INNER JOIN tiposalon t ON (t.codigotiposalon = ts.codigotiposalon) "
                                            . " WHERE a.SolicitudAsignacionEspacioId = '".$datosvalidacion['solicitud'.$r]."' "
                                            . " AND s.codigodia = '".$row_horarios_uno['codigodia']."' "
                                            . " AND a.codigoestado = 100 "
                                            . " ORDER BY AsignacionEspaciosId ASC "
                                            . " LIMIT 0,1";

                                    $horarios2 = $db->Execute($sqlsolicitud);
                                    $row_horarios = $horarios2->FetchRow();

                                    $horario['estado'] = "cargado";
                                    $horario['nombredia'] = $row_horarios['nombredia'];
                                    $horario['codigodia'] = $row_horarios['codigodia'];
                                    $horario['horainicial'] = ereg_replace(":00$", "", $row_horarios['HoraInicio']);
                                    $horario['horafinal'] = ereg_replace(":00$", "", $row_horarios['HoraFin']);

                                    if($row_horarios['ClasificacionEspaciosId']== 4){
                                        $horario['nombresede'] = 'Usaquen';
                                    }elseif($row_horarios['ClasificacionEspaciosId']== 5){
                                        $horario['nombresede'] = 'Chia';
                                    }                                                

                                    $horario['nombresalon'] = $row_horarios['Nombre'];
                                    $horario['codigosalon'] = $row_horarios['numerosalon'];
                                    $horario['nombretiposalon'] = $row_horarios['nombretiposalon'];
                                    ?>
                                    <tr>
                                        <td>
                                            <div align="center">
                                                <font size="2" face="tahoma">
                                                    <?php echo " " . $horario['nombredia'] . " "; ?>
                                                </font>
                                            </div>
                                        </td>
                                        <td>
                                            <div align="center">
                                                <font size="2" face="tahoma">
                                                    <?php echo " " . $horario['horainicial'] . " "; ?>
                                                </font>
                                            </div>
                                        </td>
                                        <td>
                                            <div align="center">
                                                <font size="2" face="tahoma">
                                                    <?php echo " " . $horario['horafinal'] . " "; ?>
                                                </font>
                                            </div>
                                        </td>
                                        <td>
                                            <div align="center">
                                                <font size="2" face="tahoma">
                                                    <?php echo " " . $horario['nombresede'] . " "; ?>
                                                </font>
                                            </div>
                                        </td>
                                        <td align="center">
                                            <div align="center">
                                                <font size="2" face="tahoma">
                                                <?php
                                                    if ($horario['codigosalon'] == 212) {
                                                        echo " " . $horario['nombresalon'] . " ";
                                                        $horario['Estatus'] ='por atender';
                                                    }else{
                                                        echo " " . $horario['nombresalon'] . " ";
                                                        $horario['Estatus'] = 'Atendida';
                                                    }
                                                ?>
                                                </font>
                                            </div>
                                        </td>
                                        <td>
                                            <div align="center">
                                                <font size="2" face="tahoma">
                                                    <?php echo " " . $horario['nombretiposalon'] . " "; ?>
                                                </font>
                                            </div>
                                        </td>
                                        <td>
                                            <div align="center">
                                                <font size="2" face="tahoma">
                                                    <?php echo " " . $horario['Estatus'] . " "; ?>
                                                </font>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php
                                    $r++;
                                } 
                            }else{
                                while ($row_horarios = $horarios->FetchRow()){
                                    $horario['estado'] = "cargado";
                                    $horario['nombredia'] = $row_horarios['nombredia'];
                                    $horario['codigodia'] = $row_horarios['codigodia'];
                                    $horario['horainicial'] = ereg_replace(":00$", "", $row_horarios['horainicial']);
                                    $horario['horafinal'] = ereg_replace(":00$", "", $row_horarios['horafinal']);
                                    $horario['nombresede'] = $row_horarios['nombresede'];
                                    $horario['nombresalon'] = $row_horarios['nombresalon'];
                                    $horario['codigosalon'] = $row_horarios['codigosalon'];
                                    $horario['nombretiposalon'] = $row_horarios['nombretiposalon'];
                                    // Imprime los horarios de cada objeto grupo
                                    ?>
                                    <tr>
                                        <td>
                                            <div align="center">
                                                <font size="2" face="tahoma">
                                                    <?php echo " " . $horario['nombredia'] . " "; ?>
                                                </font>
                                            </div>
                                        </td>
                                        <td>
                                            <div align="center">
                                                <font size="2" face="tahoma">
                                                    <?php echo " " . $horario['horainicial'] . " "; ?>
                                                </font>
                                            </div>
                                        </td>
                                        <td>
                                            <div align="center">
                                                <font size="2" face="tahoma">
                                                    <?php echo " " . $horario['horafinal'] . " "; ?>
                                                </font>
                                            </div>
                                        </td>
                                        <td>
                                            <div align="center">
                                                <font size="2" face="tahoma">
                                                    <?php echo " " . $horario['nombresede'] . " "; ?>
                                                </font>
                                            </div>
                                        </td>
                                        <td align="center">
                                            <div align="center">
                                                <font size="2" face="tahoma">
                                                    <?php
                                                    if ($horario['codigosalon'] == 1){
                                                        echo " " . $horario['nombresalon'] . " ";
                                                    }else{
                                                        echo " " . $horario['codigosalon'] . " ";
                                                    }
                                                    ?>
                                                </font>
                                            </div>
                                        </td>
                                        <td>
                                            <div align="center">
                                                <font size="2" face="tahoma">
                                                    <?php echo " " . $horario['nombretiposalon'] . " "; ?>
                                                </font>
                                            </div>
                                        </td>
                                        <td>
                                            <div align="center">
                                                <font size="2" face="tahoma">
                                                    Sin solicitud
                                                </font>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            }
                            /*
                             * @modified Andres Ariza <arizaandres@unbosque.edu.co>
                             * Cuando un grupo ya tenga usuarios matriculados ya sea en matriculados o en matriculados electiva el sistema no debe permitir 
                             * modificar o eliminar los horarios, para controlar esto se agrega una validacion para verificar que la suma de los usuarios sea 0
                             * y solo ahi mostrar los botones
                             * Caso reportado por Diana Rojas - Registro y Control Académico <dianarojas@unbosque.edu.co> Fecha: 2 de diciembre de 2016, 12:08 Asunto: Error SALA - Grupos y horarios
                             * @since  December 02, 2016
                             */
                            unset($matriculadosTemp);
                            $matriculadosTemp = $matriculadosgrupo + $matriculadosdetalleprematriculaelectiva;

                            if( $matriculadosTemp == 0 ){
                                ?>
                                <tr>
                                    <td colspan="8" align="center">
                                        <font size="2" face="tahoma">
                                            <?php
                                            if (isset($codigofacultad) && ($codigoestadoperiodosesion <> 2 OR $codigoperiodo >= $row_selperiodoactivo['codigoperiodo']) && $username != "adminplantafisica"){
                                                ?>
                                                <input type="button" name="Editar_Horario" value="Editar Horario" onClick="<?php
                                                    if ($row_matriculadosgrupo['matriculaditos'] > '0'){
                                                        echo "alert('No es posible modificar el Horario ya que hay alumnos matriculados en este grupo esto puede Generar cruces de horarios con otras materias')";
                                                    }else{
                                                        echo "window.open('editarhorario.php" . $dirini . "&grupo1=" . $codigogrupo . "&numerohorassemanales1=" . $numerohorassemanales . "&idgrupo1=" . $idgrupo . "&Padre=" . $datosvalidacion['padre'] . "','miventana','width=800,height=400,left=100,top=200,scrollbars=yes')";
                                                    } ?>">

                                                <input type="button" name="Eliminar_Horario" value="Eliminar Horario"  onClick="<?php
                                                    if ($row_matriculadosgrupo['matriculaditos'] > '0' || $row_matriculadosgrupo['matriculadosgrupoelectiva'] > '0'){
                                                        echo "alert('No es posible modificar el Horario ya que hay alumnos matriculados en este grupo esto puede Generar cruces de horarios con otras materias')";
                                                    }else{
                                                        echo "window.open('eliminarhorario.php" . $dirini . "&grupo1=" . $codigogrupo . "&numerohorassemanales1=" . $numerohorassemanales . "&idgrupo1=" . $idgrupo . "&Padre=" . $datosvalidacion['padre'] . "','miventana','width=500,height=400,left=200,top=200,scrollbars=yes')";
                                                    } ?>">
                                                <?php
                                            }
                                            // Debe validar que este boton lo use solamente una persona (La encargada de los salones)
                                            if ($username == "adminplantafisica"){
                                                if(($codigoestadoperiodosesion == 1) || ($codigoestadoperiodosesion == 4)){
                                                    // Mira si los horarios tienen asignado fecha
                                                    $query_fechahorarios = "SELECT h.idhorario "
                                                            . " FROM horario h"
                                                            . " horariodetallefecha hd "
                                                            . " WHERE h.idgrupo = '$idgrupo' "
                                                            . " AND h.idhorario = hd.idhorario";

                                                    $fechahorarios = $db->Execute($query_fechahorarios);
                                                    $totalRows_fechahorarios = $fechahorarios->rowCount();

                                                    if($totalRows_fechahorarios != ""){
                                                        ?>
                                                        <input type="button" name="Salones" value="Salones"  onClick="<?php
                                                            echo "window.open('salones.php".$dirini."&grupo1=".$codigogrupo."&idgrupo1=".$idgrupo."&filtrado=Aceptar','miventana','width=500,height=400,left=200,top=200,scrollbars=yes')"; ?>">

                                                        <input type="button" name="Formato" value="Formato"  onClick="<?php
                                                            echo "window.open('formato.php".$dirini."&grupo1=".$codigogrupo."&idgrupo1=".$idgrupo."&filtrado=Aceptar','miventana','width=700,height=500,left=200,top=200,scrollbars=yes')"; ?>">

                                                        <?php
                                                    }else{
                                                        ?>
                                                        <input type="button" name="Salones" value="Salones"  onClick="alert('La facultad no le ha colocado fechas de uso del salón, comuníquese con ellos e infórmeles')">
                                                        <?php
                                                    }
                                                }
                                            }
                                            ?>
                                        </font>
                                    </td>
                                </tr>
                                <?php
                            }
                            /* END MODIFICATION */
                        }else{
                            if(isset($codigofacultad) && ($codigoestadoperiodosesion == 1 OR $codigoestadoperiodosesion == 3 OR $codigoperiodo >= $row_selperiodoactivo['codigoperiodo'])){
                                ?>
                                <tr>
                                    <td align="center" colspan="6">
                                        <font size="2" face="tahoma">
                                            <input type="button" name="Adicionar_Horario" value="Adicionar Horario" onClick="<?php
                                            echo "window.open('adicionarhorario.php".$dirini."&grupo1=".$codigogrupo."&numerohorassemanales1=".$numerohorassemanales."&idgrupo1=".$idgrupo."','miventana','width=800,height=400,left=100,top=100,scrollbars=yes')"; ?>">
                                        </font>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                            <tr>
                                <td align="center" colspan="6">
                                    <font color="#FF0000" size="-1" face="tahoma">
                                        Tiene Pendiente Adicionar Horario a este grupo
                                    </font>
                                </td>
                            </tr>
                            <?php
                            $pendiente = true;
                        }
                        ?>
                    </table>
                    <?php
                }
                ?>
                <br>
                <?php
                /* Modificación realizada para ocultar el botón de eliminar grupos cuando esté ya tiene estudiantes matriculados. */
                $matriculadosTemp = $matriculadosgrupo + $matriculadosdetalleprematriculaelectiva;
                if($matriculadosTemp == 0 && isset($codigofacultad) && ($codigoperiodo<> 2 OR $codigoperiodo >= $row_selperiodoactivo['codigoperiodo'])){
                    ?>
                    <div align="center">
                        <br>    
                        <input type="button" name="eliminargrupo" value="Eliminar Grupo" onClick="<?php echo "window.open('eliminargrupo.php" . $dirini . "&grupo1=" . $codigogrupo . "&idgrupo1=" . $idgrupo . "&Padre=" . $datosvalidacion['padre'] . "','miventana','width=500,height=300,top=150,left=150')"; ?>">
                    </div>
                    <?php
                }
                $botones++;
            }
                $numobj++;
            }
            ?>
            <p align="center">
            <hr>
            <div align="center">
                <font size="2" face="Tahoma">
                    <br/>
                    <?php
                    if(isset($codigofacultad) && ($codigoestadoperiodosesion == 1 OR $codigoestadoperiodosesion == 3 OR $codigoperiodo >= $row_selperiodoactivo['codigoperiodo']) && $username != "adminplantafisica"){
                        ?>
                        <input type="button" name="Nuevo" value="Adicionar un Nuevo Grupo"  onClick="<?php echo "window.open('adicionargrupo.php" . $dirini . "&idgrupo1=" . $idgrupo . "&numerohorassemanales1=" . $numerohorassemanales . "','miventana','width=700,height=200,top=200,left=150')"; ?>">
                        <br>
                        <?php
                    }
                    ?>
                    <br>
                </font>
                <br>
            </div>
            <div align="center">
                <font size="2" face="Tahoma">
                <?php
                if(isset($variables->visualizado)){
                    if(!isset($variables->lineaenfasis)){
                        ?>
                        <input type="button" name="Cancelar" value="Regresar al Plan de Estudio" onClick="window.location.href='../planestudio/materiasporsemestre.php<?php echo "?planestudio=$idplanestudio&visualizado" ?>'" />
                        <?php
                    }else{
                        ?>
                        <input type="button" name="Cancelar" value="Regresar al Plan de Estudio" onClick="window.location.href='../planestudio/lineadeenfasis/materiaslineadeenfasisporsemestre.php<?php echo "?planestudio=$idplanestudio&lineaenfasis=$idlineaenfasis&visualizado" ?>'" />
                        <?php
                    }
                }else{
                    ?>
                    <input type="button" name="Cancelar" value="Salir" onClick="cancelar()" />
                    <?php
                }
                ?>
                </font>
            </div>
    </form>
</body>
</html>