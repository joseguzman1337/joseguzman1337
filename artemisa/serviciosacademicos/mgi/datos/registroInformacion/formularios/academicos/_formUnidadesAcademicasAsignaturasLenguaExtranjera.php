<?php
    require_once("../../../templates/template.php");
    $db = getBD();
    $utils = new Utils_datos();
    $id = $_REQUEST["id"];
	$titulo="Asignaturas que utilizan lengua extranjera en las actividades de aprendizaje y evaluación del curso y porcentaje de utilización en el programa académico";
	$subtitulo="Total de asignaturas que utilizan lengua extranjera";
	$subtitulo2=true;
        $idForm = "forma".$_REQUEST['alias'];
?>

<div id="tabs-21">
<form action="save.php" method="post" id="forma<?=$_REQUEST['alias']?>">
            <input type="hidden" name="entity" id="entity" value="fortalecimientoacademicoinfhuerfana" />
            <input type="hidden" name="action" value="saveDynamic2" id="action" />
            <input type="hidden" name="semestre" value="" id="semestre" />
            <input type="hidden" name="aux[]" value="" id="aux" />
            <span class="mandatory">* Son campos obligatorios</span>
            <fieldset id="numPersonas">   
                
		<legend><?=$titulo; ?></legend>
                <div class="formModalidad">
                     <?php include("./_elegirProgramaAcademico.php"); ?>
                </div>
                
                <div class="vacio"></div>
                
                <label for="nombre" class="fixedLabel">Semestre: <span class="mandatory">(*)</span></label>
                <?php $utils->getSemestresSelect($db,"codigoperiodo"); ?>
                
                <?php $utils->pintarBotonCargar("popup_cargarDocumento(".$id.",22,$('#forma".$_REQUEST['alias']." #codigoperiodo').val(),$('#forma".$_REQUEST['alias']." #unidadAcademica').val())","popup_verDocumentos(".$id.",22,$('#forma".$_REQUEST['alias']." #codigoperiodo').val(),$('#forma".$_REQUEST['alias']." #unidadAcademica').val())"); ?>
  	 
                <table align="center" class="formData last" width="92%">
			<tr class="dataColumns">
				<th class="borderR"><?=$subtitulo?></th>
<?
				if($subtitulo2) {
?>
					<th class="borderR">% de utilización</th>
<?
				}
?>
			</tr>
				<tr id="contentColumns" class="row">
					<td class="column borderR" align="center">
                                            <input type="text" class="required number" name="total_asignaturas" id="total_asignaturas" title="Total de asignaturas" tabindex="1" autocomplete="off" size="20" style='text-align:center' />
                                        </td>
<?
					if($subtitulo2) {
?>
						<td class="column borderR" align="center"><input type="text" class="required number" name="porcentaje_utilizacion" id="porcentaje_utilizacion" title="% de utilización" tabindex="1" autocomplete="off" size="20" style='text-align:center' /></td>
<?
					}
?>
				</tr>
		</table>
                
                <div class="vacio"></div>
                
                <div id="respuesta_forma<?=$_REQUEST['alias']?>" class="msg-success" style="display:none"></div>
	</fieldset>
	<input type="hidden" name="alias" value="<?=$_REQUEST['alias']?>" />
	<div class="guardar" onmouseover="guardar(this)" title="">
    <div class="vacio"></div>
	<input type="submit" value="Guardar cambios" class="first" />
	</div>
</form>
<script type="text/javascript">
	$(':submit').click(function(event) {
		event.preventDefault();
		var valido= validateForm("#forma<?=$_REQUEST['alias']?>");
		if(valido){
			sendFormLenguaExtranjera();
		}
	});
        
        $(document).on('change', "#forma<?=$_REQUEST['alias']?> #modalidad", function(){
                    getCarreras("#forma<?=$_REQUEST['alias']?>");
                    changeFormModalidad("#forma<?=$_REQUEST['alias']?>");
                });
                
                $(document).on('change', "#forma<?=$_REQUEST['alias']?> #unidadAcademica", function(){
                    //getDataActividadesAcademicos("#forma<?=$_REQUEST['alias']?>");
                    changeFormModalidad("#forma<?=$_REQUEST['alias']?>");
                });
        
	function sendFormLenguaExtranjera(){
            $('#forma<?=$_REQUEST['alias']?> #semestre').val($('#forma<?=$_REQUEST['alias']?> #codigoperiodo').val());
            $('#forma<?=$_REQUEST['alias']?> #aux').val($('#forma<?=$_REQUEST['alias']?> #unidadAcademica').val());
            $('#forma<?=$_REQUEST['alias']?> #total_asignaturas').attr('name', 'total_asignaturas[' + $('#forma<?=$_REQUEST['alias']?> #aux').val() + "]");
            <?php if($subtitulo2) { ?>
                $('#forma<?=$_REQUEST['alias']?> #porcentaje_utilizacion').attr('name', 'porcentaje_utilizacion[' + $('#forma<?=$_REQUEST['alias']?> #aux').val() + "]");
            <?php } ?>
                activarModalidades('#forma<?=$_REQUEST['alias']?>');
                $.ajax({
				dataType: 'json',
				type: 'POST',
				url: 'formularios/academicos/saveFortalecimientoAcademico.php',
				data: $('#forma<?=$_REQUEST['alias']?>').serialize(),                
				success:function(data){
					<?php if($permisos["rol"][0]!=1) { ?>
                            desactivarModalidades('#forma<?=$_REQUEST['alias']?>');
							<?php } ?>
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
       