<?php require_once('../../../../Connections/conexion.php');session_start();

       $base= "select * from periodoacademico where estadoperiodoacademico = 1";
       $sol=mysql_db_query($database_conexion,$base);
	   $totalRows = mysql_num_rows($sol);
       $row=mysql_fetch_array($sol);
?>

<?php 
 
 $sql = "insert into jornadalaboral(numerodocumento,codigotipolabor,codigoperiodoacademico,codigofacultad,codigoasignatura)";
 $sql.= "VALUES('".$_SESSION['numerodocumento']."','".$_POST['codigotipolabor']."','".$row['codigoperiodoacademico']."','".$_POST['codigofacultad']."','".$_POST['codigoasignatura']."')"; 
  
$result = mysql_query($sql,$conexion);

echo "<h5>¡Gracias! Sus datos han quedado registrados en el sistema.</h5>";
echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=jornadalaboral.php'>";
?>

