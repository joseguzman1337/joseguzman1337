<?php require_once('../../../../Connections/conexion.php');session_start();?>
<?php 
 
 $sql = "insert into investigacion(numerodocumento,tituloinvestigacion,institucioninvestigacion,entidadfinanciamientoinvestigacion,unidadtiempoinvestigacion,tiempoinvestigacion,liderinvestigacion,cantidadinvestigadores,codigotipoinvestigacion)";
 $sql.= "VALUES('".$_SESSION['numerodocumento']."','".$_POST['tituloinvestigacion']."','".$_POST['institucioninvestigacion']."','".$_POST['entidadfinanciamientoinvestigacion']."','".$_POST['unidadtiempoinvestigacion']."','".$_POST['tiempoinvestigacion']."','".$_POST['liderinvestigacion']."','".$_POST['cantidadinvestigadores']."','".$_POST['codigotipoinvestigacion']."')"; 
  
$result = mysql_query($sql,$conexion);

echo "<h5>¡Gracias! Sus datos han quedado registrados en el sistema.</h5>";
echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=investigacion.php'>";
?>

