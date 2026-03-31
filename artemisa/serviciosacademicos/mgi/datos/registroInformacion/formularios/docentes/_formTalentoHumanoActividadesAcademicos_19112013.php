<?php
    require_once("../../../templates/template.php");
    $db = getBD();
    $utils = new Utils_datos();
    
    $usuario_con=$_SESSION['MM_Username'];
    if($utils->UsuarioAprueba_FormHuerfana($db,$usuario_con)){
    $aprobacion=true;
    }
?>

<div id="tabs-12">
<form action="save.php" method="post" id="form_actividadesAcademicos">
            <input type="hidden" name="entity" id="entity" value="formUnidadesAcademicasActividadesAcademicos" />
            <input type="hidden" name="action" value="saveDynamic2" id="action" />
            <input type="hidden" name="actividad" value="2" id="actividad" />
            <input type="hidden" name="idsiq_formUnidadesAcademicasActividadesAcademicos" value="" id="idsiq_formUnidadesAcademicasActividadesAcademicos" />
            
            <span class="mandatory">* Son campos obligatorios</span>
            <fieldset id="numPersonas">   
                <legend>Dedicación de los Académicos por actividades</legend>              
                <div class="vacio"></div>
                <label for="nombre" class="fixedLabel">Semestre: <span class="mandatory">(*)</span></label>
                <?php $utils->getSemestresSelect($db,"codigoperiodo");  
                      //$sectores = $utils->getActives($db,"siq_tipoActividadAcademicos","nombre");
                    $categoriasPadres = $utils->getAll($db,"siq_tipoActividadAcademicos","actividadPadre=0 AND codigoestado=100","nombre"); 
                ?>
                
                <?php $utils->pintarBotonCargar("popup_cargarDocumento(9,16,$('#form_actividadesAcademicos #codigoperiodo').val(),$('#form_actividadesAcademicos #unidadAcademica').val())","popup_verDocumentos(9,16,$('#form_actividadesAcademicos #codigoperiodo').val(),$('#form_actividadesAcademicos #unidadAcademica').val())"); ?>
                                
                <table align="center" class="formData last" width="92%" >
                    <thead>            
                        <tr class="dataColumns">
                            <th class="column" colspan="<?php if($aprobacion) echo "5"; else echo "4";?>"><span>Dedicación de los Académicos por actividades</span></th>                                    
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column borderR" colspan="2"><span>Clase De Actividades</span></th> 
                            <th class="column "><span>Horas Semanales</span></th> 
                            <th class="column borderR"><span>Tiempos completos equivalentes</span></th>
                            <?php if($aprobacion) { ?>
                            <th class="column"><span>Aprobar</span></th> 
                            <?php } ?>
                        </tr>
                     </thead>
                     <tbody>
                         <?php while ($rowC = $categoriasPadres->FetchRow()) { 
                                $first = true;
                                $categorias = $utils->getAll($db,"siq_tipoActividadAcademicos","actividadPadre=".$rowC["idsiq_tipoActividadAcademicos"]." AND codigoestado=100","nombre"); 
                                while ($row = $categorias->FetchRow()) { 
                             ?>
                                <tr class="dataColumns">
                                    <?php if($first){ $first = false; ?>
                                        <td class="column borderR" rowspan="<?php echo $categorias->RecordCount(); ?>" > 
                                            <?php echo $rowC["nombre"]; ?> <span class="mandatory">(*)</span>
                                        </td>
                                    <?php } ?>
                                    <td class="column borderR"><?php echo $row["nombre"]; ?> <span class="mandatory">(*)</span>
                                            <input type="hidden"  class="grid-3-12 required number" minlength="1" name="idCategory[]" id="idCategory_<?php echo $row["idsiq_tipoActividadAcademicos"]; ?>" value="<?php echo $row["idsiq_tipoActividadAcademicos"]; ?>" />
                                        <input type="hidden" name="idsiq_detalleformUnidadesAcademicasActividadesAcademicos[]" value="" id="idsiq_detalleformUnidadesAcademicasActividadesAcademicos_<?php echo $row["idsiq_tipoActividadAcademicos"]; ?>" />

                                    </td>
                                    <td class="column"> 
                                        <input type="text"  class="grid-5-12 required number" minlength="1" name="numHoras[]" id="numHoras_<?php echo $row["idsiq_tipoActividadAcademicos"]; ?>" title="Horas Semanales" maxlength="10" tabindex="1" onblur="calculo('numHoras_<?php echo $row["idsiq_tipoActividadAcademicos"]; ?>','numAcademicosTCE_<?php echo $row["idsiq_tipoActividadAcademicos"]; ?>')" autocomplete="off" value="0" />
                                    </td>
                                    <td class="column borderR"> 
                                        <input type="text"  class="grid-6-12 required number" minlength="1" name="numAcademicosTCE[]" id="numAcademicosTCE_<?php echo $row["idsiq_tipoActividadAcademicos"]; ?>" title="Académicos de Tiempo Completo" readonly maxlength="10" tabindex="1" autocomplete="off" value="0" />
                                    </td>
                                    <?php if($aprobacion){ ?>
				    <td class="column">
					<input type="hidden" value="0" name="Verificado[]" id="VerEscondido_<?php echo $row["idsiq_tipoActividadAcademicos"]; ?>" />
					<input type="checkbox"  class="grid-4-12 required number" minlength="1" name="Verificado[]" id="Verificado_<?php echo $row["idsiq_tipoActividadAcademicos"]; ?>" title="Verificado" maxlength="10" tabindex="1" autocomplete="off" value="1" />
				    </td>
				    <?php 
				    }
				    ?> 
                                </tr>
                        <?php } } ?>        
                    </tbody>
                </table>                   
                
                <div class="vacio"></div>
                <div id="msg-success" class="msg-success" style="display:none"><p>Los datos han sido guardados de forma correcta.</p></div>
            </fieldset>
            
            <input type="submit" id="submitActividadesAcademicos" value="Guardar datos" class="first" /> 
        </form>
</div>

<script type="text/javascript">

var aprobacion = '<?php echo $aprobacion; ?>';
    getDataActividadesAcademicos("#form_actividadesAcademicos");
    
    function calculo(Nh,NhTCE){
      var nH1=parseFloat($("#"+Nh).val());
      var nHTCE=nH1/40;
      $("#"+NhTCE).val(nHTCE)
      
    }
        
                $('#submitActividadesAcademicos').click(function(event) {
                    event.preventDefault();
                    var valido= validateForm("#form_actividadesAcademicos");
                    if(valido){
                        sendFormFormacionActividadesAcademicos("#form_actividadesAcademicos");
                    }
                });
                
                $('#form_actividadesAcademicos #codigoperiodo').bind('change', function(event) {
                    getDataActividadesAcademicos("#form_actividadesAcademicos");
                });
                
                $(document).on('change', "#form_actividadesAcademicos #modalidad", function(){
                    getCarreras("#form_actividadesAcademicos");
                    changeFormModalidad("#form_actividadesAcademicos");
                });
                
                $(document).on('change', "#form_actividadesAcademicos #unidadAcademica", function(){
                    getDataActividadesAcademicos("#form_actividadesAcademicos");
                    changeFormModalidad("#form_actividadesAcademicos");
                });
                
                function getDataActividadesAcademicos(formName){
                    var periodo = $(formName + ' #codigoperiodo').val();
                    var entity = $(formName + " #entity").val();
                    var actividad = $(formName + " #actividad").val();
                         $.ajax({
                            dataType: 'json',
                            type: 'POST',
                            url: './formularios/docentes/saveTalentoHumano.php',
                            data: { periodo: periodo, action: "getDataDynamic2", entity: entity, joinField: "", actividad:actividad, campoPeriodo: "codigoperiodo",
                                    entityJoin: "siq_tipoActividadAcademicos" },     
                            success:function(data){
                                if (data.success == true){
                                    for (var i=0;i<data.total;i++){                                  
                                        $(formName + " #idCategory_"+data.data[i].idCategory).val(data.data[i].idCategory);
                                        $("#idsiq_detalleformUnidadesAcademicasActividadesAcademicos_"+data.data[i].idCategory).val(data.data[i].idsiq_detalleformUnidadesAcademicasActividadesAcademicos);
                                        $(formName + " #numHoras_"+data.data[i].idCategory).val(data.data[i].numHoras);
                                        $(formName + " #numAcademicosTCE_"+data.data[i].idCategory).val(data.data[i].numAcademicosTCE);
                                        //console.log(aprobacion);
                                        if(data.data[i].Verificado=="1"){
                                           $(formName + " #Verificado_"+data.data[i].idCategory).attr("checked", true);
                                           if(aprobacion==""){
					      $(formName + " #numHoras_"+data.data[i].idCategory).attr("readonly", true).addClass("disable");
					      $(formName + " #numAcademicosTCE_"+data.data[i].idCategory).attr("readonly", true).addClass("disable");					      
                                           }
                                        }
                                        else{
					  $("#Verificado_"+data.data[i].idCategory).attr("checked", false); 
					  if(aprobacion==""){
					      $(formName + " #numHoras_"+data.data[i].idCategory).attr("readonly", false).removeClass("disable");
					      $(formName + " #numAcademicosTCE_"+data.data[i].idCategory).attr("readonly", false).removeClass("disable");					      
                                           }
                                        }
                                    }
                                    $(formName + " #action").val("updateDynamic2");
                                }else{                        
                                    //no se encontraron datos
                                    alert('aca22'+$("#idsiq_formUnidadesAcademicasActividadesAcademicos").val());
                                    if($("#idsiq_formUnidadesAcademicasActividadesAcademicos").val()==""){
                                               $(formName + ' input[name="idsiq_detalleformUnidadesAcademicasActividadesAcademicos[]"]').each(function() {                                     
                                                      $(this).val("");                                       
                                               });
                                               var mes = $(formName + ' #codigoperiodo').val();
                                               var act=$(formName + ' #actividad').val();
                                                document.forms[formName.replace("#","")].reset();
                                                $(formName + ' #codigoperiodo').val(mes);
                                                $(formName + ' #actividas').val(act);
                                                $(formName + " #action").val("saveDynamic2");
                                                
                                                $("#idsiq_formUnidadesAcademicasActividadesAcademicos").val("");
                                                $( formName + " input[type=checkbox]" ).each(function() {					      
						$( this).attr("checked", false);
						});
						$( formName + " input[type=text]" ).each(function() {					      
						  $( this).attr("readonly", false).removeClass("disable");
						});
                                            }
                                }
                            },
                            error: function(data,error,errorThrown){alert(error + errorThrown);}
                        }); 
                }

                function sendFormFormacionActividadesAcademicos(formName){
                $(formName + " input[type=checkbox]:checked" ).each(function() {
		  var id= $( this ).attr( "id" );
		  var n = id.split("_");
		  $( "#VerEscondido_"+n[1]).attr("disabled","disabled");
		});
		
		$(formName + " input[type=checkbox]:not(:checked)" ).each(function() {
		  var id= $( this ).attr( "id" );
		  var n = id.split("_");
		  $( "#VerEscondido_"+n[1]).removeAttr("disabled");
		});
                    $.ajax({
                        dataType: 'json',
                        type: 'POST',
                        url: './formularios/docentes/saveTalentoHumano.php',
                        data: $(formName).serialize(),                
                        success:function(data){
                            if (data.success == true){
                                 //window.location.href="./viewData.php?id=row_<?php //echo $formulario["idsiq_formulario"]; ?>";  
                                 $("#idsiq_formUnidadesAcademicasActividadesAcademicos").val(data.message);
                                 for (var i=0;i<data.total;i++)
                                 {                                  
                                    $("#idsiq_detalleformUnidadesAcademicasActividadesAcademicos_"+data.dataCat[i]).val(data.data[i]);
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
