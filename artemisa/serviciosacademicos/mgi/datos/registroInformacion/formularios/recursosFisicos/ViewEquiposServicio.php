<?php
    session_start();
    include_once('../../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);

session_start();
require_once("../../../templates/template.php");
$db = getBD();
$utils = new Utils_datos();

?>
<form action="" method="post" id="form1_eq">
	<input type="hidden" name="formulario" value="form1_eq" />
	<input type="hidden" name="action" value="SelectDynamic" id="action" />
	<span class="mandatory">* Son campos obligatorios</span>
	<fieldset>  
		<legend>Equipos de Cómputo al Servicio de la Comunidad Académica</legend>
		<?php
		$query_papa = "select idclasificacionesinfhuerfana,clasificacionesinfhuerfana from siq_clasificacionesinfhuerfana where aliasclasificacionesinfhuerfana='T_NECSCA'";
        $papa= $db->Execute($query_papa);
        $totalRows_papa = $papa->RecordCount();
		$row_papa = $papa->FetchRow();
		?> 
		<input type="hidden" name="padre" value="<?php echo $row_papa['idclasificacionesinfhuerfana']; ?>" />               
		<legend><?php echo $row_papa['clasificacionesinfhuerfana']; ?></legend>
		<label for="semestre" class="grid-2-12">Semestre: <span class="mandatory">(*)</span></label>
		<?php $utils->getSemestresSelect($db,"semestre");?>
        <input type="hidden" name="semestre" value="" id="semestre" /> 
		<table align="center" id="estructuraReporte"  class="formData last" width="92%">
			<thead>             			
				<tr id="dataColumns">
                    <th class="column borderR" ><span>Poblacion que Cubre</span></th>
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
		      		$hijos= $db->Execute($query_hijos);
		      		$totalRows_hijos = $hijos->RecordCount();
		      		$cuentadat=$totalRows_hijos+1;
		      		?>
		      		<tr id="contentColumns" class="row">
			  			<td class="column borderR" rowspan="<?php echo $cuentadat;?>"><?php echo $row_sectores['clasificacionesinfhuerfana']; ?></td>
			      	</tr>
			      	<?php
			      	while($row_hijos= $hijos->FetchRow()){
			      		?>
			      		<tr>
				  		<td class="column borderR"><?php echo $row_hijos['clasificacionesinfhuerfana']; ?></td>
				  		<td class="column borderR center"  name="cantidad_<?php echo $row_hijos['idclasificacionesinfhuerfana']; ?>" id="cantidad_<?php echo $row_hijos['idclasificacionesinfhuerfana']; ?>"></td>
				  		</tr>
				  		<?php
			      	}
			  }
			  ?>	
			  <tr id="contentColumns" class="row">
		  		
		  		<th class="column borderR total" >Total:<span class="mandatory"></span></th>
		  		<th class="column borderR"></th>
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

$('#form1_eq'+' #semestre').bind('change', function(event) {
         sendForm_un();
    });

function sendForm_un(formName){
	var periodo = $('#form1_eq #semestre').val();
	$('#form1_eq #semestre').val(periodo);
	$("#form1_eq #action").val('SelectDynamic');
	$.ajax({
		url: './formularios/recursosFisicos/saveOficinaTecnologia.php',
		type: 'POST',
		dataType: 'json',
		data: $('#form1_eq').serialize(),
		success:function(data){
			// console.log(data.cant);
			if (data.success==true){
				var sumaCantidad = 0;
				$.each(data.cant, function(indice, valor) {
					sumaCantidad = parseInt(sumaCantidad)+parseInt(valor);
					$("#form1_eq #cantidad_" + indice).html(valor);
				});
				$("#form1_eq #sumaCantidad").html(sumaCantidad);
			}else{
				$.each(data.cant, function(indice, valor) {
					 $("#form1_eq #cantidad_" + indice).html(valor);
				});
				$("#form1_eq #sumaCantidad").html("");
				$('#form1_eq #msg-success').css('display','block');
				$('#form1_eq #msg-success').html('<p>' +  data.descrip + '</p>');
				$('#form1_eq #msg-success').addClass('msg-error');
				$('#form1_eq #msg-success').delay(5500).fadeOut(800);
			}
		},
	});           
}
</script>