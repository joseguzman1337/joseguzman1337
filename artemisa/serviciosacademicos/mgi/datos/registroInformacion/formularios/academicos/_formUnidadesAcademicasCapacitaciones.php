<?php
    require_once("../../../templates/template.php");
    $db = getBD();
    $utils = new Utils_datos();
    
    
    $usuario_con=$_SESSION['MM_Username'];
    if($utils->UsuarioAprueba_FormHuerfana($db,$usuario_con)){
      $aprobacion=true;
    }
?>
<div id="tabs-4">
<form action="save.php" method="post" id="form_capacitaciones">
            <input type="hidden" name="entity" id="entity" value="formUnidadesAcademicasCapacitaciones" />
            <input type="hidden" name="action" value="save" id="action" />
            <input type="hidden" name="idsiq_formUnidadesAcademicasCapacitaciones" value="" id="idsiq_formUnidadesAcademicasCapacitaciones" />
            
            <span class="mandatory">* Son campos obligatorios</span>
            <fieldset id="numPersonas">   
                <legend>Capacitación dada al talento humano de la Unidad Académica</legend>
                
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
                
            <?php $utils->pintarBotonCargar("popup_cargarDocumento(9,5,$('#form_capacitaciones #mes').val()+'-'+$('#form_capacitaciones #anio').val(),$('#form_capacitaciones #unidadAcademica').val())","popup_verDocumentos(9,5,$('#form_capacitaciones #mes').val()+'-'+$('#form_capacitaciones #anio').val(),$('#form_capacitaciones #unidadAcademica').val())"); ?>
            
                <table align="center" class="formData last" width="92%" >
                    <thead>            
                        <tr class="dataColumns">
                            <th class="column" colspan="<?php if($aprobacion) echo "3"; else echo "2";?>"><span>Capacitación dada al talento humano de la Unidad Académica</span></th>                                    
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column" ><span>Tipo de capacitación</span></th> 
                            <th class="column" ><span>Número de académicos participantes</span></th>
                            <?php if($aprobacion) { ?>
                            <th class="column" ><span>Aprobar</span></th> 
                            <?php } ?>
                        </tr>
                     </thead>
                     <tbody>
                        <tr class="dataColumns">
                            <td class="column ">Conferencia <span class="mandatory">(*)</span></td>
                            <td class="column"> 
                                <input type="text" class="grid-4-12 required number" minlength="1" name="numConferencia" id="numConferencia" title="Total de Académicos" maxlength="10" tabindex="1" autocomplete="off" value="0" />
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
                            <td class="column">Taller <span class="mandatory">(*)</span></td>
                            <td class="column">
                                <input type="text" class="grid-4-12 required number" minlength="1" name="numTaller" id="numTaller" title="Total de Académicos" maxlength="10" tabindex="1" autocomplete="off" value="0" />
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
                            <td class="column">Curso <span class="mandatory">(*)</span></td>
                            <td class="column">
                                <input type="text" class="grid-4-12 required number" minlength="1" name="numCurso" id="numCurso" title="Total de Académicos" maxlength="10" tabindex="1" autocomplete="off" value="0" />
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
                            <td class="column">Otro <span class="mandatory">(*)</span></td>
                            <td class="column">
                                <input type="text" class="grid-4-12 required number" minlength="1" name="numOtro" id="numOtro" title="Total de Académicos" maxlength="10" tabindex="1" autocomplete="off" value="0" />
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
            <input type="submit" id="submitCapacitaciones" value="Guardar datos" class="first" /> 
            </div>
        </form>
</div>

<script type="text/javascript">

var aprobacion = '<?php echo $aprobacion; ?>';
    getDataCapacitaciones("#form_capacitaciones");
    
                $('#submitCapacitaciones').click(function(event) {
                    event.preventDefault();
                    var valido= validateForm("#form_capacitaciones");
                    if(valido){
                        sendFormCapacitaciones("#form_capacitaciones");
                    }
                });
                
                $('#form_capacitaciones #mes').add($('#form_capacitaciones #anio')).bind('change', function(event) {
                    getDataCapacitaciones("#form_capacitaciones");
                });
                
                $(document).on('change', "#form_capacitaciones #modalidad", function(){
                    getCarreras("#form_capacitaciones");
                    changeFormModalidad("#form_capacitaciones");
                });
                
                $(document).on('change', "#form_capacitaciones #unidadAcademica", function(){
                    getDataCapacitaciones("#form_capacitaciones");
                    changeFormModalidad("#form_capacitaciones");
                });
                
                function getDataCapacitaciones(formName){
                    var periodo = $(formName + ' #mes').val()+"-"+$(formName + ' #anio').val();
                    var entity = $(formName + " #entity").val();
                    var codigocarrera = $(formName + " #unidadAcademica").val();
                    if(codigocarrera==""){
                        //no hay datos xq no hay carrera
                        if($("#idsiq_formUnidadesAcademicasCapacitaciones").val()!=""){
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
                             $("#idsiq_formUnidadesAcademicasCapacitaciones").val("");
                        }
                    } else {
                        $.ajax({
                            dataType: 'json',
                            type: 'POST',
                            url: './formularios/academicos/saveUnidadesAcademicas.php',
                            data: { periodo: periodo, action: "getData", entity: entity, campoPeriodo: "codigoperiodo",codigocarrera:codigocarrera },     
                            success:function(data){
                                if (data.success == true){
                                    $("#idsiq_formUnidadesAcademicasCapacitaciones").val(data.data.idsiq_formUnidadesAcademicasCapacitaciones);
                                    $(formName + " #numConferencia").val(data.data.numConferencia);
                                    $(formName + " #numTaller").val(data.data.numTaller);
                                    $(formName + " #numCurso").val(data.data.numCurso);
                                    $(formName + " #numOtro").val(data.data.numOtro);
                                    
                                    
                                        if(data.data.Verificado=="1"){
                                        //console.log(data.data.Verificado);
                                           $(formName + " #Verificado").attr("checked", true);
                                           if(aprobacion==""){
					      $(formName + " #numConferencia").attr("readonly", true).addClass("disable");					      
                                           }
                                        }
                                        else{
					  $(formName + " #Verificado").attr("checked", false); 
					  if(aprobacion==""){
					      $(formName + " #numConferencia").attr("readonly", false).removeClass("disable");					      
                                           }
                                        }
                                        
                                        if(data.data.VerificadoDos=="1"){
                                           $(formName + " #VerificadoDos").attr("checked", true);
                                           if(aprobacion==""){
					      $(formName + " #numTaller").attr("readonly", true).addClass("disable");					      
                                           }
                                        }
                                        else{
					  $(formName + " #VerificadoDos").attr("checked", false); 
					  if(aprobacion==""){
					      $(formName + " #numTaller").attr("readonly", false).removeClass("disable");					      
                                           }
                                        }
                                        
                                        if(data.data.VerificadoTres=="1"){
                                           $(formName + " #VerificadoTres").attr("checked", true);
                                           if(aprobacion==""){
					      $(formName + " #numCurso").attr("readonly", true).addClass("disable");					      
                                           }
                                        }
                                        else{
					  $(formName + " #VerificadoTres").attr("checked", false); 
					  if(aprobacion==""){
					      $(formName + " #numCurso").attr("readonly", false).removeClass("disable");					      
                                           }
                                        }
                                        
                                        if(data.data.VerificadoCuatro=="1"){
                                           $(formName + " #VerificadoCuatro").attr("checked", true);
                                           if(aprobacion==""){
					      $(formName + " #numOtro").attr("readonly", true).addClass("disable");					      
                                           }
                                        }
                                        else{
					  $(formName + " #VerificadoCuatro").attr("checked", false); 
					  if(aprobacion==""){
					      $(formName + " #numOtro").attr("readonly", false).removeClass("disable");					      
                                           }
                                        }
                                    
                                    $(formName + " #action").val("update");
                                }
                                else{                        
                                    //no se encontraron datos
                                    if($("#idsiq_formUnidadesAcademicasCapacitaciones").val()!=""){
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
                                        $("#idsiq_formUnidadesAcademicasCapacitaciones").val("");
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

                function sendFormCapacitaciones(formName){
                              
                
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
                                 $("#idsiq_formUnidadesAcademicasCapacitaciones").val(data.message);
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
