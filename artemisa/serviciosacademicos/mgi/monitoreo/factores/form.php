<?php
function writeForm($edit, $id="") {
    $data = array();
    $action = "save";
    if($edit){
        $action = "update";
        if($id!=""){    
            $utils = new Utils_monitoreo();
            $data = $utils->getDataEntity("factor", $id);            
            //var_dump($data);
            //die();
        }
    }
?>
<div id="form"> 
    <div id="msg-error"></div>
    
    <form action="save.php" method="post" id="form_test" >
            <input type="hidden" name="entity" value="factor" />
            <input type="hidden" name="action" value="<?php echo $action; ?>" />
            <?php
            if($edit&&$id!=""){
                echo '<input type="hidden" name="idsiq_factor" value="'.$id.'">';
            }
            ?>
            <span class="mandatory">* Son campos obligatorios</span>
            <fieldset>   
                <legend>Información del Factor</legend>
                <label for="nombre" class="grid-2-12">Nombre del Factor: <span class="mandatory">(*)</span></label>
                <input type="text"  class="grid-5-12 required" minlength="2" name="nombre" id="nombre" title="Nombre del Factor" maxlength="120" tabindex="1" autocomplete="off" value="<?php if($edit){ echo $data['nombre']; } ?>" />
            
                <label for="codigo" class="grid-2-12">Código:</label>
                <input type="text"  class="grid-5-12" minlength="2" name="codigo" id="codigo" title="codigo" maxlength="120" tabindex="1" autocomplete="off" value="<?php if($edit){ echo $data['codigo']; } ?>" />
            
                <label for="descripcion" class="grid-2-12">Descripción: </label>
                <textarea class="grid-5-12" name="descripcion" id="descripcion" maxlength="700" autocomplete="off"><?php if($edit){ echo $data['descripcion']; } ?></textarea>
                
            </fieldset>
            
            <?php if($edit){ ?><input type="submit" value="Guardar cambios" class="first" />
            <?php } else { ?><input type="submit" value="Registrar factor" class="first" /> <?php } ?>
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
                    window.location.href="index.php";
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
