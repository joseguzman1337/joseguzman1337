<?php require_once('../../../../Connections/conexion.php');session_start();?>
<?php 
 
 $sql = "insert into condecoracion(numerodocumento,nombrecondecoracion,institucioncondecoracion,codigotipocondecoracion)";
 $sql.= "VALUES('".$_SESSION['numerodocumento']."','".$_POST['nombrecondecoracion']."','".$_POST['institucioncondecoracion']."','".$_POST['codigotipocondecoracion']."')"; 
  
$result = mysql_query($sql,$conexion);

echo "<h5>¡Gracias! Sus datos han quedado registrados.</h5>";
echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=condecoracion.php'>";
?>

