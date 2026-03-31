<?php 
    require_once("../../../templates/template.php");
    $db = getBD();
    $utils = new Utils_datos();
$id= $_REQUEST["id"];
$usuario_con=$_SESSION['MM_Username']; 
    if($utils->UsuarioAprueba_FormHuerfana($db,$usuario_con)){
        $aprobacion=true;
   }
    ?>
<div id="tabs-1">
<form action="save.php" method="post" id="form_test">
            <input type="hidden" name="entity" id="entity" value="formInvestigacionesGruposInvestigacion" />
            <input type="hidden" name="action" value="saveDynamic2" id="action" />
            <input type="hidden" name="idsiq_formInvestigacionesGruposInvestigacion" value="" id="idsiq_formInvestigacionesGruposInvestigacion" />
            
            <span class="mandatory">* Son campos obligatorios</span>
            <fieldset id="numPersonas">   
                <legend>Grupos de investigación</legend>
                
                <label class="fixedLabel" style="clear:none;width:90px">Año: <span class="mandatory">(*)</span></label>
                <?php $utils->getYearsSelect("codigoperiodo");  ?>
                <?php $utils->pintarBotonCargar("popup_cargarDocumento(".$id.",1,$('#form_test #codigoperiodo').val())","popup_verDocumentos(".$id.",1,$('#form_test #codigoperiodo').val())"); ?>
                
            <!--<input type="hidden" name="codigoperiodo" value="" id="codigoperiodo" />  -->                 
                
                <div class="vacio"></div>
                
                <table align="center" class="formData" width="92%" >
                    <thead>            
                        <tr class="dataColumns">
                            <th class="column" colspan="<?php if($aprobacion) echo "1"; else echo "2";?>"><span>Grupos de investigación</span></th>
                            <?php if($aprobacion){ ?>
                            <th class="column"><span>
                                <input type="hidden" value="0" name="VerEscondido" id="VerEscondido" />
				<input type="checkbox"  class="grid-4-12 required number" minlength="1" name="Verificado" id="Verificado" title="Verificado" maxlength="10" tabindex="1" autocomplete="off" value="1" />
	                   </span></th>  
                           <?php } ?>
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column" ><span>Grupos de investigación</span></th> 
                            <th class="column" ><span>No. Grupos</span></th> 
                        </tr>
                     </thead>
                     <tbody>
                        <tr class="dataColumns">
                            <td class="column ">“Grupos UEB reconocidos COLCIENCIAS <span class="mandatory">(*)</span></td>
                            <td class="column"> 
                                <input type="text"  class="grid-4-12 required number" minlength="1" name="numColciencias" id="numColciencias"  maxlength="30" tabindex="1" autocomplete="off" value="" />
                            </td>
                        </tr>
                        <tr class="dataColumns">
                            <td class="column">Grupos avalados por la UEB sin reconocimiento <span class="mandatory">(*)</span></td>
                            <td class="column">
                                <input type="text"  class="grid-4-12 required number" minlength="1" name="numUEB" id="numUEB" maxlength="30" tabindex="1" autocomplete="off" value="" />
                            </td>
                        </tr>
                    </tbody>
                </table>   
                
                <table align="center" class="formData" width="92%" >
                    <thead>            
                        <tr class="dataColumns">
                            <th class="column" colspan="2"><span>Relación Grupos Universidad / nacional </span></th>                                    
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column" ><span>Relación Grupos Universidad / Nacional</span></th> 
                            <th class="column" ><span>No. Grupos</span></th> 
                        </tr>
                     </thead>
                     <tbody>
                        <tr class="dataColumns">
                            <td class="column">Grupos de investigación de las IES reconocidos por COLCIENCIAS <span class="mandatory">(*)</span></td>
                            <td class="column"> 
                                <input type="text"  class="grid-4-12 required number" minlength="1" name="numUniversidadColciencias" id="numUniversidadColciencias" maxlength="30" tabindex="1" autocomplete="off" value="" />
                            </td>
                        </tr>
                        <tr class="dataColumns">
                            <td class="column">Número total de grupos reconocidos por Colciencias <span class="mandatory">(*)</span></td>
                            <td class="column">
                                <input type="text"  class="grid-4-12 required number" minlength="1" name="numTotalColciencias" id="numTotalColciencias" maxlength="30" tabindex="1" autocomplete="off" value="" />
                            </td>
                        </tr>
                    </tbody>
                </table> 
                
                <div class="vacio"></div>
                <div id="msg-success" class="msg-success" style="display:none"><p>Los cambios han sido guardados de forma correcta.</p></div>
            </fieldset>
            
            <input type="submit" id="submitGrupos" value="Guardar datos" class="first" />
        </form>
</div>
<script type="text/javascript">
    
    var aprobacion = '<?php echo $aprobacion; ?>';
    
    getDataGrupos();
    
                $('#submitGrupos').click(function(event) {
                    event.preventDefault();
                    var valido= validateForm("#form_test");
                    if(valido){
                        sendFormGrupos();
                    }
                });
                
               // $('#form_test #codigoperiodo').change(function(event) {
       $('#form_test #codigoperiodo').bind('change', function(event) {
                    getDataGrupos();
                });
                
                function getDataGrupos(){
                   
                    var periodo = $('#form_test #codigoperiodo').val();
                    var entity = $("#form_test #entity").val();
                    $.ajax({
                        dataType: 'json',
                        type: 'POST',
                        url: './formularios/docentes/saveTalentoHumano.php',
                        data: { periodo: periodo, action: "getData", entity: entity, campoPeriodo: "codigoperiodo" },     
                        success:function(data){
                            if (data.success == true){
                                 $("#idsiq_formInvestigacionesGruposInvestigacion").val(data.data.idsiq_formInvestigacionesGruposInvestigacion);
                                 $("#numColciencias").val(data.data.numColciencias);
                                 $("#numUEB").val(data.data.numUEB);
                                 $("#numUniversidadColciencias").val(data.data.numUniversidadColciencias);
                                 $("#numTotalColciencias").val(data.data.numTotalColciencias); 
                                 $("#form_test #action").val("updateDynamic2");
                                
                                 if(data.data.Verificado=="1"){ 
                                           $("#form_test #Verificado").attr("checked", true);
                                           $('#form_test #msg-success').html('<p> Ya esta validado</p>');
                                           $('#form_test #msg-success').removeClass('msg-error');
                                           $('#form_test #msg-success').css('display','block');
                                           $("#form_test #msg-success").delay(5500).fadeOut(300);
                                           $("#form_test #submitGrupos").attr('disabled','disabled');
                                           $("#form_test").find(':input').each(function() {
                                                 $(this).removeAttr("readonly").addClass("disable");
                                                 $(this).removeAttr("disabled").addClass("disable");
                                            });
                                          }else{
                                               
                                              $("#form_test").find(':input').each(function() {
                                                 $(this).removeAttr("readonly").removeClass("disable");
                                            }); 
                                           // $("#form_test #enviafinanciamiento").removeAttr('disabled','disabled');
                                              $("#form_test #Verificado").attr("checked", false);
                                            }
                                 
                                       // $("#form_test #action").val("updateDynamic2");
                                 //$("#form_test #verificada_"+data.data.verificada).attr('checked', 'checked');
                            }
                            else{                        
                                //no se encontraron datos
                                if($("#idsiq_formInvestigacionesGruposInvestigacion").val()!=""){
                                        var anio = $('#form_test #codigoperiodo').val();
                                    document.forms["form_test"].reset();         
                                            $('#form_test #codigoperiodo').val(anio);
                                    $("#form_test #action").val("saveDynamic2");
                                    $("#idsiq_formInvestigacionesGruposInvestigacion").val("");
                                     $("#form_test #Verificado").attr("checked", false);
                                            $("#form_test").find(':input').each(function() {
                                                       $(this).removeAttr("readonly").removeClass("disable");
                                            });
                                    
                                }
                            }
                        },
                        error: function(data,error,errorThrown){alert(error + errorThrown);}
                    });  
                }

                function sendFormGrupos(){
                      $("#form_test input[type=checkbox]:checked" ).each(function() {
                        var id= $( this ).attr( "id" );
                        $( "#VerEscondido").attr("disabled","disabled");
                      });

                      $("#form_test input[type=checkbox]:not(:checked)" ).each(function() {
                        var id= $( this ).attr( "id" );
                        $( "#VerEscondido").removeAttr("disabled");
                      });
                
                    $.ajax({
                        dataType: 'json',
                        type: 'POST',
                        url: './formularios/docentes/saveTalentoHumano.php',
                        data: $('#form_test').serialize(),                
                        success:function(data){
                            if (data.success == true){ 
                                 $("#idsiq_formInvestigacionesGruposInvestigacion").val(data.message);
                                 $("#form_test #action").val("updateDynamic2");
                                 $('#msg-success').html('<p>Los cambios han sido guardados de forma correcta.</p>');
                                 $('#form_test #msg-success').css('display','block');
                                 $("#form_test #msg-success").delay(5500).fadeOut(800);
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