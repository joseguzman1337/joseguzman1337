<? 
session_start();
require_once("../../../templates/template.php");
$db = getBD();
$utils = new Utils_datos();
?>
<form action="" method="post" id="forma<?=$_REQUEST['alias']?>">
	<span class="mandatory">* Son campos obligatorios</span>
	<fieldset>  
		<legend>Estadísticas uso de la cueva y las terrazas</legend>
		<label class="fixedLabel">Mes: <span class="mandatory">(*)</span></label>
                <?php $utils->getMonthsSelect(); ?>
                
                <label class="fixedLabel" style="clear:none;width:90px">Año: <span class="mandatory">(*)</span></label>
                <?php $utils->getYearsSelect("anio"); ?>
            <input type="hidden" name="semestre" value="" id="semestre" />             
                
		<!--<label for="semestre" class="grid-2-12">Semestre: <span class="mandatory">(*)</span></label>-->
		<?php //$utils->getSemestresSelect($db,"semestre");
                 $idForm = "forma".$_REQUEST['alias'];
                 $utils->pintarBotonCargar("popup_cargarDocumento(3,5,$('#".$idForm." #semestre').val())","popup_verDocumentos(3,5,$('#".$idForm." #semestre').val())");  ?>
		<table align="center" class="formData last" width="92%">
<?
			$query2="select	 sch.clasificacionesinfhuerfana
					,sch.aliasclasificacionesinfhuerfana
				from siq_clasificacionesinfhuerfana sch
				join (	select idclasificacionesinfhuerfana
					from siq_clasificacionesinfhuerfana 
					where aliasclasificacionesinfhuerfana='".$_REQUEST['alias']."'
				) sub on sch.idpadreclasificacionesinfhuerfana=sub.idclasificacionesinfhuerfana
				where sch.estado";
			$exec2= $db->Execute($query2);
			while($row2 = $exec2->FetchRow()) {
?>
				<tr class="dataColumns category">
					<th colspan="7" class="borderR"><?=$row2['clasificacionesinfhuerfana']?></th>               
				</tr>
				<tr class="dataColumns">
					<th class="borderR">Día</th>               
					<th class="borderR">Lunes</th>               
					<th class="borderR">Martes</th>               
					<th class="borderR">Miercoles</th>               
					<th class="borderR">Jueves</th>
					<th class="borderR">Viernes</th>
					<th class="borderR">Sabado</th>
				</tr>
	<?
				$query="select	 sch.idclasificacionesinfhuerfana
						,sch.clasificacionesinfhuerfana
					from siq_clasificacionesinfhuerfana sch
					join (	select idclasificacionesinfhuerfana
						from siq_clasificacionesinfhuerfana 
						where aliasclasificacionesinfhuerfana='".$row2['aliasclasificacionesinfhuerfana']."'
					) sub on sch.idpadreclasificacionesinfhuerfana=sub.idclasificacionesinfhuerfana
					where sch.estado";
				$exec= $db->Execute($query);
				while($row = $exec->FetchRow()) {
	?>
					<tr id="contentColumns" class="row">
						<td class="column borderR">
							<input type="hidden" name="aux[<?=$row['idclasificacionesinfhuerfana']?>]" value="<?=$row['idclasificacionesinfhuerfana']?>">
							<?=$row['clasificacionesinfhuerfana']?>: <span class="mandatory">(*)</span>
						</td>
						<td class="column borderR" align="center"><input type="text" class="required number" name="lunes[<?=$row['idclasificacionesinfhuerfana']?>]" id="lunes[<?=$row['idclasificacionesinfhuerfana']?>]" title="Lunes" maxlength="10" tabindex="1" autocomplete="off" size="6" style='text-align:center' /></td>
						<td class="column borderR" align="center"><input type="text" class="required number" name="martes[<?=$row['idclasificacionesinfhuerfana']?>]" id="martes[<?=$row['idclasificacionesinfhuerfana']?>]" title="Martes" maxlength="10" tabindex="1" autocomplete="off" size="6" style='text-align:center' /></td>
						<td class="column borderR" align="center"><input type="text" class="required number" name="miercoles[<?=$row['idclasificacionesinfhuerfana']?>]" id="miercoles[<?=$row['idclasificacionesinfhuerfana']?>]" title="Miercoles" maxlength="10" tabindex="1" autocomplete="off" size="6" style='text-align:center' /></td>
						<td class="column borderR" align="center"><input type="text" class="required number" name="jueves[<?=$row['idclasificacionesinfhuerfana']?>]" id="jueves[<?=$row['idclasificacionesinfhuerfana']?>]" title="Jueves" maxlength="10" tabindex="1" autocomplete="off" size="6" style='text-align:center' /></td>
						<td class="column borderR" align="center"><input type="text" class="required number" name="viernes[<?=$row['idclasificacionesinfhuerfana']?>]" id="viernes[<?=$row['idclasificacionesinfhuerfana']?>]" title="Viernes" maxlength="10" tabindex="1" autocomplete="off" size="6" style='text-align:center' /></td>
						<td class="column borderR" align="center"><input type="text" class="required number" name="sabado[<?=$row['idclasificacionesinfhuerfana']?>]" id="sabado[<?=$row['idclasificacionesinfhuerfana']?>]" title="Sábado" maxlength="10" tabindex="1" autocomplete="off" size="6" style='text-align:center' /></td>
					</tr>
	<?
				}
			}
	?>
		</table>
                
                <div class="vacio"></div>
                <div id="respuesta_forma<?=$_REQUEST['alias']?>" class="msg-success" style="display:none"></div>
	</fieldset>
	<input type="hidden" name="alias" value="<?=$_REQUEST['alias']?>" />
	<input type="submit" value="Guardar cambios" class="first" />
</form>
<script type="text/javascript">
	$(':submit').click(function(event) {
		event.preventDefault();
		var valido= validateForm("#forma<?=$_REQUEST['alias']?>");
		if(valido){
			sendForm();
		}
	});
	function sendForm(){
            var periodo = $('#forma<?=$_REQUEST['alias']?> #mes').val()+$('#forma<?=$_REQUEST['alias']?> #anio').val();
                $('#forma<?=$_REQUEST['alias']?> #semestre').val(periodo);
		$.ajax({
				dataType: 'json',
				type: 'POST',
				url: 'formularios/proyeccionSocial/saveBienestarUniversitario.php',
				data: $('#forma<?=$_REQUEST['alias']?>').serialize(),                
				success:function(data){
				if (data.success == true){
					$('#respuesta_forma<?=$_REQUEST['alias']?>').html('<p>' + data.message + '</p>');
					$('#respuesta_forma<?=$_REQUEST['alias']?>').removeClass('msg-error');
					$('#respuesta_forma<?=$_REQUEST['alias']?>').css('display','block');
                                        $("#respuesta_forma<?=$_REQUEST['alias']?>").delay(5500).fadeOut(800);
				} else {
					$('#respuesta_forma<?=$_REQUEST['alias']?>').html('<p>' + data.message + '</p>');
					$('#respuesta_forma<?=$_REQUEST['alias']?>').addClass('msg-error');
					$('#respuesta_forma<?=$_REQUEST['alias']?>').css('display','block');
                                        $("#respuesta_forma<?=$_REQUEST['alias']?>").delay(5500).fadeOut(800);
				}
			},
			error: function(data,error,errorThrown){alert(error + errorThrown);}
		});            
	}
</script>
