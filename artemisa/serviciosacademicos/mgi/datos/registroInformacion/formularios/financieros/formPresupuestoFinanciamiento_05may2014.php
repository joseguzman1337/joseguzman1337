<?php
session_start();
require_once("../../../templates/template.php");
$db = getBD();
$utils = new Utils_datos();
?>

<form action="" method="post" id="financiamiento">                      
            <span class="mandatory">* Son campos obligatorios</span>
	      <fieldset>
		<?php
		$query_papa = "select idclasificacionesinfhuerfana,clasificacionesinfhuerfana from siq_clasificacionesinfhuerfana where aliasclasificacionesinfhuerfana='P_FIN_INST'";
                $papa= $db->Execute($query_papa);
                $totalRows_papa = $papa->RecordCount();
		$row_papa = $papa->FetchRow();
		?>                
		<legend><?php echo $row_papa['clasificacionesinfhuerfana']; ?></legend>
		<label for="anio" class="grid-2-12">Año: <span class="mandatory">(*)</span></label>
		<?php $utils->getYearsSelect("anio"); 
                 $utils->pintarBotonCargar("popup_cargarDocumento(13,5,$('#financiamiento #anio').val())","popup_verDocumentos(13,5,$('#financiamiento #anio').val())");?>

		<table align="center" id="estructuraReporte"  class="formData last" width="92%">
		    <thead>             			
			<tr id="dataColumns">
                            <th class="column borderR" ><span>Ingresos</span></th>
                            <th class="column borderR"><span>Presupuestado</span></th>
                            <th class="column borderR" ><span>Ejecutado</span></th>                            
			</tr>				
                   </thead>
		    <tbody>
		      <?php 
		      $query_sectores = "select idclasificacionesinfhuerfana,clasificacionesinfhuerfana from siq_clasificacionesinfhuerfana where idpadreclasificacionesinfhuerfana ='".$row_papa['idclasificacionesinfhuerfana']."' order by 2 ";
		      $sectores= $db->Execute($query_sectores);
		      $totalRows_sectores = $sectores->RecordCount();
		      while($row_sectores = $sectores->FetchRow()){      
		      ?>
		      <tr id="contentColumns" class="row">
			  <td class="column borderR" ><?php echo $row_sectores['clasificacionesinfhuerfana']; ?>:<span class="mandatory">(*)</span></td>
			  <td class="column borderR" ><input type="text" class="required number" minlength="" name="<?php echo $row_sectores['idclasificacionesinfhuerfana']; ?>/presupuestado" id="<?php echo $row_sectores['idclasificacionesinfhuerfana']; ?>/presupuestado" title="Presupuestado" maxlength="60" tabindex="1" autocomplete="off" size="15" /></td>
			  <td class="column borderR" ><input type="text" class="required number" minlength="" name="<?php echo $row_sectores['idclasificacionesinfhuerfana']; ?>/ejecutado" id="<?php echo $row_sectores['idclasificacionesinfhuerfana']; ?>/ejecutado" title="Ejecutado" maxlength="60" tabindex="1" autocomplete="off" size="15" /></td>
			  
		      </tr>
			<?php 
			}
			?>	
		     </tbody>
		  </table>
                <div class="vacio"></div>
                <div id="msg-success" class="msg-success" style="display:none"></div>
            </fieldset>
	      <input type="hidden" name="formulario" value="financiamiento" />
	      <input type="hidden" name="padre" value="<?php echo $row_papa['idclasificacionesinfhuerfana']; ?>" />
	     <input type="submit" id="enviafinanciamiento" value="Registrar datos" class="first" />
</form>

<script type="text/javascript">
    $(function(){
        $("#financiamiento input[type='text']").maskMoney({allowZero:true,thousands:',', decimal:'.',precision:0,allowNegative:false, defaultZero:false});
    });
    
                $('#enviafinanciamiento').click(function(event) {
                    event.preventDefault();
                    replaceCommas("#financiamiento");
                    var valido= validateForm("#financiamiento");
                    if(valido){
                        financiamiento();
                    }
                });

                function financiamiento(){//$('#form_test').serialize()

		    //var empresanacionale = $('#empresanacionale').val();
                    
		  $.ajax({//Ajax
				   type: 'GET',
				   url: 'formularios/financieros/savePresupuestos.php',
				   async: false,
				   dataType: 'json',
				   data:$('#financiamiento').serialize(),
				   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
				  success:function(data){
				    if (data.success == true){					  
					$('#financiamiento #msg-success').html('<p>' + data.message + '</p>');
					$('#financiamiento #msg-success').removeClass('msg-error');
					$('#financiamiento #msg-success').css('display','block');
                                        $("#financiamiento #msg-success").delay(5500).fadeOut(800);
				    }
				    else{                        
					$('#financiamiento #msg-success').html('<p>' + data.message + '</p>');
					$('#financiamiento #msg-success').addClass('msg-error');
					$('#financiamiento #msg-success').css('display','block');
                                        $("#financiamiento #msg-success").delay(5500).fadeOut(800);
				    }
				}
				//error: function(data,error,errorThrown){alert(error + errorThrown);}
				   
			}); //AJAX
                        addCommas("#financiamiento");

                }
</script>
