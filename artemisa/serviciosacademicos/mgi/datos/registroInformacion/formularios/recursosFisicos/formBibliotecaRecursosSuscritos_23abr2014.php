<? 
session_start();
require_once("../../../templates/template.php");
$db = getBD();
$utils = new Utils_datos();
if($utils->UsuarioAprueba_FormHuerfana($db,$usuario_con)){
        $aprobacion=true;
 }
?>
<form action="" method="post" id="forma<?=$_REQUEST['alias']?>">
     <input type="hidden" name="entity" id="entity" value="<?=$_REQUEST['alias']?>" />
        <input type="hidden" name="action" value="saveDynamic2" id="action" />
	<span class="mandatory">* Son campos obligatorios</span>
	<fieldset>  
		<legend>Recursos suscritos – Número de títulos y consultas</legend>
		<label for="mes" class="grid-2-12">Mes: <span class="mandatory">(*)</span></label>
<?		
		$utils->getMonthsSelect("mes"); 
		$utils->getYearsSelect("anio"); 
                 $idForm = "forma".$_REQUEST['alias'];
                 $utils->pintarBotonCargar("popup_cargarDocumento(2,9,$('#".$idForm." #mes').val()+'-'+$('#".$idForm." #anio').val())","popup_verDocumentos(2,9,$('#".$idForm." #mes').val()+'-'+$('#".$idForm." #anio').val())");

?>
		<table align="center" class="formData last" width="92%">
                   <?php if($aprobacion){ ?> 
                    <tr class="dataColumns category">
                                <th class="column" colspan="5"><span>
                                                <input type="hidden" value="0" name="VerEscondido" id="VerEscondido" />
                                                <input type="checkbox"  class="grid-4-12 required number" minlength="1" name="Verificado" id="Verificado" title="Verificado" maxlength="10" tabindex="1" autocomplete="off" value="1" />
                                           </span></th>  
                                           
                                </tr>
                       <?php } ?>
<?
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
				if($row2['aliasclasificacionesinfhuerfana']=='re_rsntc_bib' || $row2['aliasclasificacionesinfhuerfana']=='le_rsntc_bib' || $row2['aliasclasificacionesinfhuerfana']=='bdxs_rsntc_bib')
					$colspan1=5;
				if($row2['aliasclasificacionesinfhuerfana']=='bde_rsntc_bib' || $row2['aliasclasificacionesinfhuerfana']=='bdaa_rsntc_bib' || $row2['aliasclasificacionesinfhuerfana']=='ova_rsntc_bib' || $row2['aliasclasificacionesinfhuerfana']=='bdc_rsntc_bib')
					//$colspan=3;
                                        $colspan1=5;
				if($row2['aliasclasificacionesinfhuerfana']=='gr_rsntc_bib') 
					//$colspan=2;
                                        $colspan1=5;
                                        $colspan2=4;
?>
				<tr class="dataColumns category">
					<th colspan="<?php echo $colspan1 ?>"class="borderR"><?=$row2['clasificacionesinfhuerfana']?></th>               
                                       
                                </tr>
				<tr class="dataColumns">
					<th class="borderR">Descripción</th>
<?
					if($row2['aliasclasificacionesinfhuerfana']=='re_rsntc_bib' || $row2['aliasclasificacionesinfhuerfana']=='le_rsntc_bib' || $row2['aliasclasificacionesinfhuerfana']=='bdxs_rsntc_bib') {
?>  
						<th class="borderR">No. Títulos Revista Imp.</th>
						<th class="borderR">No. Títulos Revista Elec.</th>
						<th class="borderR">No. Títulos Libros</th>
						<th class="borderR">Número de consultas</th>
<?
					}
					if($row2['aliasclasificacionesinfhuerfana']=='bde_rsntc_bib' || $row2['aliasclasificacionesinfhuerfana']=='bdaa_rsntc_bib' || $row2['aliasclasificacionesinfhuerfana']=='ova_rsntc_bib') {
?>  
						<th class="borderR" colspan="2">Material especial</th>
						<th class="borderR" colspan="2">Número de consultas</th>
<?
					}
					if($row2['aliasclasificacionesinfhuerfana']=='bdc_rsntc_bib') {
?>  
						<th class="borderR" colspan="2">Revistas indexadas</th>
						<th class="borderR" colspan="2">Número de consultas</th>
<?
					}
					if($row2['aliasclasificacionesinfhuerfana']=='gr_rsntc_bib') {
?>  
						<th class="borderR" colspan="4">No. de cuentas creadas</th>
<?
					}
?>  
				</tr>
	<?
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
							<input type="hidden" name="aux[<?=$row['idclasificacionesinfhuerfana']?>]" value="<?=$row['idclasificacionesinfhuerfana']?>">
							<?=$row['clasificacionesinfhuerfana']?>: <span class="mandatory">(*)</span>
                                                        <input type="hidden"  class="grid-3-12 required number" minlength="1" name="idclasificacionesinfhuerfana[]" id="idclasificacionesinfhuerfana_<?php echo $row["idclasificacionesinfhuerfana"]; ?>" value="<?php echo $row["idclasificacionesinfhuerfana"]; ?>" />
                                                        <input type="hidden" name="id[]" value="" id="id_<?php echo $row["idclasificacionesinfhuerfana"]; ?>" /></td>
                           
						</td>
<?
						if($row2['aliasclasificacionesinfhuerfana']=='re_rsntc_bib' || $row2['aliasclasificacionesinfhuerfana']=='le_rsntc_bib' || $row2['aliasclasificacionesinfhuerfana']=='bdxs_rsntc_bib') {
?>  
							<td class="column borderR" align="center"><input type="text" class="required number" name="nro_titulos_revista_imp[]" id="nro_titulos_revista_imp_<?=$row['idclasificacionesinfhuerfana']?>" title="No. Títulos Revista Imp." maxlength="3" tabindex="1" autocomplete="off" size="6" style='text-align:center' /></td>
							<td class="column borderR" align="center"><input type="text" class="required number" name="nro_titulos_revista_elec[]" id="nro_titulos_revista_elec_<?=$row['idclasificacionesinfhuerfana']?>" title="No. Títulos Revista Elec." maxlength="3" tabindex="1" autocomplete="off" size="6" style='text-align:center' /></td>
							<td class="column borderR" align="center"><input type="text" class="required number" name="nro_titulos_libros[]" id="nro_titulos_libros_<?=$row['idclasificacionesinfhuerfana']?>" title="No. Títulos Libros" maxlength="3" tabindex="1" autocomplete="off" size="6" style='text-align:center' /></td>
							<td class="column borderR" align="center"><input type="text" class="required number" name="nro_consultas[]" id="nro_consultas_<?=$row['idclasificacionesinfhuerfana']?>" title="Número de consultas" maxlength="3" tabindex="1" autocomplete="off" size="6" style='text-align:center' />
                                                        <input type="hidden" class="required number" name="material_especial[]" id="material_especial_<?=$row['idclasificacionesinfhuerfana']?>" value="0" />
                                                        <input type="hidden" class="required number" name="revistas_indexadas[]" id="revistas_indexadas_<?=$row['idclasificacionesinfhuerfana']?>" value="0" />
                                                         <input type="hidden" class="required number" name="nro_ctas_creadas[]" id="nro_ctas_creadas_<?=$row['idclasificacionesinfhuerfana']?>" value="0" />
                                                        </td>
                                                        
<?
						}
						if($row2['aliasclasificacionesinfhuerfana']=='bde_rsntc_bib' || $row2['aliasclasificacionesinfhuerfana']=='bdaa_rsntc_bib' || $row2['aliasclasificacionesinfhuerfana']=='ova_rsntc_bib') {
?>  
							<td class="column borderR" align="center" colspan="2"><input type="text" class="required number" name="material_especial[]" id="material_especial_<?=$row['idclasificacionesinfhuerfana']?>" title="Material especial" maxlength="3" tabindex="1" autocomplete="off" size="6" style='text-align:center' /></td>
							<td class="column borderR" align="center" colspan="2"><input type="text" class="required number" name="nro_consultas[]" id="nro_consultas_<?=$row['idclasificacionesinfhuerfana']?>" title="Número de consultas" maxlength="3" tabindex="1" autocomplete="off" size="6" style='text-align:center' />
                                                        <input type="hidden" class="required number" name="nro_ctas_creadas[]" id="nro_ctas_creadas_<?=$row['idclasificacionesinfhuerfana']?>" value="0" /></td>
<?
						}
						if($row2['aliasclasificacionesinfhuerfana']=='bdc_rsntc_bib') {
?>  
							<td class="column borderR" align="center" colspan="2"><input type="text" class="required number" name="revistas_indexadas[]" id="revistas_indexadas_<?=$row['idclasificacionesinfhuerfana']?>" title="Revistas indexadas" maxlength="3" tabindex="1" autocomplete="off" size="6" style='text-align:center' /></td>
							<td class="column borderR" align="center" colspan="2"><input type="text" class="required number" name="nro_consultas[]" id="nro_consultas_<?=$row['idclasificacionesinfhuerfana']?>" title="Número de consultas" maxlength="3" tabindex="1" autocomplete="off" size="6" style='text-align:center' />
                                                        <input type="hidden" class="required number" name="nro_ctas_creadas[]" id="nro_ctas_creadas_<?=$row['idclasificacionesinfhuerfana']?>" value="0" /></td>
<?
						}
						if($row2['aliasclasificacionesinfhuerfana']=='gr_rsntc_bib') {
?>  
							<td class="column borderR" align="center" colspan="4"><input type="text" class="required number" name="nro_ctas_creadas[]" id="nro_ctas_creadas_<?=$row['idclasificacionesinfhuerfana']?>" title="No. de cuentas creadas" maxlength="3" tabindex="1" autocomplete="off" size="6" style='text-align:center' /></td>
<?
						}
?>  
					</tr>	
	<?
				}
			}
	?>
		</table>
                
                <div class="vacio"></div>
                <div id="msg-success" class="msg-success" style="display:none"><p>Los datos han sido guardados de forma correcta.</p></div>
	</fieldset>
	<input type="hidden" name="alias" value="<?=$_REQUEST['alias']?>" />
	<input type="submit" value="Guardar cambios" id="enviar9" name="enviar9" class="first" />
</form>
<script type="text/javascript">
var aprobacion = '<?php echo $aprobacion; ?>';  
    getData9("#forma<?=$_REQUEST['alias']?>");
    
                $('#enviar9').click(function(event) {
                    event.preventDefault();
                    var valido= validateForm("#forma<?=$_REQUEST['alias']?>");
                    if(valido){
                        sendForm9("#forma<?=$_REQUEST['alias']?>");
                    }
                });
                
     $('#forma<?=$_REQUEST['alias']?> #mes').bind('change', function(event) {
          getData9("#forma<?=$_REQUEST['alias']?>");
    });
    
     $('#forma<?=$_REQUEST['alias']?> #anio').bind('change', function(event) {
          getData9("#forma<?=$_REQUEST['alias']?>");
    });
    
    function getData9(formName){
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
                                       //alert(data[i].idclasificacionesinfhuerfana+'-->>'+data[i].material_especial+'-'+data[i].revistas_indexadas+'-'+data[i].nro_ctas_creadas+'-->>')
                                        
                                        $(formName + " #idclasificacionesinfhuerfana_"+data[i].idclasificacionesinfhuerfana).val(data[i].idclasificacionesinfhuerfana);
                                        $(formName + " #id_"+data[i].idclasificacionesinfhuerfana).val(data[i].id);
                                        $(formName + " #nro_titulos_revista_imp_"+data[i].idclasificacionesinfhuerfana).val(data[i].nro_titulos_revista_imp);
                                        $(formName + " #nro_titulos_revista_elec_"+data[i].idclasificacionesinfhuerfana).val(data[i].nro_titulos_revista_elec);
                                        $(formName + " #nro_titulos_libros_"+data[i].idclasificacionesinfhuerfana).val(data[i].nro_titulos_libros);
                                        $(formName + " #nro_consultas_"+data[i].idclasificacionesinfhuerfana).val(data[i].nro_consultas);
                                        $(formName + " #material_especial_"+data[i].idclasificacionesinfhuerfana).val(data[i].material_especial);
                                        $(formName + " #revistas_indexadas_"+data[i].idclasificacionesinfhuerfana).val(data[i].revistas_indexadas);
                                        $(formName + " #nro_ctas_creadas_"+data[i].idclasificacionesinfhuerfana).val(data[i].nro_ctas_creadas);
                                        
                                         if(data[i].Verificado=="1"){ 
                                           $(formName + " #Verificado").attr("checked", true);
                                           $(formName + ' #msg-success').html('<p> Ya esta validado</p>');
                                           $(formName + ' #msg-success').removeClass('msg-error');
                                           $(formName + ' #msg-success').css('display','block');
                                           $(formName + " #msg-success").delay(5500).fadeOut(300);
                                           $(formName + " #enviar9").attr('disabled','disabled');
                                           $(formName).find(':input').each(function() {
                                                 $(this).attr('readonly', true).addClass("disable");
                                                 $(this).removeAttr("disabled");
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
