<?php require_once('../../../../Connections/conexion.php');session_start();?>
<?php
 $base= "update jornadalaboral set  codigotipolabor = '".$_POST['codigotipolabor']."',codigofacultad='".$_POST['codigofacultad']."',codigoasignatura='".$_POST['codigoasignatura']."' where  idjornadalaboral = '".$_POST['modificar']."'";
 $sol=mysql_db_query($database_conexion,$base);
 //echo "<h5>Datos Modificados</h5>";
 echo "<META HTTP-EQUIV='Refresh' CONTENT='1;URL=jornadalaboral.php'>";
?>