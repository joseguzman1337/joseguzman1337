<?PHP 
session_start();
require_once("../../../templates/template.php");
$db = getBD();
$utils = new Utils_datos();
if($_REQUEST['alias']=='apeirbyh') {
	$titulo="Asignaturas del plan de estudios que incorporan el referente de la bioética y las humanidades";
	$subtitulo="Total de asignaturas con referente bioética y humanidades";
	$subtitulo2=false;
} elseif($_REQUEST['alias']=='auleaaecpupa') {
	$titulo="Asignaturas que utilizan lengua extranjera en las actividades de aprendizaje y evaluación del curso y porcentaje de utilización en el programa académico";
	$subtitulo="Total de asignaturas que utilizan lengua extranjera";
	$subtitulo2=true;
} elseif($_REQUEST['alias']=='aaiaaepu') {
	$titulo="Asignaturas que articulan la internacionalización  con las actividades de aprendizaje y evaluación y porcentaje de utilización";
	$subtitulo="Total de asignaturas que articulan la internacionalización";
	$subtitulo2=true;
} else {
	$titulo="Asignaturas que incluyen herramientas mediadas por las TIC en las actividades de evaluación y actividades de aprendizaje y porcentaje de utilización en total";
	$subtitulo="Total de asignaturas que utilizan TICs";
	$subtitulo2=true;
}
?>
<form action="" method="post" id="forma<?PHP echo $_REQUEST['alias']?>">
	<span class="mandatory">* Son campos obligatorios</span>
	<fieldset>  
		<legend><?PHP echo $titulo?></legend>
		<label for="semestre" class="grid-2-12">Semestre: <span class="mandatory">(*)</span></label>
<?PHP
		$utils->getSemestresSelect($db,"semestre");
		$idForm = "forma".$_REQUEST['alias'];
		$utils->pintarBotonCargar("popup_cargarDocumento(2,1,$('#".$idForm." #mes').val()+'-'+$('#".$idForm." #anio').val())","popup_verDocumentos(2,1,$('#".$idForm." #mes').val()+'-'+$('#".$idForm." #anio').val())"); ?>
                
		<table align="center" class="formData last" width="92%">
			<tr class="dataColumns">
				<th class="borderR">Programas acad&eacute;micos</th>               
				<th class="borderR"><?PHP echo $subtitulo?></th>
<?PHP
				if($subtitulo2) {
?>
					<th class="borderR">% de utilización</th>
<?PHP
				}
?>
			</tr>
<?PHP
			$query="select	 codigocarrera
					,nombrecarrera
				from carrera
				where codigomodalidadacademica=200
					and codigomodalidadacademicasic=200
					and fechavencimientocarrera>=curdate()
				order by nombrecarrera";
			$exec= $db->Execute($query);
			while($row = $exec->FetchRow()) {
?>
				<tr id="contentColumns" class="row">
					<td class="column borderR">
						<input type="hidden" name="aux[<?PHP echo $row['codigocarrera']?>]" value="<?PHP echo $row['codigocarrera']?>">
						<?PHP echo $row['nombrecarrera']?>: <span class="mandatory">(*)</span>
					</td>
					<td class="column borderR" align="center"><input type="text" class="required number" name="total_asignaturas[<?PHP echo $row['codigocarrera']?>]" id="total_asignaturas[<?PHP echo $row['codigocarrera']?>]" title="Total de asignaturas" maxlength="3" tabindex="1" autocomplete="off" size="6" style='text-align:center' /></td>
<?PHP
					if($subtitulo2) {
?>
						<td class="column borderR" align="center"><input type="text" class="required number" name="porcentaje_utilizacion[<?PHP echo $row['codigocarrera']?>]" id="porcentaje_utilizacion[<?PHP echo $row['codigocarrera']?>]" title="% de utilización" maxlength="3" tabindex="1" autocomplete="off" size="6" style='text-align:center' /></td>
<?PHP
					}
?>
				</tr>
<?PHP
			}
?>
		</table>
                <div class="vacio"></div>
                <div id="respuesta_forma<?PHP echo $_REQUEST['alias']?>" class="msg-success" style="display:none"></div>
	</fieldset>
	<input type="hidden" name="alias" value="<?PHP echo $_REQUEST['alias']?>" />
	<input type="submit" value="Guardar cambios" class="first" />
</form>
<script type="text/javascript">
	$(':submit').click(function(event) {
		event.preventDefault();
		var valido= validateForm("#forma<?PHP echo $_REQUEST['alias']?>");
		if(valido){
			sendForm();
		}
	});
	function sendForm(){
		$.ajax({
				dataType: 'json',
				type: 'POST',
				url: 'formularios/academicos/saveFortalecimientoAcademico.php',
				data: $('#forma<?PHP echo $_REQUEST['alias']?>').serialize(),                
				success:function(data){
				if (data.success == true){
					$('#respuesta_forma<?PHP echo $_REQUEST['alias']?>').html('<p>' + data.message + '</p>');
					$('#respuesta_forma<?PHP echo $_REQUEST['alias']?>').removeClass('msg-error');
					$('#respuesta_forma<?PHP echo $_REQUEST['alias']?>').css('display','block');
                                        $("#respuesta_forma<?PHP echo $_REQUEST['alias']?>").delay(5500).fadeOut(800);
				} else {
					$('#respuesta_forma<?PHP echo $_REQUEST['alias']?>').html('<p>' + data.message + '</p>');
					$('#respuesta_forma<?PHP echo $_REQUEST['alias']?>').addClass('msg-error');
					$('#respuesta_forma<?PHP echo $_REQUEST['alias']?>').css('display','block');
                                        $("#respuesta_forma<?=$_REQUEST['alias']?>").delay(5500).fadeOut(800);
				}
			},
			error: function(data,error,errorThrown){alert(error + errorThrown);}
		});            
	}
</script>
