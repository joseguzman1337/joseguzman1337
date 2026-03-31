<?php require_once('../../../../Connections/conexion.php');session_start();?>
<input name="detalle" type="hidden" value="<?php echo $_GET['detalle']; ?>">
<?php
       $base2= "select * from jornadalaboral,detallejornadalaboral,dia where ((dia.codigodia = detallejornadalaboral.codigodia) and (detallejornadalaboral.idjornadalaboral=jornadalaboral.idjornadalaboral)and(jornadalaboral.numerodocumento='".$_SESSION['numerodocumento']."'))";
       $sol2=mysql_db_query($database_conexion,$base2);
	   $totalRows2= mysql_num_rows($sol2);
       $row2=mysql_fetch_array($sol2); 
	 do   
      { 
       if (($row2['codigodia']==$_POST['codigodia'])and(date("h-i-s",strtotime($_POST['horainicialdetallejornadalaboral']))>=(date("h-i-s",strtotime($row2['horainicialdetallejornadalaboral']))))and(date("h-i-s",strtotime($_POST['horainicialdetallejornadalaboral']))<=(date("h-i-s",strtotime($row2['horafinaldetallejornadalaboral']))))and($row2['meridianohorainicialdetallejornadalaboral']==$_POST['empezar']))    
       {
		echo "<h4>Jornada laboral registrada en el sistema.</h4>"; 
		//echo "<a href='jornadalaboral.php?modificar=".$row1['iddetallejornadalaboral']."'>VOLVER</a>";
		echo "<a href=jornadalaboral.php>VOLVER</a>";
		exit();		 
       } 
	  }while ($row2=mysql_fetch_array($sol2));?>

<?php 
      $sql = "insert into detallejornadalaboral(idjornadalaboral,ubicaciondetallejornadalaboral,codigodia,horainicialdetallejornadalaboral,meridianohorainicialdetallejornadalaboral,horafinaldetallejornadalaboral,meridianohorafinaldetallejornadalaboral,observaciondetallejornadalaboral)";
      $sql.= "VALUES('".$_GET['detalle']."','".$_POST['ubicaciondetallejornadalaboral']."','".$_POST['codigodia']."','".$_POST['horainicialdetallejornadalaboral']."','".$_POST['empezar']."','".$_POST['horafinaldetallejornadalaboral']."','".$_POST['terminar']."','".$_POST['observaciondetallejornadalaboral']."')"; 
  
      $result = mysql_query($sql,$conexion);
	  echo "<h5>¡Gracias! Hemos recibido sus datos.</h5>";
	  echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=jornadalaboral.php'>";
?>