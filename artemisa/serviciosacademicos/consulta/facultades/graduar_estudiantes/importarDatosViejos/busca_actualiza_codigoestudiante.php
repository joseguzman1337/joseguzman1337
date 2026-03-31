<?php
session_start();
ini_set('memory_limit', '256M');
ini_set('max_execution_time','6400000');

//$_SESSION['MM_Username']='dirsecgeneral';
//print_r($_SESSION);
$rutaado=("../../../../funciones/adodb/");
require_once("../../../../funciones/clases/debug/SADebug.php");
require_once("../../../../Connections/salaado-pear.php");
require_once("../../../../funciones/clases/motorv2/motor.php");
require_once("../funciones/obtener_datos.php");
?>
<link rel="stylesheet" type="text/css" href="../../../../estilos/sala.css">
<?php
$query="select idregistrograduadoantiguo,documentoegresadoregistrograduadoantiguo,codigocarrera
FROM registrograduadoantiguo
";
$operacion=$sala->query($query);
$row_operacion=$operacion->fetchRow();
do
{
	$idestudiantegeneral=leer_datos_estudiante_documento($row_operacion['documentoegresadoregistrograduadoantiguo'],$sala);
	echo $idestudiantegeneral,"<br>";
	if(!empty($idestudiantegeneral))
	{
		$codigoestudiante=lee_codigo_estudiante($idestudiantegeneral,$row_operacion['codigocarrera'],$sala);
		if(!empty($codigoestudiante))
		{
			$actualiza="UPDATE registrograduadoantiguo SET codigoestudiante='$codigoestudiante' WHERE idregistrograduadoantiguo = '".$row_operacion['idregistrograduadoantiguo']."'";
			$act=$sala->query($actualiza);
		}
	}

}
while ($row_operacion=$operacion->fetchRow());

function leer_datos_estudiante_documento($numerodocumento,$sala)
{
	$query="SELECT eg.idestudiantegeneral
		FROM 
		estudiantegeneral eg
		WHERE eg.numerodocumento='$numerodocumento'
		";
	$operacion=$sala->query($query);
	$row_operacion=$operacion->fetchRow();
	if(!empty($row_operacion))
	{
		return $row_operacion['idestudiantegeneral'];
	}
}
function lee_codigo_estudiante($idestudiantegeneral,$codigocarrera,$sala)
{
	$query="SELECT e.codigoestudiante FROM estudiante e, estudiantegeneral eg
		WHERE e.idestudiantegeneral=eg.idestudiantegeneral
		AND e.codigocarrera='$codigocarrera'
		AND e.idestudiantegeneral='$idestudiantegeneral'
		";
	$operacion=$sala->query($query);
	$row_operacion=$operacion->fetchRow();
	if(!empty($row_operacion['codigoestudiante']))
	{
		return $row_operacion['codigoestudiante'];
	}
}
?>
