<?php
session_start();
require_once("../../../templates/template.php");
$db = getBD();
$utils = new Utils_datos();

if($_GET['semestre']) {
	$query="select clasificacionesinfhuerfana
		,salud
		, calidadvida
		,otras
		from siq_proyeccionofdesarrollo 
		join siq_clasificacionesinfhuerfana using(idclasificacionesinfhuerfana) 
		where codigoperiodo=".$_GET['semestre'];
	$exec= $db->Execute($query);
	if($exec->RecordCount()==0) {
?>
		<div id="msg-success" class="msg-success msg-error" ><p>No existe información para el periodo <?=$_REQUEST['semestre']?></p></div>
		
<?
	} else {
?>

<table align="center" id="estructuraReporte" class="previewReport formData last" width="92%">
        <thead>            
             <tr class="dataColumns">                 
                    <th class="column" colspan="5"><span>Proyección social: Número de Proyectos realizados con diferentes grupos de interés, según el núcleo estratégico</span></th> 
             </tr>
	     <tr class="dataColumns category">
		<th class="column borderR" rowspan="2"><span>Sector</span></th>
		<th class="column borderR" colspan="2"><span>Núcleo Estratégico</span></th>
		<th class="column borderR" rowspan="2"><span>Otras Disciplinas</span></th>
		<th class="column" rowspan="2"><span>Total</span></th>
	    </tr>
	    <tr class="dataColumns category">
		<th class="column"><span>Salud</span></th>
		<th class="column borderR"><span>Calidad de Vida</span></th>
	    </tr>	     
        </thead>
	<tbody>
	 <?php 
	  while($row_conv1= $exec->FetchRow()){
	    $total1=$row_conv1['salud']+$row_conv1['calidadvida']+$row_conv1['otras'];
	    $suma1=$suma1+$row_conv1['salud'];
	    $suma2=$suma2+$row_conv1['calidadvida'];
	    $suma3=$suma3+$row_conv1['otras'];
	    $totalgen=$totalgen+$total1;
	  ?>
	 <tr id="contentColumns" class="row">
              <td class="column borderR" ><?php echo $row_conv1['clasificacionesinfhuerfana']; ?></td>
	      <td class="column center" ><?php echo $row_conv1['salud']; ?></td>
	      <td class="column center borderR" ><?php echo $row_conv1['calidadvida']; ?></td>
	      <td class="column center borderR" ><?php echo $row_conv1['otras']; ?></td>
	      <td class="column center" ><?php echo $total1; ?></td>
	 </tr>
	<?php 
	}
	?>	
	</tbody>
	<tfoot>
             <tr id="totalColumns">
                <td class="column total title">Total</td>
		<td class="column total title"><?php echo $suma1; ?></td>
		<td class="column total title"><?php echo $suma2; ?></td>
		<td class="column total title"><?php echo $suma3; ?></td>
		<td class="column total title"><?php echo $totalgen; ?></td>
	    </tr>
	</tfoot>
</table>
<?
	}
	exit;


}

?>


<form action="" method="post" id="form3">
	<span class="mandatory">* Son campos obligatorios</span>
	<fieldset>  
		<legend>Proyección Social: Número de Proyectos Realizados con Diferentes Grupos de Interés, Según el Núcleo Estratégico</legend>
		<label for="semestre" class="grid-2-12">Semestre: <span class="mandatory">(*)</span></label>
		<?php $utils->getSemestresSelect($db,"semestre"); ?>
                <input type="submit" value="Consultar" class="first small" />
		<div id='respuesta_form3'></div>
	</fieldset>
	
</form>
<script type="text/javascript">
	$(':submit').click(function(event) {
		event.preventDefault();
		var valido= validateForm("#form3");
		if(valido){
			sendForm();
		}
	});
	function sendForm(){
		$.ajax({
				type: 'GET',
				url: './formularios/docentes/viewOficinaDesarrolloProyeccion.php',
				async: false,
				data: $('#form3').serialize(),                
				success:function(data){					
					$('#respuesta_form3').html(data);					
					
				},
				error: function(data,error,errorThrown){alert(error + errorThrown);}
		});            
	}
</script>
