<?php

session_start();
require_once("../../../templates/template.php");
$db = getBD();
$utils = new Utils_datos();

?>
<form action="" method="post" id="form1_ti">
	<input type="hidden" name="formulario" value="form1_ti" />
	<input type="hidden" name="action" value="SelectDynamic" id="action" />
	<span class="mandatory">* Son campos obligatorios</span>
	<fieldset>  
		<legend>Capacitaciones</legend>
		<?php
		$query_papa = "select idclasificacionesinfhuerfana,clasificacionesinfhuerfana from siq_clasificacionesinfhuerfana where aliasclasificacionesinfhuerfana='T_CTIC'";
        $papa= $db->Execute($query_papa);
        $totalRows_papa = $papa->RecordCount();
		$row_papa = $papa->FetchRow();
		?> 
		<input type="hidden" name="padre" value="<?php echo $row_papa['idclasificacionesinfhuerfana']; ?>" />               
		<legend><?php echo $row_papa['clasificacionesinfhuerfana']; ?></legend>
		<label class="fixedLabel">Mes: <span class="mandatory">(*)</span></label>
		<?php $utils->getMonthsSelect(); ?>
		<label class="fixedLabel" style="clear:none;width:90px">Año: <span class="mandatory">(*)</span></label>
        <?php $utils->getYearsSelect("anio");  ?>
        <input type="hidden" name="semestre" value="" id="semestre" /> 
		
		<table align="center" id="estructuraReporte"  class="formData last" width="92%">
			<thead>             			
				<tr id="dataColumns">
					<th class="column borderR" ><span>Herramienta Tecnológica</span></th>
                    <th class="column borderR" ><span>Cantidad</span></th>
                    <th class="column borderR" ><span>Tipo Usuario</span></th>                            
				</tr>
            </thead>
            <tbody>
            	<?php 
            	$query_sectores = "select idclasificacionesinfhuerfana,clasificacionesinfhuerfana from siq_clasificacionesinfhuerfana where idpadreclasificacionesinfhuerfana ='".$row_papa['idclasificacionesinfhuerfana']."' 
                          AND estado=1 order by 2 ";
		      	$sectores= $db->Execute($query_sectores);
		      	$totalRows_sectores = $sectores->RecordCount();
		      	while($row_sectores = $sectores->FetchRow()){ 
		      		?>
		      		<tr id="contentColumns" class="row">
			  			<td class ="center"><?php echo $row_sectores['clasificacionesinfhuerfana']; ?>:<span class="mandatory">(*)</span></td>
			  			<td class="center"  name="cantidad_<?php echo $row_sectores['idclasificacionesinfhuerfana']; ?>" id ="cantidad_<?php echo $row_sectores['idclasificacionesinfhuerfana']; ?>"></td>
			  			<td class="center"  name="caracteristicas_<?php echo $row_sectores['idclasificacionesinfhuerfana']; ?>" id="caracteristicas_<?php echo $row_sectores['idclasificacionesinfhuerfana']; ?>"></td>
			      </tr>
			      <?php 
			  }
			  ?>	
			  <tr id="contentColumns" class="row">
			  		<th class="column borderR total right" >Total:<span class="mandatory"></span></th>
			  		<th class="center total" name="sumaCantidad" id="sumaCantidad"><span class="mandatory"></span></th>
			  		<th class="center total"><span class="mandatory"></span></th>
			  	</tr>
			</tbody>
		</table>
		<div class="vacio"></div>
        <div id="msg-success" class="msg-success"  style="display:none"></div>
	</fieldset>
</form>
<script type="text/javascript">

sendForm_un("#form1_ti");

$('#form1_ti'+' #mes').bind('change', function(event) {
	sendForm_un("#form1_ti");
});
$('#form1_ti'+' #anio').bind('change', function(event) {
	sendForm_un("#form1_ti");
});

function sendForm_un(formName){
	var periodo = $(formName + ' #mes').val()+"-"+$(formName + ' #anio').val();
	$(formName + ' #semestre').val(periodo);
	$(formName + " #action").val('SelectDynamic');
	$.ajax({
		dataType: 'json',
		type: 'POST',
		url: './formularios/recursosFisicos/saveOficinaTecnologia.php',
		async: false,
		data: $('#form1_ti').serialize(),                
		success:function(data){		
		console.log(data);			
			if (data.success==true ){
				var sumaCantidad = 0;
				var sumaCaracteristica = 0;

				for (var i=0;i<data.total;i++){
					sumaCantidad = parseInt(sumaCantidad)+parseInt(data[i].cantidad);
					$("#form1_ti #cantidad_"+data[i].idclasificacionesinfhuerfana).html(data[i].cantidad);
					$("#form1_ti #caracteristicas_"+data[i].idclasificacionesinfhuerfana).html(data[i].caracteristicas);
				}
				$("#form1_ti #sumaCantidad").html(sumaCantidad);
				$("#form1_ti #sumaCaracteristica").html(sumaCaracteristica);
			}else{
				for (var i=0;i<data.total;i++){
					$("#form1_ti #cantidad_"+data[i].idclasificacionesinfhuerfana).html(data[i].cantidad);
				}
				$('#form1_ti #msg-success').css('display','block');
				$('#form1_ti #msg-success').html('<p>' +  data.descrip + '</p>');
				$('#form1_ti #msg-success').addClass('msg-error');
				$('#form1_ti #msg-success').delay(5500).fadeOut(800);
			}
		},
					
	});            
}
</script>