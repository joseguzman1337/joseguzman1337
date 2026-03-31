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
		<legend>Recursos suscritos – Número de títulos y consultas</legend>
                <label for="semestre" class="grid-2-12">Semestre: <span class="mandatory">(*)</span></label>
                <?php $utils->getSemestresSelect($db,"mes");
                $utils->pintarBotonCargar("popup_cargarDocumento(2,9,$('#".$idForm." #mes').val())","popup_verDocumentos(2,9,$('#".$idForm." #mes').val())");?>
		<table align="center" class="formData last" width="92%">
                   <?php if($aprobacion){ ?> 
                    <tr class="dataColumns category">
                                <th class="column" colspan="5"><span>
                                                <input type="hidden" value="0" name="VerEscondido" id="VerEscondido" />
                                                <input type="checkbox"  class="grid-4-12 required number" minlength="1" name="Verificado" id="Verificado" title="Verificado" maxlength="20" tabindex="1" autocomplete="off" value="1" />
                                           </span></th>  
                                           
                                </tr>
                       <?php } ?>
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
					<th colspan="4"class="borderR"><?php echo utf8_decode($row2['clasificacionesinfhuerfana']); ?></th>               
                                </tr>
				<tr class="dataColumns">
<?php
					if($row2['aliasclasificacionesinfhuerfana']=='bdtc_rsntc_bib') {
?>  
						<th class="borderR">Base de datos</th>
						<th class="borderR">Suscripciones</th>
<?php
					}
					if($row2['aliasclasificacionesinfhuerfana']=='bds_rsntc_bib') {
?>  
						<th class="borderR">Descripción</th>
						<th class="borderR">Número de consultas</th>
						<th class="borderR">Títulos de libros electrónicos</th>
						<th class="borderR">Títulos de revistas electrónicas</th>
<?php
					}
					if($row2['aliasclasificacionesinfhuerfana']=='bddat_rsntc_bib') {
?>  
						<th class="borderR">Área / Facultad</th>
						<th class="borderR">Bases de datos suscritas</th>
						<th class="borderR">Títulos de libros electrónicos</th>
						<th class="borderR">Títulos de revistas electrónicas</th>
<?php
					}
?>  
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
<?php
						if($row2['aliasclasificacionesinfhuerfana']=='bdtc_rsntc_bib') {
?>  
							<td class="column borderR" align="center">
								<input type="text" class="grid-8-12 required number" name="suscripciones[]" id="suscripciones_<?php echo $row['idclasificacionesinfhuerfana']?>" title="Suscripciones" maxlength="20" tabindex="1" autocomplete="off" size="6" style='text-align:center' />
								<input type="hidden" name="numero_consultas[]" id="numero_consultas_<?php echo $row['idclasificacionesinfhuerfana']?>" />
								<input type="hidden" name="bases_datos[]" id="bases_datos_<?php echo $row['idclasificacionesinfhuerfana']?>" />
								<input type="hidden" name="titulos_libros_electronicos[]" id="titulos_libros_electronicos_<?php echo $row['idclasificacionesinfhuerfana']?>" />
								<input type="hidden" name="titulos_revistas_electronicas[]" id="titulos_revistas_electronicas_<?php echo $row['idclasificacionesinfhuerfana']?>" />
							</td>
<?php
						}
						if($row2['aliasclasificacionesinfhuerfana']=='bds_rsntc_bib') {
?>
							<td class="column borderR" align="center">
								<input type="hidden" name="suscripciones[]" id="suscripciones_<?php echo $row['idclasificacionesinfhuerfana']?>" />
								<input type="text" class="grid-8-12 required number" name="numero_consultas[]" id="numero_consultas_<?php echo $row['idclasificacionesinfhuerfana']?>" title="Número de consultas" maxlength="20" tabindex="1" autocomplete="off" size="6" style='text-align:center' />
								<input type="hidden" name="bases_datos[]" id="bases_datos_<?php echo $row['idclasificacionesinfhuerfana']?>" />
							</td>
							<td class="column borderR" align="center"><input type="text" class="grid-8-12 required number" name="titulos_libros_electronicos[]" id="titulos_libros_electronicos_<?php echo $row['idclasificacionesinfhuerfana']?>" title="Títulos de libros electrónicos" maxlength="20" tabindex="1" autocomplete="off" size="6" style='text-align:center' /></td>
							<td class="column borderR" align="center"><input type="text" class="grid-8-12 required number" name="titulos_revistas_electronicas[]" id="titulos_revistas_electronicas_<?php echo $row['idclasificacionesinfhuerfana']?>" title="Títulos de revistas electrónicas" maxlength="20" tabindex="1" autocomplete="off" size="6" style='text-align:center' /></td>
<?php
						}
						if($row2['aliasclasificacionesinfhuerfana']=='bddat_rsntc_bib') {
?>
							<td class="column borderR" align="center">
								<input type="hidden" name="suscripciones[]" id="suscripciones_<?php echo $row['idclasificacionesinfhuerfana']?>" />
								<input type="hidden" name="numero_consultas[]" id="numero_consultas_<?php echo $row['idclasificacionesinfhuerfana']?>" />
								<input type="text" class="grid-8-12 required number" name="bases_datos[]" id="bases_datos_<?php echo $row['idclasificacionesinfhuerfana']?>" title="Bases de datos suscritas" maxlength="20" tabindex="1" autocomplete="off" size="6" style='text-align:center' />
							</td>
							<td class="column borderR" align="center"><input type="text" class="grid-8-12 required number" name="titulos_libros_electronicos[]" id="titulos_libros_electronicos_<?php echo $row['idclasificacionesinfhuerfana']?>" title="Títulos de libros electrónicos" maxlength="20" tabindex="1" autocomplete="off" size="6" style='text-align:center' /></td>
							<td class="column borderR" align="center"><input type="text" class="grid-8-12 required number" name="titulos_revistas_electronicas[]" id="titulos_revistas_electronicas_<?php echo $row['idclasificacionesinfhuerfana']?>" title="Títulos de revistas electrónicas" maxlength="20" tabindex="1" autocomplete="off" size="6" style='text-align:center' /></td>
<?php
						}
?>
                                                        
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
	<input type="submit" value="Guardar cambios" id="enviar9" name="enviar9" class="first" />
</form>
<script type="text/javascript">
var aprobacion = '<?php echo $aprobacion; ?>';  
    getData9("#forma<?php echo $_REQUEST['alias']?>");
    
                $('#enviar9').click(function(event) {
                    event.preventDefault();
                    var valido= validateForm("#forma<?php echo $_REQUEST['alias']?>");
                    if(valido){
                        sendForm9("#forma<?php echo $_REQUEST['alias']?>");
                    }
                });
                
     $('#forma<?php echo $_REQUEST['alias']?> #mes').bind('change', function(event) {
          getData9("#forma<?php echo $_REQUEST['alias']?>");
    });
    
    function getData9(formName){
                  //  alert('aca.. ')
    
                    var periodo = $(formName + ' #mes').val();
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
                                       //alert(data[i].idclasificacionesinfhuerfana+'-->>'+data[i].material_especial+'-'+data[i].revistas_indexadas+'-'+data[i].nro_ctas_creadas+'-->>')
                                        
                                        $(formName + " #idclasificacionesinfhuerfana_"+data[i].idclasificacionesinfhuerfana).val(data[i].idclasificacionesinfhuerfana);
                                        $(formName + " #id_"+data[i].idclasificacionesinfhuerfana).val(data[i].id);
                                        $(formName + " #suscripciones_"+data[i].idclasificacionesinfhuerfana).val(data[i].suscripciones);
                                        $(formName + " #numero_consultas_"+data[i].idclasificacionesinfhuerfana).val(data[i].numero_consultas);
                                        $(formName + " #bases_datos_"+data[i].idclasificacionesinfhuerfana).val(data[i].bases_datos);
                                        $(formName + " #titulos_libros_electronicos_"+data[i].idclasificacionesinfhuerfana).val(data[i].titulos_libros_electronicos);
                                        $(formName + " #titulos_revistas_electronicas_"+data[i].idclasificacionesinfhuerfana).val(data[i].titulos_revistas_electronicas);
                                        
                                         if(data[i].Verificado=="1"){ 
                                           $(formName + " #Verificado").attr("checked", true);
                                           $(formName + ' #msg-success').html('<p> Ya esta validado</p>');
                                           $(formName + ' #msg-success').removeClass('msg-error');
                                           $(formName + ' #msg-success').css('display','block');
                                           $(formName + " #msg-success").delay(5500).fadeOut(300);
                                           $(formName + " #enviar9").attr('disabled','disabled');
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
                                        document.forms[formName.replace("#","")].reset();
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
                
       function sendForm9(formName){
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
