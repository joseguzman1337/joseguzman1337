<?php
session_start();
require_once("../../../templates/template.php");
$db = getBD();
$utils = new Utils_datos();
?>

<form action="" method="post" id="desarrollo">                      
            <span class="mandatory">* Son campos obligatorios</span>
            <fieldset>
		<?php
		$query_papa = "select idclasificacionesinfhuerfana,clasificacionesinfhuerfana from siq_clasificacionesinfhuerfana where aliasclasificacionesinfhuerfana='PPROGDESPROF'";
                $papa= $db->Execute($query_papa);
                $totalRows_papa = $papa->RecordCount();
		$row_papa = $papa->FetchRow();
		?>
                <legend><?php echo $row_papa['clasificacionesinfhuerfana']; ?></legend>
		<label for="anio" class="grid-2-12">Año: <span class="mandatory">(*)</span></label>
		<?php $utils->getYearsSelect("anio");
                 $utils->pintarBotonCargar("popup_cargarDocumento(13,1,$('#desarrollo #anio').val())","popup_verDocumentos(13,1,$('#desarrollo #anio').val())"); ?>
                
                <table align="center" id="estructuraReporte"  class="formData last" width="92%">
                    <thead>             			
			<tr id="dataColumns">
                            <th class="column borderR" ><span>Programa</span></th>
                            <th class="column"><span>Presupuestado</span></th>
                            <th class="column" ><span>Ejecutado</span></th>                            
			</tr>				
                   </thead>
		   <tbody>
        
		    <tr id="contentColumns" class="row">        
			    <td class="column borderR" >
				<?php echo $row_papa['clasificacionesinfhuerfana']; ?>:<span class="mandatory">(*)</span>
			    </td>		
			    <td class="column" >
				<input type="text" class="required number" minlength="" name="<?php echo $row_papa['idclasificacionesinfhuerfana']; ?>/presupuestado" id="<?php echo $row_papa['idclasificacionesinfhuerfana']; ?>/presupuestado" title="Presupuestado" maxlength="60" tabindex="1" autocomplete="off" size="20" />
			    </td>
			    <td class="column" >
				<input type="text" class="required number" minlength="" name="<?php echo $row_papa['idclasificacionesinfhuerfana']; ?>/ejecutado" id="<?php echo $row_papa['idclasificacionesinfhuerfana']; ?>/ejecutado" title="Ejecutado" maxlength="60" tabindex="1" autocomplete="off" size="20" />
			    </td>
		    </tr>        
                </tbody>
		
                </table>
                
                <div class="vacio"></div>
                <div id="msg-success1" class="msg-success" style="display:none"></div>
            </fieldset>	     
	    <input type="hidden" name="formulario" value="desarrollo" />
	    <input type="hidden" name="padre" value="<?php echo $row_papa['idclasificacionesinfhuerfana']; ?>" />
            <input type="submit" id="enviar" class="first" value="Registrar datos" />
        </form>
</div>
</div>
<script type="text/javascript">
    $(function(){
        $("#desarrollo input[type='text']").maskMoney({allowZero:true,thousands:',', decimal:'.',precision:0,allowNegative:false, defaultZero:false});
    });
    
                $('#enviar').click(function(event) {
                    event.preventDefault();
                    replaceCommas("#desarrollo");
                    var valido= validateForm("#desarrollo");
                    if(valido){
                        desarrollo();
                    }
                });

                function desarrollo(){//$('#form_test').serialize()

		    //var empresanacionale = $('#empresanacionale').val();
		  $.ajax({//Ajax
				   type: 'GET',
				   url: './formularios/financieros/savePresupuestos.php',
				   async: false,
				   dataType: 'json',
				   data:$('#desarrollo').serialize(),
				   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
				  success:function(data){
				    if (data.success == true){
					$('#desarrollo #msg-success1').html('<p>' + data.message + '</p>');
					$('#desarrollo #msg-success1').removeClass('msg-error');
					$('#desarrollo #msg-success1').css('display','block');
                                        $("#desarrollo #msg-success1").delay(5500).fadeOut(800);
                                                                                			
				    }
				    else{                        
					$('#desarrollo #msg-success1').html('<p>' + data.message + '</p>');
					$('#desarrollo #msg-success1').addClass('msg-error');
					$('#desarrollo #msg-success1').css('display','block');
                                        $("#desarrollo #msg-success1").delay(5500).fadeOut(800);                                        
                                        
				    }
				}
				//error: function(data,error,errorThrown){alert(error + errorThrown);}
				   
			}); //AJAX
                        addCommas("#desarrollo");
                }
</script>