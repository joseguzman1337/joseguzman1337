<?php
session_start();
require_once("../../../templates/template.php");
$db = getBD();
$utils = new Utils_datos();
?>

<form action="" method="post" id="EquipoSer">    
        <input type="hidden" name="action" value="SelectDynamic" id="action" />
    <input type="hidden" name="codigoperiodo" value="" id="codigoperiodo" />
    <input type="hidden" name="formulario" value="EquipoSer" />
    <?php
		$query_papa = "select idclasificacionesinfhuerfana,clasificacionesinfhuerfana from siq_clasificacionesinfhuerfana where aliasclasificacionesinfhuerfana='T_NECSCA'";
                $papa= $db->Execute($query_papa);
                $totalRows_papa = $papa->RecordCount();
		$row_papa = $papa->FetchRow();
		?> 
   <input type="hidden" name="padre" value="<?php echo $row_papa['idclasificacionesinfhuerfana']; ?>" />
            <span class="mandatory">* Son campos obligatorios</span>
	      <fieldset>
		               
		<legend><?php echo $row_papa['clasificacionesinfhuerfana']; ?></legend>
		<label for="semestre" class="grid-2-12">Semestre: <span class="mandatory">(*)</span></label>
		<?php $utils->getSemestresSelect($db,"semestre");
                $utils->pintarBotonCargar("popup_cargarDocumento(10,2,$('#EquipoSer #semestre').val())","popup_verDocumentos(10,2,$('#EquipoSer #semestre').val())");?>

		<table align="center" id="estructuraReporte"  class="formData last" width="92%">
		    <thead>             			
			<tr id="dataColumns">
                            <th class="column borderR" ><span>Población que Cubre</span></th>
                            <th class="column borderR"><span>Espacios Físicos</span></th>
                            <th class="column borderR"><span>Cantidad</span></th>                            
			</tr>				
                   </thead>
		    <tbody>
		      <?php 
		      $query_sectores = "select idclasificacionesinfhuerfana,clasificacionesinfhuerfana from siq_clasificacionesinfhuerfana where idpadreclasificacionesinfhuerfana ='".$row_papa['idclasificacionesinfhuerfana']."' order by 1";
		      $sectores= $db->Execute($query_sectores);
		      $totalRows_sectores = $sectores->RecordCount();
		      while($row_sectores = $sectores->FetchRow()){ 
		      
			$query_hijos = "select idclasificacionesinfhuerfana,clasificacionesinfhuerfana from siq_clasificacionesinfhuerfana where idpadreclasificacionesinfhuerfana ='".$row_sectores['idclasificacionesinfhuerfana']."' order by 2 ";
		      //echo $query_hijos;
			  $hijos= $db->Execute($query_hijos);
		      $totalRows_hijos = $hijos->RecordCount();
		      $cuentadat=$totalRows_hijos +1;
		      ?>
		      <tr id="contentColumns" class="row">
			  <td class="column borderR" rowspan="<?php echo $cuentadat;?>"><?php echo $row_sectores['clasificacionesinfhuerfana']; ?>:<span class="mandatory">(*)</span></td>
		      </tr>
		      <?php
			while($row_hijos= $hijos->FetchRow()){
		      ?>		      
                       <tr id="contentColumns" class="row">
			  <td class="column borderR" ><?php echo $row_hijos['clasificacionesinfhuerfana']; ?>:<span class="mandatory">(*)</span>
                          <input type="hidden" name="idsiq_tecnololgia[]" id="idsiq_tecnololgia_<?php echo $row_hijos['idclasificacionesinfhuerfana']; ?>" />
                          <input type="hidden" name="idclasificacionesinfhuerfana[] " id="idclasificacionesinfhuerfana_<?php echo $row_hijos['idclasificacionesinfhuerfana']; ?>" value="<?php echo $row_hijos['idclasificacionesinfhuerfana']; ?>" /> 
                          </td>
			  <td class="column borderR" ><input type="text" class="required number" minlength="" name="cantidad[]" id="cantidad_<?php echo $row_hijos['idclasificacionesinfhuerfana']; ?>" title="Cantidad" maxlength="60" tabindex="1" autocomplete="off" size="15" /></td> 
		      </tr>                      
			<?php
			  }
			}
			?>	
		     </tbody>		     
		  </table>
                <div class="vacio"></div>
                <div id="msg-success" class="msg-success" style="display:none"></div>
            </fieldset>
	      
	     <input type="submit" id="enviaEquipoSer" value="Registrar datos" class="first" />
</form>

<script type="text/javascript">
    getformulario_equiposer("#EquipoSer");
    
    $('#EquipoSer'+' #semestre').bind('change', function(event) {
         getformulario_equiposer("#EquipoSer");
    });
    
    function getformulario_equiposer(formName){
                    var codigoperiodo = $(formName + ' #semestre').val();
                    $(formName + " #action").val('SelectDynamic');
                        $.ajax({
                            dataType: 'json',
                            type: 'POST',
                            url: 'formularios/recursosFisicos/saveOficinaTecnologia.php',
                            data: $(formName).serialize(),      
                            success:function(data){
                                if (data.success == true){
									$(formName + ' input[name="cantidad[]"]').each(function() {                                     
										  $(this).val("");                                       
									 });
									$(formName + ' input[type="hidden"][name="idsiq_tecnololgia[]"]').each(function() {  
											$(this).val("");   											
									 });
                                    for (var i=0;i<data.total;i++){   
                                       // alert(formName+'-->'+data[i].idsiq_tecnologia+'-->'+data[i].idclasificacionesinfhuerfana+'-->'+data[i].cantidad);                                
                                        $(formName + " #idsiq_tecnololgia_"+data[i].idclasificacionesinfhuerfana).val(data[i].idsiq_tecnologia);
                                        $(formName + " #idclasificacionesinfhuerfana_"+data[i].idclasificacionesinfhuerfana).val(data[i].idclasificacionesinfhuerfana);
                                        $(formName + " #cantidad_"+data[i].idclasificacionesinfhuerfana).val(data[i].cantidad);
                                      }
                                    $(formName + " #action").val("UpdateDynamic");
                                    
                                }else{                        
                                    var mes = $(formName + ' #semestre').val();
                                    document.forms[formName.replace("#","")].reset();									
									$(formName + ' input[name="cantidad[]"]').each(function() {                                     
										  $(this).val("");                                       
									 });
									$(formName + ' input[type="hidden"][name="idsiq_tecnololgia[]"]').each(function() {  
											$(this).val("");   											
									 });
                                    $(formName + ' #semestre').val(mes);
                                    $(formName + " #action").val("SaveDynamic");
                                            
                                }
                            },
                            error: function(data,error,errorThrown){alert(error + errorThrown);}
                        }); 
                 }
                 
                $('#enviaEquipoSer').click(function(event) {
                    event.preventDefault();
                    var valido= validateForm("#EquipoSer");
                    if(valido){
                        EquipoSer();
                    }
                });

                function EquipoSer(){//$('#form_test').serialize()

					//var empresanacionale = $('#empresanacionale').val();
							
				  $.ajax({//Ajax
						   type: 'GET',
						   url: 'formularios/recursosFisicos/saveOficinaTecnologia.php',
						   async: false,
						   dataType: 'json',
						   data:$('#EquipoSer').serialize(),
						   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
						  success:function(data){
							if (data.success == true){		
								getformulario_equiposer("#EquipoSer");			  
							$('#EquipoSer #msg-success').html('<p>' + data.descrip + '</p>');
							$('#EquipoSer #msg-success').removeClass('msg-error');
							$('#EquipoSer #msg-success').css('display','block');
							}
							else{                        
							$('#EquipoSer #msg-success').html('<p>' + data.descrip + '</p>');
							$('#EquipoSer #msg-success').addClass('msg-error');
							$('#EquipoSer #msg-success').css('display','block');
												$("#EquipoSer #msg-success").delay(5500).fadeOut(800);
							}
						}
						//error: function(data,error,errorThrown){alert(error + errorThrown);}
						   
					}); //AJAX

                }
</script>
