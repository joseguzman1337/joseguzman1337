<?php

session_start();
require_once("../../../templates/template.php");
$db = getBD();
$utils = new Utils_datos();

?>
<form action="" method="post" id="form1_ea">
	<input type="hidden" name="formulario" value="form1_ea" />
	<input type="hidden" name="action" value="SelectDynamic" id="action" />
	<span class="mandatory">* Son campos obligatorios</span>
	<fieldset>  
		<legend>Equipos Audiovisuales</legend>
		<?php
		$query_papa = "select idclasificacionesinfhuerfana,clasificacionesinfhuerfana from siq_clasificacionesinfhuerfana where aliasclasificacionesinfhuerfana='T_EAUB'";
        $papa= $db->Execute($query_papa);
        $totalRows_papa = $papa->RecordCount();
		$row_papa = $papa->FetchRow();
		?> 
		<input type="hidden" name="padre" value="<?php echo $row_papa['idclasificacionesinfhuerfana']; ?>" />               
		<legend><?php echo $row_papa['clasificacionesinfhuerfana']; ?></legend>
		<label for="semestre" class="grid-2-12">Semestre: <span class="mandatory">(*)</span></label>
		<?php $utils->getSemestresSelect($db,"semestre");?>
        <!-- <input type="hidden" name="semestre" value="" id="semestre" />  -->
		<table align="center" id="estructuraReporte"  class="formData last" width="92%">
			<thead>             			
				<tr id="dataColumns">
                    <th class="column borderR" ><span>Modalidad Académica</span></th>
                    <th class="column borderR"><span>Cantidad</span></th>                            
				</tr>
            </thead>
            <tbody>
            	<?php 
            	$query_sectores = "select idclasificacionesinfhuerfana,clasificacionesinfhuerfana from siq_clasificacionesinfhuerfana where idpadreclasificacionesinfhuerfana ='".$row_papa['idclasificacionesinfhuerfana']."' order by 2 ";
		      	$sectores= $db->Execute($query_sectores);
		      	$totalRows_sectores = $sectores->RecordCount();
		      	// $query_consulta_au= "select cantidad from siq_tecnologia where idpadreclasificacionesinfhuerfana ='".$row_papa['idclasificacionesinfhuerfana']."' and codigoperiodo='".$_POST['semestre']."'";
		      	 while($row_sectores = $sectores->FetchRow()){
		      	 	?>
		      	 	<tr id="contentColumns" class="row">
		      	 		<td class="column borderR" ><?php echo $row_sectores['clasificacionesinfhuerfana']; ?>:<span class="mandatory"></span></td>
		      	 		<td class="center" name="cantidad_<?php echo $row_sectores['idclasificacionesinfhuerfana']?>" id="cantidad_<?php echo $row_sectores['idclasificacionesinfhuerfana']?>"><span class="mandatory"></span></td>
		      	 	</tr>
		      	 	<?php
		      	 }
			  ?>	
			<tr id="contentColumns" class="row">
		  		<th class="column borderR total" >Total:<span class="mandatory"></span></th>
		  		<th class="center total" name="sumaCantidad" id="sumaCantidad"><span class="mandatory"></span></th>
		  	</tr>
			</tbody>
		</table>
		<div class="vacio"></div>
        <div id="msg-success" class="msg-success"  style="display:none"></div>
	</fieldset>
</form>
<script type="text/javascript">

sendForm_un();

$('#form1_ea'+' #semestre').bind('change', function(event) {
         sendForm_un();
    });

function sendForm_un(formName){
	var periodo = $('#form1_ea #semestre').val();
	$('#form1_ea #semestre').val(periodo);
	$("#form1_ea #action").val('SelectDynamic');
	$.ajax({
		url: './formularios/recursosFisicos/saveOficinaTecnologia.php',
		type: 'POST',
		dataType: 'json',
		data: $('#form1_ea').serialize(),
		success:function(data){
			// console.log(data.cant);
			if (data.success==true){
				var sumaCantidad = 0;
				$.each(data.cant, function(indice, valor) {
					sumaCantidad = parseInt(sumaCantidad)+parseInt(valor);
					$("#form1_ea #cantidad_" + indice).html(valor);
				});
				$("#form1_ea #sumaCantidad").html(sumaCantidad);
			}else{
				$.each(data.cant, function(indice, valor) {
					 $("#form1_ea #cantidad_" + indice).html(valor);
				});
				$("#form1_ea #sumaCantidad").html("");
				$('#form1_ea #msg-success').css('display','block');
				$('#form1_ea #msg-success').html('<p>' +  data.descrip + '</p>');
				$('#form1_ea #msg-success').addClass('msg-error');
				$('#form1_ea #msg-success').delay(5500).fadeOut(800);
			}
		},
	});           
}
</script>