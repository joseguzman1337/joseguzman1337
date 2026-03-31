<?php
require('../../../../Connections/sala2.php');
$rutaado = "../../../../funciones/adodb/";
require_once('../../../../Connections/salaado.php'); 

if ($_POST['Consultar'] == true)
 {
   echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=reporte_cupos_listado.php?nacodigomodalidadacademica=".$_REQUEST['nacodigomodalidadacademica']."&nacodigocarrera=".$_REQUEST['nacodigocarrera']."&tipo=".$_REQUEST['tipo']."&horario=".$_REQUEST['horario']."'>";
   exit();
 }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Listado Materias</title>
<link rel="stylesheet" href="../../../../estilos/sala.css" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
<form action="reporte_cupos.php" method="post" name="f1">
<p>LISTA DE MATERIAS CON CUPO Y HORARIOS</p>
<table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">
  <tr>
	<td colspan="2"><label id="labelresaltado">Seleccione los filtros que desee para efectuar la consulta</label></td>
  </tr>
<tr>
<td id="tdtitulogris">Modalidad Acad&eacute;mica<label id="labelresaltado"></label></td>
<td>
<?php
$query_modalidad = "SELECT codigomodalidadacademica, nombremodalidadacademica 
FROM modalidadacademica 
where codigoestado like '1%' 
order by 1";
$modalidad = $db->Execute($query_modalidad);
$totalRows_modalidad = $modalidad->RecordCount();
$row_modalidad = $modalidad->FetchRow(); 
?>

  <select name="nacodigomodalidadacademica" id="modalidad" onChange="enviar()">
    <option value="0"<?php if (!(strcmp("0", $_REQUEST['nacodigomodalidadacademica']))) {echo "SELECTED";} ?>>Todos</option>
<?php
do 
{
?>
    <option value="<?php echo $row_modalidad['codigomodalidadacademica']?>" <?php if (!(strcmp($row_modalidad['codigomodalidadacademica'], $_REQUEST['nacodigomodalidadacademica']))) {echo "SELECTED";} ?>><?php echo $row_modalidad['nombremodalidadacademica']?></option>
<?php
}
while($row_modalidad = $modalidad->FetchRow());
?>
  </select>
</td>
</tr>
<tr>
<td id="tdtitulogris"> Nombre del Programa<label id="labelresaltado"></label></td>
<td>
<?php
$query_carrera = "SELECT c.nombrecarrera, c.codigocarrera
FROM carrera c
where c.codigomodalidadacademica = '".$_REQUEST['nacodigomodalidadacademica']."'
and c.fechavencimientocarrera >= now()
order by 1";
$carrera = $db->Execute($query_carrera);
$totalRows_carrera = $carrera->RecordCount();
$row_carrera = $carrera->FetchRow();
?>
<select name="nacodigocarrera">
  <option value="0" <?php if (!(strcmp("0", $_REQUEST['nacodigocarrera']))) {echo "SELECTED";} ?>>Todos</option>
<?php
do
{	
?>
  <option value="<?php echo $row_carrera['codigocarrera'];?>" <?php if (!(strcmp($row_carrera['codigocarrera'], $_REQUEST['nacodigocarrera']))) {echo "SELECTED";} ?>> <?php echo $row_carrera['nombrecarrera']; ?> </option>
  <?php
}
while($row_carrera = $carrera->FetchRow());
?>
</select></td>
</tr>
<tr>
<td id="tdtitulogris"> Tipo de Materia</td>
<td>
<?php
$query_materia = "SELECT * from tipomateria";
$materia = $db->Execute($query_materia);
$totalRows_materia = $materia->RecordCount();
$row_materia = $materia->FetchRow();
?>
  <select name="tipo" id="tipo">
    <option value="0" <?php if (!(strcmp("0", $_REQUEST['tipo']))) {echo "SELECTED";} ?>>Todos</option>
<?php
do
{	
?>
    <option value="<?php echo $row_materia['codigotipomateria'];?>" <?php if (!(strcmp($row_materia['codigotipomateria'], $_REQUEST['tipo']))) {echo "SELECTED";} ?>><?php echo $row_materia['nombretipomateria']; ?></option>
<?php
}
while($row_materia = $materia->FetchRow());
?>
  </select>
</td>
</tr>
<tr>
  <td id="tdtitulogris">Tipo Reporte</td>
  <td>
  <select name="horario">
   <option value="1">Con Horarios</option>
   <option value="2">Sin Horarios</option> 
  </select> 
  </td>
</tr>
</table>
<br>
<input type="submit" value="Consultar" name="Consultar">
<input type="button" value="Regresar" onClick="history.go(-1)">	
</form>
<br><br>
</body>
</html>
<script language="javascript">
function enviar()
{
	document.f1.submit();
}
</script>
