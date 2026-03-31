<?php require_once('../../../../Connections/conexion.php');session_start();

 $fecha = $_POST['fnacimiento']; 
 $base= "update docente set  codigotipodocumento = '".$_POST['codigotipodocumento']."',numerodocumento ='".$_POST['numerodocumento']."',nombresdocente ='".$_POST['nombresdocente']."',apellidosdocente ='".$_POST['apellidosdocente']."',sexodocente='".$_POST['sexodocente']."',fechanacimientodocente ='".$fecha."',lugarnacimientodocente ='".$_POST['lugarnacimientodocente']."',codigopostaldocente ='".$_POST['codigopostaldocente']."',direcciondocente ='".$_POST['direcciondocente']."',ciudaddocente ='".$_POST['ciudaddocente']."',emaildocente ='".$_POST['emaildocente']."',telefonodocente ='".$_POST['telefonodocente']."',telefonodocente2 ='".$_POST['telefonodocente2']."',celulardocente ='".$_POST['celulardocente']."',faxdocente ='".$_POST['faxdocente']."',codigoescalafondocente ='".$_POST['codigoescalafondocente']."',codigotipovinculacion ='".$_POST['codigotipovinculacion']."',codigoestadodocente ='".$_POST['codigoestadodocente']."' where  numerodocumento = '".$_POST['modificar']."'";
 $sol=mysql_db_query($database_conexion,$base);
 echo "<h5>Datos Modificados</h5>";
 echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=datosbasicos1.php'>";
?>