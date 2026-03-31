<?php

if($_REQUEST['semestre']) {
	require_once("../../../templates/template.php");
	$db = getBD();
	// VALORES INICIALES PARA EL REPORTE
	//$periodo_inicial='20102';
	//$periodo_final='20122';
	$periodo_inicial=$_REQUEST['semestre'];
	$periodo_final=$_REQUEST['semestre'];
	$arrIndicadores = array("DURACIÓN DE ESTUDIOS: NÚMERO DE SEMESTRES QUE DURÓ EL ESTUDIANTE PARA GRADUARSE");

	function duracion ($codigoperiodo,$codigocarrera,$db) {
		$query="SELECT	 fechainicioperiodo
				,fechavencimientoperiodo 
			FROM periodo 
			WHERE codigoperiodo=$codigoperiodo";
		$exec= $db->Execute($query);
		$row = $exec->FetchRow();
	  
		$query="SELECT DISTINCT codigoestudiante
			FROM registrograduado
			JOIN estudiante USING(codigoestudiante)
			WHERE fechagradoregistrograduado BETWEEN '".$row['fechainicioperiodo']."' AND '".$row['fechavencimientoperiodo']."'
				AND codigocarrera=$codigocarrera";
		$exec= $db->Execute($query);
		$conteoestudiante = $exec->RecordCount();

		$query2="SELECT	 distinct 
				 codigoperiodo
				,codigoestudiante
			FROM ($query) AS sub
			JOIN notahistorico nh USING(codigoestudiante)";
		$exec2= $db->Execute($query2);
		$conteoperiodos = $exec2->RecordCount();

		return round($conteoperiodos/$conteoestudiante);
	}

?>
	<table align="left" id="estructuraReporte" class="previewReport" style="text-align:left;clear:both;margin: 10px 0px;">
		<thead>           
			<tr class="dataColumns"> 
				<th class="column" colspan="2">&nbsp;</th>
<?PHP
			$query="SELECT codigoperiodo FROM periodo WHERE codigoperiodo BETWEEN ".$periodo_inicial." AND ".$periodo_final." ORDER BY codigoperiodo";
			$exec= $db->Execute($query);
			$arrPeriodos=array();
			while($row = $exec->FetchRow()) {  
				$arrPeriodos[]=$row['codigoperiodo'];
?>
				<th class="column" colspan='<?PHP echo count($arrIndicadores)?>'><span>SEMESTRE <?PHP echo $row['codigoperiodo']?></span></th>
<?PHP 		} 
?>
			</tr>
			<tr class="dataColumns"> 
				<th class="column" colspan="2">&nbsp;</th>
<?PHP
				foreach ($arrPeriodos as $per) {
					foreach($arrIndicadores as $key => $value) {
?>
						<th class="column"><span><?PHP echo $value?></span></th>
<?PHP
					}
				}
?>
			</tr>
		</thead>
		<tbody>
<?PHP
			$query="SELECT	 DISTINCT
					 codigomodalidadacademicasic
					,nombremodalidadacademicasic
					,codigocarrera
					,nombrecarrera
				FROM carrera 
				JOIN modalidadacademicasic USING (codigomodalidadacademicasic) 
				WHERE codigomodalidadacademicasic IN (200,300,301,302)
					AND fechavencimientocarrera >=curdate() 
				ORDER BY codigomodalidadacademicasic
					,nombrecarrera";
			$exec= $db->Execute($query);
			$aux="";
			$aux2="";
			$cont2=0;
			$aux3=false;
			while($row = $exec->FetchRow()) { 
				if($aux!=$row['codigomodalidadacademicasic'])  {
					$cont2=0;
					$cols=(count($arrIndicadores)*count($arrPeriodos))+2;
					if($aux3) {
?>				
						<!--<tr id="contentColumns" class="row">
							<td class="column category" colspan="2" style="font-size:25px;font-weight:bold">TOTAL HP//=$aux2?></td>
<?PHP
							/*foreach ($arrPeriodos as $per_process) {
								foreach($arrIndicadores as $key => $value) {
									$vlr=$sum_duracion[$per_process];
?>	
									<td class="column category" style="font-size:25px;font-weight:bold" align="center"><?PHP=$vlr?></td>
<?PHP
								}
							}*/
?>
						</tr>-->
<?PHP				
					}
					$aux3=true;
?>
					<tr id="contentColumns" class="row"><td class="column category" colspan="<?PHP echo $cols?>" style="font-size:25px;font-weight:bold"><?PHP echo $row['nombremodalidadacademicasic']?></td></tr>
<?PHP		
					$sum_duracion=array();
				}
				$cont2++;
?>
				<tr class="contentColumns" class="row">
					<td class="column"><?PHP echo $cont2?></td>
					<td class="column"><?PHP echo $row['nombrecarrera']?></td>
<?PHP
					foreach ($arrPeriodos as $per_process) {
						foreach($arrIndicadores as $key => $value) {
							$vlr=duracion($per_process,$row['codigocarrera'],$db);
							$sum_duracion[$per_process]+=$vlr;
?>
							<td class="column" align="center"><?PHP echo $vlr?></td>
<?PHP
						}
					}
?>
				</tr>
<?PHP
				$aux=$row['codigomodalidadacademicasic'];
				$aux2=$row['nombremodalidadacademicasic'];
			}
?>
			<!--<tr id="contentColumns" class="row">
				<td colspan="2" class="column category" style="font-size:25px;font-weight:bold">TOTAL ?PHP//=$aux2?></td>
<?PHP
				/*foreach ($arrPeriodos as $per_process) {
					foreach($arrIndicadores as $key => $value) {
						$vlr=$sum_duracion[$per_process];
?>	
						<td class="column category" style="font-size:25px;font-weight:bold" align="center"><?PHP=$vlr?></td>
<?PHP
					}
				}*/
?>
			</tr>-->
		</tbody>        
	</table>
<?PHP
	exit;
}
?>

<form action="" method="post" id="forma" class="report">
	<br>
	<span class="mandatory">* Son campos obligatorios</span>
	<fieldset>
		<legend></legend>
		<label for="semestre" class="grid-2-12">Semestre: <span class="mandatory">(*)</span></label>
		<?php $utils->getSemestresSelect($db,"semestre"); ?>
		<input type="submit" value="Consultar" class="first small" />
		<div id='respuesta_forma'></div>
	</fieldset>
</form>
<script type="text/javascript">
	$(':submit').click(function(event) {
		event.preventDefault();
		var valido= validateForm("#forma");
		if(valido){
			$('#respuesta_forma').html('<br><center><img src="../../images/ajax-loader.gif"> <b>Generando reporte, por favor espere...</b></center>');
			sendForm();
		}
	});
	function sendForm(){
		$.ajax({
			type: 'GET',
			url: 'reportes/estudiantes/viewReporteDuracionEstudios.php',
			async: false,
			data: $('#forma').serialize(),                
			success:function(data){
				$('#respuesta_forma').html(data);
			},
			error: function(data,error,errorThrown){alert(error + errorThrown);}
	});            
}
</script>
