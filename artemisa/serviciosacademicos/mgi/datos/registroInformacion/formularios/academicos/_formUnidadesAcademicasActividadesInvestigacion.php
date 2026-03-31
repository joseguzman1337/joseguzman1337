<?php
    require_once("../../../templates/template.php");
    $db = getBD();
    $utils = new Utils_datos();
    
    $usuario_con=$_SESSION['MM_Username'];
    if($utils->UsuarioAprueba_FormHuerfana($db,$usuario_con)){
      $aprobacion=true;
    }
?>
<div id="tabs-5">
<form action="save.php" method="post" id="form_investigacion">
            <input type="hidden" name="entity" id="entity" value="formUnidadesAcademicasActividadesInvestigacion" />
            <input type="hidden" name="action" value="save" id="action" />
            <input type="hidden" name="idsiq_formUnidadesAcademicasActividadesInvestigacion" value="" id="idsiq_formUnidadesAcademicasActividadesInvestigacion" />
            
            <span class="mandatory">* Son campos obligatorios</span>
            <fieldset id="numPersonas">   
                <legend>Actividades académicas de apoyo a la Investigación Formativa</legend>
                
                <div class="formModalidad">
                     <?php include("./_elegirProgramaAcademico.php"); ?>
                </div>
                
                <div class="vacio"></div>
                
                <label for="nombre" class="fixedLabel">Mes: <span class="mandatory">(*)</span></label>
                <?php $utils->getMonthsSelect();  ?>
                
                <label for="nombre" class="fixedLabel" style="clear:none;width:90px">Año: <span class="mandatory">(*)</span></label>
                <?php $utils->getYearsSelect("anio");  
                ?>
            <input type="hidden" name="codigoperiodo" value="" id="codigoperiodo" />
                
            <?php $utils->pintarBotonCargar("popup_cargarDocumento(9,11,$('#form_investigacion #mes').val()+'-'+$('#form_investigacion #anio').val(),$('#form_investigacion #unidadAcademica').val())","popup_verDocumentos(9,11,$('#form_investigacion #mes').val()+'-'+$('#form_investigacion #anio').val(),$('#form_investigacion #unidadAcademica').val())"); ?>
                        
                <table align="center" class="formData last" width="92%" >
                    <thead>            
                        <tr class="dataColumns">
                            <th class="column" colspan="<?php if($aprobacion) echo "3"; else echo "2";?>"><span>Actividades académicas de apoyo a la Investigación Formativa</span></th>                                    
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column" ><span>Actividades académicas</span></th> 
                            <th class="column borderR" ><span>Número de eventos</span></th> 
                            <?php if($aprobacion) { ?>
                            <th class="column" ><span>Aprobar</span></th> 
                            <?php } ?>
                        </tr>
                     </thead>
                     <tbody>
                        <tr class="dataColumns">
                            <td class="column ">Seminarios <span class="mandatory">(*)</span></td>
                            <td class="column borderR"> 
                                <input type="text" class="grid-4-12 required number" minlength="1" name="numSeminarios" id="numSeminarios" title="Total de Eventos" maxlength="10" tabindex="1" autocomplete="off" value="0" />
                            </td>
                            <?php if($aprobacion){ ?>
                            <td class="column">
				<input type="hidden" value="0" name="Verificado" id="VerEscondido" />
                                <input type="checkbox"  class="grid-4-12 required number" minlength="1" name="Verificado" id="Verificado" title="Verificado" maxlength="10" tabindex="1" autocomplete="off" value="1" />
                            </td>
                            <?php 
                            }
                            ?>   
                        </tr>
                        <tr class="dataColumns">
                            <td class="column">Foros <span class="mandatory">(*)</span></td>
                            <td class="column borderR">
                                <input type="text" class="grid-4-12 required number" minlength="1" name="numForos" id="numForos" title="Total de Eventos" maxlength="10" tabindex="1" autocomplete="off" value="0" />
                            </td>
                             <?php if($aprobacion){ ?>
                            <td class="column">
				<input type="hidden" value="0" name="VerificadoDos" id="VerEscondidoDos" />
                                <input type="checkbox"  class="grid-4-12 required number" minlength="1" name="VerificadoDos" id="VerificadoDos" title="Verificado" maxlength="10" tabindex="1" autocomplete="off" value="1" />
                            </td>
                            <?php 
                            }
                            ?>
                        </tr>
                        <tr class="dataColumns">
                            <td class="column">Estudios de caso <span class="mandatory">(*)</span></td>
                            <td class="column borderR">
                                <input type="text" class="grid-4-12 required number" minlength="1" name="numEstudiosCaso" id="numEstudiosCaso" title="Total de Eventos" maxlength="10" tabindex="1" autocomplete="off" value="0" />
                            </td>
                            <?php if($aprobacion){ ?>
                            <td class="column">
				<input type="hidden" value="0" name="VerificadoTres" id="VerEscondidoTres" />
                                <input type="checkbox"  class="grid-4-12 required number" minlength="1" name="VerificadoTres" id="VerificadoTres" title="Verificado" maxlength="10" tabindex="1" autocomplete="off" value="1" />
                            </td>
                            <?php 
                            }
                            ?>
                        </tr>
                        <tr class="dataColumns">
                            <td class="column">Otros <span class="mandatory">(*)</span></td>
                            <td class="column borderR">
                                <input type="text" class="grid-4-12 required number" minlength="1" name="numOtros" id="numOtros" title="Total de Eventos" maxlength="10" tabindex="1" autocomplete="off" value="0" />
                            </td>
                            <?php if($aprobacion){ ?>
                            <td class="column">
				<input type="hidden" value="0" name="VerificadoCuatro" id="VerEscondidoCuatro" />
                                <input type="checkbox"  class="grid-4-12 required number" minlength="1" name="VerificadoCuatro" id="VerificadoCuatro" title="Verificado" maxlength="10" tabindex="1" autocomplete="off" value="1" />
                            </td>
                            <?php 
                            }
                            ?>
                        </tr>
                    </tbody>
                </table>
                
                <div class="vacio"></div>
                <div id="msg-success" class="msg-success" style="display:none"><p>Los datos han sido guardados de forma correcta.</p></div>
            </fieldset>
            <div class="guardar" onmouseover="guardar(this)" title="">
            <div class="vacio"></div>
            <input type="submit" id="submitInvestigacion" value="Guardar datos" class="first" /> 
        </div>
        </form>
</div>

<script type="text/javascript">

var aprobacion = '<?php echo $aprobacion; ?>';
    getDataInvestigacion("#form_investigacion");
    
                $('#submitInvestigacion').click(function(event) {
                    event.preventDefault();
                    var valido= validateForm("#form_investigacion");
                    if(valido){
                        sendFormInvestigacion("#form_investigacion");
                    }
                });
                
                $('#form_investigacion #mes').add($('#form_investigacion #anio')).bind('change', function(event) {
                    getDataInvestigacion("#form_investigacion");
                });
                
                $(document).on('change', "#form_investigacion #modalidad", function(){
                    getCarreras("#form_investigacion");
                    changeFormModalidad("#form_investigacion");
                });
                
                $(document).on('change', "#form_investigacion #unidadAcademica", function(){
                    getDataInvestigacion("#form_investigacion");
                    changeFormModalidad("#form_investigacion");
                });
                
                function getDataInvestigacion(formName){
                    var periodo = $(formName + ' #mes').val()+"-"+$(formName + ' #anio').val();
                    var entity = $(formName + " #entity").val();
                    var codigocarrera = $(formName + " #unidadAcademica").val();
                    if(codigocarrera==""){
                        //no hay datos xq no hay carrera
                        if($("#idsiq_formUnidadesAcademicasActividadesInvestigacion").val()!=""){
                             var modalidad = $(formName + ' #modalidad').val();
                             var unidadAcademica = $(formName + ' #unidadAcademica').val();
                             var mes = $(formName + ' #mes').val();
                             var anio = $(formName + ' #anio').val();
                             document.forms[formName.replace("#","")].reset();
                             $(formName + ' #modalidad').val(modalidad);
                             $(formName + ' #unidadAcademica').val(unidadAcademica);
                             $(formName + ' #mes').val(mes);
                             $(formName + ' #anio').val(anio);
                             $(formName + " #action").val("save");
                             $("#idsiq_formUnidadesAcademicasActividadesInvestigacion").val("");
                        }
                    } else {
                        $.ajax({
                            dataType: 'json',
                            type: 'POST',
                            url: './formularios/academicos/saveUnidadesAcademicas.php',
                            data: { periodo: periodo, action: "getData", entity: entity, campoPeriodo: "codigoperiodo",codigocarrera:codigocarrera },     
                            success:function(data){
                                if (data.success == true){
                                    $("#idsiq_formUnidadesAcademicasActividadesInvestigacion").val(data.data.idsiq_formUnidadesAcademicasActividadesInvestigacion);
                                    $(formName + " #numSeminarios").val(data.data.numSeminarios);
                                    $(formName + " #numForos").val(data.data.numForos);
                                    $(formName + " #numEstudiosCaso").val(data.data.numEstudiosCaso);
                                    $(formName + " #numOtros").val(data.data.numOtros);
                                    
                                    if(data.data.Verificado=="1"){
                                        //console.log(data.data.Verificado);
                                           $(formName + " #Verificado").attr("checked", true);
                                           if(aprobacion==""){
					      $(formName + " #numSeminarios").attr("readonly", true).addClass("disable");					      
                                           }
                                        }
                                        else{
					  $(formName + " #Verificado").attr("checked", false); 
					  if(aprobacion==""){
					      $(formName + " #numSeminarios").attr("readonly", false).removeClass("disable");					      
                                           }
                                        }
                                        
                                        if(data.data.VerificadoDos=="1"){
                                           $(formName + " #VerificadoDos").attr("checked", true);
                                           if(aprobacion==""){
					      $(formName + " #numForos").attr("readonly", true).addClass("disable");					      
                                           }
                                        }
                                        else{
					  $(formName + " #VerificadoDos").attr("checked", false); 
					  if(aprobacion==""){
					      $(formName + " #numForos").attr("readonly", false).removeClass("disable");					      
                                           }
                                        }
                                        
                                        if(data.data.VerificadoTres=="1"){
                                           $(formName + " #VerificadoTres").attr("checked", true);
                                           if(aprobacion==""){
					      $(formName + " #numEstudiosCaso").attr("readonly", true).addClass("disable");					      
                                           }
                                        }
                                        else{
					  $(formName + " #VerificadoTres").attr("checked", false); 
					  if(aprobacion==""){
					      $(formName + " #numEstudiosCaso").attr("readonly", false).removeClass("disable");					      
                                           }
                                        }
                                        
                                        if(data.data.VerificadoCuatro=="1"){
                                           $(formName + " #VerificadoCuatro").attr("checked", true);
                                           if(aprobacion==""){
					      $(formName + " #numOtros").attr("readonly", true).addClass("disable");					      
                                           }
                                        }
                                        else{
					  $(formName + " #VerificadoCuatro").attr("checked", false); 
					  if(aprobacion==""){
					      $(formName + " #numOtros").attr("readonly", false).removeClass("disable");					      
                                           }
                                        }
                                    
                                    $(formName + " #action").val("update");
                                }
                                else{                        
                                    //no se encontraron datos
                                    if($("#idsiq_formUnidadesAcademicasActividadesInvestigacion").val()!=""){
                                        var modalidad = $(formName + ' #modalidad').val();
                                        var unidadAcademica = $(formName + ' #unidadAcademica').val();
                                        var mes = $(formName + ' #mes').val();
                                        var anio = $(formName + ' #anio').val();
                                        document.forms[formName.replace("#","")].reset();
                                        $(formName + ' #modalidad').val(modalidad);
                                        $(formName + ' #unidadAcademica').val(unidadAcademica);
                                        $(formName + ' #mes').val(mes);
                                        $(formName + ' #anio').val(anio);
                                        $(formName + " #action").val("save");
                                        $("#idsiq_formUnidadesAcademicasActividadesInvestigacion").val("");
                                         $(formName + " #Verificado").attr("checked", false);
                                        $(formName + " #VerificadoDos").attr("checked", false);
                                        $(formName + " #VerificadoTres").attr("checked", false);
                                        $(formName + " #VerificadoCuatro").attr("checked", false);
                                        
                                        $( formName + " input[type=text]" ).each(function() {					      
					      $( this).attr("readonly", false).removeClass("disable");
					});
                                    }
                                }
                            },
                            error: function(data,error,errorThrown){alert(error + errorThrown);}
                        });  
                    }
                }

                function sendFormInvestigacion(formName){
                var periodo = $(formName + ' #mes').val()+"-"+$(formName + ' #anio').val();
                $(formName + ' #codigoperiodo').val(periodo);
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
                                 $("#idsiq_formUnidadesAcademicasActividadesInvestigacion").val(data.message);
                                 $(formName + " #action").val("update");
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
