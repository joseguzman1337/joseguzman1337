<?php require_once('Connections/conexion.php');session_start();
 
 $sql = "insert into asignaturadocente(numerodocumento,codigofacultad,codigoasignatura,ubicacionasignaturadocente)";
 $sql.= "VALUES('".$_SESSION['numerodocumento']."','".$_POST['codigofacultad']."','".$_POST['codigoasignatura']."','".$_POST['ubicacionasignaturadocente']."')"; 
  
$result = mysql_query($sql,$conexion);

echo "<h5>¡Gracias! Hemos recibido sus datos.</h5>";
echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=asignatura.php'>";
?>

