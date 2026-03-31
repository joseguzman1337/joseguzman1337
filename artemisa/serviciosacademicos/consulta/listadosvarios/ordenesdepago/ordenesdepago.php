<?php
if($_REQUEST['listado'] == 1)
{
?>
<script language="javascript">
	window.location.href="ordenesdepagopagas.php";
</script>
<?php
}
if($_REQUEST['listado'] == 2)
{
?>
<script language="javascript">
	window.location.href="historicomatriculas.php?sinmateriasperdidas";
</script>
<?php
}
if($_REQUEST['listado'] == 3)
{
?>
<script language="javascript">
	window.location.href="historicomatriculas.php?conmateriasperdidas";
</script>
<?php
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Listado de Históricos</title>
<link rel="stylesheet" href="../../../estilos/sala.css" type="text/css">
</head>
<body>
<p>ORDENES DE PAGO</p>
<form action="" method="post" name="f1">
<table width="70%" border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">
  <!-- <tr>
  <td colspan="2"><label id="labelresaltado">Estos listados son generados teniendo en cuenta el histórico de notas,<br>si el estudiante no tiene notas en el histórico no aparece en los listados,<br>por esta razón los estudiantes que ingresaron en el periodo activo no aparecen</label></td>
  </tr>
   --><tr>
	<td id="tdtitulogris">Seleccione El Listado</td>
	<td>
	<select name="listado" onChange="document.f1.submit()">
		<option value="0">Seleccionar</option>
		<option value="1">Ordenes de Pago pagas</option>
	</select>
	</td>
  </tr>
</table>
</form>
</body>
</html>
