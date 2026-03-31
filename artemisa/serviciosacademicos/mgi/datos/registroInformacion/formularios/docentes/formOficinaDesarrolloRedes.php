<?php
session_start();
require_once("../../../templates/template.php");
$db = getBD();
$utils = new Utils_datos();
$urlprocesa="./formularios/".$categoria["alias"]."/save".$formulario["alias"].".php";

?>

<form action="" method="post" id="redes">                      
            <span class="mandatory">* Son campos obligatorios</span>
	      <fieldset>		
                <legend>Número de Redes Nacionales e Internacionales por Programa Académico</legend>
		<label for="anio" class="grid-2-12">Año: <span class="mandatory">(*)</span></label>
		<?php $utils->getYearsSelect("anio");
                $utils->pintarBotonCargar("popup_cargarDocumento(6,4,$('#redes #anio').val())","popup_verDocumentos(6,4,$('#redes #anio').val())");  ?>


		<table align="center" id="estructuraReporte"  class="formData last" width="92%">
		    <thead>            			
			<tr id="dataColumns">
			    <th class="column borderR" rowspan="2"><span>Programa</span></th>
			    <th class="column" colspan="2"><span>Ambito</span></th>			    
			</tr>
			<tr id="dataColumns">
			    <th class="column"><span>Nacional</span></th>
			    <th class="column"><span>Internacional</span></th>
			</tr>	     
		    </thead>
		    <tbody>
		      <?php 
		      $query_sectores = "Select codigocarrera, nombrecarrera 
					from carrera 
					where codigomodalidadacademica=200 
					and now() between fechainiciocarrera and fechavencimientocarrera 
					and codigocarrera<>1 
					order by nombrecarrera";
		      $sectores= $db->Execute($query_sectores);
		      $totalRows_sectores = $sectores->RecordCount();
		      while($row_sectores = $sectores->FetchRow()){      
		      ?>
		      <tr id="contentColumns" class="row">
			  <td class="column borderR" ><?php echo $row_sectores['nombrecarrera']; ?>:<span class="mandatory">(*)</span></td>
			  <td class="column" ><input type="text" class="required number" minlength="" name="<?php echo $row_sectores['codigocarrera']; ?>/nacional" id="<?php echo $row_sectores['codigocarrera']; ?>/nacional" title="Número" maxlength="60" tabindex="1" autocomplete="off" size="15" /></td>
			  <td class="column" ><input type="text" class="required number" minlength="" name="<?php echo $row_sectores['codigocarrera']; ?>/intnacional" id="<?php echo $row_sectores['codigocarrera']; ?>/intnacional" title="Número" maxlength="60" tabindex="1" autocomplete="off" size="15" /></td>
		      </tr>
			<?php 
			}
			?>	
		     </tbody>
		  </table>
                <div class="vacio"></div>
                <div id="msg-success" class="msg-success" style="display:none"></div>
            </fieldset>
	      <input type="hidden" name="formulario" value="redes" />
	     <input type="submit" value="Registrar datos" class="first" />
</form>

<script type="text/javascript">
                $(':submit').click(function(event) {
                    event.preventDefault();
                    var valido= validateForm("#redes");
                    if(valido){
                        sendForm();
                    }
                });

                function sendForm(){//$('#form_test').serialize()

		    //var empresanacionale = $('#empresanacionale').val();
                    
		  $.ajax({//Ajax
				   type: 'GET',
				   url: 'formularios/docentes/saveOficinaDesarrollo.php',
				   async: false,
				   dataType: 'json',
				   data:$('#redes').serialize(),
				   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
				  success:function(data){
				    if (data.success == true){
					$('#redes #msg-success').html('<p>' + data.message + '</p>');
					$('#redes #msg-success').removeClass('msg-error');
					$('#redes #msg-success').css('display','block');
                                        $("#redes #msg-success").delay(5500).fadeOut(800);
				    }
				    else{                        
					$('#redes #msg-success').html('<p>' + data.message + '</p>');
					$('#redes #msg-success').addClass('msg-error');
					$('#redes #msg-success').css('display','block');
                                        $("#redes #msg-success").delay(5500).fadeOut(800);
				    }
				}
				//error: function(data,error,errorThrown){alert(error + errorThrown);}
				   
			}); //AJAX

                }
</script>
