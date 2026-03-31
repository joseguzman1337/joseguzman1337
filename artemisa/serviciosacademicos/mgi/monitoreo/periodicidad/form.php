<?php
function writeForm($edit, $id="", $db) {
    $data = array();
    $action = "save";
    $utils = new Utils_monitoreo();
    
    if(!$edit){
        $tipos = $utils->getActives($db,"nombre,idsiq_tipoValorPeriodicidad", "tipoValorPeriodicidad");
    } else {
        $tipos = $utils->getAll($db,"nombre,idsiq_tipoValorPeriodicidad", "tipoValorPeriodicidad");
        $action = "update";
        if($id!=""){    
            $data = $utils->getDataEntity("periodicidad", $id);  
        }
    }

?>
<div id="form"> 
    <form action="save.php" method="post" id="form_test">
            <input type="hidden" name="entity" value="periodicidad" />
            <input type="hidden" name="action" value="<?php echo $action; ?>" />
            <?php
            if($edit&&$id!=""){
                echo '<input type="hidden" name="idsiq_periodicidad" value="'.$id.'">';
            }
            ?>
            <span class="mandatory">* Son campos obligatorios</span>
            <fieldset>   
                <legend>Información de la Periodicidad</legend>
                <label for="nombre" class="grid-2-12">Nombre: <span class="mandatory">(*)</span></label>
                <input type="text"  class="grid-5-12 required" name="periodicidad" id="periodicidad" title="Nombre de la Periodicidad" maxlength="250" tabindex="1" autocomplete="off" value="<?php if($edit){ echo $data['periodicidad']; } ?>" />
                
                <label for="nombre" class="grid-2-12">Valor: <span class="mandatory">(*)</span></label>
                <input type="text"  class="grid-1-12 required number" name="valor" id="valor" onkeypress="return isNumberKey(event)" title="Valor en números" maxlength="8" tabindex="1" autocomplete="off" value="<?php if($edit){ echo $data['valor']; } ?>" />
                
                <label for="nombre" class="grid-2-12">Tipo del Valor: <span class="mandatory">(*)</span></label>
                <?php  echo $tipos->GetMenu2('tipo_valor',$data['tipo_valor'],false,false,1,'id="tipo_valor" class="grid-2-12 required"'); ?>
            
                <div class="vacio"></div>
                <label class="grid-2-12"></label>
                <input type="checkbox" name="aplica_monitoreo" value="1" style="margin-left:15px;" <?php if($edit && $data['aplica_monitoreo']==1){ ?> checked="checked" <?php } ?> /> Periodicidad para monitoreos<br/><br/>
                <label class="grid-2-12"></label>
                <input type="checkbox" name="aplica_alerta" value="1" style="margin-left:15px;" <?php if($edit && $data['aplica_alerta']==1){ ?> checked="checked" <?php } ?> /> Periodicidad para alertas<br/><br/>
                <label class="grid-2-12"></label>
                <input type="checkbox" name="aplica_autoevaluacion" value="1" style="margin-left:15px;" <?php if($edit && $data['aplica_autoevaluacion']==1){ ?> checked="checked" <?php } ?> /> Periodicidad para instrumentos de percepción
            </fieldset>
            
            <?php if($edit){ ?><input type="submit" value="Guardar cambios" class="first" />
            <?php } else { ?><input type="submit" value="Registrar periodicidad" class="first" /> <?php } ?>
        </form>
</div>

<script type="text/javascript">
                $(':submit').click(function(event) {
                    event.preventDefault();
                    var valido= validateForm("#form_test");
                    var checked = $("#form_test input:checked").length > 0;
                    if(valido && checked){
                        sendForm();
                    } else if(!checked){
                        $("#form_test input[type='checkbox']").each(function() {
                            if(!$(this).attr('disabled')){
                                $(this).addClass('error');
                                $(this).effect("pulsate", { times:3 }, 500);
                            }
                        });
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
