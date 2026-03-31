<? 
session_start();
require_once("../../../templates/template.php");
$db = getBD();
$utils = new Utils_datos();
if($_REQUEST['anio']) {
	$periodo=$_REQUEST['anio'];
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



			$sum_tot_suscripcion=0;
			$sum_tot_open_access=0;
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
					<th colspan="3" class="borderR"><?=$periodo?></th>               
				</tr>
				<tr class="dataColumns">
					<th class="borderR">Facultad</th>               
					<th class="borderR">Suscripción</th>               
					<th class="borderR">Open access</th>               
				</tr>
<?
				$sum_suscripcion=0;
				$sum_open_access=0;
				$query="select	 sch1.clasificacionesinfhuerfana
						,sbih.suscripcion
						,sbih.open_access
					from siq_bibliotecainfhuerfana sbih 
					join siq_clasificacionesinfhuerfana sch1 using(idclasificacionesinfhuerfana) 
					join siq_clasificacionesinfhuerfana sch2 on sch1.idpadreclasificacionesinfhuerfana=sch2.idclasificacionesinfhuerfana
					where sbih.periodicidad=".$periodo." and sch2.aliasclasificacionesinfhuerfana='".$row2['aliasclasificacionesinfhuerfana']."'";
				$exec= $db->Execute($query);
				while($row = $exec->FetchRow()) {
?>
					<tr id="contentColumns" class="row">
						<td class="column borderR"><?=$row['clasificacionesinfhuerfana']?></td>
						<td class="column borderR" align="center"><?=$row['suscripcion']?></td>
						<td class="column borderR" align="center"><?=$row['open_access']?></td>
					</tr>
<?
					$sum_suscripcion+=$row['suscripcion'];
					$sum_open_access+=$row['open_access'];
				} 
?>
				<tr>
					<th class="borderR">Total</th>
					<th class="borderR"><?=$sum_suscripcion?></th>
					<th class="borderR"><?=$sum_open_access?></th>
				</tr>
<?
				$sum_tot_suscripcion+=$sum_suscripcion;
				$sum_tot_open_access+=$sum_open_access;
			}
?>
			<tr id="contentColumns" class="row">
				<td colspan='3'>&nbsp;</td>
			</tr>
			<tr class="dataColumns category">
				<th class="borderR" style='font-size:25px'>GRAN TOTAL</th>
				<th class="borderR" style='font-size:25px'><?=$sum_tot_suscripcion?></th>
				<th class="borderR" style='font-size:25px'><?=$sum_tot_open_access?></th>
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
		<legend>Bases de datos disponibles por área temática</legend>
		<label for="periodo" class="grid-2-12">Periodo: <span class="mandatory">(*)</span></label>
<?		
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
				url: 'formularios/recursosFisicos/viewBibliotecaBasesDeDatosDispxAreaTematica.php',
				async: false,
				data: $('#form<?=$_REQUEST['alias']?>').serialize(),                
				success:function(data){
					$('#respuesta_form<?=$_REQUEST['alias']?>').html(data);
				},
				error: function(data,error,errorThrown){alert(error + errorThrown);}
		});            
	}
</script>
