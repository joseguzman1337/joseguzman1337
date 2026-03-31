<?php 
 
 $sql = "insert into condecoracion(numerodocumento,nombrecondecoracion,institucioncondecoracion,codigotipocondecoracion)";
 $sql.= "VALUES('".$_SESSION['numerodocumento']."','".$_POST['nombrecondecoracion']."','".$_POST['institucioncondecoracion']."','".$_POST['codigotipocondecoracion']."')"; 
  
$result = mysql_query($sql,$conexion);
echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=condecoracion.php'>";
?>

