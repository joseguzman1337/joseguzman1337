<?php
session_start();
require_once("../../../templates/template.php");
$db = getBD();
$utils = new Utils_datos();

if($_GET['semestre']) {
	$query="select codigoperiodo,fechainicioperiodo,fechavencimientoperiodo from periodo where codigoperiodo=".$_GET['semestre'];
	$exec= $db->Execute($query);
	$row_conv1= $exec->FetchRow();
	if($exec->RecordCount()==0) {
?>
<div id="msg-success" class="msg-success msg-error" ><p>No existe información para el año <?=$_REQUEST['anio']?></p></div>
<?
	} else {

	$query_modalidad="select nombremodalidadacademicasic, codigomodalidadacademicasic from modalidadacademicasic where codigomodalidadacademicasic not in('000',100,101,400)";
	$modalidad= $db->Execute($query_modalidad);
	$total_modalidad=$modalidad->RecordCount();

?>
<br><br>
<table align="center" id="estructuraReporte" class="previewReport" width="92%">
        <thead>            
             <tr id="dataColumns">                 
                    <th class="column" colspan="2"><span>5. Egresados de la Universidad el Bosque</span></th> 
             </tr>
	     <tr id="dataColumns">
		<th class="column" ><span>Nombre Programa</span></th>		
		<th class="column" ><span>Número de Egresados</span></th>
	    </tr>     
        </thead>
	<tbody>	
	<?php while($row_modalidad = $modalidad->FetchRow()){
	/*Inicio ciclo que pinta los bloques de modalidad*/
	?>
	<tr class="contentColumns" class="row">
              <td class="column" colspan="2" align="center"><b><?php echo strtoupper($row_modalidad['nombremodalidadacademicasic']); ?></b></td>       
         </tr>
         <?php 
	$query_carreras="select nombrecarrera, codigocarrera from carrera 
	where now() between fechainiciocarrera and fechavencimientocarrera
	and codigomodalidadacademicasic ='".$row_modalidad['codigomodalidadacademicasic']."'";
	$carreras= $db->Execute($query_carreras);
	$totalRows_carreras = $carreras->RecordCount();
	
	while($row_carreras = $carreras->FetchRow()){
	    $query_graduados="select count(*) as total, e.codigocarrera from registrograduado r, estudiante e
	    where r.codigoestudiante=e.codigoestudiante
	    and e.codigocarrera='".$row_carreras['codigocarrera']."'
	    and r.fecharegistrograduado between '".$row_conv1['fechainicioperiodo']."' and '".$row_conv1['fechavencimientoperiodo']."'
	    group by e.codigocarrera";
	$graduados= $db->Execute($query_graduados);
	$totalRows_graduados = $graduados->RecordCount();
	$row_graduados = $graduados->FetchRow();
	  

	/*Inicio ciclo que pinta las carreras en la modalidad correspondiente*/	    
	 ?>	 
	 <tr id="contentColumns" class="row">
              <td class="column" ><?php echo $row_carreras['nombrecarrera']; ?></td>	      
	      <td class="column" ><?php if($row_graduados['total']=='') echo "0"; else echo $row_graduados['total']; ?></td>
	 </tr>
	<?php 
	$total_carrera=$total_carrera+$row_graduados['total'];
	}
	?>
	</tbody>
	<thead>
             <tr id="totalColumns">
                <td class="column total title" align="center"><b>Total Egresados <?php echo $row_modalidad['nombremodalidadacademicasic']; ?></b></td>		
		<td class="column total title" ><b><?php echo $total_carrera; ?></b></td>
	      </tr>
	  </thead>

	<?
	$cuentafinal=$total_carrera+$cuentafinal;
	unset($total_carrera);
	}
	//exit();
	?>	
	<tfoot>
             <tr id="totalColumns">
                <td class="column total title">Total Graduados</td>		
		<td class="column total title"><?php echo $cuentafinal; ?></td>
	    </tr>
	</tfoot>
</table>
<?
	}
	exit;


}

?>


<form action="" method="post" id="form6">
	<span class="mandatory">* Son campos obligatorios</span>
	<fieldset>  
		<legend>Egresados de la Universidad El Bosque</legend>
		<label for="semestre" class="grid-2-12">Semestre: <span class="mandatory">(*)</span></label>
		<?php $utils->getSemestresSelect($db,"semestre"); ?>
                
                <input type="submit" value="Consultar" class="first small" />	
		<div id='respuesta_form6'></div>
	</fieldset>
</form>
<script type="text/javascript">
	$(':submit').click(function(event) {
		event.preventDefault();
		var valido= validateForm("#form6");
		if(valido){
			sendFormEgresados();
		}
	});
	function sendFormEgresados(){
		$.ajax({
				type: 'GET',
				url: './formularios/docentes/viewOficinaDesarrolloEgresados.php',
				async: false,
				data: $('#form6').serialize(),                
				success:function(data){					
					$('#respuesta_form6').html(data);					
					
				},
				error: function(data,error,errorThrown){alert(error + errorThrown);}
		});            
	}
</script>
