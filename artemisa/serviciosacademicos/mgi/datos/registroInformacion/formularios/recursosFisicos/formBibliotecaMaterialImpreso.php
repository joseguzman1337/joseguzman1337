<?
session_start();
require_once("../../../templates/template.php");
$db = getBD();
$utils = new Utils_datos();
?>
<form action="" method="post" id="form1">
	<span class="mandatory">* Son campos obligatorios</span>
	<fieldset>  
		<legend>Volúmenes y títulos del material impreso</legend>
		<label for="anio" class="grid-2-12">Año: <span class="mandatory">(*)</span></label>
		<?php $utils->getYearsSelect("anio"); ?>
		<table align="center" class="formData last" width="92%">
			<tr id="dataColumns">
				<th>Material</th>               
				<th>Volúmenes</th>
				<th>Titulos</th>
			</tr>
<?
			$query="select	 sch.idclasificacionesinfhuerfana
					,sch.clasificacionesinfhuerfana
				from siq_clasificacionesinfhuerfana sch
				join (	select idclasificacionesinfhuerfana
					from siq_clasificacionesinfhuerfana 
					where aliasclasificacionesinfhuerfana='vytdmi'
				) sub on sch.idpadreclasificacionesinfhuerfana=sub.idclasificacionesinfhuerfana
				where sch.estado";
			$exec= $db->Execute($query);
			while($row = $exec->FetchRow()) {
?>
				<tr id="contentColumns" class="row">
					<td class="column">
						<input type="hidden" name="aux[<?=$row['idclasificacionesinfhuerfana']?>]" value="<?=$row['idclasificacionesinfhuerfana']?>">
						<?=$row['clasificacionesinfhuerfana']?>: <span class="mandatory">(*)</span>
					</td>
					<td class="column" align="center"><input type="text" class="required number" name="volumenes[<?=$row['idclasificacionesinfhuerfana']?>]" id="volumenes[<?=$row['idclasificacionesinfhuerfana']?>]" title="volumen" maxlength="3" tabindex="1" autocomplete="off" size="6" style='text-align:center' /></td>
					<td class="column" align="center"><input type="text" class="required number" name="titulos[<?=$row['idclasificacionesinfhuerfana']?>]" id="titulos[<?=$row['idclasificacionesinfhuerfana']?>]" title="titulo" maxlength="3" tabindex="1" autocomplete="off" size="6" style='text-align:center' /></td>
				</tr>
<?				
			}
?>
		</table>
                
                <div class="vacio"></div>
                <div id="msg-success" class="msg-success" style="display:none"></div>
	</fieldset>
	<input type="hidden" name="formulario" value="form1" />
	<input type="submit" value="Guardar cambios" class="first" />
</form>

<script type="text/javascript">
	$('#form1 :submit').click(function(event) {
		event.preventDefault();
		var valido= validateForm("#form1");
		if(valido){
			sendForm();
		}
	});
        
	function sendForm(){
		$.ajax({
			dataType: 'json',
			type: 'POST',
			url: 'formularios/recursosFisicos/saveBiblioteca.php',
			data: $('#form1').serialize(),                
			success:function(data){
                            console.log(data);
				if (data.success == true){
					$('#form1 #msg-success').html('<p>' + data.message + '</p>');
					$('#form1 #msg-success').removeClass('msg-error');
					$('#form1 #msg-success').css('display','block');
                                        $("#form1 #msg-success").delay(5500).fadeOut(800);
				} else {                        
					$('#form1 #msg-success').html('<p>' + data.message + '</p>');
					$('#form1 #msg-success').addClass('msg-error');
					$('#form1 #msg-success').css('display','block');
                                        $("#form1 #msg-success").delay(5500).fadeOut(800);
				}
			},
			error: function(data,error,errorThrown){alert(error + errorThrown);}
		});            
	}
</script>
