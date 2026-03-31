<?php require_once('../../../../Connections/conexion.php');session_start();?>
<?php
/*
       $base2= "select * from jornadalaboral,detallejornadalaboral,dia where ((dia.codigodia = detallejornadalaboral.codigodia) and (detallejornadalaboral.idjornadalaboral=jornadalaboral.idjornadalaboral)and(jornadalaboral.numerodocumento='".$_SESSION['numerodocumento']."')) ";
       $sol2=mysql_db_query($database_conexion,$base2);
	   $totalRows2= mysql_num_rows($sol2);
       $row2=mysql_fetch_array($sol2); 		   
 do
    { 
     if(($row2['codigodia']==$_POST['codigodia'])and(date("h-i-s",strtotime($row2['horainicialdetallejornadalaboral']))==date("h-i-s",strtotime($_POST['horainicialdetallejornadalaboral']))))    
    {
	 echo "<h4>Dia y hora Asignada</h4>";	
     exit();
     echo "<META HTTP-EQUIV='Refresh' CONTENT='1; URL=detallejornadalaboral.php'>"; 
    }
  
   }while ($row1=mysql_fetch_array($sol2));*/?>
<?php
	 $base= "update detallejornadalaboral set  ubicaciondetallejornadalaboral ='".$_POST['ubicaciondetallejornadalaboral']."',codigodia ='".$_POST['codigodia']."',horainicialdetallejornadalaboral ='".$_POST['horainicialdetallejornadalaboral']."',meridianohorainicialdetallejornadalaboral='".$_POST['empezar']."',horafinaldetallejornadalaboral ='".$_POST['horafinaldetallejornadalaboral']."',meridianohorafinaldetallejornadalaboral='".$_POST['terminar']."',observaciondetallejornadalaboral ='".$_POST['observaciondetallejornadalaboral']."' where  iddetallejornadalaboral = '".$_GET['modificar']."'";
	 $sol=mysql_db_query($database_conexion,$base);
	 echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=jornadalaboral.php'>";
?>