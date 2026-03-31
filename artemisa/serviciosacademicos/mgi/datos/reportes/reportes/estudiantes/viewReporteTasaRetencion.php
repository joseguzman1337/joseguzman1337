<?php

if($_REQUEST['semestre']) {
	require_once("../../../templates/template.php");
	$db = getBD();
	// VALORES INICIALES PARA EL REPORTE
	//$periodo_inicial='20102';
	//$periodo_final='20122';
	$periodo_inicial=$_REQUEST['semestre'];
	$periodo_final=$_REQUEST['semestre'];
	$arrIndicadores = array( "ESTUDIANTES QUE SIGUEN SIENDO ESTUDIANTES TRES SEMESTRES DESPUES"
				,"ESTUDIANTES QUE DESERTAN"
				,"INDICADOR DE RETENCIÓN ESTUDIANTIL");

	function estudiantes_siguen ($codigoperiodo,$codigocarrera,$db) {
		$query="SELECT codigoperiodo 
			FROM (
				Select codigoperiodo 
				From periodo 
				Where codigoperiodo<$codigoperiodo 
				Order By codigoperiodo Desc 
				Limit 3
			) sub 
			ORDER BY codigoperiodo 
			LIMIT 1";
		$exec= $db->Execute($query);
		$row = $exec->FetchRow();
		$codigoperiodo_cohorte=$row['codigoperiodo'];

		$query="SELECT codigoestudiante
			FROM (
				Select Distinct ee.codigoestudiante
				From estudianteestadistica ee
				, carrera c
				, estudiante e
				, estudiantegeneral eg
				Where e.codigocarrera = $codigocarrera
					And e.codigocarrera=c.codigocarrera
					And ee.codigoestudiante=e.codigoestudiante
					And eg.idestudiantegeneral=e.idestudiantegeneral
					And ee.codigoperiodo = '$codigoperiodo_cohorte'
					And ee.codigoprocesovidaestudiante= 400
					And ee.codigoestado Like '1%'
					And eg.idestudiantegeneral Not In (	select idestudiantegeneral 
										from estudiante e 
										join estudiantegeneral eg using(idestudiantegeneral) 
										where codigoperiodo < '$codigoperiodo_cohorte'
									)
			) sub1
			JOIN (
				Select Distinct ee.codigoestudiante
				From estudianteestadistica ee
				, carrera c
				, estudiante e
				Where e.codigocarrera = $codigocarrera
					And e.codigocarrera=c.codigocarrera
					And ee.codigoestudiante=e.codigoestudiante
					And ee.codigoperiodo = '$codigoperiodo'
					And ee.codigoprocesovidaestudiante= 401
					And ee.codigoestado Like '1%'
			) sub2 USING(codigoestudiante)";
		$exec= $db->Execute($query);
		return $exec->RecordCount();
	}

	function desercion ($codigoperiodo,$codigocarrera,$db) {
		$query="SELECT codigoperiodo 
			FROM (
				Select codigoperiodo 
				From periodo 
				Where codigoperiodo<$codigoperiodo 
				Order By codigoperiodo Desc 
				Limit 3
			) sub 
			ORDER BY codigoperiodo 
			LIMIT 1";
		$exec= $db->Execute($query);
		$row = $exec->FetchRow();
		$codigoperiodo_cohorte=$row['codigoperiodo'];

		$query="SELECT codigoestudiante
			FROM (
				Select Distinct ee.codigoestudiante
				From estudianteestadistica ee
				, carrera c
				, estudiante e
				, estudiantegeneral eg
				Where e.codigocarrera = $codigocarrera
					And e.codigocarrera=c.codigocarrera
					And ee.codigoestudiante=e.codigoestudiante
					And eg.idestudiantegeneral=e.idestudiantegeneral
					And ee.codigoperiodo = '$codigoperiodo_cohorte'
					And ee.codigoprocesovidaestudiante= 400
					And ee.codigoestado Like '1%'
					And eg.idestudiantegeneral Not In (	select idestudiantegeneral 
										from estudiante e 
										join estudiantegeneral eg using(idestudiantegeneral) 
										where codigoperiodo < '$codigoperiodo_cohorte'
									)
			) sub1
			LEFT JOIN (
				Select distinct ee.codigoestudiante
				From estudianteestadistica ee
				, carrera c
				, estudiante e
				Where e.codigocarrera = $codigocarrera
					And e.codigocarrera=c.codigocarrera
					And ee.codigoestudiante=e.codigoestudiante
					And ee.codigoperiodo = '$codigoperiodo'
					And ee.codigoprocesovidaestudiante= 401
					And ee.codigoestado Like '1%'
			) sub2 USING(codigoestudiante)
			WHERE sub2.codigoestudiante IS NULL";
		$exec= $db->Execute($query);
		return $exec->RecordCount();
	}
	 
	function retencion ($codigoperiodo,$codigocarrera,$db) {
		$estudiantes_siguen=estudiantes_siguen($codigoperiodo,$codigocarrera,$db);
		$estudiantes_desertan=desercion($codigoperiodo,$codigocarrera,$db);
		$total_estudiantes=$estudiantes_siguen+$estudiantes_desertan;
		return round(($estudiantes_siguen*100)/$total_estudiantes);
	}



?>
	<table align="left" id="estructuraReporte" class="previewReport" style="text-align:left;clear:both;margin: 10px 0px;">
		<thead>           
			<tr class="dataColumns"> 
				<th class="column" colspan="2">&nbsp;</th>
<?
			$query="SELECT codigoperiodo FROM periodo WHERE codigoperiodo BETWEEN ".$periodo_inicial." AND ".$periodo_final." ORDER BY codigoperiodo";
			$exec= $db->Execute($query);
			$arrPeriodos=array();
			while($row = $exec->FetchRow()) {  
				$arrPeriodos[]=$row['codigoperiodo'];
?>
				<th class="column" colspan='<?=count($arrIndicadores)?>'><span>PERIODO <?=$row['codigoperiodo']?></span></th>
<?
 			} 
?>
			</tr>
			<tr class="dataColumns"> 
				<th class="column" colspan="2">&nbsp;</th>
<?
				foreach ($arrPeriodos as $per) {
					foreach($arrIndicadores as $key => $value) {
?>
						<th class="column"><span><?=$value?></span></th>
<?
					}
				}
?>
			</tr>
		</thead>
		<tbody>
<?
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
						<tr id="contentColumns" class="row">
							<td class="column category" colspan="2" style="font-size:25px;font-weight:bold">TOTAL <?=$aux2?></td>
<?
							foreach ($arrPeriodos as $per_process) {
								foreach($arrIndicadores as $key => $value) {
									switch($key) {
										case 0: $vlr=$sum_estudiantes_siguen[$per_process];break;
										case 1: $vlr=$sum_desercion[$per_process];break;
										case 2: $vlr="&nbsp;";break;
									}
?>	
									<td class="column category" style="font-size:25px;font-weight:bold" align="center"><?=$vlr?></td>
<?
								}
							}
?>
						</tr>
<?				
					}
					$aux3=true;
?>
					<tr id="contentColumns" class="row"><td class="column category" colspan="<?=$cols?>" style="font-size:25px;font-weight:bold"><?=$row['nombremodalidadacademicasic']?></td></tr>
<?		
					$sum_estudiantes_siguen=array();
					$sum_desercion=array();
				}
				$cont2++;
?>
				<tr class="contentColumns" class="row">
					<td class="column"><?=$cont2?></td>
					<td class="column"><?=$row['nombrecarrera']?></td>
<?
					foreach ($arrPeriodos as $per_process) {
						foreach($arrIndicadores as $key => $value) {
							switch($key) {
								case 0: 
									$vlr=estudiantes_siguen($per_process,$row['codigocarrera'],$db);
									$sum_estudiantes_siguen[$per_process]+=$vlr;
									break;
								case 1: 
									$vlr=desercion($per_process,$row['codigocarrera'],$db);
									$sum_desercion[$per_process]+=$vlr;
									break;
								case 2: 
									$vlr=retencion($per_process,$row['codigocarrera'],$db)." %";break;
							}
?>
							<td class="column" align="center"><?=$vlr?></td>
<?
						}
					}
?>
				</tr>
<?
				$aux=$row['codigomodalidadacademicasic'];
				$aux2=$row['nombremodalidadacademicasic'];
			}
?>
			<tr id="contentColumns" class="row">
				<td colspan="2" class="column category" style="font-size:25px;font-weight:bold">TOTAL <?=$aux2?></td>
<?
				foreach ($arrPeriodos as $per_process) {
					foreach($arrIndicadores as $key => $value) {
						switch($key) {
							case 0: $vlr=$sum_estudiantes_siguen[$per_process];break;
							case 1: $vlr=$sum_desercion[$per_process];break;
							case 2: $vlr="&nbsp;";break;
						}
?>	
						<td class="column category" style="font-size:25px;font-weight:bold" align="center"><?=$vlr?></td>
<?
					}
				}
?>
			</tr>
		</tbody>        
	</table>
<?
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
			url: 'reportes/estudiantes/viewReporteTasaRetencion.php',
			async: false,
			data: $('#forma').serialize(),                
			success:function(data){
				$('#respuesta_forma').html(data);
			},
			error: function(data,error,errorThrown){alert(error + errorThrown);}
	});            
}
</script>
