<?php
session_start();
include_once('../../../utilidades/ValidarSesion.php');
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);
include (realpath(dirname(__FILE__) . "/../../../../sala/includes/adaptador.php"));


require_once('seguridadplandeestudio.php');
if(isset($_GET['planestudio']))
{
	$idplanestudio = $_GET['planestudio'];
	//echo "<br>$idplanestudio";
}
if(!isset($_GET['eliminar']))
{
	echo '<script language="javascript">
		if(!confirm("¿Desea eliminar el plan de estudio?"))
		{
			window.location.href="plandeestudioinicial.php";
		}
		else
		{
			window.location.href="eliminarplandeestudio.php?planestudio='.$idplanestudio.'&eliminar";
		}
	</script>';
}
?>
<html>
<head>
<title>Eliminar Plan de Estudio en Construcción</title>
</head>
<body>
<?php
if(isset($_GET['eliminar']))
{
	// Elimina el plan de estudios
	$query_updeliminarplanestudio = "UPDATE planestudio
	SET codigoestadoplanestudio = '200'
	WHERE idplanestudio = '$idplanestudio'";
	//echo "<br>$query_updeliminarplanestudio<br>";
	$updeliminarplanestudio = $db->Execute($query_updeliminarplanestudio);

	// Elimina el detalle del plan de estudios
	$query_updeliminardetalleplanestudio = "UPDATE detalleplanestudio
	SET codigoestadodetalleplanestudio = '200'
	WHERE idplanestudio = '$idplanestudio'";
	//echo "<br>$query_updeliminardetalleplanestudio<br>";
	$updeliminardetalleplanestudio = $db->Execute($query_updeliminardetalleplanestudio);

	// Elimina la linea de enfasis
	$query_updeliminarlineaenfasis = "UPDATE lineaenfasisplanestudio
	SET codigoestadolineaenfasisplanestudio = '200'
	WHERE idplanestudio = '$idplanestudio'";
	//echo "<br>$query_updeliminarlineaenfasis<br>";
	$updeliminarlineaenfasis = $db->Execute($query_updeliminarlineaenfasis);

	// Elimina el detalle de la linea de enfasis
	$query_updeliminardetallelineaenfasis = "UPDATE detallelineaenfasisplanestudio
	SET codigoestadodetallelineaenfasisplanestudio='200'
	WHERE idplanestudio = '$idplanestudio'";
	//echo "<br>$query_updeliminardetallelineaenfasis<br>";
	$updeliminardetallelineaenfasis = $db->Execute($query_updeliminardetallelineaenfasis);

	// Elimina la referencia al plan de estudios
	$query_updeliminarreferenciaplanestudio = "UPDATE referenciaplanestudio
	SET codigoestadoreferenciaplanestudio='200'
	WHERE idplanestudio = '$idplanestudio'";
	//echo "<br>$query_updeliminarreferenciaplanestudio<br>";
	$updeliminarreferenciaplanestudio = $db->Execute($query_updeliminarreferenciaplanestudio);

	// Elimina los estudiantes que tengan el plan de estudios
	$query_updeliminarplanestudioestudiante = "UPDATE planestudioestudiante
	SET codigoestadoplanestudioestudiante='200'
	WHERE idplanestudio = '$idplanestudio'";
	//echo "<br>$query_updeliminarreferenciaplanestudio<br>";
	$updeliminarplanestudioestudiante = $db->Execute($query_updeliminarplanestudioestudiante);
?>
<script language="javascript">
	alert("El plan de estudio ha sido eliminado");
	window.location.href="plandeestudioinicial.php";
</script>
<?php
}
?>
</body>
</html>
