<?PHP  
require_once("../../../templates/template.php");
$db = getBD();
$utils = new Utils_datos();
function meses() {
	return array (	 "1"=>"Enero" 		,"2"=>"Febrero"		,"3"=>"Marzo"		
			,"4"=>"Abril"		,"5"=>"Mayo"		,"6"=>"Junio"		
			,"7"=>"Julio"		,"8"=>"Agosto"		,"9"=>"Septiembre"	
			,"10"=>"Octubre"	,"11"=>"Noviembre"	,"12"=>"Diciembre" );
}
?>
<form action="save.php" method="post" id="form5">
	<span class="mandatory">* Son campos obligatorios</span>
	<fieldset>  
		<legend>Bases de datos disponibles por área temática</legend>
		<label for="mes" class="grid-2-12">Mes: <span class="mandatory">(*)</span></label>
		<select name='mes'>
<?PHP 
			foreach (meses() as $key => $valor) {
				$selected=(date('m')==$key)?" selected":"";
?>
				<option value='<?PHP echo $key?>' <?PHP echo $selected?>><?PHP echo $valor?></option>
<?PHP 					} ?>
		</select>
		<table align="left" class="formData last" width="92%" >
			<thead>
				<tr id="dataColumns">
					<th>Facultad</th>               
					<th>Suscripción</th>
					<th>Open Access</th>
				</tr>
			</thead>
			<tbody>
<?PHP 
			$query="select * from siq_tiposdbxareatematica";
			$exec= $db->Execute($query);
			while($row = $exec->FetchRow()) {
?>
				<tr id="contentColumns" class="row">
					<td class="column"><?PHP echo $row['tipodbxareatematica']?>: <span class="mandatory">(*)</span></td>
					<td class="column" align="center"><input type="text" class="required number" name="suscripcion[<?PHP echo $row['idtipodbxareatematica']?>]" id="volumenes[<?PHP echo $row['idtipodbxareatematica']?>]" title="suscipción" maxlength="3" tabindex="1" autocomplete="off" />
					<td class="column" align="center"><input type="text" class="required number" name="open_access[<?PHP echo $row['idtipodbxareatematica']?>]" id="titulos[<?PHP echo $row['idtipodbxareatematica']?>]" title="open access" maxlength="3" tabindex="1" autocomplete="off" />
				</tr>
<?PHP                                       } ?>
			</tbody>
		</table>
	</fieldset>
	<input type="hidden" name="formulario" value="form5" />   
	<input type="submit" value="Guardar cambios" class="first" />
</form>
<div id='respuesta_form5' style='color: #548412; font-weight: bold; padding: 10px 20px 5px 38px;'></div>
<script type="text/javascript">
	$(':submit').click(function(event) {
		event.preventDefault();
		var valido= validateForm("#form5");
		if(valido){
			sendForm();
		}
	});
	function sendForm(){
		$.ajax({
				dataType: 'json',
				type: 'POST',
				url: 'formularios/recursosFisicos/saveBiblioteca.php',
				data: $('#form5').serialize(),                
				success:function(data){
				if (data.success == true){
					$('#respuesta_form5').html('<p>' + data.message + '</p>');
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
