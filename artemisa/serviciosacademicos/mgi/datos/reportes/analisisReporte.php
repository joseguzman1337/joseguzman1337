<?php
    include("../templates/template.php");
    $edit = false;
    $db = writeHeader($text."Realizar Análisis al Reporte",TRUE);
    
                $data = array();
                $indicador = array();
                $action = "";
                $id = $_REQUEST["id"];
                $utils = new Utils_datos();
                if($id!="" && $id!=null){
                    $data = $utils->getDataEntity("reporte",$id);  
                    $indicador = $utils->getDataEntity("indicador",$_REQUEST["idI"]);
                    $indicadorGeneral = $utils->getDataEntity("indicadorGenerico",$indicador["idIndicadorGenerico"]);
                    $action = "update";                    
                    $edit = true;
                }
    
?>
   
        <div id="contenido">
            <h4 style="margin-bottom:10px;"><?php echo $indicadorGeneral["codigo"]." ".$indicadorGeneral["nombre"]; ?></h4>
            <div id="form"> 
                <form action="actualizarIndicadorNumerico.php" method="post" name="analisisForm" id="form_test" enctype="multipart/form-data" >
                        <input type="hidden" name="entity" value="reporte" />
                        <input type="hidden" name="action" value="<?php echo $action; ?>" />
                        <input type="hidden" name="estado_definicion_reporte" value="5" />
                        <?php
                        if($id!="" && $id!=null ){
                            echo '<input type="hidden" name="idsiq_reporte" value="'.$id.'">';
                        }
                        ?>
                        <span class="mandatory">* Son campos obligatorios</span>
                        <fieldset>   
                            <legend>Análisis del Indicador</legend>
                            
                            <label for="analisis" style="margin-bottom:10px;margin-right:10px;width:90px;">Resumen <span class="mandatory">(*)</span></label>
                            <textarea class="grid-9-12 required" name="analisis" id="analisis" maxlength="700" autocomplete="off"><?php if($edit){ echo $data['analisis']; } ?></textarea>
                            
                            <label for="analisis" style="margin-bottom:0px;margin-right:10px;width:90px;">Análisis Completo <span class="mandatory">(*)</span></label>
                            <input type="file" name="analisis" id="documentoAnalisis" style="margin-bottom:5px;" />
                            <span style="clear:both;display:block;font-size:0.8em;margin-left:120px;">* Solo se permiten archivos Word.</span>
                        </fieldset>        
                        <fieldset>   
                            <legend>Anexos de Soporte al Análisis</legend>
                            <input type="hidden" name="numDocumentos" id="numDocumentos" value="1" />
                            <label for="analisis" style="margin-bottom:10px;margin-right:10px;width:90px;">Documento de Soporte </label>
                            <input type="file" name="documentos[]" id="documento_1" style="margin-bottom:5px;" />
                            
                            <input type="button" id="nuevoDocumento" value="Agregar otro documento" class="first small" style="padding:3px 19px 4px;" />	
                            <span style="clear:both;display:block;font-size:0.8em;margin-left:120px;" id="textodocumento_1">* Solo se permiten archivos PDF.</span>
                            
                        
                        </fieldset>       
                        
                        <?php if($edit){ ?><input type="submit" value="Registrar análisis" class="first" />
                        <?php } else { ?><input type="submit" value="Registrar análisis" class="first" /> <?php } ?>
                    </form>
            </div>
           
        </div>

            <script type="text/javascript">
                
                            $(':submit').click(function(event) {
                                event.preventDefault();
                                var valido= validateForm("#form_test");                                
                                if(valido){
                                    if($('#documentoAnalisis').val()!=""){
                                        var ext = $('#documentoAnalisis').val().split('.').pop().toLowerCase();
                                        if($.inArray(ext, ['doc','docx']) == -1) {
                                            alert('Extensión no válida. Solo puede subir archivos de tipo Word.');
                                        } else { 
                                            document.analisisForm.submit();
                                        }
                                    }
                                }
                            });
                            
                            
                            $('#nuevoDocumento').click(function() {
                                var numDoc = $("#numDocumentos").val();
                                //chequear si el documento anterior ya fue elegido
                                if($("#documento_"+numDoc).val()===""){
                                    alert("Debe elegir el documento anterior antes de agregar otro adicional.");
                                } else {
                                    var numDoc2 = parseInt(numDoc) + 1;
                                    var html = '<label for="analisis" style="margin-bottom:10px;margin-right:10px;width:90px;">Documento de Soporte</label>';
                                    html = html + '<input type="file" name="documentos[]" id="documento_'+numDoc2+'" style="margin-bottom:5px;"/>';
                                    
                                    $("#documento_"+numDoc).after(html);
                                    $("#numDocumentos").val(numDoc2);
                                }
                            });
                
            </script>

<?php writeFooter(); ?>
