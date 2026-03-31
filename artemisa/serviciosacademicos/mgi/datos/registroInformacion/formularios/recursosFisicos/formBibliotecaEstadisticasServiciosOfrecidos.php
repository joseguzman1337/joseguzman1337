<?
session_start();
require_once("../../../templates/template.php");
$db = getBD();
$utils = new Utils_datos();
?>
<form action="" method="post" id="form4">
	<span class="mandatory">* Son campos obligatorios</span>
	<fieldset>  
		<legend>Estadísticas por cada Servicio ofrecido</legend>
		<label for="mes" class="grid-2-12">Mes: <span class="mandatory">(*)</span></label>
<?		
		$utils->getMonthsSelect("mes"); 
		$utils->getYearsSelect("anio"); 
?>
		<table align="center" class="formData last" width="92%">
<?
			$query="select idclasificacionesinfhuerfana
					,clasificacionesinfhuerfana
					,aliasclasificacionesinfhuerfana
				from siq_clasificacionesinfhuerfana ch 
				where aliasclasificacionesinfhuerfana in ('sdlb','sdrcap','sdra','sdrcom','sdrs')";
			$exec= $db->Execute($query);
			while($row = $exec->FetchRow()) {
?>
				<tr id="dataColumns">
<?
					if($row['aliasclasificacionesinfhuerfana']=='sdlb') {
?>
						<th>Servicio de la biblioteca</th>               
						<th>Nro. de consultas docentes</th>
						<th>Nro. de consultas estudiantes</th>
<?				
					}
					if($row['aliasclasificacionesinfhuerfana']=='sdrcap') {
?>					
						<th>Servicio de referencia</th>               
						<th>Nro. de capacitación a docentes</th>
						<th>Nro. de capacitación a estudiantes</th>
<?				
					}
					if($row['aliasclasificacionesinfhuerfana']=='sdra') {
?>					
						<th>Servicio de referencia</th>               
						<th>Nro. de artículos solicitados docentes</th>
						<th>Nro. de artículos solicitados estudiantes</th>
<?				
					}
					if($row['aliasclasificacionesinfhuerfana']=='sdrcom') {
?>					
						<th>Servicio de referencia</th>               
						<th colspan="2">Comunidad académica y administrativa</th>
<?				
					}
					if($row['aliasclasificacionesinfhuerfana']=='sdrs') {
?>
						<th>Servicio de la biblioteca</th>               
						<th>Nro. de solicitudes de docentes</th>
						<th>Nro. de solicitudes de estudiantes</th>
<?				
					}
?>
				</tr>
<?
				$query2="select idclasificacionesinfhuerfana
						,clasificacionesinfhuerfana
					from siq_clasificacionesinfhuerfana
					where idpadreclasificacionesinfhuerfana=".$row['idclasificacionesinfhuerfana'];
				$exec2= $db->Execute($query2);
				while($row2 = $exec2->FetchRow()) {
?>
					<tr id="contentColumns" class="row">
						<td class="column">
							<input type="hidden" name="aux[<?=$row2['idclasificacionesinfhuerfana']?>]" value="<?=$row2['idclasificacionesinfhuerfana']?>">
							<?=$row2['clasificacionesinfhuerfana']?> <span class="mandatory">(*)</span>
						</td>
<?
						if($row['aliasclasificacionesinfhuerfana']=='sdlb') {
?>
							<td class="column" align="center"><input type="text" class="required number" name="consultas_doc[<?=$row2['idclasificacionesinfhuerfana']?>]" id="consultas_doc[<?=$row2['idclasificacionesinfhuerfana']?>]" title="nro. de consultas docentes" maxlength="3" tabindex="1" autocomplete="off" size="6" style='text-align:center' /></td>
							<td class="column" align="center"><input type="text" class="required number" name="consultas_est[<?=$row2['idclasificacionesinfhuerfana']?>]" id="consultas_est[<?=$row2['idclasificacionesinfhuerfana']?>]" title="nro. de consultas estudiantes" maxlength="3" tabindex="1" autocomplete="off" size="6" style='text-align:center' /></td>
<?	
						}
						if($row['aliasclasificacionesinfhuerfana']=='sdrcap') {
?>
							<td class="column" align="center"><input type="text" class="required number" name="capacitacion_doc[<?=$row2['idclasificacionesinfhuerfana']?>]" id="capacitacion_doc[<?=$row2['idclasificacionesinfhuerfana']?>]" title="nro. de capacitación a docentes" maxlength="3" tabindex="1" autocomplete="off" size="6" style='text-align:center' /></td>
							<td class="column" align="center"><input type="text" class="required number" name="capacitacion_est[<?=$row2['idclasificacionesinfhuerfana']?>]" id="capacitacion_est[<?=$row2['idclasificacionesinfhuerfana']?>]" title="nro. de capacitación a estudiantes" maxlength="3" tabindex="1" autocomplete="off" size="6" style='text-align:center' /></td>
<?	
						}
						if($row['aliasclasificacionesinfhuerfana']=='sdra') {
?>
							<td class="column" align="center"><input type="text" class="required number" name="articulos_doc[<?=$row2['idclasificacionesinfhuerfana']?>]" id="articulos_doc[<?=$row2['idclasificacionesinfhuerfana']?>]" title="nro. de artículos solicitados a docentes" maxlength="3" tabindex="1" autocomplete="off" size="6" style='text-align:center' /></td>
							<td class="column" align="center"><input type="text" class="required number" name="articulos_est[<?=$row2['idclasificacionesinfhuerfana']?>]" id="articulos_est[<?=$row2['idclasificacionesinfhuerfana']?>]" title="nro. de artículos solicitados a estudiantes" maxlength="3" tabindex="1" autocomplete="off" size="6" style='text-align:center' /></td>
<?	
						}
						if($row['aliasclasificacionesinfhuerfana']=='sdrcom') {
?>
							<td class="column" colspan="2" align="center"><input type="text" class="required number" name="comunidad[<?=$row2['idclasificacionesinfhuerfana']?>]" id="comunidad[<?=$row2['idclasificacionesinfhuerfana']?>]" title="Comunidad academica y administrativa" maxlength="3" tabindex="1" autocomplete="off" size="6" style='text-align:center' /></td>
<?	
						}
						if($row['aliasclasificacionesinfhuerfana']=='sdrs') {
?>
							<td class="column" align="center"><input type="text" class="required number" name="solicitudes_doc[<?=$row2['idclasificacionesinfhuerfana']?>]" id="solicitudes_doc[<?=$row2['idclasificacionesinfhuerfana']?>]" title="nro. de solicitudes de docentes" maxlength="3" tabindex="1" autocomplete="off" size="6" style='text-align:center' /></td>
							<td class="column" align="center"><input type="text" class="required number" name="solicitudes_est[<?=$row2['idclasificacionesinfhuerfana']?>]" id="solicitudes_est[<?=$row2['idclasificacionesinfhuerfana']?>]" title="nro. de solicitudes de estudiantes" maxlength="3" tabindex="1" autocomplete="off" size="6" style='text-align:center' /></td>
<?	
						}
?>
					</tr>
<?	
				} 
?>
<?
			} 
?>
		</table>
                
                <div class="vacio"></div>
                <div id="msg-success" class="msg-success" style="display:none"></div>
	</fieldset>
	<input type="hidden" name="formulario" value="form4" />
	<input type="submit" value="Guardar cambios" class="first" />
</form>
<script type="text/javascript">
	$(':submit').click(function(event) {
		event.preventDefault();
		var valido= validateForm("#form4");
		if(valido){
			sendForm4();
		}
	});
	function sendForm4(){
		$.ajax({
				dataType: 'json',
				type: 'POST',
				url: 'formularios/recursosFisicos/saveBiblioteca.php',
				data: $('#form4').serialize(),                
				success:function(data){
				if (data.success == true){		
					$('#form4 #msg-success').html('<p>' + data.message + '</p>');
					$('#form4 #msg-success').removeClass('msg-error');
					$('#form4 #msg-success').css('display','block');
                                        $("#form4 #msg-success").delay(5500).fadeOut(800);
				} else {
					$('#form4 #msg-success').html('<p>' + data.message + '</p>');
					$('#form4 #msg-success').addClass('msg-error');
					$('#form4 #msg-success').css('display','block');
                                        $("#form4 #msg-success").delay(5500).fadeOut(800);
				}
			},
			error: function(data,error,errorThrown){alert(error + errorThrown);}
		});            
	}
</script>
