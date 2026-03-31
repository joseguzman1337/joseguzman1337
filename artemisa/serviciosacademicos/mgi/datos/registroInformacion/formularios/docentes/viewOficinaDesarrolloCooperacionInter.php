<?php
session_start();
require_once("../../../templates/template.php");
$db = getBD();
$utils = new Utils_datos();

if($_GET['semestre']) {
	$query="select	clasificacionesinfhuerfana
			,convenionacional
			, conveniointnacional
		from siq_convenioofdesarrollo
		join siq_clasificacionesinfhuerfana using(idclasificacionesinfhuerfana)
		where codigoperiodo=".$_GET['semestre']."
		and aliasclasificacionesinfhuerfana is null";
	$exec= $db->Execute($query);
	
	$query_ven="select	clasificacionesinfhuerfana
			,convenionacional
			, conveniointnacional
		from siq_convenioofdesarrollo
		join siq_clasificacionesinfhuerfana using(idclasificacionesinfhuerfana)
		where codigoperiodo=".$_GET['semestre']."
		and aliasclasificacionesinfhuerfana is not null"
		;
	$exec_ven= $db->Execute($query_ven);
	
	if($exec->RecordCount()==0) {
?>
		<div id="msg-success" class="msg-success msg-error" ><p>No existe información  para el semestre <?=$_REQUEST['semestre']?></p></div>
<?
	} else {
?>

<table align="center" id="estructuraReporte" class="previewReport formData last" width="92%">
        <thead>            
             <tr class="dataColumns">                 
                    <th class="column" colspan="5"><span>Convenios interinstitucionales para la realización de prácticas empresariales</span></th> 
             </tr>
	     <tr class="dataColumns category">
		<th class="column borderR" rowspan="2"><span>Sector</span></th>
		<th class="column borderR" colspan="2"><span>Tipo de Convenio</span></th>
		<th class="column" rowspan="2"><span>Total</span></th>
	    </tr>
	    <tr class="dataColumns category">
		<th class="column"><span>Nacional</span></th>
		<th class="column borderR"><span>Internacional</span></th>
	    </tr>	     
        </thead>
	<tbody>
	 <?php 
	  while($row_conv1= $exec->FetchRow()){
	    $total1=$row_conv1['convenionacional']+$row_conv1['conveniointnacional'];
	    $suma1=$suma1+$row_conv1['convenionacional'];
	    $suma2=$suma2+$row_conv1['conveniointnacional'];
	    $totalgen=$totalgen+$total1;
	  ?>
	 <tr id="contentColumns" class="row">
              <td class="column borderR" ><?php echo $row_conv1['clasificacionesinfhuerfana']; ?></td>
	      <td class="column center" ><?php echo $row_conv1['convenionacional']; ?></td>
	      <td class="column center borderR" ><?php echo $row_conv1['conveniointnacional']; ?></td>
	      <td class="column center" ><?php echo $total1; ?></td>
	 </tr>
	<?php 
	}
	?>	
	</tbody>
	<tfoot>
             <tr id="totalColumns">
                <td class="column total title borderR">Total</td>
		<td class="column total title"><?php echo $suma1; ?></td>
		<td class="column total title borderR"><?php echo $suma2; ?></td>
		<td class="column total title"><?php echo $totalgen; ?></td>
	    </tr>
	    
	 <?php 
	  while($row_ven= $exec_ven->FetchRow()){
	   $total_v=$row_ven['convenionacional']+$row_ven['conveniointnacional'];
	?>
	  <tr id="totalColumns">
                <td class="column total title borderR"><?php echo $row_ven['clasificacionesinfhuerfana']; ?></td>
		<td class="column total title"><?php echo $row_ven['convenionacional']; ?></td>
		<td class="column total title borderR"><?php echo $row_ven['conveniointnacional']; ?></td>
		<td class="column total title"><?php echo $total_v; ?></td>
	    </tr>
	<?php 
	}
	?>
	</tfoot>
</table>
<?
	}
	exit;


}

?>


<form action="" method="post" id="form2">
	<span class="mandatory">* Son campos obligatorios</span>
	<fieldset>  
		<legend>Convenios Interinstitucionales para la Realización de Prácticas Empresariales</legend>
		<label for="semestre" class="grid-2-12">Semestre: <span class="mandatory">(*)</span></label>
		<?php $utils->getSemestresSelect($db,"semestre"); ?>	
	
	<input type="submit" value="Consultar" class="first small"/>	
		<div id='respuesta_form2'></div>
	</fieldset>
</form>
<script type="text/javascript">
	$(':submit').click(function(event) {
		event.preventDefault();
		var valido= validateForm("#form2");
		if(valido){
			sendForm();
		}
	});
	function sendForm(){
		$.ajax({
				type: 'GET',
				url: './formularios/docentes/viewOficinaDesarrolloCooperacionInter.php',
				async: false,
				data: $('#form2').serialize(),                
				success:function(data){					
					$('#respuesta_form2').html(data);					
					
				},
				error: function(data,error,errorThrown){alert(error + errorThrown);}
		});            
	}
</script>
