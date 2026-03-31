<?php
    session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
session_start();
include_once (realpath(dirname(__FILE__)).'/../../../../EspacioFisico/templates/template.php');
include_once (realpath(dirname(__FILE__)).'/../../../../EspacioFisico/Solicitud/festivos.php');

$prorroga = new classSolicitudProrroga();
$db = getBD();
$idInstitu = $_POST['idinstituto'];
$idConvenio = $_POST['convenioID'];
$actionID = $_POST['Action_id'];
$idInstituRotac=$_POST['institucionID'];
$periodo=$_POST['periodo'];
$actionActividad=$_POST['editData_1'];

if($actionID == 'calculardias')
{
    $fechaingreso=$_POST['fechaingreso'];
	$fechaegreso=$_POST['fechaegreso'];
    $dias = $_POST['dias'];
    $fechaingreso = strtotime($fechaingreso);
    $Fechai = date ( 'j-m-Y' , $fechaingreso ); 
    $fechaegreso = strtotime($fechaegreso);
    $Fechaf = date ( 'j-m-Y' , $fechaegreso );

    include_once('../../../../EspacioFisico/Solicitud/SolicitudEspacio_class.php');
    $C_Solicitud = new SolicitudEspacio();
    
    $contadorL = 0; $contadorMa = 0; $contadorMi = 0; $contadorJ = 0; $contadorV = 0; $contadorS = 0; $contadorD = 0;
    $c=0;
    $nuevafecha = $Fechai;

    $arrayDates = convertDatesRangeToArray($Fechai,$Fechaf,$dias);


    foreach($arrayDates as $fecha)
    {
        #obtiene el dia en numero es decir lunes = 1
        $DiaNum = $C_Solicitud->DiasSemana($fecha);
        #dia lunes
        if($dias[0] == 'true' && $DiaNum == 1) { $contadorL++;}
        #dia martes
        if($dias[1] == 'true' && $DiaNum == 2) { $contadorMa++;}
        #dia miercoles
        if($dias[2] == 'true' && $DiaNum == 3) { $contadorMi++;}
        #dia jueves
        if($dias[3] == 'true' && $DiaNum == 4) { $contadorJ++;}
        #dia viernes
        if($dias[4] == 'true' && $DiaNum == 5) { $contadorV++;}
        #dia sabado
        if($dias[5] == 'true' && $DiaNum == 6) { $contadorS++;}
        #dia domingo
        if($dias[6] == 'true' && $DiaNum == 7) { $contadorD++;}
        $c++;
        
        $nuevafecha = strtotime ( '+1 day' , strtotime ( $nuevafecha ) ) ;
        $nuevafecha = date ( 'j-m-Y' , $nuevafecha );         
    }
    $c = ($contadorL + $contadorMa + $contadorMi + $contadorJ + $contadorV + $contadorS + $contadorD);
    echo $c;
}

function convertDatesRangeToArray($fechaI,$fechaF,array $dias)
{
    #array de dias para comparar si la fehca inicial es alguno de los dias del array
    $arrayDates = array();

    $fechaInicial = new DateTime($fechaI);

    $fechaFinal = new DateTime($fechaF);
    $diff = $fechaInicial->diff($fechaFinal);
    $fechaInicialArray = $fechaInicial->format('Y-m-d');

    #se recorren las fechas para insertarlas al array
    for($i = 0; $i <= $diff->days; $i++)
    {
        $arrayDates[] = $fechaInicialArray;
        $fechaInicialArray = $fechaInicial->modify('+1 day')->format('Y-m-d');
    }
    return $arrayDates;
}

if($actionID == 'VerInstituciones')
{
    $id = $_POST['id'];
    $sqlinstituciones = "SELECT ic.InstitucionConvenioId, ic.NombreInstitucion, ui.IdUbicacionInstitucion, ui.NombreUbicacion FROM InstitucionConvenios ic INNER JOIN UbicacionInstituciones ui ON ui .InstitucionConvenioId = ic.InstitucionConvenioId INNER JOIN Convenios c ON c.InstitucionConvenioId = ic.InstitucionConvenioId where c.ConvenioId = '".$id."'";
    $instituciones = $db->GetAll($sqlinstituciones); 
          
    $imp = "<select id='institucionID'  name='institucionID' ><option value='-1' ></option>";
    foreach($instituciones as $lista)
    {
        $imp.= "<option value='".$lista['InstitucionConvenioId']."-".$lista['IdUbicacionInstitucion']."'>".$lista['NombreInstitucion']." - ".$lista['NombreUbicacion']."</option>";
    } 
    $imp.="</select>";
    echo $imp;  
}

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
	$prorroga->dataMateriaPeriodo($db,$periodo,$cestudiante);
}
if($actionID === 'calcularfechas')
{
	$fechaingreso=$_POST['fechaingreso'];
	$fechaegreso=$_POST['fechaegreso'];
	$DiasHabiles = $prorroga->DiasHabiles($fechaingreso,$fechaegreso);    
	$CantidadDiasHabiles=$prorroga->Evalua($DiasHabiles);
	echo json_encode($CantidadDiasHabiles);
}

if($actionID === 'CalcularHoras')
{    
    $jornada = $_POST['jornada'];
    $dias = $_POST['dias'];
    switch($jornada)
    {
        case '1':
        {
            $totalhoras = $dias * 12;
        }break;
        case '2':
        {
            $totalhoras = $dias * 5;
        }break;
        case '3':
        {
            $totalhoras = $dias * 5;
        }break;
        case '4':
        {
            $totalhoras = $dias * 5;
        }break;
        case '5':
        {
            $totalhoras = $dias * 12;
        }break;
        case '6':
        {
            $totalhoras = '432';
        }break;
        case '7':
        {
            $totalhoras = $dias * 4;
        }break;
    }
   echo $totalhoras;
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
	public function dataMateriaPeriodo($db,$periodo,$cestudiante)
	{
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
                        // echo $sqlMaterias;
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
										'".$user."',
										'".$dateAct."',
										'".$dateAct."',
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