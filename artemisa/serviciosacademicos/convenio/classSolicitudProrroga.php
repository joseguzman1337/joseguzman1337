<?php
    session_start();
    include_once('../utilidades/ValidarSesion.php');
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);

    include_once ('../EspacioFisico/templates/template.php');
    include_once ('../EspacioFisico/Solicitud/festivos.php');

    $prorroga = new classSolicitudProrroga();
    $db = getBD();
    $idInstitu = $_POST['idinstituto'];
    $idConvenio = $_POST['convenioID'];
    $actionID = $_POST['Action_id'];
    $idInstituRotac=$_POST['institucionID'];
    $periodo=$_POST['periodo'];
    $actionActividad=$_POST['editData_1'];
    $modalidad=$_POST['modalidad'];

    if ($idInstitu) {
        $prorroga->selectConveniosActual($db, $idInstitu);
    }
    if ($idConvenio) {
        if ($actionID <> 'SaveDataProrroga') {
            $prorroga->infoConvenioContacto($db, $idConvenio);
        }
    }
    if ($actionID === 'SaveDataProrroga') {
        $prorroga->saveProrroga($db, $idConvenio);
    }
    if($idInstituRotac)
    {
    	$prorroga->dataConvenioFacultad($db,$idInstituRotac);
    }
    if($periodo)
    {
    	$cestudiante=$_POST['cestudiante'];
    	$prorroga->dataMateriaPeriodo($db,$periodo,$cestudiante,$modalidad);
    }
    if($actionID === 'calculafecha')
    {
    	$fechaingreso=$_POST['fechaingreso'];
    	$fechaegreso=$_POST['fechaegreso'];
    	$DiasHabiles = $prorroga->DiasHabiles($fechaingreso,$fechaegreso);
    	$CantidadDiasHabiles=$prorroga->Evalua($DiasHabiles);
    	echo json_encode($CantidadDiasHabiles);

    }
    if($actionID === 'SaveDataActividad')
    {
    	$prorroga->saveActividades($db,$prorroga);
    }
    if($actionID === 'deleteActividad')
    {
    	$prorroga->deleteActividad($db);
    }




class classSolicitudProrroga
{
	public function dataMateriaPeriodo($db,$periodo,$cestudiante,$modalidad = 200)
	{
		if($modalidad == 200){
			$sqlMaterias ="SELECT eg.nombresestudiantegeneral,eg.apellidosestudiantegeneral,pl.idplanestudio,d.codigomateria,c.nombrecarrera,
			m.nombremateria,p.semestreprematricula,m.numerocreditos,do.nombredocente,do.apellidodocente,d.codigomateriaelectiva, eg.numerodocumento, per.nombreperiodo
			FROM estudiante e,prematricula p,detalleprematricula d,planestudioestudiante pl,carrera c,materia m,grupo g,docente do, estudiantegeneral eg, periodo per
			where p.codigoestudiante = e.codigoestudiante
			and p.idprematricula = d.idprematricula
			and d.idgrupo = g.idgrupo
			and do.numerodocumento = g.numerodocumento
			and pl.codigoestudiante = p.codigoestudiante
			and c.codigocarrera = e.codigocarrera
			and m.codigomateria = d.codigomateria
			and p.codigoestadoprematricula like '4%'
			and d.codigoestadodetalleprematricula like '3%'
			and pl.codigoestadoplanestudioestudiante like '1%'
			and p.codigoestudiante = '".$cestudiante."'
			and p.codigoperiodo = '".$periodo."'
			and m.TipoRotacionId<>1
			and eg.idestudiantegeneral = e.idestudiantegeneral
			and per.codigoperiodo = p.codigoperiodo
			order by m.nombremateria ";
		}else{
			$sqlMaterias = "SELECT
								m.nombremateria,
								m.codigomateria
							FROM
								planestudioestudiante pl
							INNER JOIN planestudio pe ON pe.idplanestudio = pl.idplanestudio
							INNER JOIN materia m ON m.codigocarrera = pe.codigocarrera
							AND m.TipoRotacionId <> '1'
							WHERE
								pl.codigoestudiante = '".$cestudiante."'
							AND pl.codigoestadoplanestudioestudiante LIKE '1%'";
		}
        $dataMaterias = $db->Execute($sqlMaterias);
        $dataMateriasALL = $dataMaterias->getArray();
        echo json_encode($dataMateriasALL);
	}// function dataMateriaPeriodo
	public function dataConvenioFacultad($db,$idInstituRotac)
	{
		$SQL = "SELECT C.ConvenioId , C.NombreConvenio
                FROM Convenios C
                WHERE C.InstitucionConvenioId='$idInstituRotac'";
        $convenioRotacion = $db->Execute($SQL);
        $convenioRotacionALL = $convenioRotacion->getArray();
        echo json_encode($convenioRotacionALL);
	}
    public function selectConveniosActual($db, $idInstitu)
	{
        $SQL = "SELECT C.ConvenioId , C.NombreConvenio
                FROM Convenios C
                WHERE C.InstitucionConvenioId='$idInstitu'";
        $convenios = $db->Execute($SQL);
        $conveniosALL = $convenios->getArray();
        echo json_encode($conveniosALL);
    }// function dataConvenioFacultad
    public function infoConvenioContacto($db, $idConvenio)
	{
        $SQL = "SELECT
            c.Representante,
            IC.NombreSupervisor,
            c.SupervisorInstitucion,
            c.SupervisorBosque,
            FA.codigofacultad
            FROM
                    Convenios c
            JOIN siq_tipoconvenio stc ON stc.idsiq_tipoconvenio = c.idsiq_tipoconvenio
            JOIN InstitucionConvenios IC ON c.InstitucionConvenioId = IC.InstitucionConvenioId
            JOIN conveniocarrera CR ON c.ConvenioId = CR.ConvenioId
            JOIN carrera CA ON CR.codigocarrera = CA.codigocarrera
            JOIN facultad FA  ON FA.codigofacultad=CA.codigofacultad
            WHERE
                    c.ConvenioId= '$idConvenio'
            GROUP BY c.NombreConvenio";
        $facultadCon = $db->Execute($SQL);
        $facultadConALL = $facultadCon->getArray();
        echo json_encode($facultadConALL);
    }// function infoConvenioContacto
    public function saveProrroga($db, $idConvenio)
	{
        $codigoFacultad = $_POST['codigofacultad'];
        //comprobamos que sea una petición ajax
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            //obtenemos el archivo a subir
            $file = $_FILES['archivo']['name'];

            //comprobamos si existe un directorio para subir el archivo
            //si no es así, lo creamos
            if (!is_dir("fileSolicitudConvenioProrroga/"))
                mkdir("fileSolicitudConvenioProrroga/", 0777);

            //comprobamos si el archivo ha subido
            if ($file && move_uploaded_file($_FILES['archivo']['tmp_name'], "fileSolicitudConvenioProrroga/" . $file)) {
                sleep(3); //retrasamos la petición 3 segundos
                echo $file; //devolvemos el nombre del archivo para pintar la imagen
            }
        } else {
            throw new Exception("Error Processing Request", 1);
        }
        $SQL = "UPDATE Convenios
                SET Estado = 'Solicitado',
                    tipoSolicitud = 'Prorroga',
                    RutaArchivoSolicitdProrroga = '$file',
                    codigofacultad = '$codigoFacultad'
                WHERE
                    ConvenioId = '$idConvenio'";
        $save = $db->Execute($SQL);
        echo json_encode('true');
    }// Function saveProrroga
	function DiasHabiles($fecha_inicial,$fecha_final)
	{

		list($dia,$mes,$year) = explode("-",$fecha_inicial);
		$ini = mktime(0, 0, 0, $mes , $dia, $year);
		list($diaf,$mesf,$yearf) = explode("-",$fecha_final);
		$fin = mktime(0, 0, 0, $mesf , $diaf, $yearf);

		$r = 0;
		while($ini != $fin)
		{
		$ini = mktime(0, 0, 0, $mes , $dia+$r, $year);
		$newArray[] .=$ini;
		$r++;
		}
		return $newArray;
	}//function DiasHabiles
	function Evalua($arreglo)
	{

		$fes=new festivos();
		$j= count($arreglo);


		for($i=0;$i<=$j;$i++)
		{
		 $dia = $arreglo[$i];
				 $fecha = getdate($dia);


							$feriado = $fecha['mday']."-".$fecha['mon'];
							if($fecha["wday"]==0 or $fecha["wday"]==6)
							{
								$dia_ ++;
							}
							elseif($fes->esFestivo($fecha['mday'],$fecha['mon'],$fecha['year']) === true)
							{
								$dia_ ++;
								$mes=$fecha['mon'];
							}


		}
		$rlt = $j - $dia_;
		if($mes === 5)
		{
			$rlt=  $rlt + 1;
		}
		return $rlt;
	}//function Evalua
	public function saveActividades($db,$prorroga)
	{
		$user = $_POST['user'];
		$convenioId=$_POST['convenioId'];
		$actividades = array();
		$idActividades = array();
		$dateAct = date("Y-m-d");
		$actividades = $_POST['actividad'];
		$idActividades = $_POST['idActividad'];
		$idactividadN=$_POST['actividadN'];
        $Periodo     = $_POST['Periodo'];

		if((!empty($idActividades))&&(!empty($actividades)))
		{
			$prorroga->updateActividades($db,$actividades,$idActividades,$user);
		}
		foreach($idactividadN as $actividad)
			{
				 $sqlInsertActividad= "INSERT INTO ActividadConvenios
									(
										ConvenioId,
										NombreActividad,
										UsuarioCreacion,
										UsuarioUltimaModificacion,
										FechaCreacion,
										FechaUltimaModificacion,
                                        CodigoPeriodo
									)
									VALUES
									(
										'".$convenioId."',
										'".$actividad."',
										'".$user."',
										'$user',
										'$dateAct',
										'$dateAct',
                                        '".$Periodo."'
									);";
				$save = $db->Execute($sqlInsertActividad);
			}
			echo json_encode('true');

	}//function saveActividades
	public function updateActividades($db,$actividades=null,$idActividad=null,$user=null)
	{
		$dateAct = date("Y-m-d");
		$i=0;
		foreach($actividades as $actividad )
        {
			$sqlUpdateActividad= "UPDATE ActividadConvenios
				SET NombreActividad ='".$actividad."',
					UsuarioUltimaModificacion = '".$user."',
					FechaUltimaModificacion  = '".$dateAct."'
				WHERE
					(
						ActividadConvenioId = '".$idActividad[$i]."'
					)";

			$update = $db->Execute($sqlUpdateActividad);
			$i++;
		}
	}//UpdateActividades
	public function deleteActividad($db)
	{
		$dateAct = date("Y-m-d");
		$user = $_POST['user'];
		$valueACtividad= $_POST['value'];

        $sqlUpdateActividad= "UPDATE ActividadConvenios
				SET CodigoEstado ='200',
					UsuarioUltimaModificacion = '".$user."',
					FechaUltimaModificacion  = '".$dateAct."'
				WHERE
					(
						ActividadConvenioId = '".$valueACtividad."'
					)";

		$update = $db->Execute($sqlUpdateActividad);
	}
}