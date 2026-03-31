<?PHP  
session_start();
require_once("../../../templates/template.php");
$db = getBD();
$utils = new Utils_datos();
if($_REQUEST['anio']) {
	$query="select	 clasificacionesinfhuerfana
			,volumenes
			,titulos 
		from siq_volumenesytitulosmaterialimpreso 
		join siq_clasificacionesinfhuerfana using(idclasificacionesinfhuerfana) 
		where anio=".$_REQUEST['anio'];
	$exec= $db->Execute($query);
	if($exec->RecordCount()==0) {
?>
		<div id="msg-success" class="msg-success msg-error" ><p>No existe información almacenada para el año <?PHP echo $_REQUEST['anio']?></p></div>
<?PHP 
	} else {
?>
		<table align="center" class="formData last"  width="92%">
			<tr id="dataColumns"> 
				<th colspan="3" style="font-size:20px"><?PHP echo $_REQUEST['anio']?></th>               
			</tr>
			<tr id="dataColumns">
				<th>Material</th>               
				<th>Volúmenes</th>
				<th>Titulos</th>
			</tr>
<?PHP 
			$sum_volumenes=0;
			$sum_titulos=0;
			while($row = $exec->FetchRow()) {
?>
				<tr id="contentColumns" class="row">
					<td class="column"><?PHP echo $row['clasificacionesinfhuerfana']?></td>
					<td class="column" align="center"><?PHP echo $row['volumenes']?></td>
					<td class="column" align="center"><?PHP echo $row['titulos']?></td>
				</tr>
<?PHP 
				$sum_volumenes+=$row['volumenes'];
				$sum_titulos+=$row['titulos'];
			} 
?>
			<tr id="dataColumns">
				<th>Total</th>               
				<th><?PHP echo $sum_volumenes?></th>
				<th><?PHP echo $sum_titulos?></th>
			</tr>
		</table>
<?PHP 
	}
	exit;
}
?>
<form action="" method="post" id="form1">
	<span class="mandatory">* Son campos obligatorios</span>
	<fieldset>  
		<legend>Volúmenes y títulos del material impreso</legend>
		<label for="anio" class="grid-2-12">Año: <span class="mandatory">(*)</span></label>
		<?php $utils->getYearsSelect("anio"); ?>
		<input type="submit" value="Consultar" class="first small" />
		<div id='respuesta_form1'></div>
	</fieldset>
</form>
<script type="text/javascript">
	$(':submit').click(function(event) {
		event.preventDefault();
		var valido= validateForm("#form1");
		if(valido){
			sendForm();
		}
	});
	function sendForm(){
		$.ajax({
				type: 'GET',
				url: 'formularios/recursosFisicos/viewBibliotecaMaterialImpreso.php',
				async: false,
				data: $('#form1').serialize(),                
				success:function(data){
					$('#respuesta_form1').html(data);
				},
				error: function(data,error,errorThrown){alert(error + errorThrown);}
		});            
	}
</script>
