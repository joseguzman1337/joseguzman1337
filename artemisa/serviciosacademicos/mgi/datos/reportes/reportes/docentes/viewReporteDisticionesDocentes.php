<?php

if($_GET['semestre']) {

require_once("../../../templates/template.php");
$db = getBD();

$codigoperiodo = $_GET['semestre'];

$numSem=substr($codigoperiodo,-1);
$anio=substr($codigoperiodo,0,-1);
if($numSem==1){
  $mes=3;
}
else{
  $mes=9;
}
$mes_anio=$mes."-".$anio;

$query_periodo="select * from periodo where codigoperiodo ='$codigoperiodo'";
$periodo= $db->Execute($query_periodo);
$totalRows_periodo= $periodo->RecordCount();
$row_periodo= $periodo->FetchRow();
$fechainicioperiodo=$row_periodo['fechainicioperiodo'];
$fechavencimientoperiodo=$row_periodo['fechavencimientoperiodo'];


$query_docreconocimiento="select count(idsiq_formUnidadesAcademicasReconocimientosProfesores) as total_docentes  from siq_formUnidadesAcademicasReconocimientosProfesores s
join carrera c using(codigocarrera)
where s.fechaReconocimiento between '$fechainicioperiodo' and '$fechavencimientoperiodo'
and s.codigoestado like '1%'
and c.codigomodalidadacademicasic=200;";
$docreconocimiento= $db->Execute($query_docreconocimiento);
$row_docreconocimiento= $docreconocimiento->FetchRow();

$query_totaldocente="select (numAcademicosTC+numAcademicos34T+numAcademicosMT)as academicos 
from siq_formTalentoHumanoNumeroPersonas where codigoperiodo='$mes_anio'
and codigoestado like '1%'";
$totaldocente= $db->Execute($query_totaldocente);
$row_totaldocente= $totaldocente->FetchRow();


	//echo "<br/><br/>";echo "1 <pre>";print_r($datos_estadistica->seguimiento_inscripcionvsmatriculadosnuevos(132,'arreglo'));echo "<br/><br/>";  
?>
<table align="left" id="estructuraReporte" class="previewReport" style="text-align:left;clear:both;margin: 10px 0px;width:100%">
        <thead>                         
	     <tr class="dataColumns">
		<th class="column" style="width:16%;"><span>Número Total de Distinciones Obtenidas por Profesores</span></th>
		<th class="column" style="width:16%;"><span>Número de Profesores </span></th>		
		<th class="column" style="width:18%;"><span>Porcentaje</span></th>		
	    </tr>
	    
        </thead>
        <tbody>       
	
	<tr class="contentColumns" class="row">              
	      <td class="column" style="text-align:center;width:22%;"><?php echo $row_docreconocimiento['total_docentes']; ?></td>
	      <td class="column" style="text-align:center;width:22%;"><?php if($row_totaldocente['academicos']!='') echo $row_totaldocente['academicos']; else echo "0"; ?></td>
	      <td class="column" style="text-align:center;width:22%;"><?php echo round($row_docreconocimiento['total_docentes']/$row_totaldocente['academicos'],2)."%"; ?></td>	      
	</tr>             	
        </tbody>        	
    </table>
<?php
/*$end1 = microtime(true);
$time = $end1 - $start1;
echo "<br/><br/>";echo('totales tardo '. $time . ' seconds to execute.');*/
exit();

}
?>

<form action="" method="post" id="distincion" class="report">
	<span class="mandatory">* Son campos obligatorios</span>
	<fieldset>  
		
		<label for="semestre" class="grid-2-12">Semestre: <span class="mandatory">(*)</span></label>
		<?php $utils->getSemestresSelect($db,"semestre"); ?>
	
	<input type="submit" value="Consultar" class="first small"/>
        <img src="../../images/ajax-loader.gif" style="display:none;clear:both;margin:20px auto;" id="loading"/>	
		<div id='tableDiv'></div>
	</fieldset>
</form>
<script type="text/javascript">
	$(':submit').click(function(event) {
		event.preventDefault();
		var valido= validateForm("#distincion");
		if(valido){
			sendForm();
		}
	});
	function sendForm(){
            $('#tableDiv').html("");
            $("#loading").css("display","block");
		$.ajax({
				type: 'GET',
				url: './reportes/docentes/viewReporteDisticionesDocentes.php',
				async: false,
				data: $('#distincion').serialize(),                
				success:function(data){			
                                    $("#loading").css("display","none");		
					$('#tableDiv').html(data);					
					
				},
				error: function(data,error,errorThrown){alert(error + errorThrown);}
		});            
	}
</script>
