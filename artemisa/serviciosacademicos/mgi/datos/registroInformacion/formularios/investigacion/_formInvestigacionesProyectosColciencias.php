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
<form action="save.php" method="post" id="form_colciencias">
            <input type="hidden" name="entity" id="entity" value="formInvestigacionesProyectosColciencias" />
            <input type="hidden" name="action" value="save" id="action" />
            <input type="hidden" name="idsiq_formInvestigacionesProyectosColciencias" value="" id="idsiq_formInvestigacionesProyectosColciencias" />
            
            <span class="mandatory">* Son campos obligatorios</span>
            <fieldset id="numPersonas">   
                <legend>Proyectos presentados y aprobados en Colciencias</legend>
                
                <label class="fixedLabel" style="clear:none;width:90px">Año: <span class="mandatory">(*)</span></label>
                <?php $utils->getYearsSelect("codigoperiodo");  ?>
                <?php $utils->pintarBotonCargar("popup_cargarDocumento(".$id.",5,$('#form_colciencias #codigoperiodo').val())","popup_verDocumentos(".$id.",5,$('#form_colciencias #codigoperiodo').val())"); ?>
                
            <!--<input type="hidden" name="codigoperiodo" value="" id="codigoperiodo" />  -->                 
                
                <div class="vacio"></div>
                
                <table align="center" class="formData" width="92%" >
                    <thead>            
                        <tr class="dataColumns">
                            <th class="column" colspan="<?php if($aprobacion) echo "1"; else echo "2";?>"><span>Proyectos presentados y aprobados en Colciencias</span></th>    
                            <?php if($aprobacion){ ?>
                            <th class="column"><span>
                                <input type="hidden" value="0" name="VerEscondido" id="VerEscondido" />
				<input type="checkbox"  class="grid-4-12 required number" minlength="1" name="Verificado" id="Verificado" title="Verificado" maxlength="10" tabindex="1" autocomplete="off" value="1" />
	                   </span></th>  
                           <?php } ?>
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column" ><span>Proyectos presentados</span></th> 
                            <th class="column" ><span>No. de Proyectos</span></th> 
                        </tr>
                     </thead>
                     <tbody>
                        <tr class="dataColumns">
                            <td class="column ">Número de proyectos presentados por la Institución a COLCIENCIAS <span class="mandatory">(*)</span></td>
                            <td class="column"> 
                                <input type="text"  class="grid-4-12 required number" minlength="1" name="numProyectosPresentados" id="numProyectosPresentados"  maxlength="30" tabindex="1" autocomplete="off" value="" />
                            </td>
                        </tr>
                        <tr class="dataColumns">
                            <td class="column">Número de proyectos presentados a COLCIENCIAS a nivel Nacional <span class="mandatory">(*)</span></td>
                            <td class="column">
                                <input type="text"  class="grid-4-12 required number" minlength="1" name="numProyectosPresentadosColciencias" id="numProyectosPresentadosColciencias" maxlength="30" tabindex="1" autocomplete="off" value="" />
                            </td>
                        </tr>
                        <tr class="dataColumns">
                            <td class="column ">Número de proyectos aprobados por COLCIENCIAS de la Institución <span class="mandatory">(*)</span></td>
                            <td class="column"> 
                                <input type="text"  class="grid-4-12 required number" minlength="1" name="numProyectosAprobados" id="numProyectosAprobados"  maxlength="30" tabindex="1" autocomplete="off" value="" />
                            </td>
                        </tr>
                        <tr class="dataColumns">
                            <td class="column">Número de proyectos aprobados por COLCIENCIAS a nivel Nacional <span class="mandatory">(*)</span></td>
                            <td class="column">
                                <input type="text"  class="grid-4-12 required number" minlength="1" name="numProyectosAprobadosColciencias" id="numProyectosAprobadosColciencias" maxlength="30" tabindex="1" autocomplete="off" value="" />
                            </td>
                        </tr>
                    </tbody>
                </table>   
                
                <div class="vacio"></div>
                <div id="msg-success" class="msg-success" style="display:none"><p>Los cambios han sido guardados de forma correcta.</p></div>
            </fieldset>
            
            <input type="submit" id="submitColciencias" value="Guardar datos" class="first" />
        </form>
</div>
<script type="text/javascript">
    
    var aprobacion = '<?php echo $aprobacion; ?>';
    
    getDataColciencias();
    
                $('#submitColciencias').click(function(event) {
                    event.preventDefault();
                    var valido= validateForm("#form_colciencias");
                    if(valido){
                        sendFormGrupos();
                    }
                });
                
               // $('#form_colciencias #codigoperiodo').change(function(event) {
       $('#form_colciencias #codigoperiodo').bind('change', function(event) {
                    getDataColciencias();
                });
                
                function getDataColciencias(){
                    var periodo = $('#form_colciencias #codigoperiodo').val();
                    var entity = $("#form_colciencias #entity").val();
                    $.ajax({
                        dataType: 'json',
                        type: 'POST',
                        url: './formularios/docentes/saveTalentoHumano.php',
                        data: { periodo: periodo, action: "getData", entity: entity, campoPeriodo: "codigoperiodo" },     
                        success:function(data){
                            if (data.success == true){
                                 $("#idsiq_formInvestigacionesProyectosColciencias").val(data.data.idsiq_formInvestigacionesProyectosColciencias);
                                 $("#numProyectosPresentados").val(data.data.numProyectosPresentados);
                                 $("#numProyectosPresentadosColciencias").val(data.data.numProyectosPresentadosColciencias);
                                 $("#numProyectosAprobados").val(data.data.numProyectosAprobados);
                                 $("#numProyectosAprobadosColciencias").val(data.data.numProyectosAprobadosColciencias);    
                                 $("#form_colciencias #action").val("update");
                               $('#msg-success').html('<p>Los cambios han sido guardados de forma correcta.</p>');  
                             if(data.data.Verificado=="1"){ 
                                           $("#form_colciencias #Verificado").attr("checked", true);
                                           $('#form_colciencias #msg-success').html('<p> Ya esta validado</p>');
                                           $('#form_colciencias #msg-success').removeClass('msg-error');
                                           $('#form_colciencias #msg-success').css('display','block');
                                           $("#form_colciencias #msg-success").delay(5500).fadeOut(300);
                                           $("#form_colciencias #submitGrupos").attr('disabled','disabled');
                                           $("#form_colciencias").find(':input').each(function() {
                                                 $(this).removeAttr("readonly").addClass("disable");
                                                 $(this).removeAttr("disabled").addClass("disable");
                                            });
                                          }else{
                                               
                                              $("#form_colciencias").find(':input').each(function() {
                                                 $(this).removeAttr("readonly").removeClass("disable");
                                            }); 
                                           // $("#form_colciencias #enviafinanciamiento").removeAttr('disabled','disabled');
                                              $("#form_colciencias #Verificado").attr("checked", false);
                                            }
                                 //$("#form_colciencias #verificada_"+data.data.verificada).attr('checked', 'checked');
                            }
                            else{                        
                                //no se encontraron datos
                                if($("#idsiq_formInvestigacionesProyectosColciencias").val()!=""){
                                        var anio = $('#form_colciencias #codigoperiodo').val();
                                    document.forms["form_colciencias"].reset();         
                                            $('#form_colciencias #codigoperiodo').val(anio);
                                    $("#form_colciencias #action").val("save");
                                    $("#idsiq_formInvestigacionesProyectosColciencias").val("");
                                    $("#form_colciencias #Verificado").attr("checked", false);
                                            $("#form_colciencias").find(':input').each(function() {
                                                       $(this).removeAttr("readonly").removeClass("disable");
                                            }); 
                                }
                            }
                        },
                        error: function(data,error,errorThrown){alert(error + errorThrown);}
                    });  
                }

                function sendFormGrupos(){
                
                 $("#form_colciencias input[type=checkbox]:checked" ).each(function() {
                        var id= $( this ).attr( "id" );
                        $( "#VerEscondido").attr("disabled","disabled");
                      });

                      $("#form_colciencias input[type=checkbox]:not(:checked)" ).each(function() {
                        var id= $( this ).attr( "id" );
                        $( "#VerEscondido").removeAttr("disabled");
                      });
                      
                    $.ajax({
                        dataType: 'json',
                        type: 'POST',
                        url: './formularios/docentes/saveTalentoHumano.php',
                        data: $('#form_colciencias').serialize(),                
                        success:function(data){
                            if (data.success == true){ 
                                 $("#idsiq_formInvestigacionesProyectosColciencias").val(data.message);
                                 $("#form_colciencias #action").val("update");
                                 $("#form_colciencias #msg-success").html('<p>Los cambios han sido guardados de forma correcta.</p>');
                                 $('#form_colciencias #msg-success').css('display','block');
                                 $("#form_colciencias #msg-success").delay(5500).fadeOut(800);
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