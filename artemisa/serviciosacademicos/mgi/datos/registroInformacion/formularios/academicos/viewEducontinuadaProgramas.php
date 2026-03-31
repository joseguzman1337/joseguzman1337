<?php
session_start();
if(isset($reporteEspecifico)){ 
$rutaInc = "../registroInformacion/";
}else{
	require_once("../../../templates/template.php");
	$db = getBD();
	$rutaInc = "./";
}

$utils = new Utils_datos();
if(($_POST['anio'])&&($_POST['mes'])) {
	$periodicidad=$_REQUEST['anio'].$_REQUEST['mes'];
	$query="select	 id
			,clasificacion
			,nombrecategorias
			,num_abierto
			,num_cerrado
			,num_pres
			,num_vir
			,num_sem
			,numero_asistentes
		from siq_educacioncontinuadaprogramasinfhuerfana
		join infoEducacionContinuada using(idclasificacion)
		left join programasEducacionContinuada using(idcategorias)
		where periodicidad=".$periodicidad;
	$reg=$db->Execute($query);

	if($reg->RecordCount()==0) {
?>
		<div id="msg-success" class="msg-success msg-error" ><p>No existe información para la fecha  <?php echo$periodicidad?></p></div>
<?php
	} else {
		
?>
<div id="tableDiv">
		<table align="center" class="formData last previewReport" width="100%" >
			<thead>            
				<tr class="dataColumns">
					<th class="column" colspan="13"><span>Número programas y de asistentes ofertados por la División de Educación Continuada</span></th>                                    
				</tr>
				<tr class="dataColumns category">
					<th class="column borderR" rowspan="3" width="10%"><span>Tipos de Programas</span></th>
					<th class="column borderR" rowspan="3" width="10%"><span>Categoria</span></th>
					<th class="column borderR" colspan="5" width="40%"><span>Modalidad</span></th>
					<th class="column borderR" rowspan="3" width="10%"><span>Número Asistentes</span></th>
					<th class="column borderR" colspan="4" width="30%"><span>Componente Internacional</span></th>
				</tr>
				<tr >
					<th class="column borderR" rowspan="2" width="8%">ABI</th>
					<th class="column borderR" rowspan="2" width="8%">CER</th>	
					<th class="column borderR" rowspan="2" width="8%">PRE</th>
					<th class="column borderR" rowspan="2" width="8%">VIR</th>
					<th class="column borderR" rowspan="2" width="8%">SEMI</th>
					<th class="column borderR" width="15%">Participantes</th>
					<th class="column borderR" width="15%">Conferencistas</th>
				</tr>
				<tr>
					<th class="column borderR" width="15%">Pais / Cantidad</th>
					<th class="column borderR" width="15%">Pais / Cantidad</th>
				</tr>
			</thead> 
			<tbody>              	 
<?php
				$sumaABI = 0;
				$sumaCER = 0;
				$sumaPRE = 0;
				$sumaVIR = 0;
				$sumaSEMI = 0;
				$sumaAsistentes = 0;
				while($row=$reg->FetchRow()) {
				$sumaABI += $row['num_abierto'];
				$sumaCER += $row['num_cerrado'];
				$sumaPRE += $row['num_pres'];
				$sumaVIR += $row['num_vir'];
				$sumaSEMI += $row['num_sem'];
				$sumaAsistentes += $row['numero_asistentes'];
?>

					<tr id="contentColumns" class="row">
						<td class="column borderR"><?php echo$row['clasificacion']?></td>
						<td class="column borderR"><?php echo$row['nombrecategorias']?></td>
						<td class="column borderR" align="center"><?php echo$row['num_abierto']?></td>
						<td class="column borderR" align="center"><?php echo$row['num_cerrado']?></td>
						<td class="column borderR" align="center"><?php echo$row['num_pres']?></td>
						<td class="column borderR" align="center"><?php echo$row['num_vir']?></td>
						<td class="column borderR" align="center"><?php echo$row['num_sem']?></td>
						<td class="column borderR" align="center"><?php echo$row['numero_asistentes']?></td>
						<td class="column borderR" align="center">
<?php
      $SQL_Detalle='SELECT  
                        d.id,
                        d.tipo,
                        d.pais,
                        d.cantidad,
                        p.nombrepais
                        
                        FROM siq_detalle_educacioncontinuadaprogramasinfhuerfana d INNER JOIN pais p ON d.pais=p.idpais
                        
                        WHERE
                        
                        d.codigoestado=100
                        AND
                        d.tipo=1
                        AND
                        d.id_educacioncontinuadaprogramasinfhuerfana="'.$row['id'].'"';
                    
                    if($Detalle=&$db->Execute($SQL_Detalle)===false){
                        echo '<br>Error En el SQL Consulta....'.$SQL_Detalle;
                        die;
                    }//if
                    while(!$Detalle->EOF){
                        echo '<br>'.$Detalle->fields['nombrepais'].'&nbsp;&nbsp;&nbsp;&nbsp;'.$Detalle->fields['cantidad'];
                        $sumParcialParticipantes[] += $Detalle->fields['cantidad'];
                        $Detalle->MoveNext();
                    }
						
?>
						</td>
						<td class="column borderR" align="center">
<?php
						
                                    
              $query3='SELECT  
                        d.id,
                        d.tipo,
                        d.pais,
                        d.cantidad,
                        p.nombrepais
                        
                        FROM siq_detalle_educacioncontinuadaprogramasinfhuerfana d INNER JOIN pais p ON d.pais=p.idpais
                        
                        WHERE
                        
                        d.codigoestado=100
                        AND
                        d.tipo=2
                        AND
                        d.id_educacioncontinuadaprogramasinfhuerfana="'.$row['id'].'"';
                    
                    if($Detalle2=&$db->Execute($query3)===false){
                        echo '<br>Error En el SQL Consulta....'.$SQL_Detalle;
                        die;
                    }//if  
                    while(!$Detalle2->EOF){
                        
                        echo '<br>'.$Detalle2->fields['nombrepais'].'&nbsp;&nbsp;&nbsp;&nbsp;'.$Detalle2->fields['cantidad'];
                        $sumParcialConferencistas[] += $Detalle2->fields['cantidad'];
                        $Detalle2->MoveNext();
                    }      
							
?>
						</td>
					</tr>

<?php
				}
				function sumaTodo($arreglo){
					foreach ($arreglo as $key => $value) {
						$sum += $value;
					}
					return $sum;
				}
?>
<tr id="contentColumns" class="row">
	<td class="column borderR center" colspan="2">Total</td>
	<td name="totalABI" id="totalABI" class="column borderR center"><?php echo $sumaABI; ?></td>
	<td name="totalCER" id="totalCER" class="column borderR center"><?php echo $sumaCER; ?></td>
	<td name="totalPRE" id="totalPRE" class="column borderR center"><?php echo $sumaPRE; ?></td>
	<td name="totalVIR" id="totalVIR" class="column borderR center"><?php echo $sumaVIR; ?></td>
	<td name="totalSEMI" id="totalSEMI" class="column borderR center"><?php echo $sumaSEMI; ?></td>
	<td name="totalAsistentes" id="totalAsistentes" class="column borderR center"><?php echo $sumaAsistentes; ?></td>
	<td name="totalParticipantes" id="totalParticipantes" class="column borderR center"><?php echo sumaTodo($sumParcialParticipantes); ?></td>
	<td name="totalConferencistas" id="totalConferencistas" class="column borderR center"><?php echo sumaTodo($sumParcialConferencistas); ?></td>
</tr>
			</tbody>    
		</table>
	</div>
<?PHP
	}
	exit;
}

?>
<form action="" method="post" id="form1">
	<span class="mandatory">* Son campos obligatorios</span>
	<fieldset>  
		<legend>Programas y de asistentes ofertados por la División de Educación Continuada</legend>
		<label for="anio" class="grid-2-12">Año: <span class="mandatory">(*)</span></label>
<?php
		$utils->getYearsSelect("anio");
?>
		<label for="mes" class="grid-2-12">Mes: <span class="mandatory">(*)</span></label>
<?php
		$utils->getMonthsSelect("mes");
?>
		<input type="submit" value="Consultar" class="first small" />	
		<div id='respuesta_form1'></div>
	</fieldset>
</form>
<script type="text/javascript">
	$(':submit').click(function(event) {
		event.preventDefault();
		var valido= validateForm("#form1");
		if(valido){
			sendForm_ofre();
		}
	});
	function sendForm_ofre(){
		$.ajax({
			type: 'POST',
			url: '<?php echo $rutaInc;?>formularios/academicos/viewEducontinuadaProgramas.php',
			async: false,
			data: $('#form1').serialize(),                
			success:function(data){					
				$('#respuesta_form1').html(data);					
			},
			error: function(data,error,errorThrown){alert(error + errorThrown);}
		});            
	}
</script>
