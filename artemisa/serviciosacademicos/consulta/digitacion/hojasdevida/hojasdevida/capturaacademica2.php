<?php require_once('../../../../Connections/conexion.php');session_start();

$fecha = $_POST['fgrado']; 

 
	 $sql = "insert into historialacademico(numerodocumento,tituloobtenidohistorialacademico,institucionhistorialacademico,lugarhistorialacademico,fechagradohistorialacademico,codigotipogrado)";
	 $sql.= "VALUES('".$_SESSION['numerodocumento']."','".$_POST['tituloobtenidohistorialacademico']."','".$_POST['institucionhistorialacademico']."','".$_POST['lugarhistorialacademico']."','".$fecha."','".$_POST['codigotipogrado']."')"; 
	  
	$result = mysql_query($sql,$conexion);
	
	echo "<h5>¡Gracias! Sus datos han quedado registrados en el sistema</h5>";
	echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=academica.php'>";
?>

