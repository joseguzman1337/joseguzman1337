<?php

if($_GET['mes'] && $_GET['anio']) {

require_once("../../../templates/template.php");
$db = getBD();

$codigoperiodo = $_GET['mes']."-".$_GET['anio'];


$query_categoria="select idsiq_talentohumano_docente_escalafon, nombre from siq_talentohumano_docente_escalafon where codigoestado like '1%'";
$categoria= $db->Execute($query_categoria);
$totalRows_categoria= $categoria->RecordCount();

$query_totalhoras="select sum(catedraTiempo) as total_catedra,sum(medioTiempo) as total_medio,sum(completoTiempo ) as total_completo
	  from siq_formTalentoHumanoDedicacionEscalafonCNA where codigoperiodo='$codigoperiodo'
	  and codigoestado like '1%'";
$totalhoras= $db->Execute($query_totalhoras);
$row_totalhoras= $totalhoras->FetchRow();


	//echo "<br/><br/>";echo "1 <pre>";print_r($datos_estadistica->seguimiento_inscripcionvsmatriculadosnuevos(132,'arreglo'));echo "<br/><br/>";  
?>
<table align="left" id="estructuraReporte" class="previewReport" style="text-align:left;clear:both;margin: 10px 0px;width:100%">
        <thead>            
             <tr class="dataColumns">
                 
                    <th class="column" rowspan="3" style="width:34%;"><span>ESCALAFÓN</span></th>
                    <th class="column" colspan="6" style="width:66%;text-align:center;">DEDICACION - CNA</span></th>                    
             </tr>
             <tr class="dataColumns">
		<th class="column" style="width:16%;text-align:center;">HORA CÁTEDRA</span></th>
                    <th class="column" rowspan="2" style="width:10%;text-align:center;">PORCENTAJE</span></th>
                    <th class="column" style="width:16%;text-align:center;">1/2 TIEMPO</span></th>
                    <th class="column" rowspan="2" style="width:10%;text-align:center;">PORCENTAJE</span></th>
                    <th class="column" style="width:18%;text-align:center;">TIEMPO COMPLETO</span></th>
                    <th class="column" rowspan="2" style="width:10%;text-align:center;">PORCENTAJE</span></th>
             </tr>
	     <tr class="dataColumns">
		<th class="column" style="width:16%;"><span>1 - 10  HORAS</span></th>
		<th class="column" style="width:16%;"><span>11 - 28  HORAS</span></th>		
		<th class="column" style="width:18	%;"><span>29 - 40  HORAS</span></th>		
	    </tr>
	    
        </thead>
        <tbody>
        
	<?php
	
	while($row_categoria = $categoria->FetchRow()){	
	
	  $query_ededicacioncna="select catedraTiempo,medioTiempo,completoTiempo from siq_formTalentoHumanoDedicacionEscalafonCNA where idTalentoEscalafon='".$row_categoria['idsiq_talentohumano_docente_escalafon']."'
	  and codigoperiodo='$codigoperiodo'
	  and codigoestado like '1%'";
	  $ededicacioncna= $db->Execute($query_ededicacioncna);
	  $row_ededicacioncna= $ededicacioncna->FetchRow();
	  
	  /*Sumatoria total horas*/
	  $total_catedra=$row_ededicacioncna['catedraTiempo']+$total_catedra;
	  $total_medio=$row_ededicacioncna['medioTiempo']+$total_medio;
	  $total_completo=$row_ededicacioncna['completoTiempo']+$total_completo;
	  
	  /*Calculo del porcentaje*/
	  $calculo_catedra=$row_ededicacioncna['catedraTiempo']/$row_totalhoras['total_catedra']*100;
	  $calculo_medio=$row_ededicacioncna['medioTiempo']/$row_totalhoras['total_medio']*100;
	  $calculo_completo=$row_ededicacioncna['completoTiempo']/$row_totalhoras['total_completo']*100;
	  
	  /*Sumatoria total porcentaje*/
	  $total_por_catedra= $calculo_catedra+$total_por_catedra;
	  $total_por_medio=$calculo_medio+$total_por_medio;
	  $total_por_completo=$calculo_completo+$total_por_completo;
	?>
	<tr class="contentColumns" class="row">
              <td class="column" style="width:34%;"><?php echo $row_categoria['nombre']; ?></td>
	      <td class="column" style="text-align:center;width:22%;"><?php echo $row_ededicacioncna['catedraTiempo']; ?></td>
	      <td class="column" style="text-align:center;width:22%;"><?php echo round($calculo_catedra,2)."%"; ?></td>
	      <td class="column" style="text-align:center;width:22%;"><?php echo $row_ededicacioncna['medioTiempo']; ?></td>
	      <td class="column" style="text-align:center;width:22%;"><?php echo round($calculo_medio,2)."%"; ?></td>
	      <td class="column" style="text-align:center;width:22%;"><?php echo $row_ededicacioncna['completoTiempo']; ?></td>              
              <td class="column" style="text-align:center;width:22%;"><?php echo round($calculo_completo,2)."%"; ?></td>    
	</tr>             
	<?php
	/*Fin del ciclo de categorias*/ 
	 }	 	 
	 ?>
        </tbody>        
	<tfoot>
             <tr class="totalColumns">
		    <td class="column total title" style="width:34%;"><b>Total</b></td>                                
                    <td style="text-align:center;width:22%;"><b><?php echo $total_catedra; ?></b></td>
                    <td style="text-align:center;width:22%;"><b><?php echo $total_por_catedra."%"; ?></b></td>
                    <td style="text-align:center;width:22%;"><b><?php echo $total_medio; ?></b></td>
                    <td style="text-align:center;width:22%;"><b><?php echo $total_por_medio."%"; ?></b></td>
                    <td style="text-align:center;width:22%;"><b><?php echo $total_completo; ?></b></td>
                    <td style="text-align:center;width:22%;"><b><?php echo $total_por_completo."%"; ?></b></td>
                                      
            </tr>
        </tfoot>
    </table>
<?php
/*$end1 = microtime(true);
$time = $end1 - $start1;
echo "<br/><br/>";echo('totales tardo '. $time . ' seconds to execute.');*/
exit();

}
?>

<form action="" method="post" id="dedicacioncna" class="report">
	<span class="mandatory">* Son campos obligatorios</span>
	<fieldset>  
		
		<label for="mes" class="grid-2-12">Mes: <span class="mandatory">(*)</span></label>
		<?php $utils->getMonthsSelect("mes"); ?>
		
		<label for="anio" class="grid-2-12">Año: <span class="mandatory">(*)</span></label>
		<?php $utils->getYearsSelect("anio"); ?>
		
	
	<input type="submit" value="Consultar" class="first small"/>
        <img src="../../images/ajax-loader.gif" style="display:none;clear:both;margin:20px auto;" id="loading"/>	
		<div id='tableDiv'></div>
	</fieldset>
</form>
<script type="text/javascript">
	$(':submit').click(function(event) {
		event.preventDefault();
		var valido= validateForm("#dedicacioncna");
		if(valido){
			sendForm();
		}
	});
	function sendForm(){
            $('#tableDiv').html("");
            $("#loading").css("display","block");
		$.ajax({
				type: 'GET',
				url: './reportes/docentes/viewReporteEscalafonDedicacionCNA.php',
				async: false,
				data: $('#dedicacioncna').serialize(),                
				success:function(data){			
                                    $("#loading").css("display","none");		
					$('#tableDiv').html(data);					
					
				},
				error: function(data,error,errorThrown){alert(error + errorThrown);}
		});            
	}
</script>
