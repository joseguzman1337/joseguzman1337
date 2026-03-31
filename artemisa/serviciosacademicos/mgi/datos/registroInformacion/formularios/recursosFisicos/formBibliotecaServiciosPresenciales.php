<?php 
session_start();
require_once("../../../templates/template.php");
$db = getBD();
$utils = new Utils_datos();
if($utils->UsuarioAprueba_FormHuerfana($db,$usuario_con)){
        $aprobacion=true;
}
?>
<form action="" method="post" id="forma<?php echo $_REQUEST['alias']?>">
    <input type="hidden" name="entity" id="entity" value="<?php echo $_REQUEST['alias']?>" />
        <input type="hidden" name="action" value="saveDynamic2" id="action" />
	<span class="mandatory">* Son campos obligatorios</span>
	<fieldset>  
		<legend>Servicios presenciales</legend>
		<label for="mes" class="grid-2-12">Mes: <span class="mandatory">(*)</span></label>
<?php		
		$utils->getMonthsSelect("mes"); 
		$utils->getYearsSelect("anio"); 
                 $idForm = "forma".$_REQUEST['alias'];
                 $utils->pintarBotonCargar("popup_cargarDocumento(2,5,$('#".$idForm." #mes').val()+'-'+$('#".$idForm." #anio').val())","popup_verDocumentos(2,5,$('#".$idForm." #mes').val()+'-'+$('#".$idForm." #anio').val())");

?>
		<table align="center" class="formData last" width="92%">
<?php
			$query2="select	 sch.clasificacionesinfhuerfana
					,sch.aliasclasificacionesinfhuerfana
				from siq_clasificacionesinfhuerfana sch
				join (	select idclasificacionesinfhuerfana
					from siq_clasificacionesinfhuerfana 
					where aliasclasificacionesinfhuerfana='".$_REQUEST['alias']."'
				) sub on sch.idpadreclasificacionesinfhuerfana=sub.idclasificacionesinfhuerfana
				where sch.estado";
			$exec2= $db->Execute($query2);
			while($row2 = $exec2->FetchRow()) {
?>
				<tr class="dataColumns category">
					<th colspan="<?php if($aprobacion) echo "7"; else echo "8"; ?>" class="borderR"><?php echo $row2['clasificacionesinfhuerfana']?></th>               
                                        <?php if($aprobacion){ ?>
                                            <th class="column"><span>
                                                <input type="hidden" value="0" name="VerEscondido" id="VerEscondido" />
                                                <input type="checkbox"  class="grid-4-12 required number" minlength="1" name="Verificado" id="Verificado" title="Verificado" maxlength="20" tabindex="1" autocomplete="off" value="1" />
                                           </span></th>  
                                           <?php } ?>
                                </tr>
				<tr class="dataColumns">
					<th class="borderR">Perfiles / Servicios presenciales</th>               
					<th class="borderR">Consulta en sala</th>               
					<th class="borderR">Préstamo externo</th>               
					<th class="borderR">Préstamo interbibliotecario</th>               
					<th class="borderR">Cartas de presentación</th>               
					<th class="borderR">Préstamo de equipos</th>               
					<th class="borderR">Préstamo de salas de estudio</th>              
					<th class="borderR">Formación a usuarios</th>              
				</tr>
	<?php
				$query="select	 sch.idclasificacionesinfhuerfana
						,sch.clasificacionesinfhuerfana
					from siq_clasificacionesinfhuerfana sch
					join (	select idclasificacionesinfhuerfana
						from siq_clasificacionesinfhuerfana 
						where aliasclasificacionesinfhuerfana='".$row2['aliasclasificacionesinfhuerfana']."'
					) sub on sch.idpadreclasificacionesinfhuerfana=sub.idclasificacionesinfhuerfana
					where sch.estado";
				$exec= $db->Execute($query);
				while($row = $exec->FetchRow()) {
	?>
					<tr id="contentColumns" class="row">
						<td class="column borderR">
							<input type="hidden" name="aux[<?php echo $row['idclasificacionesinfhuerfana']?>]" value="<?php echo $row['idclasificacionesinfhuerfana']?>">
							<?php echo utf8_decode($row['clasificacionesinfhuerfana']); ?>: <span class="mandatory">(*)</span>
                                                        <input type="hidden"  class="grid-3-12 required number" minlength="1" name="idclasificacionesinfhuerfana[]" id="idclasificacionesinfhuerfana_<?php echo $row["idclasificacionesinfhuerfana"]; ?>" value="<?php echo $row["idclasificacionesinfhuerfana"]; ?>" />
                                                        <input type="hidden" name="id[]" value="" id="id_<?php echo $row["idclasificacionesinfhuerfana"]; ?>" /></td>
                           
						</td>
						<td class="column borderR" align="center"><input type="text" class="grid-12-12 required number" name="consulta_sala[]" id="consulta_sala_<?php echo $row['idclasificacionesinfhuerfana']?>" title="Préstamos en sala" maxlength="20" tabindex="1" autocomplete="off" size="6" style='text-align:center' /></td>
						<td class="column borderR" align="center"><input type="text" class="grid-12-12 required number" name="prestamo_externo[]" id="prestamo_externo_<?php echo $row['idclasificacionesinfhuerfana']?>" title="Préstamo externo" maxlength="20" tabindex="1" autocomplete="off" size="6" style='text-align:center' /></td>
						<td class="column borderR" align="center"><input type="text" class="grid-12-12 required number" name="prestamo_interbibliotecario[]" id="prestamo_interbibliotecario_<?php echo $row['idclasificacionesinfhuerfana']?>" title="Préstamo interbibliotecario" maxlength="20" tabindex="1" autocomplete="off" size="6" style='text-align:center' /></td>
						<td class="column borderR" align="center"><input type="text" class="grid-12-12 required number" name="cartas_presentacion[]" id="cartas_presentacion_<?php echo $row['idclasificacionesinfhuerfana']?>" title="Cartas de presentación" maxlength="20" tabindex="1" autocomplete="off" size="6" style='text-align:center' /></td>
						<td class="column borderR" align="center"><input type="text" class="grid-12-12 required number" name="prestamo_equipos[]" id="prestamo_equipos_<?php echo $row['idclasificacionesinfhuerfana']?>" title="Renovaciones presenciales" maxlength="20" tabindex="1" autocomplete="off" size="6" style='text-align:center' /></td>
						<td class="column borderR" align="center"><input type="text" class="grid-12-12 required number" name="prestamo_salas_estudio[]" id="prestamo_salas_estudio_<?php echo $row['idclasificacionesinfhuerfana']?>" title="Sugerencias recibidas" maxlength="20" tabindex="1" autocomplete="off" size="6" style='text-align:center' /></td>
						<td class="column borderR" align="center"><input type="text" class="grid-12-12 required number" name="formacion_usuarios[]" id="formacion_usuarios_<?php echo $row['idclasificacionesinfhuerfana']?>" title="Formacion a usuarios" maxlength="20" tabindex="1" autocomplete="off" size="6" style='text-align:center' /></td>
					</tr>
	<?php
				}
			}
	?>
		</table>
                
                <div class="vacio"></div>
                <div id="msg-success" class="msg-success" style="display:none"><p>Los datos han sido guardados de forma correcta.</p></div>
	</fieldset>
	<input type="hidden" name="alias" value="<?php echo $_REQUEST['alias']?>" />
	<input type="submit" value="Guardar cambios" id="enviar6" name="enviar6" class="first" />
</form>
<script type="text/javascript">
var aprobacion = '<?php echo $aprobacion; ?>';  
    getData6("#forma<?php echo $_REQUEST['alias']?>");
    
                $('#enviar6').click(function(event) {
                    event.preventDefault();
                    var valido= validateForm("#forma<?php echo $_REQUEST['alias']?>");
                    if(valido){
                        sendForm6("#forma<?php echo $_REQUEST['alias']?>");
                    }
                });
                
     $('#forma<?php echo $_REQUEST['alias']?> #mes').bind('change', function(event) {
          getData6("#forma<?php echo $_REQUEST['alias']?>");
    });
    
     $('#forma<?php echo $_REQUEST['alias']?> #anio').bind('change', function(event) {
          getData6("#forma<?php echo $_REQUEST['alias']?>");
    });
    
    function getData6(formName){
                  //  alert('aca.. ')
    
                    var periodo = $(formName + ' #anio').val()+$(formName + ' #mes').val();
                   // var periodo = $(formName + ' #codigoperiodo').val();
                    var entity = $(formName + " #entity").val();
                    $(formName + " #action").val("selectDynamic2");
                        $.ajax({
                            dataType: 'json',
                            type: 'POST',
                            url: './formularios/recursosFisicos/saveBiblioteca.php',
                            data: $(formName).serialize(),   
                            success:function(data){
                                if (data.success == true){
                                   // $("#id").val(data.message);
                                    for (var i=0;i<data.total;i++){                                  
                                      //  alert(data[i].id+'-'+data[i].idclasificacionesinfhuerfana+'-'+data[i].cantidad+'-->>')
                                        
                                        $(formName + " #idclasificacionesinfhuerfana_"+data[i].idclasificacionesinfhuerfana).val(data[i].idclasificacionesinfhuerfana);
                                        $(formName + " #id_"+data[i].idclasificacionesinfhuerfana).val(data[i].id);
                                        $(formName + " #consulta_sala_"+data[i].idclasificacionesinfhuerfana).val(data[i].consulta_sala);
                                        $(formName + " #prestamo_externo_"+data[i].idclasificacionesinfhuerfana).val(data[i].prestamo_externo);
                                        $(formName + " #prestamo_interbibliotecario_"+data[i].idclasificacionesinfhuerfana).val(data[i].prestamo_interbibliotecario);
                                        $(formName + " #cartas_presentacion_"+data[i].idclasificacionesinfhuerfana).val(data[i].cartas_presentacion);
                                        $(formName + " #prestamo_equipos_"+data[i].idclasificacionesinfhuerfana).val(data[i].prestamo_equipos);
                                        $(formName + " #prestamo_salas_estudio_"+data[i].idclasificacionesinfhuerfana).val(data[i].prestamo_salas_estudio);
                                        $(formName + " #formacion_usuarios_"+data[i].idclasificacionesinfhuerfana).val(data[i].formacion_usuarios);
                                        
                                         if(data[i].Verificado=="1"){ 
                                           $(formName + " #Verificado").attr("checked", true);
                                           $(formName + ' #msg-success').html('<p> Ya esta validado</p>');
                                           $(formName + ' #msg-success').removeClass('msg-error');
                                           $(formName + ' #msg-success').css('display','block');
                                           $(formName + " #msg-success").delay(5500).fadeOut(300);
                                           $(formName + " #enviar6").attr('disabled','disabled');
                                           $(formName).find(':input').each(function() {
                                                 $(this).removeAttr("readonly").addClass("disable");
                                                 $(this).removeAttr("disabled").addClass("disable");
                                            });
                                          }else{
                                               
                                              $(formName).find(':input').each(function() {
                                                 $(this).removeAttr("readonly").removeClass("disable");
                                            }); 
                                           // $(formName + " #enviafinanciamiento").removeAttr('disabled','disabled');
                                              $(formName + " #Verificado").attr("checked", false);
                                            }
                                    }
                                    $(formName + " #action").val("updateDynamic2");
                                }else{                        
                                    //no se encontraron datos
                                    if($("#id").val()!=""){
                                        $(formName + ' input[name="id[]"]').each(function() {                                     
                                            $(this).val("");                                       
                                        });
                                        var mes = $(formName + ' #mes').val();
                                        var anio = $(formName + ' #anio').val();
                                        document.forms[formName.replace("#","")].reset();
                                        $(formName + ' #anio').val(anio);
                                        $(formName + ' #mes').val(mes);
                                        $(formName + " #action").val("saveDynamic2");
                                            $("#id").val("");
                                            $(formName + " #Verificado").attr("checked", false);
                                            $(formName).find(':input').each(function() {
                                                       $(this).removeAttr("readonly").removeClass("disable");
                                            });
                                     }
                                }
                            },
                            error: function(data,error,errorThrown){alert(error + errorThrown);}
                        });  
                }
                
       function sendForm6(formName){
                 $(formName + " input[type=checkbox]:checked" ).each(function() {
                        var id= $( this ).attr( "id" );
                        $( "#VerEscondido").attr("disabled","disabled");
                      });

                      $(formName + " input[type=checkbox]:not(:checked)" ).each(function() {
                        var id= $( this ).attr( "id" );
                        $( "#VerEscondido").removeAttr("disabled");
                      });
                    $(formName + " #action").val("saveDynamic2");
                    $.ajax({
                        dataType: 'json',
                        type: 'POST',
                        url: './formularios/recursosFisicos/saveBiblioteca.php',
                        data: $(formName).serialize(),                
                        success:function(data){
                            if (data.success == true){
                                 //window.location.href="./viewData.php?id=row_<?php //echo $formulario["idsiq_formulario"]; ?>";  
                                // $("#id").val(data.message);
//                                 for (var i=0;i<data.total;i++)
//                                 {                                  
//                                    $("#id_"+data.dataCat[i]).val(data.data[i]);
//                                 }
                                 $(formName + " #action").val("updateDynamic2");
                                 
                                  $(formName + ' #msg-success').html('<p>'+data.descrip+'</p>');
                                           $(formName + ' #msg-success').removeClass('msg-error');
                                           $(formName + ' #msg-success').css('display','block');
                                           $(formName + " #msg-success").delay(5500).fadeOut(300);
                            }
                            else{                        
                                $('#msg-error').html('<p>' + data.message + '</p>');
                                $('#msg-error').addClass('msg-error');
                            }
                        },
                        error: function(data,error,errorThrown){alert(error + errorThrown);}
                    });            
                }
</script>

