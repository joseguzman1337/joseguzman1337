<?php
ini_set('memory_limit', '128M');
ini_set('max_execution_time','216000');
$rutaado=("../../../funciones/adodb/");
require_once("../../../Connections/salaado-pear.php");
require_once("../../../funciones/clases/formulario/auto_formulario.php");
require_once("../../../funciones/clases/debug/SADebug.php");
if($_SESSION['usuario']<>"admintecnologia" && $_SESSION['usuario'] <> "coordinadorsisinfo")
{

	echo "<h1>Usted no tiene permiso para ver esta página</h1>";
	exit();
}
$query="show tables from sala";
$operacion=$sala->query($query);
;
do
{
	$array_interno[]=$row_operacion;
}
while ($row_operacion=$operacion->fetchRow());

foreach ($array_interno as $llave => $valor)
{
	$tabla=$valor['Tables_in_sala'];
	if($tabla<>"")
	{
		$generador = new GeneradorArchivoDescripcionTabla($tabla,$sala,'sala',false);
		$array_coincidencias=$generador->BuscarCoincidenciasTabla($tabla);
		$ruta="/var/tmp/";
		$generador->GenerarArchivoSeparadoPorComas($array_coincidencias,$ruta,$tabla.".txt");
		unset($generador);
	}
}
?>