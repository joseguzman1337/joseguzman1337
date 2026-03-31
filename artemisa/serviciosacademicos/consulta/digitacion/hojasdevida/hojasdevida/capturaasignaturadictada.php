<?php require_once('../../../../Connections/conexion.php');session_start();
 
 $sql = "insert into asignaturahistoriallaboral(numerodocumento,institucionasignaturahistoriallaboral,nombrefacultadasignaturahistoriallaboral,nombreasignaturahistoriallaboral)";
 $sql.= "VALUES('".$_SESSION['numerodocumento']."','".$_POST['institucionasignaturahistoriallaboral']."','".$_POST['nombrefacultadasignaturahistoriallaboral']."','".$_POST['nombreasignaturahistoriallaboral']."')"; 
  
$result = mysql_query($sql,$conexion);

echo "<h5>¡Gracias! Sus datos han sido registrados en el sistema.</h5>";
echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=asignaturadictada.php'>";
?>

