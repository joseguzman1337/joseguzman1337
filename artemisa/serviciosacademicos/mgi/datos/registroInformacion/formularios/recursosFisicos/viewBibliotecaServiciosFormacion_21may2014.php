<? 
session_start();
require_once("../../../templates/template.php");
$db = getBD();
$utils = new Utils_datos();
if($_REQUEST['anio'] && $_REQUEST['mes']) {
	$periodo=$_REQUEST['anio'].$_REQUEST['mes'];
	$query="select sbih.id
		from siq_bibliotecainfhuerfana sbih 
		join siq_clasificacionesinfhuerfana sch1 using(idclasificacionesinfhuerfana) 
		join siq_clasificacionesinfhuerfana sch2 on sch1.idpadreclasificacionesinfhuerfana=sch2.idclasificacionesinfhuerfana
		join siq_clasificacionesinfhuerfana sch3 on sch2.idpadreclasificacionesinfhuerfana=sch3.idclasificacionesinfhuerfana
		where sbih.periodicidad=".$periodo." and sch3.aliasclasificacionesinfhuerfana='".$_REQUEST['alias']."'";
	$exec= $db->Execute($query);
	if($exec->RecordCount()==0) {
?>
		<div id="msg-success" class="msg-success msg-error" ><p>No existe información almacenada para el periodo <?=$periodo?></p></div>

<?
	} else {
?>
                <table align="center" class="formData last" width="92%">
<?
			$sum_tot_induccion_biblioteca=0;
			$sum_tot_busqueda_recuperacion_informacion=0;
			$sum_tot_gestor_referencias=0;
			$sum_tot_seminario_taller=0;
			$query2="select	 sch.clasificacionesinfhuerfana
					,sch.aliasclasificacionesinfhuerfana
				from siq_clasificacionesinfhuerfana sch
				join (	select idclasificacionesinfhuerfana
					from siq_clasificacionesinfhuerfana 
					where aliasclasificacionesinfhuerfana='".$_REQUEST['alias']."'
				) sub on sch.idpadreclasificacionesinfhuerfana=sub.idclasificacionesinfhuerfana
				where sch.estado";
			$exec2= $db->Execute($query2);
			while($row2 = $exec2->FetchRow()) {
?>
				<tr class="dataColumns category">
					<th colspan="5" class="borderR"><?=$periodo?></th>               
				</tr>
				<tr class="dataColumns">
					<th class="borderR">Perfiles / Módulos de formación</th>               
					<th class="borderR">Inducción biblioteca</th>               
					<th class="borderR">Búsqueda y recuperación de información</th>               
					<th class="borderR">Gestor de referencias</th>               
					<th class="borderR">Seminario taller</th>               
				</tr>
<?
				$sum_induccion_biblioteca=0;
				$sum_busqueda_recuperacion_informacion=0;
				$sum_gestor_referencias=0;
				$sum_seminario_taller=0;
				$query="select	 sch1.clasificacionesinfhuerfana
						,sbih.induccion_biblioteca
						,sbih.busqueda_recuperacion_informacion
						,sbih.gestor_referencias
						,sbih.seminario_taller
					from siq_bibliotecainfhuerfana sbih 
					join siq_clasificacionesinfhuerfana sch1 using(idclasificacionesinfhuerfana) 
					join siq_clasificacionesinfhuerfana sch2 on sch1.idpadreclasificacionesinfhuerfana=sch2.idclasificacionesinfhuerfana
					where sbih.periodicidad=".$periodo." and sch2.aliasclasificacionesinfhuerfana='".$row2['aliasclasificacionesinfhuerfana']."'";
				$exec= $db->Execute($query);
				while($row = $exec->FetchRow()) {
?>
					<tr id="contentColumns" class="row">
						<td class="column borderR"><?=$row['clasificacionesinfhuerfana']?></td>
						<td class="column borderR" align="center"><?=$row['induccion_biblioteca']?></td>
						<td class="column borderR" align="center"><?=$row['busqueda_recuperacion_informacion']?></td>
						<td class="column borderR" align="center"><?=$row['gestor_referencias']?></td>
						<td class="column borderR" align="center"><?=$row['seminario_taller']?></td>
					</tr>
<?
					$sum_induccion_biblioteca+=$row['induccion_biblioteca'];
					$sum_busqueda_recuperacion_informacion+=$row['busqueda_recuperacion_informacion'];
					$sum_gestor_referencias+=$row['gestor_referencias'];
					$sum_seminario_taller+=$row['seminario_taller'];
				} 
?>
				<tr>
					<th class="borderR">Total</th>
					<th class="borderR"><?=$sum_induccion_biblioteca?></th>
					<th class="borderR"><?=$sum_busqueda_recuperacion_informacion?></th>
					<th class="borderR"><?=$sum_gestor_referencias?></th>
					<th class="borderR"><?=$sum_seminario_taller?></th>
				</tr>
<?
				$sum_tot_induccion_biblioteca+=$sum_induccion_biblioteca;
				$sum_tot_busqueda_recuperacion_informacion+=$sum_busqueda_recuperacion_informacion;
				$sum_tot_gestor_referencias+=$sum_gestor_referencias;
				$sum_tot_seminario_taller+=$sum_seminario_taller;
			}
?>
			<tr id="contentColumns" class="row">
				<td colspan='5'>&nbsp;</td>
			</tr>
			<tr class="dataColumns category">
				<th class="borderR" style='font-size:25px'>GRAN TOTAL</th>
				<th class="borderR" style='font-size:25px'><?=$sum_tot_induccion_biblioteca?></th>
				<th class="borderR" style='font-size:25px'><?=$sum_tot_busqueda_recuperacion_informacion?></th>
				<th class="borderR" style='font-size:25px'><?=$sum_tot_gestor_referencias?></th>
				<th class="borderR" style='font-size:25px'><?=$sum_tot_seminario_taller?></th>
			</tr>
		</table>
<?
	}
	exit;
}
?>
<form action="" method="post" id="form<?=$_REQUEST['alias']?>">
	<span class="mandatory">* Son campos obligatorios</span>
	<fieldset>  
		<legend>Servicios de formación</legend>
		<label for="periodo" class="grid-2-12">Periodo: <span class="mandatory">(*)</span></label>
<?		
		$utils->getMonthsSelect("mes"); 
		$utils->getYearsSelect("anio"); 
?>
		<input type="hidden" name="alias" value="<?=$_REQUEST['alias']?>" />
		<input type="submit" value="Consultar" class="first small" />
		<div id='respuesta_form<?=$_REQUEST['alias']?>'></div>
	</fieldset>
</form>
<script type="text/javascript">
	$(':submit').click(function(event) {
		event.preventDefault();
		var valido= validateForm("#form<?=$_REQUEST['alias']?>");
		if(valido){
			sendForm();
		}
	});
	function sendForm(){
		$.ajax({
				type: 'GET',
				url: 'formularios/recursosFisicos/viewBibliotecaServiciosFormacion.php',
				async: false,
				data: $('#form<?=$_REQUEST['alias']?>').serialize(),                
				success:function(data){
					$('#respuesta_form<?=$_REQUEST['alias']?>').html(data);
				},
				error: function(data,error,errorThrown){alert(error + errorThrown);}
		});            
	}
</script>
