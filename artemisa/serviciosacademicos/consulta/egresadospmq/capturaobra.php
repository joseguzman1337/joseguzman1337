<?php 
 $sql = "insert into autoria(numerodocumento,nombreautoria,referenciaautoria)";
 $sql.= "VALUES('".$_SESSION['numerodocumento']."','".$_POST['nombreautoria']."','".$_POST['referenciaautoria']."')"; 

$result = mysql_query($sql,$conexion);
echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=obra.php'>";
?>

