<script type="text/javascript">
	$(function() {
		$( "#tabs" ).tabs({
		beforeLoad: function( event, ui ) {
			ui.jqXHR.error(function() {
				ui.panel.html(
				"Ocurrio un problema cargando el contenido." );
				});
			}
		});
	});
</script>

<? 
function meses() {
	return array (	 "1"=>"Enero" 		,"2"=>"Febrero"		,"3"=>"Marzo"		
			,"4"=>"Abril"		,"5"=>"Mayo"		,"6"=>"Junio"		
			,"7"=>"Julio"		,"8"=>"Agosto"		,"9"=>"Septiembre"	
			,"10"=>"Octubre"	,"11"=>"Noviembre"	,"12"=>"Diciembre" );
}
?>
<div id="tabs">
	<ul>
		<li><a href="formularios/recursosFisicos/material_impreso.php">Material impreso</a></li>
		<li><a href="formularios/recursosFisicos/bases_de_datos.php">Bases de datos</a></li>
		<li><a href="detalleCertificacion.php?id=<?php echo $id; ?>">Convenios Suscritos para la adquisición y prestación de servicios de información de la Biblioteca</a></li>
	</ul>
	<div id="tab-1">
		<form action="save.php" method="post" id="form_test1">
			<span class="mandatory">* Son campos obligatorios</span>
			<fieldset>  
				<legend>Volúmenes y títulos del material impreso</legend>
				<label for="mes" class="grid-2-12">Mes: <span class="mandatory">(*)</span></label>
				<select name='mes'>
<?
					foreach (meses() as $key => $valor) {
						$selected=(date('m')==$key)?" selected":"";
?>
						<option value='<?=$key?>' <?=$selected?>><?=$valor?></option>
<?					} ?>
				</select>
                                <table class="previewReport" style="text-align:left;clear:both;margin: 10px 0px;">
					<thead>
						<tr id="dataColumns">
							<th>Material</th>               
							<th>Volúmenes</th>
							<th>Titulos</th>
						</tr>
					</thead>
					<tbody>
<?
                                        $query="select * from siq_tiposmaterialimpreso";
                                        $exec= $db->Execute($query);
                                        while($row = $exec->FetchRow()) {
?>
						<tr id="contentColumns" class="row">
							<td class="column"><?=$row['tipomaterialimpreso']?>: <span class="mandatory">(*)</span></td>
                					<td class="column" align="center"><input type="text" class="required number" name="volumenes[<?=$row['idtipomaterialimpreso']?>]" id="volumenes[<?=$row['idtipomaterialimpreso']?>]" title="volumen" maxlength="3" tabindex="1" autocomplete="off" />
                					<td class="column" align="center"><input type="text" class="required number" name="titulos[<?=$row['idtipomaterialimpreso']?>]" id="titulos[<?=$row['idtipomaterialimpreso']?>]" title="titulo" maxlength="3" tabindex="1" autocomplete="off" />
						</tr>
<?                                      } ?>
					</tbody>
				</table>

				<!--<legend>Información del Aspecto</legend>-->
				<!--<label for="idmaterial" class="grid-2-12">Id Material: <span class="mandatory">(*)</span></label>
				<input type="text" class="grid-5-12" minlength="2" name="idmaterial" id="idmaterial" title="codigo" maxlength="120" tabindex="1" autocomplete="off" />
				<label for="volumenes" class="grid-2-12">Volumenes: <span class="mandatory">(*)</span></label>
				<input type="text" class="grid-5-12" minlength="2" name="volumenes" id="volumenes" title="codigo" maxlength="120" tabindex="1" autocomplete="off" />
				<label for="titulos" class="grid-2-12">Titulos: <span class="mandatory">(*)</span></label>
				<input type="text" class="grid-5-12" minlength="2" name="titulos" id="titulos" title="codigo" maxlength="120" tabindex="1" autocomplete="off" />-->

			</fieldset>
			<input type="hidden" name="formulario" value="tab-1" />
			<input type="submit" value="Guardar cambios" class="first" />
		</form>
	</div>
	<div id="tab-2">
		<form action="save.php" method="post" id="form_test2">
			<span class="mandatory">* Son campos obligatorios</span>
			<fieldset>  
				<legend>Bases de datos disponibles por área temática</legend>
				<label for="mes" class="grid-2-12">Mes: <span class="mandatory">(*)</span></label>
				<select name='mes'>
<?
					foreach (meses() as $key => $valor) {
						$selected=(date('m')==$key)?" selected":"";
?>
						<option value='<?=$key?>' <?=$selected?>><?=$valor?></option>
<?					} ?>
				</select>
                                <table class="previewReport" style="text-align:left;clear:both;margin: 10px 0px;">
					<thead>
						<tr id="dataColumns">
							<th>Facultad</th>               
							<th>Suscripción</th>
							<th>Open Access</th>
						</tr>
					</thead>
					<tbody>
<?
                                        $query="select * from siq_tiposdbxareatematica";
                                        $exec= $db->Execute($query);
                                        while($row = $exec->FetchRow()) {
?>
						<tr id="contentColumns" class="row">
							<td class="column"><?=$row['tipodbxareatematica']?>: <span class="mandatory">(*)</span></td>
                					<td class="column" align="center"><input type="text" class="required number" name="suscripcion[<?=$row['idtipodbxareatematica']?>]" id="volumenes[<?=$row['idtipodbxareatematica']?>]" title="suscipción" maxlength="3" tabindex="1" autocomplete="off" />
                					<td class="column" align="center"><input type="text" class="required number" name="open_access[<?=$row['idtipodbxareatematica']?>]" id="titulos[<?=$row['idtipodbxareatematica']?>]" title="open access" maxlength="3" tabindex="1" autocomplete="off" />
						</tr>
<?                                      } ?>
					</tbody>
				</table>
			</fieldset>
			<input type="hidden" name="formulario" value="tab-2" />
			<input type="submit" value="Guardar cambios" class="first" />
		</form>
	</div>
	<div id='prueba' style='color: #548412; font-weight: bold; padding: 10px 20px 5px 38px;'></div>
</div>

<script type="text/javascript">
	$(':submit').click(function(event) {
		event.preventDefault();
		var valido= validateForm("#form_test");
		if(valido){
			sendForm();
		}
	});
	function sendForm(){
		$.ajax({
				dataType: 'json',
				type: 'POST',
				url: 'formularios/recursosFisicos/saveBiblioteca.php',
				data: $('#form_test').serialize(),                
				success:function(data){
				if (data.success == true){
					$('#prueba').html('<p>' + data.message + '</p>');
					//window.location.href="index.php";
				}
				else{                        
					$('#msg-error').html('<p>' + data.message + '</p>');
					$('#msg-error').addClass('msg-error');
				}
			},
			error: function(data,error,errorThrown){alert(error + errorThrown);}
		});            
	}
</script>
