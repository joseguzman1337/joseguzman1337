<?php require_once('../../../../Connections/conexion.php');session_start();?>
<?php
 $base= "update asignaturahistoriallaboral set  institucionasignaturahistoriallaboral = '".$_POST['institucionasignaturahistoriallaboral']."',nombrefacultadasignaturahistoriallaboral ='".$_POST['nombrefacultadasignaturahistoriallaboral']."',nombreasignaturahistoriallaboral ='".$_POST['nombreasignaturahistoriallaboral']."' where  idasignaturahistoriallaboral = '".$_POST['modificar']."'";
 $sol=mysql_db_query("hojavida",$base);
 echo "<h5>Datos Modificados</h5>";
 echo "<META HTTP-EQUIV='Refresh' CONTENT='1; URL=asignaturadictada.php'>";
?>