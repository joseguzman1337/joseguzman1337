<?php
function writeForm($edit, $id="", $db) {
    $data = array();
    $action = "save";
    $utils = new Utils_monitoreo();
    $caract = array();
    if(!$edit){
        $factores = $utils->getActives($db,"nombre,idsiq_factor", "factor");
    } else {
        //$factores = $utils->getAll($db,"nombre,idsiq_factor", "factor");
        $factores = $utils->getActives($db,"nombre,idsiq_factor", "factor");
        $action = "update";
        if($id!=""){    
            $data = $utils->getDataEntity("aspecto", $id);  
            $caract = $utils->getDataEntity("caracteristica", $data["idCaracteristica"]); 
        }
    }

?>
<div id="form"> 
    <form action="save.php" method="post" id="form_test">
            <input type="hidden" name="entity" value="aspecto" />
            <input type="hidden" name="action" value="<?php echo $action; ?>" />
            <?php
            if($edit&&$id!=""){
                echo '<input type="hidden" name="idsiq_aspecto" value="'.$id.'">';
            }
            ?>
            <span class="mandatory">* Son campos obligatorios</span>
            <fieldset>   
                <legend>Información del Aspecto</legend>
                <label for="nombre" class="grid-2-12">Nombre del Aspecto: <span class="mandatory">(*)</span></label>
                <textarea title="Nombre del Aspecto" id="nombre" name="nombre" class="grid-10-12 required"><?php if($edit){ echo $data['nombre']; } ?></textarea>
                <!---<input type="text"  class="grid-5-12 required" name="nombre" id="nombre" title="Nombre del Aspecto" maxlength="250" tabindex="1" autocomplete="off" value="<?php //if($edit){ echo $data['nombre']; } ?>" />-->
            
                <label for="codigo" class="grid-2-12">Código:</label>
                <input type="text"  class="grid-5-12" minlength="2" name="codigo" id="codigo" title="codigo" maxlength="120" tabindex="1" autocomplete="off" value="<?php if($edit){ echo $data['codigo']; } ?>" />
            
                <label for="descripcion" class="grid-2-12">Descripción: </label>
                <textarea class="grid-10-12" name="descripcion" id="descripcion" maxlength="700" autocomplete="off"><?php if($edit){ echo $data['descripcion']; } ?></textarea>
                
            </fieldset>
            <fieldset id="containerAutoComplete">   
                <legend>Información de la Característica</legend>
                <label for="nombre" class="grid-2-12">Factor:</label>
                <?php
                // idFactor es el nombre del select, el data es el que esta elegido de la lista, 
                //primer true que se deje una opción en blanco, segundo false que no deje elegir múltiples opciones
                //el 1 es si es un listbox o un select, 
                echo $factores->GetMenu2('factor',$caract['idFactor'],true,false,1,'id="factor" class="grid-5-12 required" disabled="true"'); ?>
                
                
                <label for="nombre" class="grid-2-12">Característica: <span class="mandatory">(*)</span></label>
                <input type="text"  class="grid-5-12 required" minlength="2" name="caracteristica" id="caracteristica" title="Nombre de la Caracteristica" maxlength="120" tabindex="1" autocomplete="off" value="<?php echo $caract["nombre"]; ?>"  />
                <input type="hidden" name="idCaracteristica" id="idCaracteristica" value="<?php echo $data["idCaracteristica"]; ?>" />
            </fieldset>
            
            <?php if($edit){ ?><input type="submit" value="Guardar cambios" class="first" />
            <?php } else { ?><input type="submit" value="Registrar aspecto" class="first" /> <?php } ?>
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
                
                $(document).ready(function() {
                    $('#caracteristica').autocomplete({
                        source: function( request, response ) {
                            $.ajax({
                                url: "../searchs/lookForCaracteristicas.php",
                                dataType: "json",
                                data: {
                                    term: request.term,
                                    factor: ""
                                },
                                success: function( data ) {
                                    response( $.map( data, function( item ) {
                                        return {
                                            label: item.label,
                                            value: item.value,
                                            id: item.id,
                                            idFactor: item.idFactor
                                        }
                                    }));
                                }
                            });
                        },
                        minLength: 2,
                        selectFirst: false,
                        open: function(event, ui) {
                            var maxWidth = $('#containerAutoComplete').width()-400;  
                            var width = $(this).autocomplete("widget").width();
                            if(width>maxWidth){
                                $(".ui-autocomplete.ui-menu").width(maxWidth);                                 
                            }
                        },
                        select: function( event, ui ) {
                            //alert(ui.item.id);
                            $('#idCaracteristica').val(ui.item.id);
                            $('#factor').val(ui.item.idFactor);
                        }                
                    });
                });
  </script>
<?php } ?>
