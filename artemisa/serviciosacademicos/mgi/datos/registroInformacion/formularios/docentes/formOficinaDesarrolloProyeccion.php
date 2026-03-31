<?php
session_start();
require_once("../../../templates/template.php");
$db = getBD();
$utils = new Utils_datos();
$urlprocesa="./formularios/".$categoria["alias"]."/save".$formulario["alias"].".php";
?>

<form action="" method="post" id="proyeccion">                      
            <span class="mandatory">* Son campos obligatorios</span>
	      <fieldset>
		<?php
		$query_papa = "select idclasificacionesinfhuerfana,clasificacionesinfhuerfana from siq_clasificacionesinfhuerfana where aliasclasificacionesinfhuerfana='prnunprdfintgr'";
                $papa= $db->Execute($query_papa);
                $totalRows_papa = $papa->RecordCount();
		$row_papa = $papa->FetchRow();
		?>
                <legend><?php echo $row_papa['clasificacionesinfhuerfana']; ?></legend>
		<label for="semestre" class="grid-2-12">Semestre: <span class="mandatory">(*)</span></label>
		<?php $utils->getSemestresSelect($db,"semestre"); 
                $utils->pintarBotonCargar("popup_cargarDocumento(6,2,$('#proyeccion #semestre').val())","popup_verDocumentos(6,2,$('#proyeccion #semestre').val())"); ?>

		<table align="center" id="estructuraReporte"  class="formData last" width="92%">
		    <thead>            			
			<tr id="dataColumns">
			    <th class="column borderR" rowspan="2"><span>Sector</span></th>
			    <th class="column borderR" colspan="2"><span>Núcleo Estratégico</span></th>
			    <th class="column" rowspan="2"><span>Otras Disciplinas</span></th>
			</tr>
			<tr id="dataColumns">
			    <th class="column"><span>Salud</span></th>
			    <th class="column borderR"><span>Calidad de Vida</span></th>
			</tr>	     
		    </thead>
		    <tbody>
		      <?php 
		      $query_sectores = "select idclasificacionesinfhuerfana,clasificacionesinfhuerfana from siq_clasificacionesinfhuerfana where idpadreclasificacionesinfhuerfana ='".$row_papa['idclasificacionesinfhuerfana']."' ";
		      $sectores= $db->Execute($query_sectores);
		      $totalRows_sectores = $sectores->RecordCount();
		      while($row_sectores = $sectores->FetchRow()){      
		      ?>
		      <tr id="contentColumns" class="row">
			  <td class="column borderR" ><?php echo $row_sectores['clasificacionesinfhuerfana']; ?>:<span class="mandatory">(*)</span></td>
			  <td class="column" ><input type="text" class="required number" minlength="" name="<?php echo $row_sectores['idclasificacionesinfhuerfana']; ?>/salud" id="<?php echo $row_sectores['idclasificacionesinfhuerfana']; ?>/salud" title="Salud" maxlength="60" tabindex="1" autocomplete="off" size="15" /></td>
			  <td class="column borderR" ><input type="text" class="required number" minlength="" name="<?php echo $row_sectores['idclasificacionesinfhuerfana']; ?>/calidad" id="<?php echo $row_sectores['idclasificacionesinfhuerfana']; ?>/calidad" title="Calidad" maxlength="60" tabindex="1" autocomplete="off" size="15" /></td>
			  <td class="column" ><input type="text" class="required number" minlength="" name="<?php echo $row_sectores['idclasificacionesinfhuerfana']; ?>/otras" id="<?php echo $row_sectores['idclasificacionesinfhuerfana']; ?>/otras" title="Otras" maxlength="60" tabindex="1" autocomplete="off" size="15" /></td>
		      </tr>
			<?php 
			}
			?>	
		     </tbody>
		  </table>
                <div class="vacio"></div>
                <div id="msg-success" class="msg-success" style="display:none"></div>
            </fieldset>
	      <input type="hidden" name="formulario" value="proyeccion" />
	     <input type="submit" value="Registrar datos" class="first" />
</form>

<script type="text/javascript">
                $(':submit').click(function(event) {
                    event.preventDefault();
                    var valido= validateForm("#proyeccion");
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
				   data:$('#proyeccion').serialize(),
				   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
				  success:function(data){
				    if (data.success == true){					  
					$('#proyeccion #msg-success').html('<p>' + data.message + '</p>');
					$('#proyeccion #msg-success').removeClass('msg-error');
					$('#proyeccion #msg-success').css('display','block');
                                        $("#proyeccion #msg-success").delay(5500).fadeOut(800);
				    }
				    else{                        
					$('#proyeccion #msg-success').html('<p>' + data.message + '</p>');
					$('#proyeccion #msg-success').addClass('msg-error');
					$('#proyeccion #msg-success').css('display','block');
                                        $("#proyeccion #msg-success").delay(5500).fadeOut(800);
				    }
				}
				//error: function(data,error,errorThrown){alert(error + errorThrown);}
				   
			}); //AJAX

                }
</script>
