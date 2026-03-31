<?php require_once('../../../../Connections/conexion.php');session_start();?>
<?php 
 $sql = "insert into cursoinformaldictado(numerodocumento,institucioncursoinformaldictado,areacursoinformaldictado,nombrecursoinformaldictado,unidadtiempocursoinformaldictado,tiempocursoinformaldictado,lugarcursoinformaldictado,codigotipocursodictado,tipoeventocursoinformaldictado)";
 $sql.= "VALUES('".$_SESSION['numerodocumento']."','".$_POST['institucioncursoinformaldictado']."','".$_POST['areacursoinformaldictado']."','".$_POST['nombrecursoinformaldictado']."','".$_POST['unidadtiempocursoinformaldictado']."','".$_POST['tiempocursoinformaldictado']."','".$_POST['lugarcursoinformaldictado']."','".$_POST['codigotipocursodictado']."','".$_POST['tipoeventocursoinformaldictado']."')"; 
  
$result = mysql_query($sql,$conexion);

echo "<h5>¡Gracias! Sus datos han quedado registrados en el sistema.</h5>";
echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=cursodictado.php'>";
?>

