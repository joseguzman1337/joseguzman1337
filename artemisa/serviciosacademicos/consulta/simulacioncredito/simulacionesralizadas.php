<html>
<head>
<title>Seleccionar o crear simulación</title>
</head>
<body>
<div align="center">
<form name="form1" method="get" action="">
<p><strong>SIMULACIONES REALIZADAS</strong><br>
<?php 
if(!isset($_GET['idsimulacioncredito']))
{
	$ordenjoda = new Ordenpago($sala, $codigoestudiante, $codigoperiodo, $numeroordenpago);
	$numeroordenpagojoda = $ordenjoda->tomar_numeroordenpago();
?>
<select name="numeroordenpago" onChange="form1.submit()">
<option value="<?php echo $numeroordenpagojoda; ?>">Seleccionar</option>
<?php
	while($row_selordenes = mysql_fetch_array($selordenes))
	{
?>
<option value="<?php echo $row_selordenes['numeroordenpago']; ?>" <?php if($_GET['numeroordenpago'] == $row_selordenes['numeroordenpago']) echo "selected";?>><?php echo $row_selordenes['numeroordenpago'];?></option>
<?php
	}
?>
</select>
<?php
}
?>
</form>
</div>
</body>
</html>
