<? 
session_start();
require_once("../../../templates/template.php");
$db = getBD();
$utils = new Utils_datos();
?>
<form action="" method="post" id="forma<?=$_REQUEST['alias']?>">
	<span class="mandatory">* Son campos obligatorios</span>
	<fieldset>  
		<legend>
<?
			if($_REQUEST['alias']=='eaddiaf')
				echo "Estadísticas área de deportes y actividad física";
			if($_REQUEST['alias']=='eads')
				echo "Estadísticas área de salud";
			if($_REQUEST['alias']=='eadcyr')
				echo "Estadísticas área de cultura y recreación";
			if($_REQUEST['alias']=='edvu')
				echo "Estadísticas de voluntariado universitario";
?>
		</legend>
		<label for="semestre" class="grid-2-12">Semestre: <span class="mandatory">(*)</span></label>
		<?php $utils->getSemestresSelect($db,"semestre"); ?>
                <table align="center" class="formData last" width="92%">
			<tr class="dataColumns">
				<th rowspan="2" class="borderR">Servicio o actividad</th>               
				<th colspan="3" class="borderR">Estudiantes</th>               
				<th rowspan="2" class="borderR">Docentes</th>               
				<th rowspan="2" class="borderR">Administrativos</th>
<?
				if($_REQUEST['alias']=='eaddiaf' || $_REQUEST['alias']=='eads' || $_REQUEST['alias']=='eadcyr') {
?>
					<th rowspan="2" class="borderR">Familiares</th>
<?
				}
				if($_REQUEST['alias']=='eaddiaf' || $_REQUEST['alias']=='eadcyr' || $_REQUEST['alias']=='edvu') {
?>
					<th rowspan="2" class="borderR">Nro. de encuentros o presentaciones oficiales</th>
<?
				}
				if($_REQUEST['alias']=='edvu') {
?>
					<th rowspan="2" class="borderR">Beneficiarios comunidad</th>
<?
				}
?>
			</tr>
			<tr class="dataColumns ">
				<th>Pregado</th>               
				<th>Posgrado</th>
				<th class="borderR">Egresados</th>
			</tr>
<?
			$query="select	 sch.idclasificacionesinfhuerfana
					,sch.clasificacionesinfhuerfana
				from siq_clasificacionesinfhuerfana sch
				join (	select idclasificacionesinfhuerfana
					from siq_clasificacionesinfhuerfana 
					where aliasclasificacionesinfhuerfana='".$_REQUEST['alias']."'
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
					<td class="column" align="center"><input type="text" class="required number" name="pregrado[<?=$row['idclasificacionesinfhuerfana']?>]" id="pregrado[<?=$row['idclasificacionesinfhuerfana']?>]" title="Pregado" maxlength="3" tabindex="1" autocomplete="off" size="6" style='text-align:center' /></td>
					<td class="column" align="center"><input type="text" class="required number" name="posgrado[<?=$row['idclasificacionesinfhuerfana']?>]" id="posgrado[<?=$row['idclasificacionesinfhuerfana']?>]" title="Posgrado" maxlength="3" tabindex="1" autocomplete="off" size="6" style='text-align:center' /></td>
					<td class="column borderR" align="center"><input type="text" class="required number" name="egresados[<?=$row['idclasificacionesinfhuerfana']?>]" id="egresados[<?=$row['idclasificacionesinfhuerfana']?>]" title="Egresados" maxlength="3" tabindex="1" autocomplete="off" size="6" style='text-align:center' /></td>
					<td class="column borderR" align="center"><input type="text" class="required number" name="docentes[<?=$row['idclasificacionesinfhuerfana']?>]" id="docentes[<?=$row['idclasificacionesinfhuerfana']?>]" title="Docentes" maxlength="3" tabindex="1" autocomplete="off" size="6" style='text-align:center' /></td>
					<td class="column borderR" align="center"><input type="text" class="required number" name="administrativos[<?=$row['idclasificacionesinfhuerfana']?>]" id="administrativos[<?=$row['idclasificacionesinfhuerfana']?>]" title="Administrativos" maxlength="3" tabindex="1" autocomplete="off" size="6" style='text-align:center' /></td>
<?
					if($_REQUEST['alias']=='eaddiaf' || $_REQUEST['alias']=='eads' || $_REQUEST['alias']=='eadcyr') {
?>
						<td class="column borderR" align="center"><input type="text" class="required number" name="familiares[<?=$row['idclasificacionesinfhuerfana']?>]" id="familiares[<?=$row['idclasificacionesinfhuerfana']?>]" title="Familiares" maxlength="3" tabindex="1" autocomplete="off" size="6" style='text-align:center' /></td>
<?
					}
					if($_REQUEST['alias']=='eaddiaf' || $_REQUEST['alias']=='eadcyr' || $_REQUEST['alias']=='edvu') {
?>
						<td class="column borderR" align="center"><input type="text" class="required number" name="encuentros[<?=$row['idclasificacionesinfhuerfana']?>]" id="encuentros[<?=$row['idclasificacionesinfhuerfana']?>]" title="Nro. de encuentros o presentaciones oficiales" maxlength="3" tabindex="1" autocomplete="off" size="6" style='text-align:center' /></td>
<?
					}
					if($_REQUEST['alias']=='edvu') {
?>
						<td class="column" align="center"><input type="text" class="required number" name="beneficiarios[<?=$row['idclasificacionesinfhuerfana']?>]" id="beneficiarios[<?=$row['idclasificacionesinfhuerfana']?>]" title="Beneficiarios comunidad" maxlength="3" tabindex="1" autocomplete="off" size="6" style='text-align:center' /></td>
<?
					}
?>
				</tr>
<?
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
