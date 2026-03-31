<?php require_once('Connections/conexion.php');?>
<?php
 $base= "update asignaturadocente set  codigofacultad ='".$_POST['codigofacultad']."',codigoasignatura ='".$_POST['codigoasignatura']."',ubicacionasignaturadocente ='".$_POST['ubicacionasignaturadocente']."' where  idasignaturadocente = '".$_POST['modificar']."'";
 $sol=mysql_db_query("hojavida",$base);
 echo "<h5>Datos Modificados</h5>";
 echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=asignatura.php'>";
?>