<?php
function writeForm($edit, $db, $id="") {
    $data = array();
    $action = "save";
    $utils = Utils::getInstance();
    if($edit){
        $action = "update";
        if($id!=""){    
            $data = $utils->getDataEntity("firmaEscaneadaEducacionContinuada", $id,"idfirmaEscaneadaEducacionContinuada");   
        }
    }

?>
<div id="form"> 
    <div id="msg-error"><?php echo $_REQUEST["mensaje"]; ?></div>
    
    <form action="processFirma.php" method="post" id="form_test" enctype="multipart/form-data"  name="signForm" >
            <input type="hidden" name="entity" value="firmaEscaneadaEducacionContinuada" />
            <input type="hidden" name="action" value="<?php echo $action; ?>" />
            <?php
            if($edit&&$id!=""){
                echo '<input type="hidden" name="idfirmaEscaneadaEducacionContinuada" value="'.$id.'">';
            }
            ?>
            <span class="mandatory">* Son campos obligatorios</span>
            <fieldset>   
                <legend>Información de la firma</legend>
                <label for="apellidodocente" class="grid-2-12">Nombre: <span class="mandatory">(*)</span></label>
                <input type="text"  class="grid-5-12 required" name="nombre" id="nombre" title="Nombre del dueño(a) de la firma" maxlength="200" tabindex="1" autocomplete="off" value="<?php if($edit){ echo $data['nombre']; } ?>" />
            
                <label for="nombredocente" class="grid-2-12">Cargo: <span class="mandatory">(*)</span></label>
                <input type="text"  class="grid-5-12 required" minlength="2" name="cargo" id="cargo" title="Cargo del dueño(a) de la firma" maxlength="120" tabindex="1" autocomplete="off" value="<?php if($edit){ echo $data['cargo']; } ?>" />
            
                <label for="codigogenero" class="grid-2-12">Organización/Unidad:</label>
                <input type="text"  class="grid-5-12" minlength="2" name="unidad" id="unidad" title="Organización o unidad a la que pertenece" maxlength="120" tabindex="1" autocomplete="off" value="<?php if($edit){ echo $data['unidad']; } else { echo "Universidad El Bosque"; } ?>" />
                
                <label for="firma" class="grid-2-12">Firma: <?php if(!$edit){ ?><span class="mandatory">(*)</span><?php } ?></label>
                <input class="required" type="file" name="file" id="file" style="margin-bottom:3px;">
				<?php if($edit&&$id!=""){ echo "<span style='float:left;margin-left:10px;margin-top:-4px;font-size:0.8em'>Puede dejar este campo en blanco si<br/>no desea cambiar la imagen de la firma</span>"; } ?>
                
				<div class="vacio"></div>
				<span style="margin-left:15%;"></span><span style="margin-left:17px;font-size:0.8em;">Imagenes de tipo gif, png y jpg.</span>
                
            </fieldset>
            
            <?php if($edit){ ?><input type="submit" value="Guardar cambios" class="first" />
            <?php } else { ?><input type="submit" value="Registrar firma" class="first" /> <?php } ?>
        </form>
</div>

<script type="text/javascript">
    $(':submit').click(function(event) {
        event.preventDefault();
        var valido= validateForm("#form_test");
        
        if(valido){ 
            if($('#file').val()!=""){
                var ext = $('#file').val().split('.').pop().toLowerCase();
                if($.inArray(ext, ['gif','png','jpg','jpeg','PNG','JPG']) == -1) {
                    alert('Extensión no válida. Solo puede subir imagenes de tipo: gif, png, jpg o jpeg.');
                } else { 
                    document.signForm.submit();
                } 
            } else {                
                <?php if($edit&&$id!=""){ ?>
                 //si solo esta editando no importa que este vacia la imagen
                 document.signForm.submit();        
                <?php } else { ?>
                   alert("Debe elegir la firma escaneada para registrarla en el sistema."); 
                <?php } ?>
            }
        }
    });
    
</script>
<?php } ?>
