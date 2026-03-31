<?php
session_start();
$rol=$_SESSION['rol'];
$codigoperiodo=$_GET['codigoperiodo'];
//$codigoperiodo=20062;
$usuario=$_SESSION['MM_Username'];
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Aplica ARP Listado</title>
<link rel="stylesheet" type="text/css" href="../../../estilos/sala.css">
</head>
<?php
$rutaado="../../../funciones/adodb/";
require_once("../../../Connections/salaado-pear.php");
require_once("../../../funciones/clases/formulariov2/clase_formulario.php");
require_once("../../../funciones/clases/motorv2/motor.php");
require_once('../../../funciones/clases/autenticacion/redirect.php'); 
$formulario = new formulario(&$sala,"formulario","post","",true,"aplicaarp_listado.php");
$formulario->jsVarios();
$fechahoy=$formulario->fechahoy;
?>
<body>
<form name="formulario" method="POST" action="">
<input type="hidden" name="codigocarrera" value="<?php echo $_GET['codigocarrera'];?>"
<input type="hidden" name="codigomodalidadacademica" value="<?php echo $_GET['codigomodalidadacademica'];?>"
</form>

<?php
if(isset($_GET['codigocarrera']) and !empty($_GET['codigocarrera']))
{

	$codigocarrera=$_GET['codigocarrera'];
	$query_aplicaarp="SELECT
	ap.idaplicaarp, 
	ap.nombreaplicaarp, 
	c.nombrecarrera, 
	ap.codigoperiodo, 
	es.nombreempresasalud, 
	ap.valorbaseaplicaarp, 
	ap.porcentajeaplicaarp, 
	ap.valorfijoaplicaarp, 
	ap.fechaaplicaarp, 
	ap.fechainicioaplicaarp, 
	ap.fechafinalaplicaarp, 
	tap.codigotipoaplicaarp, 
	co.codigoconcepto, 
	ap.semestreinicioaplicaarp, 
	ap.semestrefinalaplicaarp 
	FROM
	aplicaarp ap, carrera c, concepto co, tipoaplicaarp tap, empresasalud es
	WHERE
	ap.codigocarrera=c.codigocarrera
	AND ap.codigoconcepto=co.codigoconcepto
	AND ap.codigotipoaplicaarp=tap.codigotipoaplicaarp
	AND ap.idempresasalud=es.idempresasalud
	AND ap.codigoperiodo='$codigoperiodo'
	AND ap.codigocarrera='$codigocarrera'
	";
}
elseif(isset($_GET['codigomodalidadacademica']) and !empty($_GET['codigomodalidadacademica']))
{
	$codigomodalidadacademica=$_GET['codigomodalidadacademica'];
	$query_aplicaarp="SELECT
	ap.idaplicaarp, 
	ap.nombreaplicaarp, 
	c.nombrecarrera, 
	ap.codigoperiodo, 
	es.nombreempresasalud, 
	ap.valorbaseaplicaarp, 
	ap.porcentajeaplicaarp, 
	ap.valorfijoaplicaarp, 
	ap.fechaaplicaarp, 
	ap.fechainicioaplicaarp, 
	ap.fechafinalaplicaarp, 
	tap.codigotipoaplicaarp, 
	co.codigoconcepto, 
	ap.semestreinicioaplicaarp, 
	ap.semestrefinalaplicaarp 
	FROM
	aplicaarp ap, carrera c, concepto co, tipoaplicaarp tap, empresasalud es, modalidadacademica ma
	WHERE
	ap.codigocarrera=c.codigocarrera
	AND ap.codigoconcepto=co.codigoconcepto
	AND ap.codigotipoaplicaarp=tap.codigotipoaplicaarp
	AND ap.idempresasalud=es.idempresasalud
	AND ap.codigoperiodo='$codigoperiodo'
	AND c.codigomodalidadacademica=ma.codigomodalidadacademica
	AND ma.codigomodalidadacademica='$codigomodalidadacademica'
	";
}
$operacion=$sala->query($query_aplicaarp);
$row_operacion=$operacion->fetchRow();
do
{
	if($row_operacion['idaplicaarp']<>"")
	{
		$array_interno[]=$row_operacion;
	}
}
while($row_operacion=$operacion->fetchRow());
$motor = new matriz($array_interno,"Listado aplicaarp periodo $codigoperiodo","aplicaarp_listado.php","si","si","menu.php",$_SERVER['REQUEST_URI'],true,"si","../../../");
$motor->agregarllave_emergente("idaplicaarp","aplicaarp_listado.php","aplicaarp.php","aplicaarp","idaplicaarp","codigoperiodo=$codigoperiodo",850,400,200,150,"yes","yes","no","no","no");
$motor->mostrar();
$formulario->boton_ventana_emergente("Agregar","aplicaarp.php","codigocarrera=$codigocarrera&codigoperiodo=$codigoperiodo",850,400,200,150);


?>
</body>
</html>
