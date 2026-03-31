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
			$sum_tot_solicitud_articulos=0;
			$sum_tot_preguntele_bibliotecologo=0;
			$sum_tot_bases_datos=0;
			$sum_tot_renovacion_prestamos=0;
			$sum_tot_gestor_referencias=0;
			$sum_tot_buzon_sugerencias=0;
			$sum_tot_seguidores_facebook=0;
			$sum_tot_seguidores_twitter=0;
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
					<th colspan="9" class="borderR"><?=$periodo?></th>               
				</tr>
				<tr class="dataColumns">
					<th class="borderR">Perfiles / Servicios en línea</th>               
					<th class="borderR">Solicitud de artículos</th>               
					<th class="borderR">Pregúntele al bibliotecólogo</th>               
					<th class="borderR">Bases de datos</th>               
					<th class="borderR">Renovación de préstamos</th>               
					<th class="borderR">Gestor de referencias</th>               
					<th class="borderR">Buzón de sugerencias</th>               
					<th class="borderR">Seguidores Facebook</th>               
					<th class="borderR">Seguidores Twitter</th>               
				</tr>
<?
				$sum_solicitud_articulos=0;
				$sum_preguntele_bibliotecologo=0;
				$sum_bases_datos=0;
				$sum_renovacion_prestamos=0;
				$sum_gestor_referencias=0;
				$sum_buzon_sugerencias=0;
				$sum_seguidores_facebook=0;
				$sum_seguidores_twitter=0;
				$query="select	 sch1.clasificacionesinfhuerfana
						,sbih.solicitud_articulos
						,sbih.preguntele_bibliotecologo
						,sbih.bases_datos
						,sbih.renovacion_prestamos
						,sbih.gestor_referencias
						,sbih.buzon_sugerencias
						,sbih.seguidores_facebook
						,sbih.seguidores_twitter
					from siq_bibliotecainfhuerfana sbih 
					join siq_clasificacionesinfhuerfana sch1 using(idclasificacionesinfhuerfana) 
					join siq_clasificacionesinfhuerfana sch2 on sch1.idpadreclasificacionesinfhuerfana=sch2.idclasificacionesinfhuerfana
					where sbih.periodicidad=".$periodo." and sch2.aliasclasificacionesinfhuerfana='".$row2['aliasclasificacionesinfhuerfana']."'";
				$exec= $db->Execute($query);
				while($row = $exec->FetchRow()) {
?>
					<tr id="contentColumns" class="row">
						<td class="column borderR"><?=$row['clasificacionesinfhuerfana']?></td>
						<td class="column borderR" align="center"><?=$row['solicitud_articulos']?></td>
						<td class="column borderR" align="center"><?=$row['preguntele_bibliotecologo']?></td>
						<td class="column borderR" align="center"><?=$row['bases_datos']?></td>
						<td class="column borderR" align="center"><?=$row['renovacion_prestamos']?></td>
						<td class="column borderR" align="center"><?=$row['gestor_referencias']?></td>
						<td class="column borderR" align="center"><?=$row['buzon_sugerencias']?></td>
						<td class="column borderR" align="center"><?=$row['seguidores_facebook']?></td>
						<td class="column borderR" align="center"><?=$row['seguidores_twitter']?></td>
					</tr>
<?
					$sum_solicitud_articulos+=$row['solicitud_articulos'];
					$sum_preguntele_bibliotecologo+=$row['preguntele_bibliotecologo'];
					$sum_bases_datos+=$row['bases_datos'];
					$sum_renovacion_prestamos+=$row['renovacion_prestamos'];
					$sum_gestor_referencias+=$row['gestor_referencias'];
					$sum_buzon_sugerencias+=$row['buzon_sugerencias'];
					$sum_seguidores_facebook+=$row['seguidores_facebook'];
					$sum_seguidores_twitter+=$row['seguidores_twitter'];
				} 
?>
				<tr>
					<th class="borderR">Total</th>
					<th class="borderR"><?=$sum_solicitud_articulos?></th>
					<th class="borderR"><?=$sum_preguntele_bibliotecologo?></th>
					<th class="borderR"><?=$sum_bases_datos?></th>
					<th class="borderR"><?=$sum_renovacion_prestamos?></th>
					<th class="borderR"><?=$sum_gestor_referencias?></th>
					<th class="borderR"><?=$sum_buzon_sugerencias?></th>
					<th class="borderR"><?=$sum_seguidores_facebook?></th>
					<th class="borderR"><?=$sum_seguidores_twitter?></th>
				</tr>
<?
				$sum_tot_solicitud_articulos+=$sum_solicitud_articulos;
				$sum_tot_preguntele_bibliotecologo+=$sum_preguntele_bibliotecologo;
				$sum_tot_bases_datos+=$sum_bases_datos;
				$sum_tot_renovacion_prestamos+=$sum_renovacion_prestamos;
				$sum_tot_gestor_referencias+=$sum_gestor_referencias;
				$sum_tot_buzon_sugerencias+=$sum_buzon_sugerencias;
				$sum_tot_seguidores_facebook+=$sum_seguidores_facebook;
				$sum_tot_seguidores_twitter+=$sum_seguidores_twitter;
			}
?>
			<tr id="contentColumns" class="row">
				<td colspan='9'>&nbsp;</td>
			</tr>
			<tr class="dataColumns category">
				<th class="borderR" style='font-size:25px'>GRAN TOTAL</th>
				<th class="borderR" style='font-size:25px'><?=$sum_tot_solicitud_articulos?></th>
				<th class="borderR" style='font-size:25px'><?=$sum_tot_preguntele_bibliotecologo?></th>
				<th class="borderR" style='font-size:25px'><?=$sum_tot_bases_datos?></th>
				<th class="borderR" style='font-size:25px'><?=$sum_tot_renovacion_prestamos?></th>
				<th class="borderR" style='font-size:25px'><?=$sum_tot_gestor_referencias?></th>
				<th class="borderR" style='font-size:25px'><?=$sum_tot_buzon_sugerencias?></th>
				<th class="borderR" style='font-size:25px'><?=$sum_tot_seguidores_facebook?></th>
				<th class="borderR" style='font-size:25px'><?=$sum_tot_seguidores_twitter?></th>
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
		<legend>Uso de servicios en línea</legend>
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
				url: 'formularios/recursosFisicos/viewBibliotecaServiciosDigitales.php',
				async: false,
				data: $('#form<?=$_REQUEST['alias']?>').serialize(),                
				success:function(data){
					$('#respuesta_form<?=$_REQUEST['alias']?>').html(data);
				},
				error: function(data,error,errorThrown){alert(error + errorThrown);}
		});            
	}
</script>
