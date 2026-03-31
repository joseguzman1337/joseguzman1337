<?php session_start();

       $fecha = $_POST['finicio']; 
       $fecha2= $_POST['ffinal']; 
	   $base= "select * from periodoacademico where estadoperiodoacademico = 1";
       $sol=mysql_db_query($database_conexion,$base);
	   $totalRows = mysql_num_rows($sol);
       $row=mysql_fetch_array($sol);?>
 <?php  
		 $sql = "insert into contratolaboral(numerodocumento,numerocontratolaboral,codigoperiodoacademico,fechainiciocontratolaboral,fechafinalcontratolaboral,codigotipocontrato,codigoestadotipocontrato)";
		 $sql.= "VALUES('".$_SESSION['numerodocumento']."','".$_POST['numerocontratolaboral']."','".$row['codigoperiodoacademico']."','".$fecha."','".$fecha2."','".$_POST['codigotipocontrato']."','".$_POST['codigoestadotipocontrato']."')"; 
		  
		$result = mysql_query($sql,$conexion);
		
		echo "<h5>¡Gracias! Sus datos han quedado registrados en el sistema</h5>";
		echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=contratolaboral.php'>";
		?>


