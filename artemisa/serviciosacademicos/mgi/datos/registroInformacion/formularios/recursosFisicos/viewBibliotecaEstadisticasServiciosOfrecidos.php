<?PHP  
session_start();
require_once("../../../templates/template.php");
$db = getBD();
$utils = new Utils_datos();
if($_REQUEST['anio'] && $_REQUEST['mes']) {
	$query="select id from siq_estadisticasservicioofrecido	where mes=".$_REQUEST['anio'].$_REQUEST['mes'];
	$exec= $db->Execute($query);
	if($exec->RecordCount()==0) {
?>
        <div id="msg-success" class="msg-success msg-error" ><p>No existe información almacenada para el mes <?PHP echo $utils->getMonthsSelect($_REQUEST['mes'],true)." - ".$_REQUEST['anio']?></p></div>

<?PHP 
	} else {
?>
		<table align="center" class="formData last" width="92%">
			<tr id="dataColumns">
				<th colspan="3" style="font-size:20px"><?PHP echo $utils->getMonthsSelect($_REQUEST['mes'],true)." - ".$_REQUEST['anio']?></th> 
			</tr>
<?PHP 
			$query="select idclasificacionesinfhuerfana
					,clasificacionesinfhuerfana
					,aliasclasificacionesinfhuerfana
				from siq_clasificacionesinfhuerfana ch 
				where aliasclasificacionesinfhuerfana in ('sdlb','sdrcap','sdra','sdrcom','sdrs')";
			$exec= $db->Execute($query);
			while($row = $exec->FetchRow()) {
?>
				<tr id="dataColumns">
<?PHP 
					if($row['aliasclasificacionesinfhuerfana']=='sdlb') {
?>
						<th>Servicio de la biblioteca</th>               
						<th>Nro. de consultas docentes</th>
						<th>Nro. de consultas estudiantes</th>
<?PHP 				
					}
					if($row['aliasclasificacionesinfhuerfana']=='sdrcap') {
?>					
						<th>Servicio de referencia</th>               
						<th>Nro. de capacitación a docentes</th>
						<th>Nro. de capacitación a estudiantes</th>
<?PHP 				
					}
					if($row['aliasclasificacionesinfhuerfana']=='sdra') {
?>					
						<th>Servicio de referencia</th>               
						<th>Nro. de artículos solicitados docentes</th>
						<th>Nro. de artículos solicitados estudiantes</th>
<?PHP 				
					}
					if($row['aliasclasificacionesinfhuerfana']=='sdrcom') {
?>					
						<th>Servicio de referencia</th>               
						<th colspan="2">Comunidad académica y administrativa</th>
<?PHP 				
					}
					if($row['aliasclasificacionesinfhuerfana']=='sdrs') {
?>
						<th>Servicio de la biblioteca</th>               
						<th>Nro. de solicitudes de docentes</th>
						<th>Nro. de solicitudes de estudiantes</th>
<?PHP 				
					}
?>
				</tr>
<?PHP 
				$query2="select clasificacionesinfhuerfana
						,consultas_docentes
						,consultas_estudiantes
						,capacitaciones_docentes
						,capacitaciones_estudiantes
						,articulos_solicitados_docentes
						,articulos_solicitados_estudiantes
						,comunidad_academica_administrativa
						,solicitudes_docentes
						,solicitudes_estudiantes
					from siq_estadisticasservicioofrecido
					join siq_clasificacionesinfhuerfana using(idclasificacionesinfhuerfana)
					where mes=".$_REQUEST['anio'].$_REQUEST['mes']."
						and idpadreclasificacionesinfhuerfana=".$row['idclasificacionesinfhuerfana'];
				$exec2= $db->Execute($query2);
				$sum_consultas_docentes=0;
				$sum_consultas_estudiantes=0;
				$sum_capacitaciones_docentes=0;
				$sum_capacitaciones_estudiantes=0;
				$sum_articulos_solicitados_docentes=0;
				$sum_articulos_solicitados_estudiantes=0;
				$sum_comunidad_academica_administrativa=0;
				$sum_solicitudes_docentes=0;
				$sum_solicitudes_estudiantes=0;
				while($row2 = $exec2->FetchRow()) {
?>
					<tr id="contentColumns" class="row">
						<td class="column"><?PHP echo $row2['clasificacionesinfhuerfana']?></td>
<?PHP 
						if($row['aliasclasificacionesinfhuerfana']=='sdlb') {
?>
							<td class="column" align="center"><?PHP echo $row2['consultas_docentes']?></td>
							<td class="column" align="center"><?PHP echo $row2['consultas_estudiantes']?></td>
<?PHP 	
						}
						if($row['aliasclasificacionesinfhuerfana']=='sdrcap') {
?>
							<td class="column" align="center"><?PHP echo $row2['capacitaciones_docentes']?></td>
							<td class="column" align="center"><?PHP echo $row2['capacitaciones_estudiantes']?></td>
<?PHP 	
						}
						if($row['aliasclasificacionesinfhuerfana']=='sdra') {
?>
							<td class="column" align="center"><?PHP echo $row2['articulos_solicitados_docentes']?></td>
							<td class="column" align="center"><?PHP echo $row2['articulos_solicitados_estudiantes']?></td>
<?PHP 	
						}
						if($row['aliasclasificacionesinfhuerfana']=='sdrcom') {
?>
							<td colspan="2" class="column" align="center"><?PHP echo $row2['comunidad_academica_administrativa']?></td>
<?PHP 	
						}
						if($row['aliasclasificacionesinfhuerfana']=='sdrs') {
?>
							<td class="column" align="center"><?PHP echo $row2['solicitudes_docentes']?></td>
							<td class="column" align="center"><?PHP echo $row2['solicitudes_estudiantes']?></td>
<?PHP 	
						}
?>
					</tr>
<?PHP 	
					$sum_consultas_docentes+=$row2['consultas_docentes'];
					$sum_consultas_estudiantes+=$row2['consultas_estudiantes'];
					$sum_capacitaciones_docentes+=$row2['capacitaciones_docentes'];
					$sum_capacitaciones_estudiantes+=$row2['capacitaciones_estudiantes'];
					$sum_articulos_solicitados_docentes+=$row2['articulos_solicitados_docentes'];
					$sum_articulos_solicitados_estudiantes+=$row2['articulos_solicitados_estudiantes'];
					$sum_comunidad_academica_administrativa+=$row2['comunidad_academica_administrativa'];
					$sum_solicitudes_docentes+=$row2['solicitudes_docentes'];
					$sum_solicitudes_estudiantes+=$row2['solicitudes_estudiantes'];
				} 
?>
				<tr id="dataColumns">
<?PHP 
					if($row['aliasclasificacionesinfhuerfana']=='sdlb') {
?>
						<th>Total</th>               
						<th><?PHP echo $sum_consultas_docentes?></th>
						<th><?PHP echo $sum_consultas_estudiantes?></th>
<?PHP 				
					}
					if($row['aliasclasificacionesinfhuerfana']=='sdrcap') {
?>					
						<th>Total</th>               
						<th><?PHP echo $sum_capacitaciones_docentes?></th>
						<th><?PHP echo $sum_capacitaciones_estudiantes?></th>
<?PHP 				
					}
					if($row['aliasclasificacionesinfhuerfana']=='sdra') {
?>					
						<th>Total</th>               
						<th><?PHP echo $sum_articulos_solicitados_docentes?></th>
						<th><?PHP echo $sum_articulos_solicitados_estudiantes?></th>
<?PHP 				
					}
					if($row['aliasclasificacionesinfhuerfana']=='sdrcom') {
?>					
						<th>Total</th>               
						<th colspan="2"><?PHP echo $sum_comunidad_academica_administrativa?></th>
<?PHP 				
					}
					if($row['aliasclasificacionesinfhuerfana']=='sdrs') {
?>					
						<th>Total</th>               
						<th><?PHP echo $sum_solicitudes_docentes?></th>
						<th><?PHP echo $sum_solicitudes_estudiantes?></th>
<?PHP 				
					}
?>
				</tr>
<?PHP 
			} 
?>
		</table>
<?PHP 
	}
	exit;
}
?>
<form action="" method="post" id="form4">
	<span class="mandatory">* Son campos obligatorios</span>
	<fieldset>  
		<legend>Estadísticas por cada Servicio ofrecido</legend>
		<label for="mes" class="grid-2-12">Mes: <span class="mandatory">(*)</span></label>
<?PHP 		
		$utils->getMonthsSelect("mes"); 
		$utils->getYearsSelect("anio"); 
?>
		<input type="submit" value="Consultar" class="first small" />
		<div id='respuesta_form4'></div>
	</fieldset>
</form>
<script type="text/javascript">
	$(':submit').click(function(event) {
		event.preventDefault();
		var valido= validateForm("#form4");
		if(valido){
			sendForm();
		}
	});
	function sendForm(){
		$.ajax({
			type: 'GET',
			url: 'formularios/recursosFisicos/viewBibliotecaEstadisticasServiciosOfrecidos.php',
			async: false,
			data: $('#form4').serialize(),                
			success:function(data){
				$('#respuesta_form4').html(data);
			},
			error: function(data,error,errorThrown){alert(error + errorThrown);}
		});            
	}
</script>
