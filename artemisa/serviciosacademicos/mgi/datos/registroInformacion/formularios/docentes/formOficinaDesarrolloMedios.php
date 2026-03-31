<?php
session_start();
require_once("../../../templates/template.php");
$db = getBD();
$utils = new Utils_datos();
$urlprocesa="./formularios/".$categoria["alias"]."/save".$formulario["alias"].".php";

  $meses = array();
  $meses[1] = "Enero";
  $meses[2] = "Febrero";
  $meses[3] = "Marzo";
  $meses[4] = "Abril";
  $meses[5] = "Mayo";
  $meses[6] = "Junio";
  $meses[7] = "Julio";
  $meses[8] = "Agosto";
  $meses[9] = "Septiembre";
  $meses[10] = "Octubre";
  $meses[11] = "Noviembre";
  $meses[12] = "Diciembre";
?>

<form action="" method="post" id="medios">                      
            <span class="mandatory">* Son campos obligatorios</span>
	      <fieldset>
		<?php
		$query_papa = "select idclasificacionesinfhuerfana,clasificacionesinfhuerfana from siq_clasificacionesinfhuerfana where aliasclasificacionesinfhuerfana='medcc'";
                $papa= $db->Execute($query_papa);
                $totalRows_papa = $papa->RecordCount();
		$row_papa = $papa->FetchRow();
		?>
                <legend><?php echo $row_papa['clasificacionesinfhuerfana']; ?></legend>
		<label for="mes" class="grid-2-12">Mes: <span class="mandatory">(*)</span></label>
		<select name="mes" id="mes" style='font-size:0.8em'>
		<?php 
		for($mes=1; $mes<=12; $mes++){
		  if (date("m") == $mes){ ?>	
		    <option value="<?php echo $mes; ?>" selected><?php echo $meses[$mes]; ?></option>
		<?php 
		  }
		  else{ ?>
		    <option value="<?php echo $mes; ?>"><?php echo $meses[$mes]; ?></option>
		<?php 
		  }
		} ?>
		</select>
		<label for="anio" class="grid-2-12">Año: <span class="mandatory">(*)</span></label>
		<?php $utils->getYearsSelect("anio"); 
                $utils->pintarBotonCargar("popup_cargarDocumento(6,3,$('#medios #mes').val()+'-'+$('#medios #anio').val())","popup_verDocumentos(6,3,$('#medios #mes').val()+'-'+$('#medios #anio').val())"); ?>


		<table align="center" id="estructuraReporte"  class="formData last" width="92%">
		    <thead>            			
			<tr id="dataColumns">
			    <th class="column" ><span>Tipo de Medio</span></th>
			    <th class="column" ><span>Número de publicaciones </span></th>			    
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
			  <td class="column" ><?php echo $row_sectores['clasificacionesinfhuerfana']; ?>:<span class="mandatory">(*)</span></td>
			  <td class="column" ><input type="text" class="required number" minlength="" name="<?php echo $row_sectores['idclasificacionesinfhuerfana']; ?>/medio" id="<?php echo $row_sectores['idclasificacionesinfhuerfana']; ?>/medio" title="Número" maxlength="60" tabindex="1" autocomplete="off" size="15" /></td>			  
		      </tr>
			<?php 
			}
			?>	
		     </tbody>
		  </table>
                <div class="vacio"></div>
                <div id="msg-success" class="msg-success" style="display:none"></div>
            </fieldset>
	      <input type="hidden" name="formulario" value="medios" />
	     <input type="submit" value="Registrar datos" class="first" />
</form>

<script type="text/javascript">
                $(':submit').click(function(event) {
                    event.preventDefault();
                    var valido= validateForm("#medios");
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
				   data:$('#medios').serialize(),
				   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
				  success:function(data){
				    if (data.success == true){
					$('#medios #msg-success').html('<p>' + data.message + '</p>');
					$('#medios #msg-success').removeClass('msg-error');
					$('#medios #msg-success').css('display','block');
                                        $("#medios #msg-success").delay(5500).fadeOut(800);
				    }
				    else{                        
					$('#medios #msg-success').html('<p>' + data.message + '</p>');
					$('#medios #msg-success').addClass('msg-error');
					$('#medios #msg-success').css('display','block');
                                        $("#medios #msg-success").delay(5500).fadeOut(800);
				    }
				}
				//error: function(data,error,errorThrown){alert(error + errorThrown);}
				   
			}); //AJAX

                }
</script>
