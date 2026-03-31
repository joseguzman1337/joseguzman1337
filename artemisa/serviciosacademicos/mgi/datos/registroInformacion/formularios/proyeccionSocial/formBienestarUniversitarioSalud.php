<?PHP  
session_start();
require_once("../../../templates/template.php");
require_once("./functionsBienestar.php"); 
$db = getBD();
$utils = new Utils_datos();
?>
<script>
    //pintar nuevas categorias
             var formName = '#forma<?=$_REQUEST['alias']?>';
             var mes = $(formName+' #mes').val()
                var anio = $(formName+' #anio').val();
                var alias = "<?PHP echo  $_REQUEST['alias']?>";
                        $.ajax({
                            dataType: 'json',
                            type: 'POST',
                            url: './formularios/proyeccionSocial/functionsBienestar.php',
                            data: { mes: mes, action: "getCategories", anio: anio, alias: alias, tipo: 2 },     
                            success:function(data){
                                if (data.success == true){
                                    //borro todas las filas
                                    $(formName + ' table').children('tbody').children('tr').remove(); 
                                     $(formName + ' table').children('tbody').html(data.data);
                                }
                            },
                            error: function(data,error,errorThrown){alert(error + errorThrown);}
                        }); 
</script>
<form action="" method="post" id="forma<? echo $_REQUEST['alias']?>">
	<span class="mandatory">* Son campos obligatorios</span>
	<fieldset>  
		<legend>Estadísticas área de la salud</legend>
		<label class="fixedLabel">Mes: <span class="mandatory">(*)</span></label>
                <?php $utils->getMonthsSelect(); ?>
                
                <label class="fixedLabel" style="clear:none;width:90px">Año: <span class="mandatory">(*)</span></label>
                <?php $utils->getYearsSelect("anio"); ?>
            <input type="hidden" name="semestre" value="" id="semestre" />             
                
		<!--<label for="semestre" class="grid-2-12">Semestre: <span class="mandatory">(*)</span></label>-->
		<?php //$utils->getSemestresSelect($db,"semestre");
                 $idForm = "forma".$_REQUEST['alias'];
                 $utils->pintarBotonCargar("popup_cargarDocumento(3,2,$('#".$idForm." #mes').val()+'-'+$('#".$idForm." #anio').val())","popup_verDocumentos(3,2,$('#".$idForm." #mes').val()+'-'+$('#".$idForm." #anio').val())");  ?>
		<table align="center" class="formData last" width="92%">
                    <tbody>
<?PHP 
			$query2="select	 sch.clasificacionesinfhuerfana
					,sch.aliasclasificacionesinfhuerfana,
                                        sch.idclasificacionesinfhuerfana
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
					<th colspan="7" class="borderR"><?PHP echo  $row2['clasificacionesinfhuerfana']?></th>               
				</tr>
				<tr class="dataColumns">
					<th rowspan="2" class="borderR">Servicio o actividad</th>               
					<th colspan="3" class="borderR">Estudiantes</th>               
					<th rowspan="2" class="borderR">Docentes</th>               
					<th rowspan="2" class="borderR">Administrativos</th>
					<th rowspan="2" class="borderR">Familiares</th>
				</tr>
				<tr class="dataColumns ">
					<th>Pregado</th>               
					<th>Posgrado</th>
					<th class="borderR">Egresados</th>
				</tr>
	<?PHP 
				$query=getQueryCateories($db,$row2['idclasificacionesinfhuerfana']);
				$exec= $db->Execute($query);
				while($row = $exec->FetchRow()) {
	?>
					<tr id="contentColumns" class="row">
						<td class="column borderR">
							<input type="hidden" name="aux[<?PHP echo  $row['idclasificacionesinfhuerfana']?>]" value="<?PHP echo  $row['idclasificacionesinfhuerfana']?>">
							<?PHP echo  $row['clasificacionesinfhuerfana']?>: <span class="mandatory">(*)</span>
						</td>
						<td class="column" align="center"><input type="text" class="required number" name="pregrado[<?PHP echo  $row['idclasificacionesinfhuerfana']?>]" id="pregrado[<?PHP echo  $row['idclasificacionesinfhuerfana']?>]" title="Pregado" maxlength="10" tabindex="1" autocomplete="off" size="6" style='text-align:center' /></td>
						<td class="column" align="center"><input type="text" class="required number" name="posgrado[<?PHP echo  $row['idclasificacionesinfhuerfana']?>]" id="posgrado[<?PHP echo  $row['idclasificacionesinfhuerfana']?>]" title="Posgrado" maxlength="10" tabindex="1" autocomplete="off" size="6" style='text-align:center' /></td>
						<td class="column borderR" align="center"><input type="text" class="required number" name="egresados[<?PHP echo  $row['idclasificacionesinfhuerfana']?>]" id="egresados[<?PHP echo  $row['idclasificacionesinfhuerfana']?>]" title="Egresados" maxlength="10" tabindex="1" autocomplete="off" size="6" style='text-align:center' /></td>
						<td class="column borderR" align="center"><input type="text" class="required number" name="docentes[<?PHP echo  $row['idclasificacionesinfhuerfana']?>]" id="docentes[<?PHP echo  $row['idclasificacionesinfhuerfana']?>]" title="Docentes" maxlength="10" tabindex="1" autocomplete="off" size="6" style='text-align:center' /></td>
						<td class="column borderR" align="center"><input type="text" class="required number" name="administrativos[<?PHP echo  $row['idclasificacionesinfhuerfana']?>]" id="administrativos[<?PHP echo  $row['idclasificacionesinfhuerfana']?>]" title="Administrativos" maxlength="10" tabindex="1" autocomplete="off" size="6" style='text-align:center' /></td>
						<td class="column borderR" align="center"><input type="text" class="required number" name="familiares[<?PHP echo  $row['idclasificacionesinfhuerfana']?>]" id="familiares[<?PHP echo  $row['idclasificacionesinfhuerfana']?>]" title="Familiares" maxlength="10" tabindex="1" autocomplete="off" size="6" style='text-align:center' /></td>
					</tr>
	<?PHP 
				}
			}
	?>
                </tbody>
		</table>
                
                <div class="vacio"></div>
                <div id="respuesta_forma<?PHP echo $_REQUEST['alias']?>" class="msg-success" style="display:none"></div>
	</fieldset>
	<input type="hidden" name="alias" value="<?PHP echo  $_REQUEST['alias']?>" />
	<input type="submit" value="Guardar cambios" class="first" />
</form>
<script type="text/javascript">
	$(':submit').click(function(event) {
		event.preventDefault();
		var valido= validateForm("#forma<?PHP echo $_REQUEST['alias']?>");
		if(valido){
			sendForm();
		}
	});
        
        $('#forma<?PHP echo $_REQUEST['alias']?> #mes').add('#forma<?PHP echo $_REQUEST['alias']?> #anio').bind('change', function(event) {
             //pintar nuevas categorias
             var formName = '#forma<?PHP echo $_REQUEST['alias']?>';
             var mes = $(formName+' #mes').val()
                var anio = $(formName+' #anio').val();
                var alias = "<?PHP echo  $_REQUEST['alias']?>";
                        $.ajax({
                            dataType: 'json',
                            type: 'POST',
                            url: './formularios/proyeccionSocial/functionsBienestar.php',
                            data: { mes: mes, action: "getCategories", anio: anio, alias: alias, tipo: 2 },     
                            success:function(data){
                                if (data.success == true){
                                    //borro todas las filas
                                    $(formName + ' table').children('tbody').children('tr').remove(); 
                                     $(formName + ' table').children('tbody').html(data.data);
                                }
                            },
                            error: function(data,error,errorThrown){alert(error + errorThrown);}
                        });  
        });
        
	function sendForm(){
            var periodo = $('#forma<?PHP echo $_REQUEST['alias']?> #mes').val()+$('#forma<?PHP echo $_REQUEST['alias']?> #anio').val();
                $('#forma<?PHP echo $_REQUEST['alias']?> #semestre').val(periodo);
                if($('#forma<?PHP echo $_REQUEST['alias']?> table').children('tbody').children('tr').length>0){
                    $.ajax({
                                    dataType: 'json',
                                    type: 'POST',
                                    url: 'formularios/proyeccionSocial/saveBienestarUniversitario.php',
                                    data: $('#forma<?PHP echo $_REQUEST['alias']?>').serialize(),                
                                    success:function(data){
                                    if (data.success == true){
                                            $('#respuesta_forma<?PHP echo $_REQUEST['alias']?>').html('<p>' + data.message + '</p>');
                                            $('#respuesta_forma<?PHP echo $_REQUEST['alias']?>').removeClass('msg-error');
                                            $('#respuesta_forma<?PHP echo $_REQUEST['alias']?>').css('display','block');
                                            $("#respuesta_forma<?PHP echo $_REQUEST['alias']?>").delay(5500).fadeOut(800);
                                    } else {

                        if(confirm(data.message+'\n Desea Modificar esta Informacion')){
                            /************************************************************************/
                            $.ajax({
                                            dataType: 'json',
                                            type: 'POST',
                                            url: 'formularios/proyeccionSocial/saveBienestarUniversitario.php?Modificar=1',
                                            data: $('#forma<?PHP echo $_REQUEST['alias']?>').serialize(),                
                                            success:function(data){
                                                if(data.val=='TRUE'){
                                                    $('#respuesta_forma<?PHP echo $_REQUEST['alias']?>').html('<p>' + data.message + '</p>');
                                                            $('#respuesta_forma<?PHP echo $_REQUEST['alias']?>').removeClass('msg-error');
                                                            $('#respuesta_forma<?PHP echo $_REQUEST['alias']?>').css('display','block');
                                            $("#respuesta_forma<?PHP echo $_REQUEST['alias']?>").delay(5500).fadeOut(800);
                                                }
                                        },//Data
                                    error: function(data,error,errorThrown){alert(error + errorThrown);}
                            }); //Ajax    
                            /************************************************************************/
                        }else{
                            $('#respuesta_forma<?PHP echo $_REQUEST['alias']?>').html('<p>' + data.message + '</p>');
                            $('#respuesta_forma<?PHP echo $_REQUEST['alias']?>').addClass('msg-error');
                            $('#respuesta_forma<?PHP echo $_REQUEST['alias']?>').css('display','block');
                            $("#respuesta_forma<?PHP echo $_REQUEST['alias']?>").delay(5500).fadeOut(800);
                        }

                                    }
                            },
                            error: function(data,error,errorThrown){alert(error + errorThrown);}
                    });  
                } else {
                    alert("Debe escoger un periodo con actividades activas y diligenciar las estadísticas para guardar.");
                }
	}
</script>
