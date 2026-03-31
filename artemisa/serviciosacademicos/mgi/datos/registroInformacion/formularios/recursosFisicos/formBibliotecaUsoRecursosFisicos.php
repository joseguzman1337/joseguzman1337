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
		<legend>Uso de los recursos físicos</legend>
		<label for="mes" class="grid-2-12">Mes: <span class="mandatory">(*)</span></label>
<?php		
		$utils->getMonthsSelect("mes"); 
		$utils->getYearsSelect("anio");                 
                $idForm = "forma".$_REQUEST['alias'];
                 $utils->pintarBotonCargar("popup_cargarDocumento(2,3,$('#".$idForm." #mes').val()+'-'+$('#".$idForm." #anio').val())","popup_verDocumentos(2,3,$('#".$idForm." #mes').val()+'-'+$('#".$idForm." #anio').val())");
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
					<th colspan="<?php if($aprobacion) echo "7"; else echo "8";?>" class="borderR"><?php echo $row2['clasificacionesinfhuerfana']?></th>               
                                        <?php if($aprobacion){ ?>
                                            <th class="column"><span>
                                                <input type="hidden" value="0" name="VerEscondido" id="VerEscondido" />
                                                <input type="checkbox"  class="grid-4-12 required number" minlength="1" name="Verificado" id="Verificado" title="Verificado" maxlength="20" tabindex="1" autocomplete="off" value="1" />
                                           </span></th>  
                                           <?php } ?>
                                </tr>
				<tr class="dataColumns">
					<th class="borderR">Perfiles / Transacción</th>               
					<th class="borderR">Ingresos a la biblioteca</th>               
					<th class="borderR">Préstamos de equipos</th>               
					<th class="borderR">Consulta y préstamos de libros</th>               
					<th class="borderR">Consulta y préstamos de revistas</th>               
					<th class="borderR">Consulta y préstamos de trabajo de grado</th>               
					<th class="borderR">Consulta y préstamos de material especial</th>               
					<th class="borderR">Prestamos de salas de estudio</th>               
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
						<td class="column borderR" align="center"><input type="text" class="grid-12-12 required number" name="ingresos_biblioteca[]" id="ingresos_biblioteca_<?php echo $row['idclasificacionesinfhuerfana']?>" title="Ingresos a la biblioteca" maxlength="20" tabindex="1" autocomplete="off" size="6" style='text-align:center' /></td>
						<td class="column borderR" align="center"><input type="text" class="grid-12-12 required number" name="prestamo_equipos[]" id="prestamo_equipos_<?php echo $row['idclasificacionesinfhuerfana']?>" title="Prestamos de equipos" maxlength="20" tabindex="1" autocomplete="off" size="6" style='text-align:center' /></td>
						<td class="column borderR" align="center"><input type="text" class="grid-12-12 required number" name="consulta_prestamo_libros[]" id="consulta_prestamo_libros_<?php echo $row['idclasificacionesinfhuerfana']?>" title="Consulta y prestamos de libros" maxlength="20" tabindex="1" autocomplete="off" size="6" style='text-align:center' /></td>
						<td class="column borderR" align="center"><input type="text" class="grid-12-12 required number" name="consulta_prestamo_revistas[]" id="consulta_prestamo_revistas_<?php echo $row['idclasificacionesinfhuerfana']?>" title="Consulta y prestamos de revistas" maxlength="20" tabindex="1" autocomplete="off" size="6" style='text-align:center' /></td>
						<td class="column borderR" align="center"><input type="text" class="grid-12-12 required number" name="consulta_prestamo_trabajos_grado[]" id="consulta_prestamo_trabajos_grado_<?php echo $row['idclasificacionesinfhuerfana']?>" title="Consulta y prestamos de trabajos de grado" maxlength="20" tabindex="1" autocomplete="off" size="6" style='text-align:center' /></td>
						<td class="column borderR" align="center"><input type="text" class="grid-12-12 required number" name="consulta_prestamo_material_especial[]" id="consulta_prestamo_material_especial_<?php echo $row['idclasificacionesinfhuerfana']?>" title="Consulta y prestamos de material especial" maxlength="20" tabindex="1" autocomplete="off" size="6" style='text-align:center' /></td>
						<td class="column borderR" align="center"><input type="text" class="grid-12-12 required number" name="prestamo_salas_estudio[]" id="prestamo_salas_estudio_<?php echo $row['idclasificacionesinfhuerfana']?>" title="Prestamos de salas de estudio" maxlength="20" tabindex="1" autocomplete="off" size="6" style='text-align:center' /></td>
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
	<input type="submit" value="Guardar cambios" id="enviar3" name="enviar3" class="first" />
</form>
<script type="text/javascript">
var aprobacion = '<?php echo $aprobacion; ?>';  
    getData3("#forma<?php echo $_REQUEST['alias']?>");
    
                $('#enviar3').click(function(event) {
                    event.preventDefault();
                    var valido= validateForm("#forma<?php echo $_REQUEST['alias']?>");
                    if(valido){
                        sendForm3("#forma<?php echo $_REQUEST['alias']?>");
                    }
                });
                
     $('#forma<?php echo $_REQUEST['alias']?> #mes').bind('change', function(event) {
          getData3("#forma<?php echo $_REQUEST['alias']?>");
    });
    
     $('#forma<?php echo $_REQUEST['alias']?> #anio').bind('change', function(event) {
          getData3("#forma<?php echo $_REQUEST['alias']?>");
    });
    
    function getData3(formName){
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
                                        $(formName + " #ingresos_biblioteca_"+data[i].idclasificacionesinfhuerfana).val(data[i].ingresos_biblioteca);
                                        $(formName + " #prestamo_equipos_"+data[i].idclasificacionesinfhuerfana).val(data[i].prestamo_equipos);
                                        $(formName + " #consulta_prestamo_libros_"+data[i].idclasificacionesinfhuerfana).val(data[i].consulta_prestamo_libros);
                                        $(formName + " #consulta_prestamo_revistas_"+data[i].idclasificacionesinfhuerfana).val(data[i].consulta_prestamo_revistas);
                                        $(formName + " #consulta_prestamo_trabajos_grado_"+data[i].idclasificacionesinfhuerfana).val(data[i].consulta_prestamo_trabajos_grado);
                                        $(formName + " #consulta_prestamo_material_especial_"+data[i].idclasificacionesinfhuerfana).val(data[i].consulta_prestamo_material_especial);
                                        $(formName + " #prestamo_salas_estudio_"+data[i].idclasificacionesinfhuerfana).val(data[i].prestamo_salas_estudio);
                                        
                                         if(data[i].Verificado=="1"){ 
                                           $(formName + " #Verificado").attr("checked", true);
                                           $(formName + ' #msg-success').html('<p> Ya esta validado</p>');
                                           $(formName + ' #msg-success').removeClass('msg-error');
                                           $(formName + ' #msg-success').css('display','block');
                                           $(formName + " #msg-success").delay(5500).fadeOut(300);
                                           $(formName + " #enviar3").attr('disabled','disabled');
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
                
       function sendForm3(formName){
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

