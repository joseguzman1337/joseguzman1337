<script language="javascript">
function validar(){

	if(document.getElementById('annio').value.length < 1){
		alert('Porfavor Digite Año');
	}
	else if(document.getElementById('periodo').value.length < 1){
		alert('Porfavor Seleccione Periodo');
	}
	else{
		document.getElementById('form1').submit();
	}
}
</script>
<form name="form1" id="form1" action="" method="POST">
<table>
<tr>
	<td>Año</td>
	<td><input name="annio" id="annio" value="<?php echo $_POST['annio']?>"></td>
</tr>
<tr>
	<td>Periodo</td>
	<td>
	<select name="periodo" id="periodo">
		<option value="">Seleccionar</option>>
		<option value="01" <?php if($_POST['periodo']=='01')echo "selected"?>>01</option>
		<option value="02" <?php if($_POST['periodo']=='02')echo "selected"?>>02</option>
	</select>
	</td>
</tr>
<tr>
	<td>Tipo Informe</td>
	<td>
	<select name="tipo" id="tipo">
		<option value="">Seleccionar</option>>
		<option value="01" <?php if($_POST['tipo']=='01')echo "selected"?>>Conteo</option>
		<option value="02" <?php if($_POST['tipo']=='02')echo "selected"?>>Detalle</option>
	</select>
	</td>
</tr>
</table>
<input name="Enviar" type="submit" value="Enviar">
</form>
<?php
ini_set('memory_limit', '256M');
ini_set('max_execution_time','6400000');
//require_once('../../../serviciosacademicos/funciones/clases/autenticacion/redirect.php');
$rutaado=("../../../serviciosacademicos/funciones/adodb_mod/");
require_once('../../../serviciosacademicos/Connections/snies_conexion_postgresql.php');
require_once('../../../serviciosacademicos/funciones/clases/motorv2/motor.php');
if(!empty($_POST['annio']) and !empty($_POST['periodo'])){
	$snies_conexion->query("SET CLIENT_ENCODING TO 'UTF-8';");

	if($_POST['tipo']=='02'){
		$query="
		select
		participante.* from participante
		";
	}
	else{
		$query="
		select count(participante.*) from participante
		";
	}

	$operacion=$snies_conexion->query($query);
	$rowOperacion=$operacion->fetchRow();
	do {
		$arrayInterno[]=$rowOperacion;
	}
	while($rowOperacion=$operacion->fetchRow());
}
$motor = new matriz($arrayInterno,'Participantes SNIES','listadoParticipantes.php','si','si','','',false,'si','../../../');
$motor->jsVarios();
$motor->mostrar();
?>