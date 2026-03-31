<?php
function writeForm($edit, $id="", $db) {
    $data = array();
    $action = "save";
    $utils = new Utils_monitoreo();
    $campos = $utils->getAll($db,"categoria", "campoPlantillaAlerta","categoria","ASC","categoria","siq_","codigoestado='100' AND aplica_periodicas='1'");
    $campos = $campos->GetArray();
    
    if(!$edit){
        $tipos = $utils->getActives($db,"nombre,idsiq_tipoResponsabilidad", "tipoResponsabilidad");
    } else {
        $tipos = $utils->getAll($db,"nombre,idsiq_tipoResponsabilidad", "tipoResponsabilidad");
        $action = "update";
        if($id!=""){    
            $data = $utils->getDataEntity("tipoAlerta", $id);  
        }
    }

?>
<div id="form"> 
    <form action="save.php" method="post" id="form_test">
            <input type="hidden" name="entity" value="tipoAlerta" />
            <input type="hidden" name="action" value="<?php echo $action; ?>" />
            <?php
            if($edit&&$id!=""){
                echo '<input type="hidden" name="idsiq_tipoAlerta" value="'.$id.'">';
            }
            ?>
            <span class="mandatory">* Son campos obligatorios</span>
            <fieldset style="padding: 1.2em 5px;">   
                <legend>Información de la Alerta</legend>
                <label for="nombre" class="grid-2-12">Nombre: <span class="mandatory">(*)</span></label>
                <input type="text"  class="grid-5-12 required" name="nombre" id="nombre" title="Nombre" maxlength="250" tabindex="1" autocomplete="off" value="<?php if($edit){ echo $data['nombre']; } ?>" />
                
                <label for="nombre" class="grid-2-12">Asunto del Correo: <span class="mandatory">(*)</span></label>
                <input type="text"  class="grid-5-12 required" name="asunto_correo" id="asunto_correo" title="Nombre" maxlength="250" tabindex="1" autocomplete="off" value="<?php echo $data['asunto_correo']; ?>" />
                
                <label for="nombre" class="grid-2-12">Insertar Campos: </label>
                <select class="grid-2-12" id="categoriaPlantillaAlerta" size="1" name="categoriaPlantillaAlerta">
                    <option></option>
                    <?php 
                    for ($i = 0; $i < count($campos); $i++) {
                        echo "<option value='".$campos[$i]["categoria"]. "'>".$campos[$i]["categoria"]."</option>";
                    } ?>
                </select>
                
                <select class="grid-3-12" id="campoPlantillaAlerta" size="1" name="campoPlantillaAlerta">
                    <option></option>
                </select>
                
                <input type="button" value="Insertar campo" style="float:left;margin-left:15px;padding: 3px 19px 5px;" id="buttonInsert"/>
                
                <label for="nombre" class="grid-2-12" style="height: 40px;margin-right:15px;">Plantilla del Mensaje: <span class="mandatory">(*)</span></label>
                <div id="menuEditor" style="width: 792px;"></div>
                
                <textarea class="grid-8-12" name="plantilla_correo" id="plantilla_correo" maxlength="700" autocomplete="off" style="width: 800px; height: 360px;"><?php if($edit){ echo $data['plantilla_correo']; } ?></textarea>
                <div class="vacio" style="margin-bottom:20px;"></div>
                
                <label for="nombre" class="grid-2-12">Tipo de Responsable (Destinatario):</label>
                <?php  echo $tipos->GetMenu2('idTipoResponsable',$data['idTipoResponsable'],true,false,1,'id="idTipoResponsable" class="grid-3-12"'); ?>
            </fieldset>
            
            <?php include("./dialogFor.php"); ?>
                        
            <?php if($edit){ ?><input type="submit" value="Guardar cambios" class="first" />
            <?php } else { ?><input type="submit" value="Crear tipo de alerta" class="first" /> <?php } ?>
        </form>
</div>

<script type="text/javascript">
    
             //<![CDATA[
            bkLib.onDomLoaded(function() {
                     var myNicEditor = new nicEditor({fullPanel : true,iconsPath : '../../images/nicEditorIcons.gif'});
                    myNicEditor.setPanel('menuEditor');
                    myNicEditor.addInstance('plantilla_correo');    
            });
            //]]>
    
                $(':submit').click(function(event) {
                    event.preventDefault();
                    var valido= validateForm("#form_test");
                    document.getElementById("plantilla_correo").innerHTML = nicEditors.findEditor('plantilla_correo').getContent();
                    //verifico que el mensaje no sea puro espacio en blanco y saltos de linea
                    var content = $.trim(document.getElementById("plantilla_correo").innerHTML); 
                    content = $("<div/>").html(content).text();
                    var find = '<br>';
                    var re = new RegExp(find, 'g');
                    content = content.replace(re,"");
                    find = '<br/>';
                    re = new RegExp(find, 'g');
                    content = content.replace(re,"");
                    find = '<br />';
                    re = new RegExp(find, 'g');
                    content = content.replace(re,"");
                    content = $.trim(content);
                    if(content==""){                        
                            //$('.nicEdit-main').parent().addClass('error');
                            $('.nicEdit-main').parent().css('border-color', 'red');
                            $('.nicEdit-main').parent().css('border-width', '1px');
                            //$(".nicEdit-main").addClass('error');
                            $('.nicEdit-main').parent().effect("pulsate", { times:3 }, 500);
                            valido = false;
                    } else {       
                          $('.nicEdit-main').parent().css('border-color', '#CCCCCC');
                          $('.nicEdit-main').parent().css('border-width', '0px 1px 1px');
                    }
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
                
                $('#categoriaPlantillaAlerta').bind("change", function(){
                    //cargo los datos del segundo select por ajax
                    if($('#categoriaPlantillaAlerta').val()==""){
                        document.getElementById("campoPlantillaAlerta").innerHTML = "<option></option>";
                    } else{             
                            $.ajax({
                                dataType: 'json',
                                type: 'POST',
                                url: "../searchs/lookForFields.php",
                                data: {
                                    categoria: $("#categoriaPlantillaAlerta").val(),
                                    periodicas: true
                                },
                                success:function(data){ 
                                    var select = "";
                                    for (var i=0;i<data.length;i++)
                                    {
                                        select = select+"<option value='"+data[i]["value"]+"'>"+data[i]["label"]+"</option>";
                                    }
                                    
                                    document.getElementById("campoPlantillaAlerta").innerHTML = select;
                                },
                                error: function(data,error){}
                            }); 
                    }
                });
                
                $('#buttonInsert').click( function () {  
                        if($("#campoPlantillaAlerta").val()!=""){
                            if($("#campoPlantillaAlerta").val()!="{{ for }}"){
                                var myNicEditor = nicEditors.findEditor('plantilla_correo');
                                myNicEditor.setContent(myNicEditor.getContent() + $("#campoPlantillaAlerta").val());   
                            } else {
                                $( "#dialog-for" ).dialog( "open" );    
                            }
                        }
                } );
                
            //dialogos para ciclos for
            $(function() {
                $( "#dialog-for" ).dialog({
                    autoOpen: false,
                    height: 270,
                    width: 500,
                    modal: true,
                    position: 'center',
                    buttons: {
                        "Insertar ciclo": function() {    
                                var myNicEditor = nicEditors.findEditor('plantilla_correo');
                                myNicEditor.setContent(myNicEditor.getContent() + "<br/> {{ for " + $("#ciclo").val() + " }} {{ endfor }} <br/>" );   
                                $( this ).dialog( "close" );
                        },
                        "Cancelar": function() {
                            $( this ).dialog( "close" );
                        }
                    },
                    close: function(event) {                        
                        //Para que no le haga submit automaticamente al form al cerrar el dialog
                        event.preventDefault();
                    }
                });
              });   
  </script>
<?php } ?>
