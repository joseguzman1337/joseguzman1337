<?php
function writeForm($edit, $id="") {
    $data = array();
    $action = "save";
    if($edit){
        $action = "update";
        if($id!=""){    
            $utils = new Utils_monitoreo();
            $data = $utils->getDataEntity("tipoOrientacion", $id);            
            //var_dump($data);
            //die();
        }
    }
?>
<div id="form"> 
    <div id="msg-error"></div>
    
    <form action="save.php" method="post" id="form_test" >
            <input type="hidden" name="entity" value="tipoOrientacion" />
            <input type="hidden" name="action" value="<?php echo $action; ?>" />
            <?php
            if($edit&&$id!=""){
                echo '<input type="hidden" name="idsiq_tipoOrientacion" value="'.$id.'">';
                echo '<input type="hidden" name="fecha_creacion" value="'.$data['fecha_creacion'].'">';
                echo '<input type="hidden" name="usuario_creacion" value="'.$data['usuario_creacion'].'">';
            }
            ?>
            <span class="mandatory">* Son campos obligatorios</span>
            <fieldset>   
                <legend>Información del Tipo de Orientación para Indicadores</legend>
                <label for="nombre" class="grid-2-12">Tipo de Orientación: <span class="mandatory">(*)</span></label>
                <input type="text"  class="grid-5-12 required" minlength="2" name="nombre" id="nombre" title="Tipo de Orientacion" maxlength="120" tabindex="1" autocomplete="off" value="<?php if($edit){ echo $data['nombre']; } ?>" />
            </fieldset>
            
            <?php if($edit){ ?><input type="submit" value="Guardar cambios" class="first" />
            <?php } else { ?><input type="submit" value="Crear tipo de orientación" class="first" /> <?php } ?>
        </form>
</div>

<script type="text/javascript">
    $(':submit').click(function(event) {
        //var buttonName = $(this).attr('name');

        //if (buttonName.indexOf('edit') >= 0) {
            //confirm("some text") logic...
        //}
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
            url: 'process.php',
            data: $('#form_test').serialize(),                
            success:function(data){
                if (data.success == true){
                    window.location.href="orientacionesIndicador.php";
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
<?php } ?>
