<? 
session_start();
require_once("../../../templates/template.php");
$db = getBD();
$utils = new Utils_datos();
//echo $_REQUEST['alias'].'-->';  
$usuario_con=$_SESSION['MM_Username'];
    if($utils->UsuarioAprueba_FormHuerfana($db,$usuario_con)){
        $aprobacion=true;
   }
?>
<form action="" method="post" id="forma<?=$_REQUEST['alias']?>">
        <input type="hidden" name="entity" id="entity" value="<?=$_REQUEST['alias']?>" />
        <input type="hidden" name="action" value="saveDynamic2" id="action" />
	<span class="mandatory">* Son campos obligatorios</span>
	<fieldset>  
		<legend>Volúmenes y títulos de colecciones</legend>
		<label for="mes" class="grid-2-12">Mes: <span class="mandatory">(*)</span></label>
<?		
		$utils->getMonthsSelect("mes"); 
		$utils->getYearsSelect("anio"); 
                $idForm = "forma".$_REQUEST['alias'];
                 $utils->pintarBotonCargar("popup_cargarDocumento(2,1,$('#".$idForm." #mes').val()+'-'+$('#".$idForm." #anio').val())","popup_verDocumentos(2,1,$('#".$idForm." #mes').val()+'-'+$('#".$idForm." #anio').val())"); ?>
                
		<table align="center" class="formData last" width="92%">
                    <?php if($aprobacion){ ?>
                    <tr class="dataColumns category">
                            <th colspan="<?php if($aprobacion) echo "2"; else echo "3";?>" class="borderR"><?=$row2['clasificacionesinfhuerfana']?></th>      

                                <th class="column"><span>
                                    <input type="hidden" value="0" name="Verificado" id="Verificado" />
                                    <input type="checkbox"  class="grid-4-12 required number" minlength="1" name="VerEscondido" id="VerEscondido" title="Verificado" maxlength="10" tabindex="1" autocomplete="off" value="1" />
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
?>
				<tr class="dataColumns category">
					<th colspan="3" class="borderR"><?=$row2['clasificacionesinfhuerfana']?></th>      
				</tr>
				<tr class="dataColumns">
					<th class="borderR">Tipo material</th>               
					<th class="borderR">Títulos</th>               
					<th class="borderR">Volúmenes</th>               
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
						<td class="column borderR" align="center">
                                                    <input type="text" class="required number" name="titulos[]" id="titulos_<?=$row['idclasificacionesinfhuerfana']?>" title="Títulos" maxlength="3" tabindex="1" autocomplete="off" size="6" style='text-align:center' />
                                                </td>
						<td class="column borderR" align="center">
                                                    <input type="text" class="required number" name="volumenes[]" id="volumenes_<?=$row['idclasificacionesinfhuerfana']?>" title="Volúmenes" maxlength="3" tabindex="1" autocomplete="off" size="6" style='text-align:center' />
                                                </td>
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
	<input type="submit" id="enviar1" name="enviar1" value="Guardar cambios" class="first" />
</form>
<script type="text/javascript">
var aprobacion = '<?php echo $aprobacion; ?>';  
    getData1("#forma<?=$_REQUEST['alias']?>");
    
                $('#enviar1').click(function(event) {
                    event.preventDefault();
                    var valido= validateForm("#forma<?=$_REQUEST['alias']?>");
                    if(valido){
                        sendForm1("#forma<?=$_REQUEST['alias']?>");
                    }
                });
                
     $('#forma<?=$_REQUEST['alias']?> #mes').bind('change', function(event) {
          getData1("#forma<?=$_REQUEST['alias']?>");
    });
    
     $('#forma<?=$_REQUEST['alias']?> #anio').bind('change', function(event) {
          getData1("#forma<?=$_REQUEST['alias']?>");
    });
    
    function getData1(formName){
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
                    //               alert('aca');
                                    for (var i=0;i<data.total;i++){                                  
                                      //  alert(data[i].id+'-'+data[i].idclasificacionesinfhuerfana+'-'+data[i].Verificado+'-->>')
                                        
                                        $(formName + " #idclasificacionesinfhuerfana_"+data[i].idclasificacionesinfhuerfana).val(data[i].idclasificacionesinfhuerfana);
                                        $(formName + " #id_"+data[i].idclasificacionesinfhuerfana).val(data[i].id);
                                        $(formName + " #titulos_"+data[i].idclasificacionesinfhuerfana).val(data[i].titulos);
                                        $(formName + " #volumenes_"+data[i].idclasificacionesinfhuerfana).val(data[i].volumenes);
                                        
                                         if(data[i].Verificado=="1"){ 
                                           $(formName + " #VerEscondido").attr("checked", true);
                                           $(formName + ' #msg-success').html('<p> Ya esta validado</p>');
                                           $(formName + ' #msg-success').removeClass('msg-error');
                                           $(formName + ' #msg-success').css('display','block');
                                           $(formName + " #msg-success").delay(5500).fadeOut(300);
                                           $(formName + " #enviar1").attr('disabled','disabled');
                                           $(formName).find(':input').each(function() {
                                                 $(this).attr('readonly', true).addClass("disable");
                                                 $(this).removeAttr("disabled");
                                            });
                                          }else{
                                               
                                              $(formName).find(':input').each(function() {
                                                 $(this).removeAttr("readonly").removeClass("disable");
                                            }); 
                                           // $(formName + " #enviafinanciamiento").removeAttr('disabled','disabled');
                                              $(formName + " #VerEscondido").attr("checked", false);
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
                                            $(formName + " #VerEscondido").attr("checked", false);
                                            
                                            $(formName).find(':input').each(function() {
                                                       $(this).removeAttr("readonly").removeClass("disable");
                                            });
                                     }
                                }
                            },
                            error: function(data,error,errorThrown){alert(error + errorThrown);}
                        });  
                }
                
       function sendForm1(formName){
                 $(formName + " input[type=checkbox]:checked" ).each(function() {
                        var id= $( this ).attr( "id" );
                        $(formName + " #Verificado").val(1); 
                       // $( "#VerEscondido").attr("disabled","disabled");
                      });

                      $(formName + " input[type=checkbox]:not(:checked)" ).each(function() {
                        var id= $( this ).attr( "id" );
                       // $( "#VerEscondido").removeAttr("disabled");
                       // alert('aca..')
                        $(formName + " #Verificado").val(0); 
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

