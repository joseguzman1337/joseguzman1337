<?php require_once('../../../../Connections/conexion.php');session_start();

$fecha = $_POST['fgrado']; 
	 $sql = "insert into capacitacion
	 (numerodocumento,
	 tituloobtenidocapacitacion,
	 codigopais,
	 periodocapacitacion,
	 aniocapacitacion,
	 codigotipocapacitacion,
	 codigotipofinanciacion,
	 codigotipogrado,
	 fechacapacitacion)";
	 $sql.= "VALUES(
	 '".$_SESSION['numerodocumento']."',
	 '".$_POST['tituloobtenidocapacitacion']."',
	 '".$_POST['codigopais']."',
	 '".$_POST['periodocapacitacion']."',
	 '".$_POST['aniocapacitacion']."',
	 '".$_POST['codigotipocapacitacion']."',
	 '".$_POST['codigotipofinanciacion']."',
	 '".$_POST['codigotipogrado']."',
	 '".date("Y-m-d")."')"; 
	$result = mysql_query($sql,$conexion);
	echo "<h5>¡Gracias! Sus datos han quedado registrados en el sistema</h5>";
	echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=capacitacion.php'>";
?>

