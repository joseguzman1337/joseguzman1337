<?php
    session_start();
    include_once('../../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
    require_once("../../../templates/template.php");
    $db = getBD();
    $utils = new Utils_datos();
    $tipo='';
    $tipo=$_REQUEST['tipo'];
    $usuario_con=$_SESSION['MM_Username'];
    // echo "<pre>"; print_r($_REQUEST);
    if($utils->UsuarioAprueba_FormHuerfana($db,$usuario_con)){
        $aprobacion=true;
    }
    
    //echo $tipo.'-->';
?>

<div id="tabs-6">
<form action="save.php" method="post" id="form_PresupuestoR3_<?php echo $_REQUEST['tipo']; ?>">
            <input type="hidden" name="entity" id="entity" value="formPresupuestoRecursos" />
            <!--<input type="hidden" name="entity" id="entity" value="detalleformPresupuestoRecursos" />-->
            <input type="hidden" name="action" value="saveDynamic2" id="action" />
            <input type="hidden" name="codigoperiodo" value="" id="codigoperiodo" />
            <input type="hidden" name="actividad" value="<?php echo $_REQUEST['tipo']; ?>" id="actividad" />
            <input type="hidden" name="idsiq_formPresupuestoRecursos" value="" id="idsiq_formPresupuestoRecursos" />
            
            <span class="mandatory">* Son campos obligatorios</span>
               <?php
                if ($tipo==1){
                    $ti="Fuentes de los Recursos";
                    $t2 = "Fuente de Financiamiento";
                }else if ($tipo==2){
                    $ti="Usos de los Recursos";
                    $t2 = "Concepto";
                }else if ($tipo==3){
                    $ti="Presupuesto y Ejecución Presupuestal";
                    $t2 = "Cifras expresadas en millones de pesos";
                }
            ?>
            <fieldset id="numPersonas">   
                <legend><?php echo $ti ?></legend>
                
                <label class="fixedLabel" style="clear:none;width:90px">Año: <span class="mandatory">(*)</span></label>
                <?php $utils->getYearsSelect("anio");  ?>
                <?php $nivelFormacion  = $utils->getAll($db,"siq_tipoRecursosPresupuesto","actividad=".$tipo." AND codigoestado=100","orden"); ?>
                <?php $utils->pintarBotonCargar("popup_cargarDocumento(5,6,$('#form_PresupuestoR3_".$_REQUEST['tipo']." #anio').val())","popup_verDocumentos(5,6,$('#form_PresupuestoR3_".$_REQUEST['tipo']." #anio').val())"); ?>
                <table align="center" class="formData last" width="92%" >
                    <thead>            
                        <tr class="dataColumns">
                            <th class="column" colspan="<?php if($tipo==3) echo "3"; else echo "2";?>"><span><?php echo $ti; ?> (en millones de pesos)</span></th>  
                            <?php if($aprobacion){ ?>
                            <th class="column"><span>
                                <input type="hidden" value="0" name="VerEscondido" id="VerEscondido" />
				<input type="checkbox"  class="grid-4-12 required number" minlength="1" name="Verificado" id="Verificado" title="Verificado" maxlength="12" tabindex="1" autocomplete="off" value="1" />
	                   </span></th>  
                           <?php } ?>
                        </tr>
                        <tr class="dataColumns category">

                            <th class="column borderR" rowspan="2"><span><?php echo $t2; ?></span></th>  
                            <?php if($tipo==3) { echo '<th class="column "><center><span>Presupuestado</span></center></th>'; } ?>
                <th class="column "><center><span>Ejecutado</span></center></th> 
                        </tr>
                        
                     </thead>
                     <tbody>
                         <?php while ($rowC = $nivelFormacion->FetchRow()) { 
                                $first = true;
                          ?>
                                <tr class="dataColumns">
                                        <td class="column borderR" >
                                            <?php echo $rowC["nombre"]; ?> <span class="mandatory">(*)</span>
                                            <input type="hidden"  class="grid-3-12 required number" minlength="1" name="idCategory[]" id="idCategory_<?php echo $rowC["idsiq_tipoRecursosPresupuesto"]; ?>" value="<?php echo $rowC["idsiq_tipoRecursosPresupuesto"]; ?>" />
                                           <input type="hidden" name="idsiq_detalleformPresupuestoRecursos[]" value="" id="idsiq_detalleformPresupuestoRecursos_<?php echo $rowC["idsiq_tipoRecursosPresupuesto"]; ?>" />
										<?php if($tipo!=3) {  ?>
										<input type="hidden" name="presupuesto[]" value="0" id="presupuesto_<?php echo $rowC["idsiq_tipoRecursosPresupuesto"]; ?>" />
										<?php } ?>
									   </td>
									   
                            <?php if($tipo==3) {  ?>
                                        <td class="column"> <center>
                                          <input type="text"  class="grid-10-12 required number" minlength="1" name="presupuesto[]" id="presupuesto_<?php echo $rowC["idsiq_tipoRecursosPresupuesto"]; ?>" title="presupuesto" maxlength="30" tabindex="1"  autocomplete="off" value="" />
                                       </center></td>
									   <?php }  ?>
                                       <td class="column"> <center>
                                         <input type="text"  class="grid-10-12 required number" minlength="1" name="ejecucion[]" id="ejecucion_<?php echo $rowC["idsiq_tipoRecursosPresupuesto"]; ?>" title="ejecucion" maxlength="30" tabindex="1"  autocomplete="off" value="" />
                                       </center></td>

                                </tr>
                        <?php  } ?>        
                    </tbody>
                </table>                   
                
                <div class="vacio"></div>
                <div id="msg-success" class="msg-success" style="display:none"><p>Los datos han sido guardados de forma correcta.</p></div>
            </fieldset>
            
            <input type="submit" id="submitDedicacionSemanal3_<?php echo $_REQUEST['tipo'] ?>" value="Guardar datos" class="first" /> 
        </form>
</div>

<script type="text/javascript">
    //var tipo=$("#actividad").val()
    var aprobacion = '<?php echo $aprobacion; ?>';
    $(function(){
        $("#form_PresupuestoR3_"+<?php echo $_REQUEST['tipo'] ?> + " input[type='text']").maskMoney({allowZero:true, thousands:',', decimal:'.',precision:0,allowNegative:true, defaultZero:false});
    });
    
    getDataRecursoPresupuesto<?php echo $_REQUEST['tipo']; ?>("#form_PresupuestoR3_"+<?php echo $_REQUEST['tipo'] ?>);
    
         
                $('#submitDedicacionSemanal3_'+<?php echo $_REQUEST['tipo'] ?>).click(function(event) {
                    event.preventDefault();
                    replaceCommas("#form_PresupuestoR3_"+<?php echo $_REQUEST['tipo'] ?>);
                    var valido= validateForm("#form_PresupuestoR3_"+<?php echo $_REQUEST['tipo'] ?>);
                    if(valido){
                       //sendDetalleFormacionActividadesAcademicos("#form_PresupuestoR3");
                    
                       sendFormRecursoPresupuesto<?php echo $_REQUEST['tipo']; ?>("#form_PresupuestoR3_"+<?php echo $_REQUEST['tipo'] ?>);
                    }
                });
                
                $('#form_PresupuestoR3_'+<?php echo $_REQUEST['tipo'] ?>+' #anio').bind('change', function(event) {
                    getDataRecursoPresupuesto<?php echo $_REQUEST['tipo']; ?>("#form_PresupuestoR3_"+<?php echo $_REQUEST['tipo'] ?>);
                });
                
             
                function getDataRecursoPresupuesto<?php echo $_REQUEST['tipo']; ?>(formName){
                   // alert(formName)
                
                    var periodo = $(formName + ' #anio').val();
                    var actividad = $(formName + " #actividad").val();
                    var entity = $(formName + " #entity").val();
                        $.ajax({
                            dataType: 'json',
                            type: 'POST',
                            url: './formularios/docentes/saveTalentoHumano.php',
                            data: { periodo: periodo, action: "getDataDynamic2", entity: entity, joinField: "idsiq_tipoRecursosPresupuesto", actividad:actividad, campoPeriodo: "codigoperiodo",
                                    entityJoin: "siq_tipoRecursosPresupuesto"},     
                            success:function(data){
                                if (data.success == true){
                                    $("#idsiq_formPresupuestoRecursos").val(data.message);
                                    //$("#anio").val(periodo);
                                   // $("#actividad").val(data.actividad)
                                   
                                    for (var i=0;i<data.total;i++)
                                    {   
                                       // alert(data.data[i].ejecucion);
                                        $(formName + " #idCategory_"+data.data[i].idCategory).val(data.data[i].idCategory);
                                        $(formName + " #idsiq_detalleformPresupuestoRecursos_"+data.data[i].idCategory).val(data.data[i].idsiq_detalleformPresupuestoRecursos);
                                        $(formName + " #presupuesto_"+data.data[i].idCategory).val(data.data[i].presupuesto);
                                        $(formName + " #ejecucion_"+data.data[i].idCategory).val(data.data[i].ejecucion);
                                        
                                        if(data.data[i].Verificado=="1"){ 
                                           $(formName + " #Verificado").attr("checked", true);
				          // $(formName + " #presupuestado_"+data[i].idclasificacionesinfhuerfana).attr("readonly", true).addClass("disable");
					  // $(formName + " #ejecutado_"+data[i].idclasificacionesinfhuerfana).attr("readonly", true).addClass("disable");
                                           $(formName + ' #msg-success').html('<p> Ya esta validado</p>');
                                           $(formName + ' #msg-success').removeClass('msg-error');
                                           $(formName + ' #msg-success').css('display','block');
                                           $(formName + " #msg-success").delay(5500).fadeOut(300);
                                           $(formName + " #enviafinanciamiento").attr('disabled','disabled');
                                           $(formName).find(':input').each(function() {
                                                 $(this).removeAttr("readonly").addClass("disable");
                                                 $(this).removeAttr("disabled").addClass("disable");
                                            });
                                          }else{
                                               
                                              $(formName).find(':input').each(function() {
                                                 $(this).removeAttr("readonly").removeClass("disable");
                                            }); 
                                           // $(formName + " #enviafinanciamiento").removeAttr('disabled','disabled');
                                              $(formName + " #Verificado").attr("checked", false);
                                            } 
                                         
                                    }
                                    $(formName + " #action").val("updateDynamic2");
                                    addCommas(formName);
                                }
                                else{                        
                                    //no se encontraron datos
                                    if($("#idsiq_formPresupuestoRecursos").val()!=""){
                                    $(formName + ' input[name="idsiq_detalleformPresupuestoRecursos[]"]').each(function() {                                     
                                  $(this).val("");                                       
                             });
                                              
                                               
                                                var anio = $(formName + ' #anio').val();
                                                document.forms[formName.replace("#","")].reset();
                                                
                                                $(formName + ' #anio').val(anio);
                                                $(formName + " #action").val("saveDynamic2");
                                                $("#idsiq_formPresupuestoRecursos").val("");
                                                $(formName + " #Verificado").attr("checked", false);
                                                $(formName).find(':input').each(function() {
                                                       $(this).removeAttr("readonly").removeClass("disable");
                                                 });
                                            }
                                }
                            },
                            error: function(data,error,errorThrown){alert(error + errorThrown);}
                        }); 
                 }
                
                function sendFormRecursoPresupuesto<?php echo $_REQUEST['tipo']; ?>(formName){
                       $(formName + " input[type=checkbox]:checked" ).each(function() {
                        var id= $( this ).attr( "id" );
                        $( "#VerEscondido").attr("disabled","disabled");
                      });

                      $(formName + " input[type=checkbox]:not(:checked)" ).each(function() {
                        var id= $( this ).attr( "id" );
                        $( "#VerEscondido").removeAttr("disabled");
                      });
                
                    var periodo = $(formName + ' #anio').val();
                    $(formName + " #codigoperiodo").val(periodo)
                    var entity = $(formName + " #entity1").val();
                    var anio = $(formName + " #anio").val();
                    $.ajax({
                        dataType: 'json',
                        type: 'POST',
                         url: './formularios/docentes/saveTalentoHumano.php',
                         data: $(formName).serialize(),                
                        success:function(data){
                            if (data.success == true){
                                 //window.location.href="./viewData.php?id=row_<?php //echo $formulario["idsiq_formulario"]; ?>";  
                                 $("#idsiq_formPresupuestoRecursos").val(data.message);
                                 
                                 for (var i=0;i<data.total;i++)
                                 {                                  
                                    $("#idsiq_detalleformPresupuestoRecursos_"+data.dataCat[i]).val(data.data[i]);
                                 }
                                 $(formName + " #action").val("updateDynamic2");
                                 $(formName + ' #msg-success').css('display','block');
                                 $(formName + " #msg-success").delay(5500).fadeOut(800);
                                // sendDetalleFormacionActividadesAcademicos(formName);
                            }
                            else{                        
                                $('#msg-error').html('<p>' + data.message + '</p>');
                                $('#msg-error').addClass('msg-error');
                            }
                        },
                        error: function(data,error,errorThrown){alert(error + errorThrown);}
                    });           
                    addCommas(formName); 
                }
                
//                           
</script>
