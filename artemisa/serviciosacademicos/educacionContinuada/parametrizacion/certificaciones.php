<?php

session_start;
	/*include_once(realpath(dirname(__FILE__)).'/../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);*/
	
	include_once(realpath(dirname(__FILE__))."/../variables.php");
    include($rutaTemplate."template.php");
    $db = writeHeader("Valores de Defecto para Certificaciones",TRUE);

    include("./menu.php");
    writeMenu(2);
    $utils = Utils::getInstance();
    $cat = "CERTIFICADOS";
    $valores = $utils->getValoresParametrizacion($db,"CERTIFICADOS");
	//var_dump($valores);
    $numValores = count($valores);
?>

    <div id="contenido">
        <h4>Valores por Defecto para Certificaciones</h4>
        <div id="form"> 
			<div id="msg-error"><?php echo $_REQUEST["mensaje"]; ?></div>
    
    <form action="process.php" method="post" id="form_test" enctype="multipart/form-data" name="signForm" >
            <input type="hidden" name="entity" value="imagenEncabezado" />
            <input type="hidden" name="action" value="updateValuesCertificaciones" />
            <?php
                echo '<input type="hidden" name="idparametrizacionEducacionContinuada" value="'.$valores[0]["idparametrizacionEducacionContinuada"].'">';
         
            ?>
            <span class="mandatory">* Son campos obligatorios</span>
            <fieldset>   
                <label for="firma" style="margin-left:10px;margin-top:5px">Encabezado: <span class="mandatory">(*)</span></label>
                <input class="required" type="file" name="file" id="file" style="margin-bottom:3px;">
				<input type="button" value="Ver encabezado actual" id="verEncabezado" class="first small"/>	
                
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
	
	$('#verEncabezado').click( function () {
			popup_carga("<?php echo str_replace("../parametrizacion/", "", $valores[0]["valor"]); ?>");
       } );
    
</script>
<?php  writeFooter(); ?>