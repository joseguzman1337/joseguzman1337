<?php
session_start();
if(!isset($_SESSION['MM_Username']))
{
	echo "<h1>Usted no está autorizado para ver esta página</h1>";
	exit();
}
ini_set('memory_limit', '128M');
ini_set('max_execution_time','216000');
//error_reporting(2047);
?>
<link rel="stylesheet" type="text/css" href="../../estilos/sala.css">
<script type="text/javascript" src="../../funciones/javascript/funciones_javascript.js"></script>
<?php
$fechahoy=date("Y-m-d H:i:s");
$rutaado=("../../funciones/adodb/");
require_once('../../Connections/salaado-pear.php');
require_once("../../funciones/clases/motorv2/motor.php");
?>
<?php
$query="
SELECT
cch.idcarreracolorhorario,c.nombrecarrera, cch.nombrecarreracolorhorario, e.nombreestado
FROM
carrera c, carreracolorhorario cch, estado e
WHERE
c.codigocarrera=cch.codigocarrera
AND cch.codigoestado=e.codigoestado
ORDER by c.nombrecarrera
";
$operacion=$sala->query($query);
$row_operacion=$operacion->fetchRow();
do
{
	if(!empty($row_operacion))
	{
		$array_interno[]=$row_operacion;
	}
}
while($row_operacion=$operacion->fetchRow());
$motor=new matriz($array_interno,"Listado de parametrización colores para horarios","carreracolorhorario_listado.php","si","no","menu.php","",true,"si");
$motor->agregarllave_emergente("nombrecarrera","carreracolorhorario_listado.php","carreracolorhorario.php","carreracolorhorario","idcarreracolorhorario","",800,200);
$motor->mostrar();
?>
