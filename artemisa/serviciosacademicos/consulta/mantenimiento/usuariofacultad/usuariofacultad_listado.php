<?php
session_start();
require_once('../../../funciones/clases/autenticacion/redirect.php');
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
	if($_SESSION['codigocarrera']<>$_GET['codigocarrera'])
	{
		$_SESSION['codigocarrera']=$_GET['codigocarrera'];
	}
}
elseif(isset($_GET['codigomodalidadacademica']) and !empty($_GET['codigomodalidadacademica']))
{
	if($_SESSION['codigomodalidadacademica']<>$_GET['codigomodalidadacademica'])
	{
		$_SESSION['codigomodalidadacademica']=$_GET['codigomodalidadacademica'];
	}

}
$codigocarrera=$_SESSION['codigocarrera'];
$codigomodalidadacademica=$_SESSION['codigomodalidadacademica'];
if($codigocarrera<>"")
{

	$query="SELECT
	us.idusuario,us.usuario,c.nombrecarrera, tuf.nombretipousuariofacultad, us.emailusuariofacultad
	FROM
	usuariofacultad us, carrera c, tipousuariofacultad tuf
	WHERE
	us.codigofacultad=c.codigocarrera
	AND c.codigocarrera='$codigocarrera'
	AND us.codigotipousuariofacultad=tuf.codigotipousuariofacultad
	";
}
else
{
	$query="SELECT
	us.idusuario,us.usuario,c.nombrecarrera, tuf.nombretipousuariofacultad, us.emailusuariofacultad
	FROM
	usuariofacultad us, carrera c, tipousuariofacultad tuf
	WHERE
	us.codigofacultad=c.codigocarrera
	AND c.codigomodalidadacademica='$codigomodalidadacademica'
	AND us.codigotipousuariofacultad=tuf.codigotipousuariofacultad
	";
}
$operacion=$sala->query($query);
$row_operacion=$operacion->fetchRow();
do
{
	if($row_operacion['idusuario']<>"")
	{
		$array_interno[]=$row_operacion;
	}
}
while($row_operacion=$operacion->fetchRow());
$motor = new matriz($array_interno,"Listado tabla usuariofacultad","usuariofacultad_listado.php","si","si","menu.php",$_SERVER['REQUEST_URI'],true,"si","../../../");
$motor->agregarllave_emergente("usuario","usuariofacultad_listado.php","usuariofacultad.php","usuariofacultad","idusuario","",850,400,200,150);
$motor->mostrar();
$formulario->boton_ventana_emergente("Agregar","usuariofacultad.php","",850,400,200,150);
?>
</body>
</html>
