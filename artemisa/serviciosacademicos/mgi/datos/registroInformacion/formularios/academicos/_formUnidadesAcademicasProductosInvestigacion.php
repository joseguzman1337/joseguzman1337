<?php
    require_once("../../../templates/template.php");
    $db = getBD();
    $utils = new Utils_datos();
?>

<div id="tabs-12">
<form action="save.php" method="post" id="form_productosInvestigacion">
            <input type="hidden" name="entity" id="entity" value="formUnidadesAcademicasProductosInvestigacion" />
            <input type="hidden" name="action" value="saveDynamic2" id="action" />
            <input type="hidden" name="idsiq_formUnidadesAcademicasProductosInvestigacion" value="" id="idsiq_formUnidadesAcademicasProductosInvestigacion" />
            
            <span class="mandatory">* Son campos obligatorios</span>
            <fieldset id="numPersonas">   
                <legend>Productos resultado de actividades de investigación formativa</legend>
                
                <div class="formModalidad">
                     <?php include("./_elegirProgramaAcademico.php"); ?>
                </div>
                
                <div class="vacio"></div>
                
                <label for="nombre" class="fixedLabel">Semestre: <span class="mandatory">(*)</span></label>
                <?php $utils->getSemestresSelect($db,"codigoperiodo");  
                      //$sectores = $utils->getActives($db,"siq_tipoActividadAcademicos","nombre");
                    $categoriasPadres = $utils->getAll($db,"siq_tipoProductoInvestigacion","productoPadre=0 AND codigoestado=100","nombre"); 
                ?>
                
                <?php $utils->pintarBotonCargar("popup_cargarDocumento(9,12,$('#form_productosInvestigacion #codigoperiodo').val(),$('#form_productosInvestigacion #unidadAcademica').val())","popup_verDocumentos(9,12,$('#form_productosInvestigacion #codigoperiodo').val(),$('#form_productosInvestigacion #unidadAcademica').val())"); ?>
                                
                <table align="center" class="formData last" width="92%" >
                    <thead>            
                        <tr class="dataColumns">
                            <th class="column" colspan="4"><span>Número productos resultado de actividades de investigación formativa</span></th>                                    
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column borderR" colspan="2"><span>Tipo de Producto</span></th> 
                            <th class="column "><span>Cantidad</span></th> 
                        </tr>
                     </thead>
                     <tbody>
                         <?php while ($rowC = $categoriasPadres->FetchRow()) { 
                                $first = true;
                                $categorias = $utils->getAll($db,"siq_tipoProductoInvestigacion","productoPadre=".$rowC["idsiq_tipoProductoInvestigacion"]." AND codigoestado=100","nombre"); 
                                while ($row = $categorias->FetchRow()) { 
                             ?>
                                <tr class="dataColumns">
                                    <?php if($first){ $first = false; ?>
                                        <td class="column borderR" rowspan="<?php echo $categorias->RecordCount(); ?>" > 
                                            <?php echo $rowC["nombre"]; ?> <span class="mandatory">(*)</span>
                                        </td>
                                    <?php } ?>
                                    <td class="column borderR"><?php echo $row["nombre"]; ?> <span class="mandatory">(*)</span>
                                            <input type="hidden"  class="grid-3-12 required number" minlength="1" name="idCategory[]" id="idCategory_<?php echo $row["idsiq_tipoProductoInvestigacion"]; ?>" value="<?php echo $row["idsiq_tipoProductoInvestigacion"]; ?>" />
                                        <input type="hidden" name="idsiq_detalleformUnidadesAcademicasProductosInvestigacion[]" value="" id="idsiq_detalleformUnidadesAcademicasProductosInvestigacion_<?php echo $row["idsiq_tipoProductoInvestigacion"]; ?>" />

                                    </td>
                                    <td class="column"> 
                                        <input type="text"  class="grid-5-12 required number" minlength="1" name="cantidad[]" id="cantidad_<?php echo $row["idsiq_tipoProductoInvestigacion"]; ?>" title="Horas Semanales" maxlength="10" tabindex="1" autocomplete="off" value="0" />
                                    </td>
                                </tr>
                        <?php } } ?>        
                    </tbody>
                </table>                   
                
                <div class="vacio"></div>
                <div id="msg-success" class="msg-success" style="display:none"><p>Los datos han sido guardados de forma correcta.</p></div>
            </fieldset>
            <div class="guardar" onmouseover="guardar(this)" title="">
            <div class="vacio"></div>
            <input type="submit" id="submitProductosInvestigacion" value="Guardar datos" class="first" /> 
            </div>
        </form>
</div>

<script type="text/javascript">
    getDataProductosInvestigacion("#form_productosInvestigacion");
    
                $('#submitProductosInvestigacion').click(function(event) {
                    event.preventDefault();
                    var valido= validateForm("#form_productosInvestigacion");
                    if(valido){
                        sendFormProductosInvestigacion("#form_productosInvestigacion");
                    }
                });
                
                $('#form_productosInvestigacion #codigoperiodo').bind('change', function(event) {
                    getDataProductosInvestigacion("#form_productosInvestigacion");
                });
                
                $(document).on('change', "#form_productosInvestigacion #modalidad", function(){
                    getCarreras("#form_productosInvestigacion");
                    changeFormModalidad("#form_productosInvestigacion");
                });
                
                $(document).on('change', "#form_productosInvestigacion #unidadAcademica", function(){
                    getDataProductosInvestigacion("#form_productosInvestigacion");
                    changeFormModalidad("#form_productosInvestigacion");
                });
                
                function getDataProductosInvestigacion(formName){
                    var periodo = $(formName + ' #codigoperiodo').val();
                    var entity = $(formName + " #entity").val();
                    var codigocarrera = $(formName + " #unidadAcademica").val();
                    if(codigocarrera==""){
                        //no hay datos xq no hay carrera
                        if($("#idsiq_formUnidadesAcademicasProductosInvestigacion").val()!=""){
                             var modalidad = $(formName + ' #modalidad').val();
                             var unidadAcademica = $(formName + ' #unidadAcademica').val();
                             var mes = $(formName + ' #codigoperiodo').val();
                             document.forms[formName.replace("#","")].reset();
                             $(formName + ' #modalidad').val(modalidad);
                             $(formName + ' #unidadAcademica').val(unidadAcademica);
                             $(formName + ' #codigoperiodo').val(mes);
                             $(formName + " #action").val("saveDynamic2");
                             $("#idsiq_formUnidadesAcademicasProductosInvestigacion").val("");
                        }
                    } else {
                        $.ajax({
                            dataType: 'json',
                            type: 'POST',
                            url: './formularios/academicos/saveUnidadesAcademicas.php',
                            data: { periodo: periodo, action: "getDataDynamic2", entity: entity, campoPeriodo: "codigoperiodo",entityJoin: "siq_tipoProductoInvestigacion",codigocarrera:codigocarrera },     
                            success:function(data){
                                if (data.success == true){
                                    $("#idsiq_formUnidadesAcademicasProductosInvestigacion").val(data.message);
                                    for (var i=0;i<data.total;i++)
                                    {                                  
                                        $(formName + " #idCategory_"+data.data[i].idCategory).val(data.data[i].idCategory);
                                        $("#idsiq_detalleformUnidadesAcademicasProductosInvestigacion_"+data.data[i].idCategory).val(data.data[i].idsiq_detalleformUnidadesAcademicasProductosInvestigacion);
                                        $(formName + " #cantidad_"+data.data[i].idCategory).val(data.data[i].cantidad);
                                    }
                                    $(formName + " #action").val("updateDynamic2");
                                }
                                else{                        
                                    //no se encontraron datos
                                    if($("#idsiq_formUnidadesAcademicasProductosInvestigacion").val()!=""){
                            $(formName + ' input[name="idsiq_detalleformUnidadesAcademicasProductosInvestigacion[]"]').each(function() {                                     
                                  $(this).val("");                                       
                             });
                                                var modalidad = $(formName + ' #modalidad').val();
                                                var unidadAcademica = $(formName + ' #unidadAcademica').val();
                                                var mes = $(formName + ' #codigoperiodo').val();
                                                document.forms[formName.replace("#","")].reset();
                                                $(formName + ' #modalidad').val(modalidad);
                                                $(formName + ' #unidadAcademica').val(unidadAcademica);
                                                $(formName + ' #codigoperiodo').val(mes);
                                                $(formName + " #action").val("saveDynamic2");
                                                $("#idsiq_formUnidadesAcademicasProductosInvestigacion").val("");
                                            }
                                }
                            },
                            error: function(data,error,errorThrown){alert(error + errorThrown);}
                        }); 
                    }
                }

                function sendFormProductosInvestigacion(formName){
                activarModalidades(formName);
                    $.ajax({
                        dataType: 'json',
                        type: 'POST',
                        url: './formularios/academicos/saveUnidadesAcademicas.php',
                        data: $(formName).serialize(),                
                        success:function(data){
							<?php if($permisos["rol"][0]!=1) { ?>
                            desactivarModalidades(formName);
							<?php } ?>
                            if (data.success == true){
                                 //window.location.href="./viewData.php?id=row_<?php //echo $formulario["idsiq_formulario"]; ?>";  
                                 $("#idsiq_formUnidadesAcademicasProductosInvestigacion").val(data.message);
                                 for (var i=0;i<data.total;i++)
                                 {                                  
                                    $("#idsiq_detalleformUnidadesAcademicasProductosInvestigacion_"+data.dataCat[i]).val(data.data[i]);
                                 }
                                 $(formName + " #action").val("updateDynamic2");
                                 $(formName + ' #msg-success').css('display','block');
                                 $(formName + " #msg-success").delay(5500).fadeOut(800);
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
