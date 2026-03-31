<?php
session_start();
require_once("../../../templates/template.php");
$db = getBD();
$utils = new Utils_datos();
?>

<form action="" method="post" id="DotaSal">                      
            <span class="mandatory">* Son campos obligatorios</span>
	      <fieldset>
		<?php
		$query_papa = "select idclasificacionesinfhuerfana,clasificacionesinfhuerfana from siq_clasificacionesinfhuerfana where aliasclasificacionesinfhuerfana='T_DSREA'";
                $papa= $db->Execute($query_papa);
                $totalRows_papa = $papa->RecordCount();
		$row_papa = $papa->FetchRow();
		?>                
		<legend><?php echo $row_papa['clasificacionesinfhuerfana']; ?></legend>
		<label for="semestre" class="grid-2-12">Semestre: <span class="mandatory">(*)</span></label>
		<?php $utils->getSemestresSelect($db,"semestre");
                $utils->pintarBotonCargar("popup_cargarDocumento(10,5,$('#DotaSal #semestre').val())","popup_verDocumentos(10,5,$('#DotaSal #semestre').val())"); ?>

		<table align="center" id="estructuraReporte"  class="formData last" width="92%">
		    <thead>             			
			<tr id="dataColumns">
                            <th class="column borderR" ><span>Aulas</span></th>
                            <th class="column borderR"><span>Cantidad</span></th>                            
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
			  <td class="column borderR" ><input type="text" class="required number" minlength="" name="<?php echo $row_sectores['idclasificacionesinfhuerfana']; ?>/cantidad" id="<?php echo $row_sectores['idclasificacionesinfhuerfana']; ?>/cantidad" title="Cantidad" maxlength="60" tabindex="1" autocomplete="off" size="15" /></td> 
		      </tr>
			<?php 
			}
			?>	
		     </tbody>
		  </table>
                <div class="vacio"></div>
                <div id="msg-success" class="msg-success" style="display:none"></div>
            </fieldset>
	      <input type="hidden" name="formulario" value="DotaSal" />
	      <input type="hidden" name="padre" value="<?php echo $row_papa['idclasificacionesinfhuerfana']; ?>" />
	     <input type="submit" id="enviaDotaSal" value="Registrar datos" class="first" />
</form>

<script type="text/javascript">
                $('#enviaDotaSal').click(function(event) {
                    event.preventDefault();
                    var valido= validateForm("#DotaSal");
                    if(valido){
                        DotaSal();
                    }
                });

                function DotaSal(){//$('#form_test').serialize()

		    //var empresanacionale = $('#empresanacionale').val();
                    
		  $.ajax({//Ajax
				   type: 'GET',
				   url: 'formularios/recursosFisicos/saveOficinaTecnologia.php',
				   async: false,
				   dataType: 'json',
				   data:$('#DotaSal').serialize(),
				   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
				  success:function(data){
				    if (data.success == true){					  
					$('#DotaSal #msg-success').html('<p>' + data.message + '</p>');
					$('#DotaSal #msg-success').removeClass('msg-error');
					$('#DotaSal #msg-success').css('display','block');
                                        $("#DotaSal #msg-success").delay(5500).fadeOut(800);
				    }
				    else{                        
					$('#DotaSal #msg-success').html('<p>' + data.message + '</p>');
					$('#DotaSal #msg-success').addClass('msg-error');
					$('#DotaSal #msg-success').css('display','block');
                                        $("#DotaSal #msg-success").delay(5500).fadeOut(800);
				    }
				}
				//error: function(data,error,errorThrown){alert(error + errorThrown);}
				   
			}); //AJAX

                }
</script>
