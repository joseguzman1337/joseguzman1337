<?php
    require_once("../../../templates/template.php");
    $db = getBD();
    $utils = new Utils_datos();
?>
<div id="form_tres">
	
	<form  method="post" id="program_edu_tres" name="program_edu_tres" action="">
        <input type="hidden" name="action" value="SelectDynamic" id="action" />
        <input type="hidden" name="codigoperiodo" value="" id="codigoperiodo" />
        <input type="hidden" name="actividad" value="numero_programas" id="actividad" />
        <input type="hidden" name="procesID" value="registrar_abiertos_cerrados" id="procesID" />
        <input type="hidden" name="idmedioscontinuada" value="" id="idmedioscontinuada" />
		<?php
            
		$query_papa = "select idclasificacion,clasificacion from infoEducacionContinuada where alias='abierto'";
                $papa= $db->Execute($query_papa);
                foreach ( $papa  as $row_p){
                    $row_papa['idclasificacion']=$row_p['idclasificacion'];
                }
			?>
            <span class="mandatory">* Son campos obligatorios</span>
            <fieldset id="numPersonas">   
                <legend>Programas de Educaci&oacuten Continuada (abiertos o cerrados)</legend>
                
                              
                <div class="vacio"></div>
                
                <label for="nombre" class="fixedLabel">Mes: <span class="mandatory">(*)</span></label>
                <?php $utils->getMonthsSelect("mes");  ?>
                
                <label for="nombre" class="fixedLabel" style="clear:none;width:90px">Año: <span class="mandatory">(*)</span></label>
                <?php $utils->getYearsSelect("anio");  
                $utils->pintarBotonCargar("popup_cargarDocumento(14,3,$('#program_edu_tres #mes').val()+'-'+$('#program_edu_tres #anio').val())","popup_verDocumentos(14,3,$('#program_edu_tres #mes').val()+'-'+$('#program_edu_tres #anio').val())");
                    $sectores = $utils->getActives($db,"siq_sectores","idsiq_sectores");
                ?>
		<table align="center" class="formData last" width="92%" >
	                    <thead>            
	                        <tr class="dataColumns">
	                            <th class="column" colspan="2"><span>Programas de Educación Continuada (abiertos o cerrados)</span></th>                                    
	                        </tr>
	                         
	                        <tr class="dataColumns category" >
	                            <th  class="column borderR"  ><span >Tipos de Programas</span></th>
	                    		<th class="column borderR"><span>Cantidad</span></th>
	                    		<!--<th class="column borderR"   ><span>Procentaje</span></th>-->
	                    		
	                    	</tr>
	                   	</thead>
	                   	<tbody>
			                   <?php 
			                     	$query_sectores = "select idclasificacion,clasificacion from infoEducacionContinuada where idpadreclasificacion ='".$row_papa['idclasificacion']."'";
			                       	$sectores= $db->Execute($query_sectores);
                                                $i=0;
                                                 foreach ( $sectores  as $row_sectores){
                                                    $first = true;
                                                    ?> 
                                                    <tr id="contentColumns" class="row">

                                                                    <td class="column borderR" ><?php echo $row_sectores['clasificacion']; ?>:<span class="mandatory">(*)</span></td><div class="vacio"></div>
                                                                    <input type="hidden" name="tipo_programa[] " id="tipo_programa_<?php echo $row_sectores['idclasificacion']; ?>" value="<?php echo $row_sectores['idclasificacion']; ?>"/>
                                                                    <input type="hidden" name="id_ofrecidos[] " id="id_ofrecidos_<?php echo $row_sectores['idclasificacion']; ?>" />
                                                                    <td class="column borderR" ><input type="text" class="required number" minlength="" name="cantidad[]"id="cantidad_<?php echo $row_sectores['idclasificacion']; ?>"  title="Número" maxlength="60" tabindex="1" autocomplete="off" size="6" />
                                                                    <input type="hidden" name="procentaje[]" id="procentaje_<?php echo $row_sectores['idclasificacion']; ?>"  maxlength="60" tabindex="1" autocomplete="off" size="6" value="0"/></td>
                                                       </tr>		
							<?php }//while($row_sectores=$sectores->FetchRow())?>
						</tbody>               	 
	                       	
                            </table>
                            </fieldset>
                                    <div id="msg-success" class="msg-success" style="display:none"><p>Los datos han sido guardados de forma correcta.</p></div>
                                    <input type="submit" width="30px" alin id="submitprogram_edu_tres" value="Guardar datos" class="first" /> 
	</form>

</div>
		

<script type="text/javascript">
    var tipo=$("#actividad").val()
    getformulario_tres("#program_edu_tres");
    
         
                $('#submitprogram_edu_tres').click(function(event) {
                    event.preventDefault();
                    var valido= validateForm("#program_edu_tres");
                    if(valido){
                       //sendDetalleFormacionActividadesAcademicos("#form_DedicacionSemanal3");
                    
                       sendformulario_tres("#program_edu_tres");
                    }
                });
                
                $('#program_edu_tres'+' #mes').bind('change', function(event) {
                    getformulario_tres("#program_edu_tres");
                });
                
                $('#program_edu_tres'+' #anio').bind('change', function(event) {
                    getformulario_tres("#program_edu_tres");
                });
                
             
                function getformulario_tres(formName){
                    var periodo = $(formName + ' #mes').val()+"-"+$(formName + ' #anio').val();
                    var actividad = $(formName + " #actividad").val();
                    var entity = $(formName + " #entity").val();
                    $(formName + " #action").val('SelectDynamic');
                        $.ajax({
                            dataType: 'json',
                            type: 'POST',
                            url: "./formularios/academicos/procesarEducacionCon.php",
                            data: $(formName).serialize(),      
                            success:function(data){
                                if (data.success == true){
                                    for (var i=0;i<data.total;i++){   
                                     //  alert(data[i].id_ofrecidos+'-->'+data[i].tipo_programa+'-->'+data[i].id_ofrecidos+'-->'+data[i].cantidad_salud+'-->'+data[i].cantidad_nucleo+'-->'+data[i].cantidad_academica);                                
                                        $(formName + " #tipo_programa_"+data[i].tipo_programa).val(data[i].tipo_programa);
                                        $(formName + " #id_ofrecidos_"+data[i].tipo_programa).val(data[i].id_ofrecidos);
                                        $(formName + " #cantidad_"+data[i].tipo_programa).val(data[i].cantidad);
                                        $(formName + " #procentaje"+data[i].tipo_programa).val(data[i].procentaje);
                                      }
                                    $(formName + " #action").val("UpdateDynamic");
                                    
                                }else{                        
                                    var mes = $(formName + ' #mes').val();
                                    var anio = $(formName + ' #anio').val();
                                    document.forms[formName.replace("#","")].reset();
                                    $(formName + ' #mes').val(mes);
                                    $(formName + ' #anio').val(anio);
                                    $(formName + " #action").val("SaveDynamic");
                                            
                                }
                            },
                            error: function(data,error,errorThrown){alert(error + errorThrown);}
                        }); 
                 }
                
                function sendformulario_tres(formName){
                    //alert('aca..')
                
//                    var periodo = $(formName +' #mes').val()+"-"+$(formName + ' #anio').val();
//                    
//                    $(formName + " #codigoperiodo").val(periodo)
//                    var entity = $(formName + " #entity1").val();
//                    var anio = $(formName + " #anio").val();
//                    var mes = $(formName + " #mes").val();
                    
                    //$(formName + " #action").val("SaveDynamic");
                    $.ajax({
                        dataType: 'json',
                        type: 'POST',
                         url: "./formularios/academicos/procesarEducacionCon.php",
                         data: $(formName).serialize(),                
                        success:function(data){
                            if (data.success == true){
                                 $(formName + " #msg-success").css('display','');
                                 $(formName + " #msg-success").html('<p>' + data.descrip + '</p>');
                                 $(formName + " #msg-success").delay(900).fadeOut(800);
                                // getformulario_tres("#program_edu_tres");
                            }
                        },
                        error: function(data,error,errorThrown){alert(error + errorThrown);}
                    });            
                }
                
//                           
</script>
