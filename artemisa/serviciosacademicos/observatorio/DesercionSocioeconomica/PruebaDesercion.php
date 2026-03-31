<?PHP 
session_start();

/*if(!isset ($_SESSION['MM_Username'])){
	echo '<blink><strong style="color:#F00; font-size:18px">No ha iniciado sesión en el sistema</strong></blink>';
	exit();
} */

global $db,$userid;
MainJson();

$codigoperiodo	='20122';

include('../../consulta/estadisticas/matriculasnew/funciones/obtener_datos.php');

$datos_estadistica=new obtener_datos_matriculas($db,$codigoperiodo);

$DesercionDato=$datos_estadistica->obtener_datos_estudiantes_desercion('5','conteo');

echo '<pre>';print_r($DesercionDato);

$DesercionArray=$datos_estadistica->obtener_datos_estudiantes_desercion('5','arreglo');

echo '<pre>';print_r($DesercionArray);

function MainJson(){
	
	global $db,$userid;
	
	include ('../templates/mainjson.php');
	
	
	$SQL_User='SELECT idusuario as id FROM usuario WHERE usuario="'.$_SESSION['MM_Username'].'"';
	
	if($Usario_id=&$db->Execute($SQL_User)===false){
		echo 'Error en el SQL Userid...<br>';
		die;
	}
	
	$userid=$Usario_id->fields['id'];
	
}

?>