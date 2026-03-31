<?php
session_start();
?>
<link rel="stylesheet" type="text/css" href="../../../estilos/sala.css">
<?php
if($_SESSION['MM_Username']=="")
{
	echo "<h1>Usted No está autorizado para ver esta página</h1>";
	exit();
}
if(empty($_SESSION['codigoperiodosesion']))
{
	echo "<h1>Debe seleccionar un periodo para la consulta</h1>";
	exit();
}
$rutaado=("../../../funciones/adodb/");
require_once('../../../Connections/salaado-pear.php');
require_once('../../../funciones/clases/motor/motor.php');
?>
<?php
$codigoperiodo=$_SESSION['codigoperiodosesion'];

$query="SELECT DISTINCT
e.codigoestudiante,
eg.numerodocumento,
eg.apellidosestudiantegeneral,
eg.nombresestudiantegeneral,
e.codigocarrera,
c.nombrecarrera,
oi.numeroordeninternasap,
op.numeroordenpago,
eo.nombreestadoordenpago,
op.fechaordenpago,
co.nombreconcepto,
do.valorconcepto,
ep.nombreestadoprematricula
FROM numeroordeninternasap oi, detalleprematricula dp, prematricula pm, estudiante e,carrera c,ordenpago op,detalleordenpago do,estudiantegeneral eg, estadoprematricula ep, concepto co, estadoordenpago eo
WHERE 
oi.idgrupo = dp.idgrupo
AND dp.idprematricula = pm.idprematricula
AND pm.idprematricula = op.idprematricula
AND op.numeroordenpago = do.numeroordenpago 
AND do.codigoconcepto = co.codigoconcepto        
AND pm.codigoestadoprematricula = ep.codigoestadoprematricula
AND op.codigoestadoordenpago = eo.codigoestadoordenpago
AND pm.codigoestudiante = e.codigoestudiante
AND e.idestudiantegeneral = eg.idestudiantegeneral
AND e.codigocarrera = c.codigocarrera
AND op.codigoperiodo='$codigoperiodo'
";
$operacion=$sala->query($query);
$row_operacion=$operacion->fetchRow();
do
{
	if($row_operacion['codigoestudiante']<>"")
	{
		$array_interno[]=$row_operacion;
	}
}
while ($row_operacion=$operacion->fetchRow());

$matriz = new matriz($array_interno,"Listado Ordenes Internas Educación Continuada $codigoperiodo","ordenesinternas.php","si","si","","ordenesinternas.php",true,"si");
$matriz->mostrar();
?>