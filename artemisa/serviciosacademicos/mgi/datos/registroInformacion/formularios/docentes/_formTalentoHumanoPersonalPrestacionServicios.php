<?php
    require_once("../../../templates/template.php");
    $db = getBD();
    $utils = new Utils_datos();
    $actividades = $utils->getActives($db,"siq_actividadPrestacionServicios","nombre");
?>
<div id="tabs-4">
<form action="save.php" method="post" id="form_prestacion">
            <input type="hidden" name="entity" id="entity" value="formTalentoHumanoPersonalPrestacionServicios" />
            <input type="hidden" name="action" value="saveDynamic" id="action" />
            <!--<input type="hidden" name="verificar" value="1" id="verificar" />-->
            
            <span class="mandatory">* Son campos obligatorios</span>
            <fieldset id="numPersonas">   
                <legend>Personal por prestación de servicios</legend>                  
                  <label class="fixedLabel">Mes: <span class="mandatory">(*)</span></label>
                <?php $utils->getMonthsSelect(); ?>
                
                <label class="fixedLabel" style="clear:none;width:90px">Año: <span class="mandatory">(*)</span></label>
                <?php $utils->getYearsSelect("anio");  ?>
            <input type="hidden" name="idsubperiodo" value="" id="idsubperiodo" />     
                
                                <?php $utils->pintarBotonCargar("popup_cargarDocumento(5,4,$('#form_prestacion #mes').val()+'-'+$('#form_prestacion #anio').val())","popup_verDocumentos(5,4,$('#form_prestacion #mes').val()+'-'+$('#form_prestacion #anio').val())"); ?>
                
                <div class="vacio"></div>
                
                <!--<label for="nombre" class="fixed">Información verificada: <span class="mandatory">(*)</span></label>
                &nbsp;&nbsp;<input type="radio" name="verificada" id="verificada_1" value="1"> <span style="font-size:0.8em">Si</span> &nbsp;
                <input type="radio" name="verificada" value="0" id="verificada_0" checked> <span style="font-size:0.8em">No</span><br/><br/>-->
                                
                <table align="center" class="formData last" width="80%" >
                    <thead>            
                        <tr class="dataColumns">
                            <th class="column" colspan="4"><span>Personal por prestación de servicios</span></th>                                    
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column" ><span>Actividad</span></th> 
                            <th class="column" ><span>Número de Personas</span></th> 
                            <!--<th class="column" ><span>Dato verificado</span></th>    -->   
                        </tr>
                     </thead>
                     <tbody>
                         <?php while ($row = $actividades->FetchRow()) { ?>

                            <tr class="dataColumns">
                                <td class="column"><?php echo $row["nombre"]; ?> <span class="mandatory">(*)</span>
                                    <input type="hidden"  class="grid-3-12 required number" minlength="1" name="idActividad[]" id="idActividad_<?php echo $row["idsiq_actividadPrestacionServicios"]; ?>" value="<?php echo $row["idsiq_actividadPrestacionServicios"]; ?>" />
                                    <input type="hidden" name="idsiq_formTalentoHumanoPersonalPrestacionServicios[]" value="" id="idsiq_formTalentoHumanoPersonalPrestacionServicios_<?php echo $row["idsiq_actividadPrestacionServicios"]; ?>" />
                                </td>
                                <td class="column"> 
                                    <input type="text"  class="grid-7-12 required number" minlength="1" name="numPersonas[]" id="numPersonas_<?php echo $row["idsiq_actividadPrestacionServicios"]; ?>" maxlength="30" tabindex="1" autocomplete="off" value=""  />
                                </td>
                                <!--<td class="column center"> 
                                    <input type="checkbox" name="veri[]" class="verificarDato" value="1" id="veri_<?php echo $row["idsiq_actividadPrestacionServicios"]; ?>" >
                                    <input type="hidden" name="verificada[]" value="0" id="verificada_<?php echo $row["idsiq_actividadPrestacionServicios"]; ?>" >
                                </td>-->
                            </tr>
   
                        <?php } ?>                        
                    </tbody>
                </table> 
		<br><br>
                <table align="center" class="formData last" width="80%" id="formCostoServicios">
                     <tbody>
                            <tr class="dataColumns">
                            	<th class="column" ><span>Costo Total Mensual de los Servicios</span></th> 
                                <td class="column">
            			    <input type="hidden" name="idsiq_formTalentoHumanoPersonalPrestacionServiciosCostoServicios" value="" id="idsiq_formTalentoHumanoPersonalPrestacionServiciosCostoServicios" />
                                    <input type="text" class="grid-7-12 required number" minlength="1" name="costoServicios" id="costoServicios" maxlength="30" tabindex="1" autocomplete="off" value=""  />
                                </td>
                            </tr>
                    </tbody>
                </table> 
                <div class="vacio"></div>
                <div id="msg-success" class="msg-success" style="display:none"><p>Los cambios han sido guardados de forma correcta.</p></div>
            </fieldset>
            
            <input type="submit" id="submitPrestacion" value="Guardar datos" class="first" /> 
        </form>
</div>

<script type="text/javascript">
    getDataPrestacion();
	
	$(function(){
	  $("#form_prestacion input").maskMoney({allowZero:true,thousands:',', decimal:'.',precision:0,allowNegative:false, defaultZero:false});
	});
    
       /* $(document).ready(function(){  
      
            $(".verificarDato").change(function() {  
                if(this.checked) {  
                    var id = $(this).attr('id').replace("veri_","");
                    $("#verificada_"+id).val(1);
                } else {  
                    var id = $(this).attr('id').replace("veri_","");
                    $("#verificada_"+id).val(0);
                }  
            });  

        });  */
    
                $('#submitPrestacion').click(function(event) {
                    event.preventDefault();
				replaceCommas("#form_prestacion");
                    var valido= validateForm("#form_prestacion");
                    if(valido){
                        sendFormPrestacion();
                    }
                });
                
                $('#form_prestacion #mes').add($('#form_prestacion #anio')).bind('change', function(event) {
                    getDataPrestacion();
                });
                
                function getDataPrestacion(){
                    $.ajax({
                        dataType: 'json',
			async: false,
                        type: 'POST',
                        url: './formularios/docentes/buscarSubperiodo.php',
                        data: { anio: $('#form_prestacion #anio').val(), mes: $('#form_prestacion #mes').val() },     
                        success:function(data){
                            if (data!=null && data.success == true){
                                 $("#idsubperiodo").val(data.idSub);
                            } else {
                                $('#msg-error').html('<p>' + data.message + '</p>');
                                $('#msg-error').addClass('msg-error');
			    }
                        },
                        error: function(data,error,errorThrown){alert(error + errorThrown);}
                    });            
                    var subperiodo = $('#form_prestacion #idsubperiodo').val();
                    var entity = $("#form_prestacion #entity").val();
                    $.ajax({
                        dataType: 'json',
                        type: 'POST',
                        url: './formularios/docentes/saveTalentoHumano.php',
                        data: { periodo: subperiodo, action: "getData", entity: "formTalentoHumanoPersonalPrestacionServiciosCostoServicios", campoPeriodo: "idsubperiodo" },     
                        success:function(data){
                            if (data!=null && data.success == true){
                                 $("#costoServicios").val(data.data.costoServicios);
								 addCommas("#form_prestacion");
                                 $("#idsiq_formTalentoHumanoPersonalPrestacionServiciosCostoServicios").val(data.data.idsiq_formTalentoHumanoPersonalPrestacionServiciosCostoServicios);
                            } else {
                                 $("#costoServicios").val("");
                                 $("#idsiq_formTalentoHumanoPersonalPrestacionServiciosCostoServicios").val("");
			                }
                        },
                        error: function(data,error,errorThrown){alert(error + errorThrown);}
                    });            
                    $.ajax({
                        dataType: 'json',
                        type: 'POST',
                        url: './formularios/docentes/saveTalentoHumano.php',
                        data: { periodo: subperiodo, action: "getDataDynamic", entity: entity, 
                            campoPeriodo: "idsubperiodo", entityJoin: "siq_actividadPrestacionServicios",
                            campoJoin: "idActividad",order:"ORDER BY nombre ASC"},     
                            success:function(data){
                            if (data!=null && data.success == true && data.data!=false){
                                var i=0
								for (var i=0;i<data.total;i++)
								{
                                 //$('input[name="idActividad[]"]').each(function() {                                     
                                        $("#idActividad_"+data.data[i]["idActividad"]).val(data.data[i]["idActividad"]);
                                        $("#idsiq_formTalentoHumanoPersonalPrestacionServicios_"+data.data[i]["idActividad"]).val(data.data[i]["idsiq_formTalentoHumanoPersonalPrestacionServicios"]);
                                        $("#numPersonas_"+data.data[i]["idActividad"]).val(data.data[i]["numPersonas"]);
                                        
                                        /*if(data.data[i]["verificada"]==1){
                                             $("#veri_"+data.data[i]["idActividad"]).attr('checked', true);
                                        } else {
                                             $("#veri_"+data.data[i]["idActividad"]).attr('checked', false);
                                        }
                                        $("#verificada_"+data.data[i]["idActividad"]).val(data.data[i]["verificada"]);*/
                                       // i = i + 1;
                                    //});
								}
                                 $("#form_prestacion #action").val("updateDynamic");
                                 //$("#form_prestacion #verificada_"+data.data[0]["verificada"]).attr('checked', 'checked');
                            }
                            else{                        
                                //no se encontraron datos
                                var i = 0;
                                $('input[name="idsiq_formTalentoHumanoPersonalPrestacionServicios[]"]').each(function() {
                                       if( ($(this).val()!="") && (i==0)){
                                           var mes = $('#form_prestacion #mes').val();
                                        var anio = $('#form_prestacion #anio').val();
                                             document.forms["form_prestacion"].reset();
                                                    $('#form_prestacion #mes').val(mes);
                                            $('#form_prestacion #anio').val(anio);
                                   $("#form_prestacion #action").val("saveDynamic"); 
                                       } 
                                       $(this).val("");
                                       i = 1;
                                });
                                $('input:checkbox').removeAttr('checked');
                            }
                        },
                        error: function(data,error,errorThrown){alert(error + errorThrown);}
                    });  
                }

                function sendFormPrestacion(){
                var subperiodo = $('#form_prestacion #idsubperiodo').val();
                var costoServicios = $("#form_prestacion #costoServicios").val();
                var idsiq_formTalentoHumanoPersonalPrestacionServiciosCostoServicios = $("#form_prestacion #idsiq_formTalentoHumanoPersonalPrestacionServiciosCostoServicios").val();
                var action = $("#form_prestacion #action").val()=="saveDynamic" ? "save" : "update";
		if(action=="update" && $('#idsiq_formTalentoHumanoPersonalPrestacionServiciosCostoServicios').val()=='')
			action="save";
		
                $('#form_prestacion #idsubperiodo').val(subperiodo);
                    $.ajax({
                        dataType: 'json',
                        type: 'POST',
                        url: './formularios/docentes/saveTalentoHumano.php',
                        data: { costoServicios: costoServicios, idsubperiodo: subperiodo, idsiq_formTalentoHumanoPersonalPrestacionServiciosCostoServicios: idsiq_formTalentoHumanoPersonalPrestacionServiciosCostoServicios, action: action, entity: "formTalentoHumanoPersonalPrestacionServiciosCostoServicios"},     
                        success:function(data){
                                 $("#idsiq_formTalentoHumanoPersonalPrestacionServiciosCostoServicios").val(data.message);
			},
                        error: function(data,error,errorThrown){alert(error + errorThrown);}
                    });            
                    $.ajax({
                        dataType: 'json',
                        type: 'POST',
                        url: './formularios/docentes/saveTalentoHumano.php',
                        data: $('#form_prestacion').serialize(),                
                        success:function(data){
							addCommas("#form_prestacion");   
                            if (data!=null && data.success == true){
                                 //window.location.href="./viewData.php?id=row_<?php //echo $_GET["id"]; ?>";
                                 $("#form_prestacion #action").val("updateDynamic");
                                 $('#form_prestacion #msg-success').css('display','block');
                                 $("#form_prestacion #msg-success").delay(5500).fadeOut(800);
                                 var i=0
                                 $('input[name="idsiq_formTalentoHumanoPersonalPrestacionServicios[]"]').each(function() {
                                        $(this).val(data.data[i]);
                                        i = i + 1;
                                    });                                
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
