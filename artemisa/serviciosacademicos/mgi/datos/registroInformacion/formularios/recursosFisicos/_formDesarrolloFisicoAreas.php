<?php
    session_start();
    include_once('../../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
    require_once("../../../templates/template.php");
    $db = getBD();
    $utils = new Utils_datos();
    $usuario_con=$_SESSION['MM_Username'];
    if($utils->UsuarioAprueba_FormHuerfana($db,$usuario_con)){
        $aprobacion=true;
    }
?>

<div id="tabs-2">
<form action="save.php" method="post" id="formAreas">
            <input type="hidden" name="entity" id="entity" value="formDesarrolloFisicoAreas" />
            <input type="hidden" name="action" value="saveDynamic2" id="action" />
            <input type="hidden" name="idsiq_formDesarrolloFisicoAreas" value="" id="idsiq_formDesarrolloFisicoAreas" />
            
            <span class="mandatory">* Son campos obligatorios</span>
            <fieldset id="numPersonas">   
                <legend>&Aacute;reas</legend>
                                
                <label for="nombre" class="fixedLabel">Semestre: <span class="mandatory">(*)</span></label>
                <?php $utils->getSemestresSelect($db,"codigoperiodo");  
                $utils->pintarBotonCargar("popup_cargarDocumento(4,3,$('#formAreas #codigoperiodo').val())","popup_verDocumentos(4,3,$('#formAreas #codigoperiodo').val())");
                $espacios = $utils->getAll($db,"siq_areasFisicas","codigoestado=100","idsiq_areasFisicas"); ?>  
                
                <div class="vacio"></div>
                
                <table align="center" class="formData last" width="92%" >
                    <thead>            
                        <tr class="dataColumns">
                            <th class="column" colspan="<?php if($aprobacion) echo "3"; else echo "2";?>"><span>&Aacute;reas</span></th>  
                            <?php if($aprobacion){ ?>
                            <th class="column"><span>
                                <input type="hidden" value="0" name="VerEscondido" id="VerEscondido" />
				<input type="checkbox"  class="grid-4-12 required number" minlength="1" name="Verificado" id="Verificado" title="Verificado" maxlength="10" tabindex="1" autocomplete="off" value="1" />
	                   </span></th>  
                           <?php } ?>
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column borderR" ><span>&Aacute;reas</span></th> 
                            <th class="column borderR" ><span>Total &Aacute;reas en M<sup>2</sup></span></th> 
                        </tr>
                     </thead>
                     <tbody>
                         <?php while ($row = $espacios->FetchRow()) { ?>
                        <tr class="dataColumns">
                            <td class="column borderR"><?php echo $row["nombre"]; ?> <span class="mandatory">(*)</span>
                                    <input type="hidden"  class="grid-3-12 required number" minlength="1" name="idCategory[]" id="idCategory_<?php echo $row["idsiq_areasFisicas"]; ?>" value="<?php echo $row["idsiq_areasFisicas"]; ?>" />
                                 <input type="hidden" name="idsiq_detalleformDesarrolloFisicoAreas[]" value="" id="idsiq_detalleformDesarrolloFisicoAreas_<?php echo $row["idsiq_areasFisicas"]; ?>" /></td>
                            <td class="column borderR"> 
                                <input type="text" class="grid-6-12 required number" minlength="1" name="metros[]" id="metros_<?php echo $row["idsiq_areasFisicas"]; ?>" title="Total de metros cuadrados" maxlength="10" tabindex="1" autocomplete="off" value="" />
                            </td>
                        </tr>
                        <?php } ?>           
                    </tbody>
                </table>                   
                
                <div class="vacio"></div>
                <div id="msg-success" class="msg-success" style="display:none"><p>Los datos han sido guardados de forma correcta.</p></div>
            </fieldset>
            
            <input type="submit" id="submitAreas" value="Guardar datos" class="first" /> 
        </form>
</div>

<script type="text/javascript">
    
    var aprobacion = '<?php echo $aprobacion; ?>';
    
    getDataAreas("#formAreas");
    
                $('#submitAreas').click(function(event) {
                    event.preventDefault();
                    var valido= validateForm("#formAreas");
                    if(valido){
                        sendFormAreas("#formAreas");
                    }
                });
                
     $('#formAreas #codigoperiodo').bind('change', function(event) {
          getDataAreas("#formAreas");
    });
    
    function getDataAreas(formName){
                    //var periodo = $(formName + ' #mes').val()+"-"+$(formName + ' #anio').val();
                    var periodo = $(formName + ' #codigoperiodo').val();
                    var entity = $(formName + " #entity").val();
                        $.ajax({
                            dataType: 'json',
                            type: 'POST',
                            url: './formularios/recursosFisicos/saveDesarrolloFisicoYMantenimiento.php',
                            data: { periodo: periodo, action: "getDataDynamic2", entity: entity, campoPeriodo: "codigoperiodo",entityJoin: "siq_areasFisicas" },     
                            success:function(data){
                                if (data.success == true){
                                    $("#idsiq_formDesarrolloFisicoAreas").val(data.message);
                                    for (var i=0;i<data.total;i++)
                                    {                                  
                                        $(formName + " #idCategory_"+data.data[i].idCategory).val(data.data[i].idCategory);
                                        $("#idsiq_detalleformDesarrolloFisicoAreas_"+data.data[i].idCategory).val(data.data[i].idsiq_detalleformDesarrolloFisicoAreas);
                                        $(formName + " #metros_"+data.data[i].idCategory).val(data.data[i].metros);
                                        
                                         if(data.data[i].Verificado=="1"){ 
                                           $(formName + " #Verificado").attr("checked", true);
                                           $(formName + ' #msg-success').html('<p> Ya esta validado</p>');
                                           $(formName + ' #msg-success').removeClass('msg-error');
                                           $(formName + ' #msg-success').css('display','block');
                                           $(formName + " #msg-success").delay(5500).fadeOut(300);
                                           $(formName + " #submitAreas").attr('disabled','disabled');
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
                                }
                                else{                        
                                    //no se encontraron datos
                                    if($("#idsiq_formDesarrolloFisicoAreas").val()!=""){
                                        $(formName + ' input[name="idsiq_detalleformDesarrolloFisicoAreas[]"]').each(function() {                                     
                                            $(this).val("");                                       
                                        });
                                        var mes = $(formName + ' #codigoperiodo').val();
                                        document.forms[formName.replace("#","")].reset();
                                            $(formName + ' #codigoperiodo').val(mes);
                                        $(formName + " #action").val("saveDynamic2");
                                            $("#idsiq_formDesarrolloFisicoAreas").val("");
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
                
       function sendFormAreas(formName){
                 $(formName + " input[type=checkbox]:checked" ).each(function() {
                        var id= $( this ).attr( "id" );
                        $( "#VerEscondido").attr("disabled","disabled");
                      });

                      $(formName + " input[type=checkbox]:not(:checked)" ).each(function() {
                        var id= $( this ).attr( "id" );
                        $( "#VerEscondido").removeAttr("disabled");
                      });
                
                    $.ajax({
                        dataType: 'json',
                        type: 'POST',
                        url: './formularios/recursosFisicos/saveDesarrolloFisicoYMantenimiento.php',
                        data: $(formName).serialize(),                
                        success:function(data){
                            if (data.success == true){
                                 //window.location.href="./viewData.php?id=row_<?php //echo $formulario["idsiq_formulario"]; ?>";  
                                 $("#idsiq_formDesarrolloFisicoAreas").val(data.message);
                                 for (var i=0;i<data.total;i++)
                                 {                                  
                                    $("#idsiq_detalleformDesarrolloFisicoAreas_"+data.dataCat[i]).val(data.data[i]);
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
