<?php 
require_once('../../../Connections/sala2.php'); 
session_start();
if (!$_SESSION['MM_Username'])
 {
   header( "Location: https://artemisa.unbosque.edu.co/serviciosacademicos/consulta/facultades/consultafacultadesv2.htm");
 }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
	<title>Subir archivos</title>
	<link rel="STYLESHEET" type="text/css" href="estilos_admin.css">
</head>
<link rel="stylesheet" type="text/css" href="../../../sala.css">
<body>
<h1 align="center">Cargar archivo Covinoc </h1>
<br>
	<form action="subearchivocovinoc.php" method="post" enctype="multipart/form-data">
	  <div align="center"> <input type="hidden" name="cadenatexto" size="20" maxlength="100">
		    <input type="hidden" name="MAX_FILE_SIZE" value="100000">
		    <br>
		    <br>
		    <b>Subir archivo <strong> covinoc.tx (Siempre en Minuscula): </strong></b>
		    <br>
            <input name="userfile" type="file">		
            <br>
		    <br><br><br>
		    <input name="submit" type="submit" value="Cargar Nuevo Archivo">
		    &nbsp;        
		</div>
	</form>
</body>
</html>
 <br><br><br>
<?php
mysql_select_db($database_sala, $sala);

$query_data = "select * 
from zdatoscovinoc
where procesado = ''";
$data = mysql_query($query_data, $sala) or die(mysql_error());
$row_data = mysql_fetch_assoc($data);
$totalRows_data = mysql_num_rows($data);	

if ($row_data <> "")
 { // if 1
?>
 <br>
 <p>Información Cargada </p>
 <br>
<table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9" width="500">
<tr>
    <td><strong>Documento</strong></td>
	<td><strong>Nombre</strong></td>
	<td><strong>Carrera</strong></td>
	<td><strong>Valor</strong></td>
  </tr>
<?php
do {
 if ($row_data['numerodocumento'] <> "")
  {
?>
  <tr>
    <td><?php echo $row_data['numerodocumento']; ?></td>
	<td><?php echo $row_data['nombreestudiante']; ?></td>
	<td><?php echo $row_data['nombrecarrera']; ?></td>
	<td><?php echo $row_data['monto']; ?></td>
  </tr>
<?
 }
}while($row_data = mysql_fetch_assoc($data));
 }// if 1
?>

</table>
<script language="javascript">
function recargar()
{
	window.location.reload("modificarmatriculado.php");
}
</script>