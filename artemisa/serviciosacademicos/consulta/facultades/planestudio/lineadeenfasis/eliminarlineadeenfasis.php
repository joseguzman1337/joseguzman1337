<?php
    session_start();
    include_once('../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION); 
    
require_once('../../../../Connections/sala2.php');
mysql_select_db($database_sala, $sala);
session_start();
require_once('../seguridadplandeestudio.php');
if(isset($_GET['planestudio']))
{
	$idplanestudio = $_GET['planestudio'];
	$idlineaenfasis = $_GET['lineaenfasis'];
	//echo "<br>$idplanestudio";
}
if(!isset($_GET['eliminar']))
{
	echo '<script language="javascript">
		if(!confirm("¿Desea eliminar la línea de énfasis?"))
		{
			window.location.href="lineadeenfasisinicial.php?planestudio='.$idplanestudio.'";
		}
		else
		{
			window.location.href="eliminarlineadeenfasis.php?planestudio='.$idplanestudio.'&lineaenfasis='.$idlineaenfasis.'&eliminar";
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
	// Elimina la linea de enfasis
	$query_updeliminarlineaenfasis = "UPDATE lineaenfasisplanestudio
	SET codigoestadolineaenfasisplanestudio = '200'
	WHERE idplanestudio = '$idplanestudio'
	and idlineaenfasisplanestudio = '$idlineaenfasis'";
	//echo "<br>$query_updeliminarlineaenfasis<br>";
	$updeliminarlineaenfasis = mysql_query($query_updeliminarlineaenfasis, $sala) or die("$query_updeliminarlineaenfasis");

	// Elimina el detalle de la linea de enfasis
	$query_updeliminardetallelineaenfasis = "UPDATE detallelineaenfasisplanestudio
	SET codigoestadodetallelineaenfasisplanestudio='200'
	WHERE idplanestudio = '$idplanestudio'
	and idlineaenfasisplanestudio = '$idlineaenfasis'";
	//echo "<br>$query_updeliminardetallelineaenfasis<br>";
	$updeliminardetallelineaenfasis = mysql_query($query_updeliminardetallelineaenfasis, $sala) or die("query_updeliminardetallelineaenfasis");

	// Elimina la referencia al plan de estudios
	$query_updeliminarreferenciaplanestudio = "UPDATE referenciaplanestudio
	SET codigoestadoreferenciaplanestudio='200'
	WHERE idplanestudio = '$idplanestudio'
	and idlineaenfasisplanestudio = '$idlineaenfasis'";
	//echo "<br>$query_updeliminarreferenciaplanestudio<br>";
	$updeliminarreferenciaplanestudio = mysql_query($query_updeliminarreferenciaplanestudio, $sala) or die("query_updeliminarreferenciaplanestudio");
	echo '<script language="javascript">
		alert("La línea de énfasis ha sido eliminada");
		window.location.href="lineadeenfasisinicial.php?planestudio='.$idplanestudio.'";
	</script>';
}
?>
</body>
</html>
