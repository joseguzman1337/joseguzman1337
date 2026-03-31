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
			$sum_tot_cantidad=0;
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
					<th class="borderR">Tipo material</th>               
					<th class="borderR">Cantiadad</th>               
				</tr>
<?
				$sum_cantidad=0;
				$query="select	 sch1.clasificacionesinfhuerfana
						,sbih.cantidad
					from siq_bibliotecainfhuerfana sbih 
					join siq_clasificacionesinfhuerfana sch1 using(idclasificacionesinfhuerfana) 
					join siq_clasificacionesinfhuerfana sch2 on sch1.idpadreclasificacionesinfhuerfana=sch2.idclasificacionesinfhuerfana
					where sbih.periodicidad=".$periodo." and sch2.aliasclasificacionesinfhuerfana='".$row2['aliasclasificacionesinfhuerfana']."'";
				$exec= $db->Execute($query);
				while($row = $exec->FetchRow()) {
?>
					<tr id="contentColumns" class="row">
						<td class="column borderR"><?=$row['clasificacionesinfhuerfana']?></td>
						<td class="column borderR" align="center"><?=$row['cantidad']?></td>
					</tr>
<?
					$sum_cantidad+=$row['cantidad'];
				} 
?>
				<tr>
					<th class="borderR">Total</th>
					<th class="borderR"><?=$sum_cantidad?></th>
				</tr>
<?
				$sum_tot_cantidad+=$sum_cantidad;
			}
?>
			<tr id="contentColumns" class="row">
				<td colspan='8'>&nbsp;</td>
			</tr>
			<tr class="dataColumns category">
				<th class="borderR" style='font-size:25px'>GRAN TOTAL</th>
				<th class="borderR" style='font-size:25px'><?=$sum_tot_cantidad?></th>
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
		<legend>Convenios Suscritos para la adquisición y prestación de servicios de información de la Biblioteca</legend>
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
				url: 'formularios/recursosFisicos/viewBibliotecaConveniosServiciosInformacionBiblioteca.php',
				async: false,
				data: $('#form<?=$_REQUEST['alias']?>').serialize(),                
				success:function(data){
					$('#respuesta_form<?=$_REQUEST['alias']?>').html(data);
				},
				error: function(data,error,errorThrown){alert(error + errorThrown);}
		});            
	}
</script>
