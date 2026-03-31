<?php
    require_once("../../../templates/template.php");
    $db = getBD();
    $utils = new Utils_datos();
    $tipo=$_REQUEST['tipo'];
    
   // echo $tipo.'-->';
?>

<div id="tabs-13">
<form action="save.php" method="post" id="formulario_edu_dos">
            <input type="hidden" name="entity" id="entity" value="numeroProgramaMesesContinuada" />
            <input type="hidden" name="action" value="SelectDynamic" id="action" />
            <input type="hidden" name="codigoperiodo" value="" id="codigoperiodo" />
            <input type="hidden" name="actividad" value="numero_programas" id="actividad" />
            <input type="hidden" name="procesID" value="registrar_ProgramasOfrecidos" id="procesID" />
            <input type="hidden" name="idmedioscontinuada" value="" id="idmedioscontinuada" />
            		<?php
            
	       $query_papa = "select idclasificacion,clasificacion from infoEducacionContinuada where alias='ofreci'";
                $papa= $db->Execute($query_papa);
                foreach ( $papa  as $row_p){
                    $row_papa['idclasificacion']=$row_p['idclasificacion'];
                }
		?>
            <span class="mandatory">* Son campos obligatorios</span>
            <fieldset id="numPersonas">   
                <legend>N&uacute;mero de programas ofrecidos por la divisi&oacute;n</legend>
                
                <label class="fixedLabel">Mes: <span class="mandatory">(*)</span></label>
                <?php $utils->getMonthsSelect(); ?>
                
                <label class="fixedLabel" style="clear:none;width:90px">Año: <span class="mandatory">(*)</span></label>
                <?php $utils->getYearsSelect("anio");  ?>
                <?php $sectores = $utils->getActives($db,"siq_sectores","idsiq_sectores"); ?>
                <?php $nivelFormacion  = $utils->getAll($db,"siq_tipoNivelFormacion","actividad=".$tipo." AND codigoestado=100","nombre"); ?>
                <?php $utils->pintarBotonCargar("popup_cargarDocumento(5,13,$('#formulario_edu_dos #mes').val()+'-'+$('#formulario_edu_dos #anio').val())","popup_verDocumentos(5,13,$('#formulario_edu_dos #mes').val()+'-'+$('#formulario_edu_dos #anio').val())"); ?>
            
                                
                <table align="center" class="formData last" width="92%" >
                    <thead>            
	                        <tr class="dataColumns">
	                            <th class="column" colspan="5"><span>Número de programas ofrecidos por la división</span></th>                                    
	                        </tr>
	                         
	                        <tr class="dataColumns category">
	                            <th class="column borderR"  ><span>Tipos de Programas</span></th>
	                    		<th class="column borderR"  ><span>Salud</span></th>
	                    		<th class="column borderR"  ><span>Calidad de vida</span></th>
	                    		<th class="column borderR" ><span>Núcleo Estratégico</span></th>
	                    		<th class="column borderR" ><span>Unidad Académica</span></th>
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
                                <tr class="dataColumns">
                                        <td class="column borderR" ><?php echo $row_sectores['clasificacion']; ?>:<span class="mandatory">(*)</span></td>
                                                <input type="hidden" name="tipo_programa[] " id="tipo_programa_<?php echo $row_sectores['idclasificacion']; ?>" value="<?php echo $row_sectores['idclasificacion']?>" />
                                                <input type="hidden" name="id_ofrecidos[] " id="id_ofrecidos_<?php echo $row_sectores['idclasificacion']; ?>" />
                                                <td class="column borderR" ><input type="text" class="required number" minlength="" name="cantidad_salud[]" id="cantidad_salud_<?php echo $row_sectores['idclasificacion']; ?>" title="Número" maxlength="60" tabindex="1" autocomplete="off" size="6" /></td>
                                                <td class="column borderR" ><input type="text" class="required number" minlength="" name="cantidad_vida[]" id="cantidad_vida_<?php echo $row_sectores['idclasificacion']; ?>" title="Número" maxlength="60" tabindex="1" autocomplete="off" size="6" /></td>
                                                <td class="column borderR" ><input type="text" class="required number" minlength="" name="cantidad_nucleo[]" id="cantidad_nucleo_<?php echo $row_sectores['idclasificacion']; ?>" title="Número" maxlength="60" tabindex="1" autocomplete="off" size="6" /></td>
                                                <td class="column borderR" ><input type="text" class="required number" minlength="" name="cantidad_academica[]" id="cantidad_academica_<?php echo $row_sectores['idclasificacion']; ?>" title="Número" maxlength="60" tabindex="1" autocomplete="off" size="6" /></td>
                                </tr>
                        <?php  } ?>        
                    </tbody>
                </table>                   
                
                <div id="msg-success" class="msg-success" style="display:none"><p>Los datos han sido guardados de forma correcta.</p></div>
            </fieldset>
            
            <input type="submit" id="submitformulario_edu_dos" value="Guardar datos" class="first" /> 
        </form>
</div>

<script type="text/javascript">
    var tipo=$("#actividad").val()
    getformulario_dos("#formulario_edu_dos");
    
         
                $('#submitformulario_edu_dos').click(function(event) {
                    event.preventDefault();
                    var valido= validateForm("#formulario_edu_dos");
                    if(valido){
                       //sendDetalleFormacionActividadesAcademicos("#form_DedicacionSemanal3");
                    
                       sendFormFormacionDedicacionSemanal3("#formulario_edu_dos");
                    }
                });
                
                $('#formulario_edu_dos'+' #mes').bind('change', function(event) {
                    getformulario_dos("#formulario_edu_dos");
                });
                
                $('#formulario_edu_dos'+' #anio').bind('change', function(event) {
                    getformulario_dos("#formulario_edu_dos");
                });
                
             
                function getformulario_dos(formName){
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
                                        $(formName + " #cantidad_salud_"+data[i].tipo_programa).val(data[i].cantidad_salud);
                                        $(formName + " #cantidad_vida_"+data[i].tipo_programa).val(data[i].cantidad_vida);
                                        $(formName + " #cantidad_nucleo_"+data[i].tipo_programa).val(data[i].cantidad_nucleo);
                                        $(formName + " #cantidad_academica_"+data[i].tipo_programa).val(data[i].cantidad_academica);
                                        
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
                
                function sendFormFormacionDedicacionSemanal3(formName){
                    var periodo = $(formName +' #mes').val()+"-"+$(formName + ' #anio').val();
                    
                    $(formName + " #codigoperiodo").val(periodo)
                    var entity = $(formName + " #entity1").val();
                    var anio = $(formName + " #anio").val();
                    var mes = $(formName + " #mes").val();
                  //  $(formName + " #action").val("SaveDynamic");
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
                                // getformulario_dos("#formulario_edu_dos");
                            }
                        },
                        error: function(data,error,errorThrown){alert(error + errorThrown);}
                    });            
                }
                
//                           
</script>
