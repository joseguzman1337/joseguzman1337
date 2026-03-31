<?php

    include_once("../variables.php");
    include($rutaTemplate."template.php");
    $db = writeHeader("Cambiar encabezado curso",TRUE);

    $utils = Utils::getInstance(); 
	$dataPlantilla = $utils->getDataEntityActive("plantillaCursoEducacionContinuada", $_REQUEST["idplantilla"],"idplantillaCursoEducacionContinuada");
	$dataCampo = $utils->getDataEntity("campoParametrizadoPlantillaEducacionContinuada", "{{imagenEncabezado}}","etiqueta");
    $data = $utils->getDataEntity("carrera", $dataPlantilla["codigocarrera"],"codigocarrera");
           
?>

    <div id="contenido">
        <h4>Encabezado Certificación <?php echo $data["nombrecarrera"]; ?></h4>
        <div id="form"> 
			<div id="msg-error"><?php if(isset($_REQUEST["success"])&& $_REQUEST["success"]==false) { echo $_REQUEST["mensaje"]; } ?></div>
    
    <form action="process.php" method="post" id="form_test" enctype="multipart/form-data" name="signForm" >
            <input type="hidden" name="action" value="changeHeader" />
            <input type="hidden" name="entity" value="detallePlantillaCursoEducacionContinuada" />
            <input type="hidden" name="idCampoParametrizado" value="<?php echo $dataCampo["idcampoParametrizadoPlantillaEducacionContinuada"]; ?>" />
            <input type="hidden" name="idPlantilla" value="<?php echo $dataPlantilla["idplantillaCursoEducacionContinuada"]; ?>" />
            
            <span class="mandatory">* Son campos obligatorios</span>
            <fieldset>   
                <label for="firma" style="margin-left:10px;margin-top:5px">Encabezado: <span class="mandatory">(*)</span></label>
                <input class="required" type="file" name="file" id="file" style="margin-bottom:3px;">
				<!--<input type="button" value="Ver encabezado actual" id="verEncabezado" class="first small"/>	-->
                
				<div class="vacio"></div>
				<span style="margin-left:110px;"></span><span style="margin-left:17px;font-size:0.8em;">Imagenes de tipo png y jpg.</span>
                
            </fieldset>
            
			<input type="submit" value="Guardar cambios" class="first" style="margin-left:10px;" />
        </form>
</div>

<script type="text/javascript">
    $(':submit').click(function(event) {
        event.preventDefault();
        var valido= validateForm("#form_test");
        
        if(valido){ 
            if($('#file').val()!=""){
                var ext = $('#file').val().split('.').pop().toLowerCase();
                if($.inArray(ext, ['png','jpg','jpeg','PNG','JPG']) == -1) {
                    alert('Extensión no válida. Solo puede subir imagenes de tipo: png, jpg o jpeg.');
                } else { 
                    document.signForm.submit();
                } 
            } else {                
                 alert("Debe elegir una imagen para realizar el cambio.");        
            }
        }
    });
	 
    function closeOpener() {   
		if (window.opener != null) {   
			window.opener.location.reload(true);   
			window.close();   
		}   
    }    
    
	<?php if(isset($_REQUEST["success"])&& $_REQUEST["success"]==true) { ?>
		closeOpener();
	<?php } ?>
</script>
<?php  writeFooter(); ?>