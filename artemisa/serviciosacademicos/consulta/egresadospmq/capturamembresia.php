<?php 
 
 $sql = "insert into membresia(numerodocumento,nombremembresia)";
 $sql.= "VALUES('".$_SESSION['numerodocumento']."','".$_POST['nombremembresia']."')"; 
  
$result = mysql_query($sql,$conexion);
echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=membresia.php'>";
?>

