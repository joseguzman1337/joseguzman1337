<?php
session_start();
require_once("../../../templates/template.php");
$db = getBD();
$utils = new Utils_datos();
?>

<form action="" method="post" id="CapTic">      
         <input type="hidden" name="action" value="SelectDynamic" id="action" />
    <input type="hidden" name="codigoperiodo" value="" id="codigoperiodo" />
    <input type="hidden" name="formulario" value="CapTic" />
    <?php
		$query_papa = "select idclasificacionesinfhuerfana,clasificacionesinfhuerfana from siq_clasificacionesinfhuerfana where aliasclasificacionesinfhuerfana='T_CTIC'";
                $papa= $db->Execute($query_papa);
                $totalRows_papa = $papa->RecordCount();
		$row_papa = $papa->FetchRow();
		?>  
    <input type="hidden" name="padre" value="<?php echo $row_papa['idclasificacionesinfhuerfana']; ?>" />
            <span class="mandatory">* Son campos obligatorios</span>
	      <fieldset>
		              
		<legend><?php echo $row_papa['clasificacionesinfhuerfana']; ?></legend>
                
                <label class="fixedLabel">Mes: <span class="mandatory">(*)</span></label>
                <?php $utils->getMonthsSelect(); ?>
                
                <label class="fixedLabel" style="clear:none;width:90px">Año: <span class="mandatory">(*)</span></label>
                <?php $utils->getYearsSelect("anio");  ?>
                <input type="hidden" name="semestre" value="" id="semestre" />       
                
		<!--<label for="semestre" class="grid-2-12">Semestre: <span class="mandatory">(*)</span></label>-->
		<?php //$utils->getSemestresSelect($db,"semestre");
                $utils->pintarBotonCargar("popup_cargarDocumento(10,7,$('#CapTic #mes').val()+'-'+$('#CapTic #anio').val())","popup_verDocumentos(10,7,$('#CapTic #mes').val()+'-'+$('#CapTic #anio').val())"); ?>

		<table align="center" id="estructuraReporte"  class="formData last" width="92%">
		    <thead>             			
			<tr id="dataColumns">
                            <th class="column borderR" ><span>Herramienta Tecnológica</span></th>
                            <th class="column borderR" ><span>Cantidad</span></th>
                            <th class="column borderR" ><span>Tipo Usuario</span></th>                            
			</tr>
                   </thead>
		    <tbody>
		      <?php 
		      $query_sectores = "select idclasificacionesinfhuerfana,clasificacionesinfhuerfana from siq_clasificacionesinfhuerfana where idpadreclasificacionesinfhuerfana ='".$row_papa['idclasificacionesinfhuerfana']."' 
                          AND estado=1 order by 2 ";
		      $sectores= $db->Execute($query_sectores);
		      $totalRows_sectores = $sectores->RecordCount();
		      while($row_sectores = $sectores->FetchRow()){      
		      ?>
                      <tr id="contentColumns" class="row">
			  <td class="column borderR" ><?php echo $row_sectores['clasificacionesinfhuerfana']; ?>:<span class="mandatory">(*)</span>
                          <input type="hidden" name="idsiq_tecnololgia[] " id="idsiq_tecnololgia_<?php echo $row_sectores['idclasificacionesinfhuerfana']; ?>" />
                          <input type="hidden" name="idclasificacionesinfhuerfana[] " id="idclasificacionesinfhuerfana_<?php echo $row_sectores['idclasificacionesinfhuerfana']; ?>" value="<?php echo $row_sectores['idclasificacionesinfhuerfana']; ?>" /> 
                          </td>
			  <td class="column borderR" ><input type="text" class="required number" minlength="" name="cantidad[]" id="cantidad_<?php echo $row_sectores['idclasificacionesinfhuerfana']; ?>" title="Cantidad" maxlength="60" tabindex="1" autocomplete="off" size="15" /></td> 
                          <td class="column borderR" ><input type="text" class="required inputTable grid-11-12" minlength="" name="caracteristicas[]" id="caracteristicas_<?php echo $row_sectores['idclasificacionesinfhuerfana']; ?>" title="Cantidad" maxlength="60" tabindex="1" autocomplete="off" size="15" /></td> 
		      
                      </tr> 
			<?php 
			}
			?>	
		     </tbody>
		  </table>
                <div class="vacio"></div>
                <div id="msg-success" class="msg-success" style="display:none"></div>
            </fieldset>
	     <input type="submit" id="enviaCapTic" value="Registrar datos" class="first" />
</form>

<script type="text/javascript">
    
     getformulario_equipoenviaCapTic("#CapTic");
    
    $('#CapTic'+' #mes').bind('change', function(event) {
         getformulario_equipoenviaCapTic("#CapTic");
    });
   
    $('#CapTic'+' #anio').bind('change', function(event) {
         getformulario_equipoenviaCapTic("#CapTic");
    });
    
    function getformulario_equipoenviaCapTic(formName){
                    var periodo = $(formName + ' #mes').val()+"-"+$(formName + ' #anio').val();
                    $(formName + ' #semestre').val(periodo)
                    $(formName + " #action").val('SelectDynamic');
                        $.ajax({
                            dataType: 'json',
                            type: 'POST',
                            url: 'formularios/recursosFisicos/saveOficinaTecnologia.php',
                            data: $(formName).serialize(),      
                            success:function(data){
                                if (data.success == true){
                                    for (var i=0;i<data.total;i++){   
                                       // alert(formName+'-->'+data[i].idsiq_tecnologia+'-->'+data[i].idclasificacionesinfhuerfana+'-->'+data[i].cantidad);                                
                                        $(formName + " #idsiq_tecnololgia_"+data[i].idclasificacionesinfhuerfana).val(data[i].idsiq_tecnologia);
                                        $(formName + " #idclasificacionesinfhuerfana_"+data[i].idclasificacionesinfhuerfana).val(data[i].idclasificacionesinfhuerfana);
                                        $(formName + " #cantidad_"+data[i].idclasificacionesinfhuerfana).val(data[i].cantidad);
                                        $(formName + " #caracteristicas_"+data[i].idclasificacionesinfhuerfana).val(data[i].caracteristicas);
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
                 
                $('#enviaCapTic').click(function(event) {
                    event.preventDefault();
                    var valido= validateForm("#CapTic");
                    if(valido){
                        CapTic();
                    }
                });

                function CapTic(){//$('#form_test').serialize()
                    var periodo = $('#CapTic  #mes').val()+"-"+$('#CapTic  #anio').val();
                    $('#CapTic  #semestre').val(periodo)
		    //var empresanacionale = $('#empresanacionale').val();
                    
		  $.ajax({//Ajax
				   type: 'GET',
				   url: 'formularios/recursosFisicos/saveOficinaTecnologia.php',
				   async: false,
				   dataType: 'json',
				   data:$('#CapTic').serialize(),
				   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
				  success:function(data){
				    if (data.success == true){		
     getformulario_equipoenviaCapTic("#CapTic");			  
					$('#CapTic #msg-success').html('<p>' +  data.descrip+ '</p>');
					$('#CapTic #msg-success').removeClass('msg-error');
					$('#CapTic #msg-success').css('display','block');
                                        $("#CapTic #msg-success").delay(5500).fadeOut(800);
				    }
				    else{                        
					$('#CapTic #msg-success').html('<p>' +  data.descrip + '</p>');
					$('#CapTic #msg-success').addClass('msg-error');
					$('#CapTic #msg-success').css('display','block');
                                        $("#CapTic #msg-success").delay(5500).fadeOut(800);
				    }
				}
				//error: function(data,error,errorThrown){alert(error + errorThrown);}
				   
			}); //AJAX

                }
</script>
