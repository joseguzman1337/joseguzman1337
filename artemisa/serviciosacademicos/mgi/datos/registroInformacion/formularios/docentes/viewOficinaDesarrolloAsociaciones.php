<?php
session_start();
require_once("../../../templates/template.php");
$db = getBD();
$utils = new Utils_datos();

if($_GET['semestre']) {
	$query="select * from siq_asociacionesofdesarrollo where codigoperiodo=".$_GET['semestre']." and codigoestado like '1%'";
	$exec= $db->Execute($query);
	
		
	if($exec->RecordCount()==0) {
?>
		<div id="msg-success" class="msg-success msg-error" ><p>No existe información  para el semestre <?=$_REQUEST['semestre']?></p></div>
<?
	} else {
?>

<table align="center" id="estructuraReporte" class="previewReport formData last" width="92%">
        <thead>            
             <tr class="dataColumns">                 
                    <th class="column" colspan="5"><span>Número de Redes y Asociaciones Institucionales</span></th> 
             </tr>
	     <tr class="dataColumns category">
		<th class="column borderR" rowspan="2"><span>Redes y Asociaciones</span></th>
		<th class="column borderR" colspan="2"><span>Ambito</span></th>		
	    </tr>
	    <tr class="dataColumns category">
		<th class="column"><span>Nacional</span></th>
		<th class="column borderR"><span>Internacional</span></th>
	    </tr>	     
        </thead>
	<tbody>
	 <?php 
	  while($row_conv1= $exec->FetchRow()){	    
	    $suma1=$suma1+$row_conv1['asociacionesnacional'];
	    $suma2=$suma2+$row_conv1['asociacionesinternacional'];
	    
	  ?>
	 <tr id="contentColumns" class="row">
              <td class="column borderR" ><?php echo $row_conv1['nombre_asociacionesofdesarrollo']; ?></td>
	      <td class="column center" ><?php echo $row_conv1['asociacionesnacional']; ?></td>
	      <td class="column center borderR" ><?php echo $row_conv1['asociacionesinternacional']; ?></td>	      
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
	    </tr>	    
	</tfoot>
</table>
<?
	}
	exit;


}

?>


<form action="" method="post" id="form7">
	<span class="mandatory">* Son campos obligatorios</span>
	<fieldset>  
		<legend>Número de Redes y Asociaciones Institucionales</legend>
		<label for="semestre" class="grid-2-12">Semestre: <span class="mandatory">(*)</span></label>
		<?php $utils->getSemestresSelect($db,"semestre"); ?>	
	
	<input type="submit" value="Consultar" class="first small"/>	
		<div id='respuesta_form7'></div>
	</fieldset>
</form>
<script type="text/javascript">
	$(':submit').click(function(event) {
		event.preventDefault();
		var valido= validateForm("#form7");
		if(valido){
			sendFormAsociaciones();
		}
	});
	function sendFormAsociaciones(){
		$.ajax({
				type: 'GET',
				url: './formularios/docentes/viewOficinaDesarrolloAsociaciones.php',
				async: false,
				data: $('#form7').serialize(),                
				success:function(data){					
					$('#respuesta_form7').html(data);					
					
				},
				error: function(data,error,errorThrown){alert(error + errorThrown);}
		});            
	}
</script>
