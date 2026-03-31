<?php require_once('../../../../Connections/conexion.php');
session_start();
$GLOBALS['numerodocumento'];
$_SESSION['numerodocumento']=$_SESSION['codigodocente'];
?>
 <?php     		 
 	   $base= "select * from docente where numerodocumento = '".$_SESSION['numerodocumento']."'";
       $sol=mysql_db_query($database_conexion,$base);
	   $totalRows = mysql_num_rows($sol);
       $row=mysql_fetch_array($sol); 
       if (! $row){
	   echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=docente.php'>";
	  }  
	  else   
	  {
	   echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=docente1.php'>";	
	  }  
 ?>