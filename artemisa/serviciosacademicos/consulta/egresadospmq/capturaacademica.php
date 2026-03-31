<?php 
$fecha = $_POST['ano']; 
  
	 $sql = "insert into historialacademico(numerodocumento,tituloobtenidohistorialacademico,institucionhistorialacademico,lugarhistorialacademico,fechagradohistorialacademico,codigotipogrado)";
	 $sql.= "VALUES('".$_SESSION['numerodocumento']."','".$_POST['tituloobtenidohistorialacademico']."','".$_POST['institucionhistorialacademico']."','".$_POST['lugarhistorialacademico']."','".$fecha."','".$_POST['codigotipogrado']."')"; 
	  
	$result = mysql_query($sql,$conexion);	
	echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=academica.php'>";
?>

