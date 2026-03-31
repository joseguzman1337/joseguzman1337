<?php
session_start();
require_once("../../../templates/template.php");
$db = getBD();
$utils = new Utils_datos();
$urlprocesa="./formularios/".$categoria["alias"]."/save".$formulario["alias"].".php";
?>

<form action="" method="post" id="asociaciones">                      
            <span class="mandatory">* Son campos obligatorios</span>
	      <fieldset>		
                <legend>Número de redes y asociaciones Institucionales</legend>
		<label for="semestre" class="grid-2-12">Semestre: <span class="mandatory">(*)</span></label>
		<?php $utils->getSemestresSelect($db,"semestre"); ?>

		<table align="center" id="estructuraReporte"  class="formData last" width="92%">
		    <thead>            			
			<tr id="dataColumns">
			    <th class="column borderR" rowspan="2"><span>Redes y Asociaciones</span></th>
			    <th class="column borderR" colspan="2"><span>Ambito</span></th>			    
			</tr>
			<tr id="dataColumns">
			    <th class="column"><span>Nacional</span></th>
			    <th class="column borderR"><span>Internacional</span></th>
			</tr>	     
		    </thead>
		    <tbody>		      
		      <tr id="contentColumns" class="row">
			  <td class="column borderR" ><input type="text" class="grid-11-12 required inputTable" minlength="" name="nombreaso" id="nombreaso" title="Nombre" maxlength="60" tabindex="1" autocomplete="off" /></td>
			  <td class="column" ><input type="text" class="required number" minlength="" name="nacional" id="nacional" title="Nacional" maxlength="60" tabindex="1" autocomplete="off" size="15" /></td>
			  <td class="column borderR" ><input type="text" class="required number" minlength="" name="intnacional" id="intnacional" title="Internacional" maxlength="60" tabindex="1" autocomplete="off" size="15" /></td>
			  
		      </tr>			
		     </tbody>
		  </table>
                <div class="vacio"></div>
                <div id="msg-success" class="msg-success" style="display:none"></div>
            </fieldset>
	      <input type="hidden" name="formulario" value="asociaciones" />
	     <input type="submit" value="Registrar datos" class="first" />
</form>

<script type="text/javascript">
                $(':submit').click(function(event) {
                    event.preventDefault();
                    var valido= validateForm("#asociaciones");
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
				   data:$('#asociaciones').serialize(),
				   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
				  success:function(data){
				    if (data.success == true){					  
					$('#asociaciones #msg-success').html('<p>' + data.message + '</p>');
					$('#asociaciones #msg-success').removeClass('msg-error');
					$('#asociaciones #msg-success').css('display','block');
                                        $("#asociaciones #msg-success").delay(5500).fadeOut(800);
				    }
				    else{                        
					$('#asociaciones #msg-success').html('<p>' + data.message + '</p>');
					$('#asociaciones #msg-success').addClass('msg-error');
					$('#asociaciones #msg-success').css('display','block');
                                        $("#asociaciones #msg-success").delay(5500).fadeOut(800);
				    }
				}
				//error: function(data,error,errorThrown){alert(error + errorThrown);}
				   
			}); //AJAX

                }
</script>
