<?php require_once('../../../../Connections/conexion.php');session_start();?>
<?php 
 
 $sql = "insert into autoria(numerodocumento,nombreautoria,referenciaautoria,codigotipoautoria)";
 $sql.= "VALUES('".$_SESSION['numerodocumento']."','".$_POST['nombreautoria']."','".$_POST['referenciaautoria']."','".$_POST['codigotipoautoria']."')"; 
  
$result = mysql_query($sql,$conexion);

echo "<h5>¡Gracias! Sus datos han sido registrados en el sistema.</h5>";
echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=obra.php'>";
?>

