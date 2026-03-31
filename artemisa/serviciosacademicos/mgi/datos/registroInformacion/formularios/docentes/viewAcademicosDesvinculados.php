<?php
require_once("../../../templates/template.php");
$db = getBD();
$utils=new Utils_Datos();
if($_GET['mes'] && $_GET['anio']) {

$codigoperiodo = $_GET['mes']."-".$_GET['anio'];

?>
<table align="left" id="estructuraReporte" class="previewReport" style="text-align:left;clear:both;margin: 10px 0px;width:100%">
        <thead>            
             <tr class="dataColumns">
                 
                    <th class="column" colspan="2"><span>Académicos Desvinculados</span></th>                    
             </tr>
             <tr class="dataColumns">		
                    <th class="column" style="text-align:center;">Motivo del retiro</span></th>
                    <th class="column" style="text-align:center;">Número de Académicos</span></th>                    
             </tr>	    
        </thead>
        <tbody>
        
	<?php
	  $query_acaddes="select numTerminacionContrato, numRenunciaOportunidad, numRenunciaMotivosPersonales,
	      numRenunciaCondicionesLaborales,numRenunciaViaje,numDespido,numOtro
	      from siq_formTalentoHumanoAcademicosDesvinculados
	      where codigoperiodo='$codigoperiodo'
	      and codigoestado like '1%'";
	  $acaddes= $db->Execute($query_acaddes);
	  $row_acaddes= $acaddes->FetchRow();
	  
	  $suma_total=$row_acaddes['numTerminacionContrato']+$row_acaddes['numRenunciaOportunidad']+$row_acaddes['numRenunciaMotivosPersonales']+$row_acaddes['numRenunciaCondicionesLaborales']+$row_acaddes['numRenunciaViaje']+$row_acaddes['numDespido']+$row_acaddes['numOtro'];
	  
	?>
	<tr class="contentColumns" class="row">
              <td class="column">Terminación de Contrato</td>
	      <td class="column" style="text-align:center;"><?php echo $row_acaddes['numTerminacionContrato']; ?></td>	      	      
	</tr> 
	<tr class="contentColumns" class="row">
              <td class="column">Renuncia por Nueva Oportunidad Laboral</td>
	      <td class="column" style="text-align:center;"><?php echo $row_acaddes['numRenunciaOportunidad']; ?></td>	      	      
	</tr> 
	<tr class="contentColumns" class="row">
              <td class="column">Renuncia por Motivos Personales</td>
	      <td class="column" style="text-align:center;"><?php echo $row_acaddes['numRenunciaMotivosPersonales']; ?></td>	      	      
	</tr> 
	<tr class="contentColumns" class="row">
              <td class="column">Renuncia  por Mejores Condiciones Laborales</td>
	      <td class="column" style="text-align:center;"><?php echo $row_acaddes['numRenunciaCondicionesLaborales']; ?></td>	      	      
	</tr> 
	<tr class="contentColumns" class="row">
              <td class="column">Renuncia por Viaje</td>
	      <td class="column" style="text-align:center;"><?php echo $row_acaddes['numRenunciaViaje']; ?></td>	      	      
	</tr> 
	<tr class="contentColumns" class="row">
              <td class="column">Despido</td>
	      <td class="column" style="text-align:center;"><?php echo $row_acaddes['numDespido']; ?></td>	      	      
	</tr> 
	<tr class="contentColumns" class="row">
              <td class="column">Otro</td>
	      <td class="column" style="text-align:center;"><?php echo $row_acaddes['numOtro']; ?></td>	      	      
	</tr> 
	 <tr class="dataColumns">
	      <th class="column total center borderR"><span>Total</span></th>                                
	      
	      <th class="column total center borderR"><?php echo $suma_total; ?></th>
	      
	  </tr>  
        </tbody>        	
    </table>
<?php
exit();

}
?>

<form action="" method="post" id="acaddesv" class="report">
	<span class="mandatory">* Son campos obligatorios</span>
	<fieldset>  
		
		<label for="mes" class="grid-2-12">Mes: <span class="mandatory">(*)</span></label>
		<?php $utils->getMonthsSelect("mes"); ?>
		
		<label for="anio" class="grid-2-12">Año: <span class="mandatory">(*)</span></label>
		<?php $utils->getYearsSelect("anio"); ?>
		
	
	<input type="submit" value="Consultar" class="first small"/>
        <img src="../../images/ajax-loader.gif" style="display:none;clear:both;margin:20px auto;" id="loading"/>	
		<div id='resAcaDes'></div>
	</fieldset>
</form>
<script type="text/javascript">
	$(':submit').click(function(event) {
		event.preventDefault();
		var valido= validateForm("#acaddesv");
		if(valido){
			sendForm();
		}
	});
	function sendForm(){
            $('#resAcaDes').html("");
            $("#loading").css("display","block");
		$.ajax({
				type: 'GET',
				url: './formularios/docentes/viewAcademicosDesvinculados.php',
				async: false,
				data: $('#acaddesv').serialize(),                
				success:function(data){			
                                    $("#loading").css("display","none");		
					$('#resAcaDes').html(data);					
					
				},
				error: function(data,error,errorThrown){alert(error + errorThrown);}
		});            
	}
</script>
