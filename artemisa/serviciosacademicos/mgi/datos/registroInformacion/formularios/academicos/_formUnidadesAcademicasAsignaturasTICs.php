<?php
	// echo "<pre>"; print_r($_REQUEST);
    require_once("../../../templates/template.php");
    $db = getBD();
    $utils = new Utils_datos();
    $id = $_REQUEST["id"];
	$titulo="Asignaturas que incluyen herramientas mediadas por las TIC en las actividades de evaluación y actividades de aprendizaje y porcentaje de utilización en total";
	$subtitulo="Total de asignaturas que utilizan TICs";
	$subtitulo2=true;
        $idForm = "forma".$_REQUEST['alias'];
?>

<div id="tabs-21">
<form action="save.php" method="post" id="forma<?php echo $_REQUEST['alias']; ?>">
            <input type="hidden" name="entity" id="entity" value="fortalecimientoacademicoinfhuerfana" />
            <input type="hidden" name="action" value="saveDynamic2" id="action" />
            <input type="hidden" name="semestre" value="" id="semestre" />
            <input type="hidden" name="actionID" value="" id="actionID" />
            <input type="hidden" name="aux[]" value="" id="aux" />
            <span class="mandatory">* Son campos obligatorios</span>
            <fieldset id="numPersonas">   
                
		<legend><?php echo $titulo; ?></legend>
                <div class="formModalidad">
                     <?php include("./_elegirProgramaAcademico.php"); ?>
                </div>
                
                <div class="vacio"></div>
                
                <label for="nombre" class="fixedLabel">Semestre: <span class="mandatory">(*)</span></label>
                <?php $utils->getSemestresSelect($db,"codigoperiodo",false,null,'BuscarData()'); ?>
                
                <?php $utils->pintarBotonCargar("popup_cargarDocumento(".$id.",24,$('#forma".$_REQUEST['alias']." #codigoperiodo').val(),$('#forma".$_REQUEST['alias']." #unidadAcademica').val())","popup_verDocumentos(".$id.",24,$('#forma".$_REQUEST['alias']." #codigoperiodo').val(),$('#forma".$_REQUEST['alias']." #unidadAcademica').val())"); ?>
                <table align="center" class="formData last" width="92%"> 

			<tr class="dataColumns">
				<th class="borderR"><?php echo $subtitulo; ?></th>

				<?php if($subtitulo2) {
				?>
					<th class="borderR">% de utilización</th>

<?php
				}
				?>
			</tr>
				<tr id="contentColumns" class="row">
					<td class="column borderR" align="center">

						<input type="text"  class="required number" name="total_asignaturas" id="total_asignaturas" title="Total de asignaturas" tabindex="1" autocomplete="off" size="20" style='text-align:center' />
                    </td>
				<?php
					if($subtitulo2) {
				?>
					<td class="column borderR" align="center">
						<input type="text" class="required number" name="porcentaje_utilizacion" id="porcentaje_utilizacion" title="% de utilización" tabindex="1" autocomplete="off" size="20" style='text-align:center' />
					</td>
		
<?php
}
				?>
				</tr>
		</table>

                <div class="vacio"></div>               
                <div id="respuesta_forma<?php echo $_REQUEST['alias']; ?>" class="msg-success" style="display:none"></div>

	</fieldset>
	<input type="hidden" name="alias" value="<?php echo $_REQUEST['alias']; ?>" />
	<div class="guardar" onmouseover="guardar(this)" title="">
    <div class="vacio"></div>
	<input type="submit" id="submitAsignaturasTICS" value="Guardar cambios" class="first" />
	</div>
</form>
<script type="text/javascript">
	BuscarData();

	$('#submitAsignaturasTICS').click(function(event) {
		event.preventDefault();
		var valido= validateForm("#forma<?php echo $_REQUEST['alias']; ?>");
		if(valido){
			sendFormTICS();
		}
	});
        

        $(document).on('change', "#forma<?php echo $_REQUEST['alias']; ?> #modalidad", function(){
                    getCarreras("#forma<?php echo $_REQUEST['alias']?>");
                    changeFormModalidad("#forma<?php echo $_REQUEST['alias']?>");
                    BuscarData();
                });
                
                $(document).on('change', "#forma<?php echo $_REQUEST['alias']?> #unidadAcademica", function(){
                    //getDataActividadesAcademicos("#forma<?=$_REQUEST['alias']?>");
                    changeFormModalidad("#forma<?php echo $_REQUEST['alias']?>");
                    BuscarData();
                });

        
	function sendFormTICS(){
		$('#forma<?php echo $_REQUEST['alias']?> #actionID').val('saveDynamic2');
            $('#forma<?php echo $_REQUEST['alias']?> #semestre').val($('#forma<?php echo $_REQUEST['alias']?> #codigoperiodo').val());
            $('#forma<?php echo $_REQUEST['alias']?> #aux').val($('#forma<?php echo $_REQUEST['alias']?> #unidadAcademica').val());
            $('#forma<?php echo $_REQUEST['alias']?> #total_asignaturas').attr('name', 'total_asignaturas[' + $('#forma<?php echo $_REQUEST['alias']?> #aux').val() + "]");
            <?php if($subtitulo2) { ?>
                $('#forma<?php echo $_REQUEST['alias']?> #porcentaje_utilizacion').attr('name', 'porcentaje_utilizacion[' + $('#forma<?php echo $_REQUEST['alias']?> #aux').val() + "]");
            <?php } ?>

                activarModalidades('#forma<?php echo $_REQUEST['alias']?>');

                $.ajax({
				dataType: 'json',
				type: 'POST',
				url: 'formularios/academicos/saveFortalecimientoAcademico.php',
				data: $('#forma<?php echo $_REQUEST['alias']?>').serialize(),                
				success:function(data){
					<?php if($permisos["rol"][0]!=1) { ?>

                            desactivarModalidades('#forma<?php echo $_REQUEST['alias']?>');
							<?php } ?>
				if (data.success == true){
					$('#respuesta_forma<?php echo $_REQUEST['alias']?>').html('<p>' + data.message + '</p>');
					$('#respuesta_forma<?php echo $_REQUEST['alias']?>').removeClass('msg-error');
					$('#respuesta_forma<?php echo $_REQUEST['alias']?>').css('display','block');
                                        $("#respuesta_forma<?php echo $_REQUEST['alias']?>").delay(5500).fadeOut(800);
				} else {
					$('#respuesta_forma<?php echo $_REQUEST['alias']?>').html('<p>' + data.message + '</p>');
					$('#respuesta_forma<?php echo $_REQUEST['alias']?>').addClass('msg-error');
					$('#respuesta_forma<?php echo $_REQUEST['alias']?>').css('display','block');
                                        $("#respuesta_forma<?php echo $_REQUEST['alias']?>").delay(5500).fadeOut(800);

				}
			},
			error: function(data,error,errorThrown){alert(error + errorThrown);}
		});            
	}
	
    function BuscarData(){
        /*************************************/
        
        $('#forma<?php echo $_REQUEST['alias']?> #actionID').val('BuscarData');
        $('#forma<?php echo $_REQUEST['alias']?> #aux').val($('#forma<?php echo $_REQUEST['alias']; ?> #unidadAcademica').val());
        
        $.ajax({//Ajax
			  type: 'GET',
			  url: 'formularios/academicos/saveFortalecimientoAcademico.php',
			  async: false,
			  dataType: 'json',
			  data:$('#forma<?php echo $_REQUEST['alias']; ?>').serialize(),
			  error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
			  success:function(data){

					if (data.val == true){
						$('#forma<?php echo $_REQUEST['alias']?> #total_asignaturas').val(data.total);
						<?php if($subtitulo2) { ?>
							$('#forma<?php echo $_REQUEST['alias']?> #porcentaje_utilizacion').val(data.porcentaje);
						<?php } ?>
					} else {
						$('#forma<?php echo $_REQUEST['alias']?> #total_asignaturas').val("");
						<?php if($subtitulo2) { ?>
							$('#forma<?php echo $_REQUEST['alias']?> #porcentaje_utilizacion').val("");
						<?php } ?>
					}
					//$('#CargarReporte').html(data);

		   },
	    }); //AJAX
        
        /*************************************/
    }/*function BuscarData*/
</script>