<?php session_start();

	 $fecha = $_POST['finicio']; 
	 $fecha2= $_POST['ffinal']; 
	 $base= "update historiallaboral set  empresahistoriallaboral = '".$_POST['empresahistoriallaboral']."',cargohistoriallaboral ='".$_POST['cargohistoriallaboral']."',tiempohistoriallaboral ='".$_POST['tiempohistoriallaboral']."',fechainiciohistoriallaboral ='".$fecha."',fechafinalhistoriallaboral ='".$fecha2."',escalafondocenciahistoriallaboral ='".$_POST['escalafondocenciahistoriallaboral']."',codigohistoriallaboral ='".$_POST['codigohistoriallaboral']."' where  idhistoriallaboral = '".$_POST['modificar']."'";
	 $sol=mysql_db_query($database_conexion,$base);
	 //echo  $base;
	// exit(); 
	 echo "<h5>Los datos han sido modificados</h5>";
	 echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=historiallaboral.php'>";
?>