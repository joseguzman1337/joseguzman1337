<?php require_once('../../../../Connections/conexion.php');session_start();?>
<?php 
 
 $sql = "insert into membresia(numerodocumento,nombremembresia)";
 $sql.= "VALUES('".$_SESSION['numerodocumento']."','".$_POST['nombremembresia']."')"; 
  
$result = mysql_query($sql,$conexion);
echo "<h5>¡Gracias! Sus datos han quedado registrados dentro del sistema.</h5>";
echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=membresia.php'>";
?>

