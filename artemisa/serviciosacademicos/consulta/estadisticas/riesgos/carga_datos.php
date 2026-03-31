<?PHP 
session_start();
include_once('../../../utilidades/ValidarSesion.php'); 
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);

//session_start();
if(!isset ($_SESSION['MM_Username'])){
	echo '<blink><strong style="color:#F00; font-size:18px">No ha iniciado sesión en el sistema</strong></blink>';
	exit();
} 
switch($_REQUEST['actionID']){
	case'Buscar':{
		global $C_EstudianteRiesgo,$userid,$db;
		MainGeneral();
		JsGenral();
		
		
		$id_carrera			= $_GET['id_carrera'];
		$Periodo			= $_GET['Periodo'];
		$Semestre			= $_GET['Semestre'];
		$Riesgo				= $_GET['Riesgo'];
		
		
		$C_EstudianteRiesgo->Buscar($id_carrera,$Periodo,$Semestre,$Riesgo);
		
		}break;
        	case 'autoCompleteMateria':{
		global $userid,$db;
		MainJson();
		
		$Letra   = $_REQUEST['term'];
		$codigocarrera = $_REQUEST['carrera'];
		
		  $SQL_Materia='SELECT codigomateria as id, nombremateria FROM materia where codigocarrera="'.$codigocarrera.'"
						AND
						nombremateria LIKE "%'.$Letra.'%"';
						
				if($D_Materia=&$db->Execute($SQL_Materia)===false){
						echo 'Error en el SQL de Auto Completar Materia...<br>'.$SQL_Materia;
						die;
					}
							
		$Result_F = array();
				
				if(!$D_Materia->EOF){
									
					while(!$D_Materia->EOF){
						
							$Rf_Vectt['label']=$D_Materia->fields['nombremateria'];
							$Rf_Vectt['value']=$D_Materia->fields['nombremateria'];
							
							$Rf_Vectt['codigomateria']=$D_Materia->fields['id'];
							
							array_push($Result_F,$Rf_Vectt);
						$D_Materia->MoveNext();	
						
						}
				}else{
					
					$Rf_Vectt['label']= 'No Hay Resultados...';
					
					array_push($Result_F,$Rf_Vectt);
					}
					
			echo json_encode($Result_F);		
					
		
		}break;
	case 'autoCompleteCarrera':{
		global $userid,$db;
		MainJson();
		
		$Letra   = $_REQUEST['term'];
		$id_Movilidad = $_REQUEST['id_Movilidad'];
		
		  $SQL_Carrera='SELECT 
						
						codigocarrera as id,
						nombrecarrera 
						
						FROM 
						
						carrera
						
						WHERE
						
						codigomodalidadacademica="'.$id_Movilidad.'"
						AND
						nombrecarrera LIKE "%'.$Letra.'%"';
						
				if($D_Carrera=&$db->Execute($SQL_Carrera)===false){
						echo 'Error en el SQL de Auto Completar Carrera...<br>'.$SQL_Carrera;
						die;
					}
							
		$Result_F = array();
				
				if(!$D_Carrera->EOF){
									
					while(!$D_Carrera->EOF){
						
							$Rf_Vectt['label']=$D_Carrera->fields['nombrecarrera'];
							$Rf_Vectt['value']=$D_Carrera->fields['nombrecarrera'];
							
							$Rf_Vectt['id_carrera']=$D_Carrera->fields['id'];
							
							array_push($Result_F,$Rf_Vectt);
						$D_Carrera->MoveNext();	
						
						}
				}else{
					
					$Rf_Vectt['label']= 'No Hay Resultados...';
					
					array_push($Result_F,$Rf_Vectt);
					}
					
			echo json_encode($Result_F);		
					
		
		}break;
	case 'autoCompleModalidad':{
		global $userid,$db;
		MainJson();
		
		$Letra   = $_REQUEST['term'];
		
		$SQL_Modalidad='SELECT 

						codigomodalidadacademica as id,
						nombremodalidadacademica as nombre
						
						
						FROM 
						
						modalidadacademica
						
						WHERE
						
						codigoestado=100
						AND
						nombremodalidadacademica LIKE "%'.$Letra.'%"';
						
				if($D_Movilidad=&$db->Execute($SQL_Modalidad)===false){
						echo 'Error en el SQL Autocompletar Movilidad...'.$SQL_Modalidad;
						die;
					}	
					
			$Result_F = array();
				
				if(!$D_Movilidad->EOF){
									
					while(!$D_Movilidad->EOF){
						
							$Rf_Vectt['label']=$D_Movilidad->fields['nombre'];
							$Rf_Vectt['value']=$D_Movilidad->fields['nombre'];
							
							$Rf_Vectt['id_modalidad']=$D_Movilidad->fields['id'];
							
							array_push($Result_F,$Rf_Vectt);
						$D_Movilidad->MoveNext();	
						
						}
				}else{
					
					$Rf_Vectt['label']= 'No Hay Resultados...';
					
					array_push($Result_F,$Rf_Vectt);
					}
					
			echo json_encode($Result_F);				
		
		}break;
	default:{
		
		global $C_EstudianteRiesgo,$userid,$db;
		MainGeneral();
		JsGenral();
		
		$C_EstudianteRiesgo->Principal();
		
		}break;
	
	}

function MainGeneral(){
		
		
		global $C_EstudianteRiesgo,$userid,$db;
		

		include("../../../men/templates/MenuReportes.php");

		require('carga_datos.class.php');  $C_EstudianteRiesgo = new Estudiante_Riesgo();

		$SQL_User='SELECT idusuario as id FROM usuario WHERE usuario="'.$_SESSION['MM_Username'].'"';

		if($Usario_id=&$db->Execute($SQL_User)===false){
				echo 'Error en el SQL Userid...<br>'.$SQL_User;
				die;
			}

		 $userid=$Usario_id->fields['id'];
	}
function MainJson(){
	
	global $userid,$db;
		
		
		include("../../../men/templates/mainjson.php");
		
		
		$SQL_User='SELECT idusuario as id FROM usuario WHERE usuario="'.$_SESSION['MM_Username'].'"';

		if($Usario_id=&$db->Execute($SQL_User)===false){
				echo 'Error en el SQL Userid...<br>'.$SQL_User;
				die;
			}
		
		 $userid=$Usario_id->fields['id'];
	}	
function JsGenral(){
	?>
    <style>
    .Borde_td{
	border:#000000 1px solid;
	}
	.Titulos{
		border:#000000 1px solid;
		background-color:#90A860;
	}
    </style>
<?PHP
}
?>