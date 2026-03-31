<?php

if($_REQUEST['semestre']) {
	require_once("../../../templates/template.php");
	$db = getBD();
	// VALORES INICIALES PARA EL REPORTE
	//$periodo_inicial='20102';
	//$periodo_final='20122';
	$periodo_inicial=$_REQUEST['semestre'];
	//$periodo_final=$_REQUEST['semestre'];
	$arrIndicadores = array( "NÚMERO DE GRADUADOS DE LA COHORTE HASTA UN AÑO LUEGO DE LA FINALIZACIÓN"
				,"NÚMERO DE MATRICULADOS PRIMERA VEZ EN EL PRIMER SEMESTRE"
				,"ÍNDICE DE ESFUERZO DE FORMACIÓN");

	function graduados ($codigoperiodo,$codigocarrera,$db) {
		$query="SELECT * 
			FROM (
				Select	 fechainicioperiodo
					,fechavencimientoperiodo As fechafinalcondicion 
				From periodo 
				Where codigoperiodo=$codigoperiodo
			) sub1 
			CROSS JOIN (
				Select fechainicioperiodo As fechainicialcondicion 
				From (
					select * 
					from periodo 
					where codigoperiodo<=$codigoperiodo 
					order by codigoperiodo desc 
					limit 2
				) sub 
				Order By codigoperiodo
				Limit 1
			) sub2 ";
		$exec= $db->Execute($query);
		$row = $exec->FetchRow();

		$query2="SELECT cantidadsemestresplanestudio+2 AS semestres
			FROM estudianteestadistica ee
			,carrera c
			,estudiante e
			,planestudioestudiante pee
			,planestudio pe
			WHERE e.codigocarrera = '$codigocarrera'
				AND e.codigocarrera=c.codigocarrera
				AND ee.codigoestudiante=e.codigoestudiante
				AND ee.codigoestudiante=pee.codigoestudiante
				AND pee.idplanestudio=pe.idplanestudio
				AND ee.codigoperiodo = '$codigoperiodo'
				AND ee.codigoprocesovidaestudiante= 400
				AND ee.codigoestado LIKE '1%'
			LIMIT 1";
		$exec2= $db->Execute($query2);

		if($exec2->RecordCount()>0) {
			$row2 = $exec2->FetchRow();
			
			$query3="SELECT codigoperiodo 
				FROM (
					Select codigoperiodo 
					From periodo 
					Where codigoperiodo<=$codigoperiodo 
					Order By codigoperiodo desc 
					Limit ".$row2['semestres']."
				) sub 
				ORDER BY codigoperiodo 
				LIMIT 1";
			$exec3= $db->Execute($query3);
			$row3 = $exec3->FetchRow();
			$codigoperiodo_cohorte=$row3['codigoperiodo'];
			$query4="SELECT codigoestudiante
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
						And eg.idestudiantegeneral not in (	select idestudiantegeneral 
											from estudiante e 
											join estudiantegeneral eg using(idestudiantegeneral) 
											where codigoperiodo < '$codigoperiodo_cohorte'
										)
				) sub1
				JOIN (
					Select Distinct rg.codigoestudiante
					From registrograduado rg
					Where fechagradoregistrograduado Between '".$row['fechainicialcondicion']."' And '".$row['fechafinalcondicion']."'
				) sub2 using(codigoestudiante)";
			$exec4= $db->Execute($query4);
			return $exec4->RecordCount();
		} else
			return 0;
	}

	function matriculados ($codigoperiodo,$codigocarrera,$db) {
		$query="SELECT fechainicioperiodo
			FROM periodo 
			WHERE codigoperiodo=$codigoperiodo ";
		$exec= $db->Execute($query);
		$row = $exec->FetchRow();

		$query2="SELECT cantidadsemestresplanestudio+2 AS semestres
			FROM estudianteestadistica ee
			,carrera c
			,estudiante e
			,planestudioestudiante pee
			,planestudio pe
			WHERE e.codigocarrera = '$codigocarrera'
				AND e.codigocarrera=c.codigocarrera
				AND ee.codigoestudiante=e.codigoestudiante
				AND ee.codigoestudiante=pee.codigoestudiante
				AND pee.idplanestudio=pe.idplanestudio
				AND ee.codigoperiodo = '$codigoperiodo'
				AND ee.codigoprocesovidaestudiante= 400
				AND ee.codigoestado LIKE '1%'
			LIMIT 1";
		$exec2= $db->Execute($query2);
		if($exec2->RecordCount()>0) {
			$row2 = $exec2->FetchRow();
			
			$query3="SELECT codigoperiodo 
				FROM (
					Select codigoperiodo 
					From periodo 
					Where codigoperiodo<=$codigoperiodo 
					Order By codigoperiodo desc 
					Limit ".$row2['semestres']."
				) sub 
				ORDER BY codigoperiodo 
				LIMIT 1";
			$exec3= $db->Execute($query3);
			$row3 = $exec3->FetchRow();
			$codigoperiodo_cohorte=$row3['codigoperiodo'];
			
			$query4="SELECT DISTINCT ee.codigoestudiante
				FROM estudianteestadistica ee
				, carrera c
				, estudiante e
				, estudiantegeneral eg
				WHERE e.codigocarrera = $codigocarrera
					AND e.codigocarrera=c.codigocarrera
					AND ee.codigoestudiante=e.codigoestudiante
					AND eg.idestudiantegeneral=e.idestudiantegeneral
					AND ee.codigoperiodo = '$codigoperiodo_cohorte'
					AND ee.codigoprocesovidaestudiante= 400
					AND ee.codigoestado LIKE '1%'
					AND eg.idestudiantegeneral NOT IN (	Select idestudiantegeneral 
										From estudiante e 
										Join estudiantegeneral eg Using(idestudiantegeneral) 
										Where codigoperiodo < '$codigoperiodo_cohorte'
										)";
			$exec4= $db->Execute($query4);
			return $exec4->RecordCount();
		} else
			return 0;
	}

	function esfuerzo ($codigoperiodo,$codigocarrera,$db) {
		$graduados=graduados($codigoperiodo,$codigocarrera,$db);
		$matriculados=matriculados($codigoperiodo,$codigocarrera,$db);
		return round(($graduados)/$matriculados,2);
	}

	?>
	<table align="left" id="estructuraReporte" class="previewReport" style="text-align:left;clear:both;margin: 10px 0px;">
		<thead>           
			<tr class="dataColumns"> 
				<th class="column" colspan="2">&nbsp;</th>
<?PHP 
			//$query="SELECT codigoperiodo FROM periodo WHERE codigoperiodo BETWEEN ".$periodo_inicial." AND ".$periodo_final." ORDER BY codigoperiodo";
			$query="SELECT codigoperiodo FROM periodo WHERE codigoperiodo='".$periodo_inicial."' ORDER BY codigoperiodo";
			$exec= $db->Execute($query);
			$arrPeriodos=array();
			while($row = $exec->FetchRow()) {  
				$arrPeriodos[]=$row['codigoperiodo'];
	?>
				<th class="column" colspan='<?PHP echo count($arrIndicadores)?>'><span>PERIODO <?PHP echo $row['codigoperiodo']?></span></th>
<?PHP		} 
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
						<tr id="contentColumns" class="row">
							<td class="column category" colspan="2" style="font-size:25px;font-weight:bold">TOTAL <?PHP echo $aux2?></td>
<?PHP 
							foreach ($arrPeriodos as $per_process) {
								foreach($arrIndicadores as $key => $value) {
									switch($key) {
										case 0: $vlr=$sum_graduados[$per_process];break;
										case 1: $vlr=$sum_matriculados[$per_process];break;
										case 2: $vlr="&nbsp;";break;
									}
?>	
									<td class="column category" style="font-size:25px;font-weight:bold" align="center"><?PHP echo $vlr?></td>
<?PHP 
								}
							}
?>
						</tr>
<?PHP 				
					}
					$aux3=true;
?>
					<tr id="contentColumns" class="row"><td class="column category" colspan="<?PHP echo $cols?>" style="font-size:25px;font-weight:bold"><?PHP echo $row['nombremodalidadacademicasic']?></td></tr>
<?PHP 		
					$sum_graduados=array();
					$sum_matriculados=array();
				}
				$cont2++;

					foreach ($arrPeriodos as $per_process) {
						foreach($arrIndicadores as $key => $value) {
							switch($key) {
								case 0: 
									$vlr1=graduados($per_process,$row['codigocarrera'],$db);
									$sum_graduados[$per_process]+=$vlr1;
									break;
								case 1: 
									$vlr2=matriculados($per_process,$row['codigocarrera'],$db);
									$sum_matriculados[$per_process]+=$vlr2;
									break;
								case 2: 
									$vlr3=esfuerzo($per_process,$row['codigocarrera'],$db);break;
							}
							
						}
					}
					if($vlr1!==0 || $vlr2!==0){
?>
				<tr class="contentColumns" class="row">
					<td class="column"><?PHP echo $cont2?></td>
					<td class="column"><?PHP echo $row['nombrecarrera']?></td>
					<td class="column" align="center"><?PHP echo $vlr1?></td>
					<td class="column" align="center"><?PHP echo $vlr2?></td>
					<td class="column" align="center"><?PHP echo $vlr3?></td>
				</tr>
<?PHP }
				$aux=$row['codigomodalidadacademicasic'];
				$aux2=$row['nombremodalidadacademicasic'];
			}
?>
			<tr id="contentColumns" class="row">
				<td colspan="2" class="column category" style="font-size:25px;font-weight:bold">TOTAL <?PHP echo $aux2?></td>
<?PHP 
				foreach ($arrPeriodos as $per_process) {
					foreach($arrIndicadores as $key => $value) {
						switch($key) {
							case 0: $vlr=$sum_graduados[$per_process];break;
							case 1: $vlr=$sum_matriculados[$per_process];break;
							case 2: $vlr="&nbsp;";break;
						}
?>	
						<td class="column category" style="font-size:25px;font-weight:bold" align="center"><?PHP echo $vlr?></td>
<?PHP 
					}
				}
?>
			</tr>
		</tbody>        
	</table>
<?PHP 
	exit;
}

if($UrlView==1){
    $Url = '../../mgi/datos/';
    $Imagen = '../../mgi/'; 
    $Report = '../../mgi/datos/reportes/';  
    ?>
    <link rel="stylesheet" href="../../mgi/css/cssreset-min.css" type="text/css" /> 
    <link rel="stylesheet" href="../../mgi/css/styleMonitoreo.css" type="text/css" /> 
    <link rel="stylesheet" href="../../mgi/css/styleDatos.css" type="text/css" /> 
    <script type="text/javascript" language="javascript" src="../../mgi/js/functions.js"></script>
    <?PHP
 
}else{
    $Url = '../';
    $Imagen = '../../';
    $Report = '';
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
			$('#respuesta_forma').html('<br><center><img src="<?PHP echo $Imagen?>images/ajax-loader.gif"> <b>Generando reporte, por favor espere...</b></center>');
			sendForm();
		}
	});
	function sendForm(){
		$.ajax({
			type: 'GET',
			url: '<?PHP echo $Report?>reportes/estudiantes/viewReporteEsfuerzoGraduandos.php',
			async: false,
			data: $('#forma').serialize(),                
			success:function(data){
				$('#respuesta_forma').html(data);
			},
			error: function(data,error,errorThrown){alert(error + errorThrown);}
	});            
}
</script>
