<?php
  
   $colname_Recordset1 = "1";
if (isset($_POST['numerodocumento'])) {
  $colname_Recordset1 = (get_magic_quotes_gpc()) ? $_POST['numerodocumento'] : addslashes($_POST['numerodocumento']);
}
	
	mysql_select_db($database_conexion, $conexion);
	$query_Recordset1 = sprintf("SELECT numerodocumento FROM docente WHERE numerodocumento = '%s'", $colname_Recordset1);
	$Recordset1 = mysql_query($query_Recordset1, $conexion) or die(mysql_error());
	$row_Recordset1 = mysql_fetch_assoc($Recordset1);
	$totalRows_Recordset1 = mysql_num_rows($Recordset1);
if (! $row_Recordset1)
   {	 
	  $fecha = $_POST['ano'].$_POST['mes'].$_POST['dia']; 
	  $sql = "insert into docente (codigotipodocumento,numerodocumento,nombresdocente,apellidosdocente,sexodocente,fechanacimientodocente,lugarnacimientodocente,codigopostaldocente,direcciondocente,ciudaddocente,emaildocente,telefonodocente,telefonodocente2,celulardocente,faxdocente,codigoescalafondocente,codigotipovinculacion,codigoestadodocente,fechaactualizaciondocente)";
      $sql.= "VALUES('".$_POST['codigotipodocumento']."','".$_POST['numerodocumento']."','".$_POST['nombresdocente']."','".$_POST['apellidosdocente']."','".$_POST['sexodocente']."','".$fecha."','".$_POST['lugarnacimientodocente']."','".$_POST['codigopostaldocente']."','".$_POST['direcciondocente']."','".$_POST['ciudaddocente']."','".$_POST['emaildocente']."','".$_POST['telefonodocente']."','".$_POST['telefonodocente2']."','".$_POST['celulardocente']."','".$_POST['faxdocente']."','".$_POST['codigoescalafondocente']."','".$_POST['codigotipovinculacion']."','".$_POST['codigoestadodocente']."','".date("Y-n-j",time())."')"; 
      $_SESSION['numerodocumento']= $_POST['numerodocumento']; 
      $result = mysql_query($sql,$conexion);        
      echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=docente1.php'>";
      mysql_free_result($Recordset1);
	  
	   $sql1 = "insert into carreraegresado(numerodocumento,codigocarrera)";
	   $sql1.= "VALUES('".$_POST['numerodocumento']."','".$_POST['especializacion']."')";
       $result1= mysql_query($sql1,$conexion);		       
   }
else 
{  
  $_SESSION['numerodocumento']= $_POST['numerodocumento'];  
  echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=docente1.php'>";
}
?>
