<?php

if($_GET['semestre']) {

require_once("../../../templates/template.php");
$db = getBD();
//$utils = new Utils_datos();


/* Query rango de Periodo */
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

/*Query total docentes*/
$query_tdocentes="select numAcademicos from siq_formTalentoHumanoNumeroPersonas
where codigoperiodo='$mes_anio'
and codigoestado like '1%';";
$tdocentes= $db->Execute($query_tdocentes);
$totalRows_tdocentes = $tdocentes->RecordCount();
$row_tdocentes = $tdocentes->FetchRow();

/*Query total correos docentes*/
$query_codocentes="select t.cantidad 
from siq_tecnologia t, siq_clasificacionesinfhuerfana s 
where t.idpadreclasificacionesinfhuerfana =540
and t.idpadreclasificacionesinfhuerfana=s.idpadreclasificacionesinfhuerfana
and t.idclasificacionesinfhuerfana=s.idclasificacionesinfhuerfana
and t.codigoperiodo='$codigoperiodo'
and t.idclasificacionesinfhuerfana =541
and t.codigoestado like '1%'";
$codocentes= $db->Execute($query_codocentes);
$totalRows_codocentes = $codocentes->RecordCount();
$row_codocentes = $codocentes->FetchRow();

/*Query total correos estudiantes*/
$query_coestudiantes="select t.cantidad 
from siq_tecnologia t, siq_clasificacionesinfhuerfana s 
where t.idpadreclasificacionesinfhuerfana =540
and t.idpadreclasificacionesinfhuerfana=s.idpadreclasificacionesinfhuerfana
and t.idclasificacionesinfhuerfana=s.idclasificacionesinfhuerfana
and t.codigoperiodo='$codigoperiodo'
and t.idclasificacionesinfhuerfana =542
and t.codigoestado like '1%'";
$coestudiantes= $db->Execute($query_coestudiantes);
$totalRows_coestudiantes = $coestudiantes->RecordCount();
$row_coestudiantes = $coestudiantes->FetchRow();

/*Query total estudiantes pregrado*/
$query_totalmat="SELECT count(ee.codigoestudiante) as total_mat
FROM estudianteestadistica ee, carrera c, estudiante e
where e.codigocarrera=c.codigocarrera
and c.codigomodalidadacademicasic=200
and ee.codigoestudiante=e.codigoestudiante
and ee.codigoperiodo = '$codigoperiodo'
and ee.codigoprocesovidaestudiante in(400,401)
and ee.codigoestado like '1%'
order by 1";
$totalmat= $db->Execute($query_totalmat);
$totalRows_totalmat= $totalmat->RecordCount();
$row_totalmat = $totalmat->FetchRow();


	//echo "<br/><br/>";echo "1 <pre>";print_r($datos_estadistica->seguimiento_inscripcionvsmatriculadosnuevos(132,'arreglo'));echo "<br/><br/>";  
?>
<table align="left" id="estructuraReporte" class="previewReport" style="text-align:left;clear:both;margin: 10px 0px;width:100%">
        <thead>            
             <tr class="dataColumns">
                 
                    <th class="column" rowspan="2" style="width:34%;"><span>TIPO</span></th>
		     <?php
			/*Recorrido de Consulta para imprimir los periodos*/
			$anioperiodo=substr($codigoperiodo,-1);			
			if($anioperiodo==1)
			$anioperiodo='I';
			else
			$anioperiodo='II';
			$anio=substr($codigoperiodo, 0, -1);			
			?>
			<th class="column" colspan="3" style="width:66%;text-align:center;"><?php echo " AÑO ".$anio." - PERIODO ".$anioperiodo; ?></span></th>
             </tr>
	     <tr class="dataColumns">
		<th class="column" style="width:22%;"><span>NÚMERO DE CORREOS</span></th>
		<th class="column" style="width:22%;"><span>NÚMERO DE PERSONAS</span></th>		
		<th class="column" style="width:22%;"><span>INDICE</span></th>		
	    </tr>
        </thead>
        <tbody>
	  <tr class="contentColumns" class="row">
		<td class="column" style="width:34%;">DOCENTES</td>
		<td class="column" style="text-align:center;width:22%;"><?php echo $row_codocentes['cantidad']; ?></td>
		<td class="column" style="text-align:center;width:22%;"><?php echo $row_tdocentes['numAcademicos']; ?></td>              
		<td class="column" style="text-align:center;width:22%;"><?php echo round($row_codocentes['cantidad']/$row_tdocentes['numAcademicos'],2); ?></td>    
	  </tr>
	  <tr class="contentColumns" class="row">
		<td class="column" style="width:34%;">ESTUDIANTES</td>
		<td class="column" style="text-align:center;width:22%;"><?php echo $row_coestudiantes['cantidad']; ?></td>
		<td class="column" style="text-align:center;width:22%;"><?php echo $row_totalmat['total_mat']; ?></td>              
		<td class="column" style="text-align:center;width:22%;"><?php echo round($row_codocentes['cantidad']/$row_totalmat['total_mat'],2); ?></td>    
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

<form action="" method="post" id="correoasig" class="report">
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
		var valido= validateForm("#correoasig");
		if(valido){
			sendForm();
		}
	});
	function sendForm(){
            $('#tableDiv').html("");
            $("#loading").css("display","block");
		$.ajax({
				type: 'GET',
				url: './reportes/organizacion/viewReporteCorreosAsignados.php',
				async: false,
				data: $('#correoasig').serialize(),                
				success:function(data){			
                                    $("#loading").css("display","none");		
					$('#tableDiv').html(data);					
					
				},
				error: function(data,error,errorThrown){alert(error + errorThrown);}
		});            
	}
</script>
