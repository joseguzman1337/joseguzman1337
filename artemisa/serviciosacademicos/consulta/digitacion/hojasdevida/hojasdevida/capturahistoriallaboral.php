<?php require_once('../../../../Connections/conexion.php');session_start();

 $fecha = $_POST['finicio']; 
 $fecha2= $_POST['ffinal']; 
 $sql = "insert into historiallaboral(numerodocumento,empresahistoriallaboral,cargohistoriallaboral,tiempohistoriallaboral,fechainiciohistoriallaboral,fechafinalhistoriallaboral,escalafondocenciahistoriallaboral,codigohistoriallaboral)";
 $sql.= "VALUES('".$_SESSION['numerodocumento']."','".$_POST['empresahistoriallaboral']."','".$_POST['cargohistoriallaboral']."','".$_POST['tiempohistoriallaboral']."','".$fecha."','".$fecha2."','".$_POST['escalafondocenciahistoriallaboral']."','".$_POST['codigohistoriallaboral']."')"; 
  
$result = mysql_query($sql,$conexion);

echo "<h5>¡Gracias! Sus datos han quedado registrados en el sistema.</h5>";
echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=historiallaboral.php'>";
?>

