<?php 
 $fecha = $_POST['ano']; 
 $fecha2= $_POST['ano2']; 
 $sql = "insert into historiallaboral(numerodocumento,empresahistoriallaboral,cargohistoriallaboral,tiempohistoriallaboral,fechainiciohistoriallaboral,fechafinalhistoriallaboral,escalafondocenciahistoriallaboral,codigohistoriallaboral)";
 $sql.= "VALUES('".$_SESSION['numerodocumento']."','".$_POST['empresahistoriallaboral']."','".$_POST['cargohistoriallaboral']."','".$_POST['tiempohistoriallaboral']."','".$fecha."','".$fecha2."','".$_POST['escalafondocenciahistoriallaboral']."','".$_POST['codigohistoriallaboral']."')"; 
  
$result = mysql_query($sql,$conexion);
echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=historiallaboral.php'>";
?>

