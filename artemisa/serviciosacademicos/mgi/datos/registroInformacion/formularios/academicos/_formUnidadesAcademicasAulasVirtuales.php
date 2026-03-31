<?php
    require_once("../../../templates/template.php");
    $db = getBD();
    $utils = new Utils_datos();
    
    $usuario_con=$_SESSION['MM_Username'];
    if($utils->UsuarioAprueba_FormHuerfana($db,$usuario_con)){
      $aprobacion=true;
    }
?>
<div id="tabs-7">
<form action="save.php" method="post" id="form_aulas">
            <input type="hidden" name="entity" id="entity" value="formUnidadesAcademicasAulasVirtuales" />
            <input type="hidden" name="action" value="save" id="action" />
            <input type="hidden" name="idsiq_formUnidadesAcademicasAulasVirtuales" value="" id="idsiq_formUnidadesAcademicasAulasVirtuales" />
            
            <span class="mandatory">* Son campos obligatorios</span>
            <fieldset id="numPersonas">   
                <legend>Uso de Aulas Virtuales en asignaturas</legend>
                
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
            
             <?php $utils->pintarBotonCargar("popup_cargarDocumento(9,6,$('#form_aulas #mes').val()+'-'+$('#form_aulas #anio').val(),$('#form_aulas #unidadAcademica').val())","popup_verDocumentos(9,6,$('#form_aulas #mes').val()+'-'+$('#form_aulas #anio').val(),$('#form_aulas #unidadAcademica').val())"); ?>
                            
                <table align="center" class="formData last" width="92%" >
                     <tbody>
                        <tr class="dataColumns">
                            <th class="column" style="text-align: left"><span>Número total de Asignaturas</span></th> 
                            <td class="column"> 
                                <input type="text" class="grid-4-12 required number" minlength="1" name="numAsignaturas" id="numAsignaturas" title="Total de Asignaturas" maxlength="10" tabindex="1" autocomplete="off" value="0" />
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
                            <th class="column" style="text-align: left"><span>Número de Asignaturas con Aula Virtual</span></th> 
                            <td class="column">
                                <input type="text" class="grid-4-12 required number" minlength="1" name="numAulasVirtuales" id="numAulasVirtuales" title="Total de Asignaturas con Aula Virtual" maxlength="10" tabindex="1" autocomplete="off" value="0" />
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
                    </tbody>
                </table>
                
                <div class="vacio"></div>
                <div id="msg-success" class="msg-success" style="display:none"><p>Los datos han sido guardados de forma correcta.</p></div>
            </fieldset>
            <div class="guardar" onmouseover="guardar(this)" title="">
            <div class="vacio"></div>
            <input type="submit" id="submitAulas" value="Guardar datos" class="first" /> 
            </div>
        </form>
</div>

<script type="text/javascript">

var aprobacion = '<?php echo $aprobacion; ?>';
    getDataAulas("#form_aulas");
    
                $('#submitAulas').click(function(event) {
                    event.preventDefault();
                    var valido= validateForm("#form_aulas");
                    if(valido){
                        sendFormAulas("#form_aulas");
                    }
                });
                
                $('#form_aulas #mes').add($('#form_aulas #anio')).bind('change', function(event) {
                    getDataAulas("#form_aulas");
                });
                
                $(document).on('change', "#form_aulas #modalidad", function(){
                    getCarreras("#form_aulas");
                    changeFormModalidad("#form_aulas");
                });
                
                $(document).on('change', "#form_aulas #unidadAcademica", function(){
                    getDataAulas("#form_aulas");
                    changeFormModalidad("#form_aulas");
                });
                
                function getDataAulas(formName){
                    var periodo = $(formName + ' #mes').val()+"-"+$(formName + ' #anio').val();
                    var entity = $(formName + " #entity").val();
                    var codigocarrera = $(formName + " #unidadAcademica").val();
                    if(codigocarrera==""){
                        //no hay datos xq no hay carrera
                        if($("#idsiq_formUnidadesAcademicasAulasVirtuales").val()!=""){
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
                             $("#idsiq_formUnidadesAcademicasAulasVirtuales").val("");
                        }
                    } else {
                        $.ajax({
                            dataType: 'json',
                            type: 'POST',
                            url: './formularios/academicos/saveUnidadesAcademicas.php',
                            data: { periodo: periodo, action: "getData", entity: entity, campoPeriodo: "codigoperiodo",codigocarrera:codigocarrera },     
                            success:function(data){
                                if (data.success == true){
                                    $("#idsiq_formUnidadesAcademicasAulasVirtuales").val(data.data.idsiq_formUnidadesAcademicasAulasVirtuales);
                                    $(formName + " #numAsignaturas").val(data.data.numAsignaturas);
                                    $(formName + " #numAulasVirtuales").val(data.data.numAulasVirtuales);
                                    
                                    if(data.data.Verificado=="1"){
                                        //console.log(data.data.Verificado);
                                           $(formName + " #Verificado").attr("checked", true);
                                           if(aprobacion==""){
					      $(formName + " #numAsignaturas").attr("readonly", true).addClass("disable");					      
                                           }
                                        }
                                        else{
					  $(formName + " #Verificado").attr("checked", false); 
					  if(aprobacion==""){
					      $(formName + " #numAsignaturas").attr("readonly", false).removeClass("disable");					      
                                           }
                                        }
                                        
                                        if(data.data.VerificadoDos=="1"){
                                           $(formName + " #VerificadoDos").attr("checked", true);
                                           if(aprobacion==""){
					      $(formName + " #numAulasVirtuales").attr("readonly", true).addClass("disable");					      
                                           }
                                        }
                                        else{
					  $(formName + " #VerificadoDos").attr("checked", false); 
					  if(aprobacion==""){
					      $(formName + " #numAulasVirtuales").attr("readonly", false).removeClass("disable");					      
                                           }
                                        }
                                    
                                    $(formName + " #action").val("update");
                                }
                                else{                        
                                    //no se encontraron datos
                                    if($("#idsiq_formUnidadesAcademicasAulasVirtuales").val()!=""){
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
                                        $("#idsiq_formUnidadesAcademicasAulasVirtuales").val("");
                                        $(formName + " #Verificado").attr("checked", false);
                                        $(formName + " #VerificadoDos").attr("checked", false);                                        
                                        
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

                function sendFormAulas(formName){
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
                                 $("#idsiq_formUnidadesAcademicasAulasVirtuales").val(data.message);
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
