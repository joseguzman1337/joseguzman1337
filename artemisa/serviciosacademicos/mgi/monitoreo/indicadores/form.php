<?php
function writeForm($edit, $db, $id = "") {
    $data = array();
    $action = "save";
    $utils = new Utils_monitoreo();
    if($edit&&$id!=""){
        $data = $utils->getDataEntity("indicador", $id);      
        $indicadorGenerico = $utils->getDataEntity("indicadorGenerico", $data["idIndicadorGenerico"]); 
        $tipo = $utils->getDataEntity("tipoIndicador", $indicadorGenerico["idTipo"]); 
        $action = "update";
        $discriminacion = $utils->getDataEntity("discriminacionIndicador", $data["discriminacion"]);       
        if($discriminacion["idsiq_discriminacionIndicador"]==1){
            $entity["label"] = "Tipo";
            $entity["nombre"] = $discriminacion["nombre"];
        } else if($discriminacion["idsiq_discriminacionIndicador"]==2){
            $entity["label"] = $discriminacion["nombre"];
            $facultad = $utils->getDataNonEntity($db,"nombrefacultad","facultad","codigofacultad='".$data["idFacultad"]."'");
            $entity["nombre"] = $facultad["nombrefacultad"];           
        } else if($discriminacion["idsiq_discriminacionIndicador"]==3){
            $entity["label"] = $discriminacion["nombre"];
            $carrera = $utils->getDataNonEntity($db,"nombrecarrera","carrera","codigocarrera='".$data["idCarrera"]."'");
            $entity["nombre"] = $carrera["nombrecarrera"];  
        } 
    }

?>
<div id="form"> 
    <form action="save.php" method="post" id="form_test">
            <input type="hidden" name="entity" value="indicador" />
            <input type="hidden" name="action" value="<?php echo $action; ?>" />
            <input type="hidden" name="idEstado" value="<?php if($edit&&$id!=""){ echo $data["idEstado"]; } else { echo "1"; } ?>" />
            <?php
            if($edit&&$id!=""){
                echo '<input type="hidden" name="idsiq_indicador" value="'.$id.'">';
            }
            ?>
            <span class="mandatory">* Son campos obligatorios</span>
            <fieldset>   
                <legend>Información del Indicador</legend>
                <label for="nombre" class="grid-2-12">Nombre del Indicador:</label>
                <span class="inputText grid-10-12" style="text-align:left;"><?php echo $indicadorGenerico['nombre']; ?></span>
                
                <label for="idTipo" class="grid-2-12">Tipo del Indicador:</label>
                <span class="inputText"><?php echo $tipo['nombre']; ?></span>
                
                <label for="idTipo" class="grid-2-12"><?php echo $entity["label"]; ?>:</label>
                <span class="inputText"><?php echo $entity['nombre']; ?></span>
            </fieldset>            
            <fieldset>   
                <legend>Detalle del Indicador</legend>     
                <?php if(intval($tipo["idsiq_tipoIndicador"])==3){ ?>
                    <label for="inexistente" id="labelInexistente" class="grid-2-12">¿Es soportado por un documento?: <span class="mandatory">(*)</span></label>
                    <?php writeYesNoSelect("inexistente",$data['inexistente']); 
                }
                ?>
                
                <label for="nombre" class="grid-2-12">¿Tiene documento de análisis?: <span class="mandatory">(*)</span></label>
                <?php writeYesNoSelect("es_objeto_analisis",$data['es_objeto_analisis']); ?>
                
                <label for="nombre" class="grid-2-12">¿Tiene anexo?: <span class="mandatory">(*)</span></label>
                <?php writeYesNoSelect("tiene_anexo",$data['tiene_anexo']); ?>
            </fieldset>
            
            <?php if($edit){ ?><input type="submit" value="Guardar cambios" class="first" />
            <?php } else { ?><input type="submit" value="Registrar indicador" class="first" /> <?php } ?>
        </form>
</div>

<script type="text/javascript">
                $(':submit').click(function(event) {
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
