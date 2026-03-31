<?
session_start();
require_once("../../../templates/template.php");
$db = getBD();
$utils = new Utils_datos();
?>
<form action="" method="post" id="form2">
	<span class="mandatory">* Son campos obligatorios</span>
	<fieldset>  
		<legend>Bases de datos – Número de títulos y consultas</legend>
		<label for="semestre" class="grid-2-12">Semestre: <span class="mandatory">(*)</span></label>
                <?php $utils->getSemestresSelect($db,"semestre"); ?>
		<table align="center" class="formData last" width="92%">
<?
			$query="select idclasificacionesinfhuerfana
					,clasificacionesinfhuerfana
					,aliasclasificacionesinfhuerfana
					,conteo
				from siq_clasificacionesinfhuerfana ch 
				join (	select idpadreclasificacionesinfhuerfana
						,count(*)+1 as conteo 
					from siq_clasificacionesinfhuerfana
					group by idpadreclasificacionesinfhuerfana
				) sub on ch.idclasificacionesinfhuerfana=sub.idpadreclasificacionesinfhuerfana
				where aliasclasificacionesinfhuerfana in ('ryle','bdde','ovda','rdr')";
			$exec= $db->Execute($query);
			while($row = $exec->FetchRow()) {
?>
				<tr id="dataColumns">
<?
					if($row['aliasclasificacionesinfhuerfana']=='ryle') {
?>
						<th>Tipo de material</th>               
						<th>Base de datos por suscripción</th>
						<th>Nro. títulos revistas</th>
						<th>Nro. títulos libros</th>
						<th>Nro. consultas</th>
<?				
					}
					if($row['aliasclasificacionesinfhuerfana']=='bdde') {
?>					
						<th>Tipo de material</th>               
						<th>Base de datos espacializadas</th>
						<th colspan="2">Contenido</th>
						<th>Nro. consultas</th>
<?				
					}
					if($row['aliasclasificacionesinfhuerfana']=='ovda') {
?>					
						<th>Tipo de material</th>               
						<th>Objetivos virtuales de aprendizaje</th>
						<th colspan="2">Contenido</th>
						<th>Nro. consultas</th>
<?				
					}
					if($row['aliasclasificacionesinfhuerfana']=='rdr') {
?>					
						<th>Tipo de material</th>               
						<th>Recursos de referenciación</th>
						<th colspan="3">Creación de nuevas cuentas</th>
<?				
					}
?>
				</tr>
				<tr id="contentColumns" class="row">
					<td class="column borderR" rowspan="<?=$row['conteo']?>"><?=$row['clasificacionesinfhuerfana']?></td>
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
						if($row['aliasclasificacionesinfhuerfana']=='ryle') {
?>
							<td class="column" align="center"><input type="text" class="required number" name="revistas[<?=$row2['idclasificacionesinfhuerfana']?>]" id="revistas[<?=$row2['idclasificacionesinfhuerfana']?>]" title="nro. títulos revistas" maxlength="3" tabindex="1" autocomplete="off" size="6" style='text-align:center' /></td>
							<td class="column" align="center"><input type="text" class="required number" name="libros[<?=$row2['idclasificacionesinfhuerfana']?>]" id="libros[<?=$row2['idclasificacionesinfhuerfana']?>]" title="nro. títulos libros " maxlength="3" tabindex="1" autocomplete="off" size="6" style='text-align:center' /></td>
							<td class="column" align="center"><input type="text" class="required number" name="consultas[<?=$row2['idclasificacionesinfhuerfana']?>]" id="consultas[<?=$row2['idclasificacionesinfhuerfana']?>]" title="nro. consultas" maxlength="3" tabindex="1" autocomplete="off" size="6" style='text-align:center' /></td>
<?	
						}
						if($row['aliasclasificacionesinfhuerfana']=='bdde' || $row['aliasclasificacionesinfhuerfana']=='ovda') {
?>
							<td class="column" align="center" colspan="2"><input type="text" class="required number" name="contenido[<?=$row2['idclasificacionesinfhuerfana']?>]" id="contenido[<?=$row2['idclasificacionesinfhuerfana']?>]" title="contenido" maxlength="3" tabindex="1" autocomplete="off" size="6" style='text-align:center' /></td>
							<td class="column" align="center"><input type="text" class="required number" name="consultas[<?=$row2['idclasificacionesinfhuerfana']?>]" id="consultas[<?=$row2['idclasificacionesinfhuerfana']?>]" title="nro. consultas" maxlength="3" tabindex="1" autocomplete="off" size="6" style='text-align:center' /></td>
<?	
						}
						if($row['aliasclasificacionesinfhuerfana']=='rdr') {
?>
							<td class="column" align="center" colspan="3"><input type="text" class="required number" name="cuentas[<?=$row2['idclasificacionesinfhuerfana']?>]" id="cuentas[<?=$row2['idclasificacionesinfhuerfana']?>]" title="Creación de nuevas cuentas" maxlength="3" tabindex="1" autocomplete="off" size="6" style='text-align:center' /></td>
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
	<input type="hidden" name="formulario" value="form2" />
	<input type="submit" value="Guardar cambios" class="first" />
</form>
<script type="text/javascript">
	$(':submit').click(function(event) {
		event.preventDefault();
		var valido= validateForm("#form2");
		if(valido){
			sendForm2();
		}
	});
	function sendForm2(){
		$.ajax({
				dataType: 'json',
				type: 'POST',
				url: 'formularios/recursosFisicos/saveBiblioteca.php',
				data: $('#form2').serialize(),                
				success:function(data){
				if (data.success == true){					
					$('#form2 #msg-success').html('<p>' + data.message + '</p>');
					$('#form2 #msg-success').removeClass('msg-error');
					$('#form2 #msg-success').css('display','block');
                                        $("#form2 #msg-success").delay(5500).fadeOut(800);
				} else {
					$('#form2 #msg-success').html('<p>' + data.message + '</p>');
					$('#form2 #msg-success').addClass('msg-error');
					$('#form2 #msg-success').css('display','block');
                                        $("#form2 #msg-success").delay(5500).fadeOut(800);
				}
			},
			error: function(data,error,errorThrown){alert(error + errorThrown);}
		});            
	}
</script>
