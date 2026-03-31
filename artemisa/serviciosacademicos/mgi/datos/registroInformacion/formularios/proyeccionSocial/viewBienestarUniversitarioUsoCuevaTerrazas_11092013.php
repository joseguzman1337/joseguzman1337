<? 
session_start();
require_once("../../../templates/template.php");
$db = getBD();
$utils = new Utils_datos();
if($_REQUEST['semestre']) {
	$query="select sbu.id
		from siq_bienestaruniversitario sbu 
		join siq_clasificacionesinfhuerfana sch1 using(idclasificacionesinfhuerfana) 
		join siq_clasificacionesinfhuerfana sch2 on sch1.idpadreclasificacionesinfhuerfana=sch2.idclasificacionesinfhuerfana
		join siq_clasificacionesinfhuerfana sch3 on sch2.idpadreclasificacionesinfhuerfana=sch3.idclasificacionesinfhuerfana
		where sbu.semestre=".$_REQUEST['semestre']." and sch3.aliasclasificacionesinfhuerfana='".$_REQUEST['alias']."'";

	$exec= $db->Execute($query);
	if($exec->RecordCount()==0) {
?>
		<div id="msg-success" class="msg-success msg-error" ><p>No existe información almacenada para el semestre <?=$_REQUEST['semestre']?></p></div>

<?
	} else {
?>
                <table align="center" class="formData last" width="92%">
<?
			$sum_tot_lunes=0;
			$sum_tot_martes=0;
			$sum_tot_miercoles=0;
			$sum_tot_jueves=0;
			$sum_tot_viernes=0;
			$sum_tot_sabado=0;
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
					<th colspan="7" class="borderR"><?=$_REQUEST['semestre']?> - <?=$row2['clasificacionesinfhuerfana']?></th>               
				</tr>
				<tr class="dataColumns">
					<th class="borderR">Día</th>               
					<th class="borderR">Lunes</th>               
					<th class="borderR">Martes</th>               
					<th class="borderR">Miercoles</th>               
					<th class="borderR">Jueves</th>
					<th class="borderR">Viernes</th>
					<th class="borderR">Sabado</th>
				</tr>
<?
				$sum_lunes=0;
				$sum_martes=0;
				$sum_miercoles=0;
				$sum_jueves=0;
				$sum_viernes=0;
				$sum_sabado=0;
				$query="select	 sch1.clasificacionesinfhuerfana
						,sbu.lunes
						,sbu.martes
						,sbu.miercoles
						,sbu.jueves
						,sbu.viernes
						,sbu.sabado
					from siq_bienestaruniversitario sbu 
					join siq_clasificacionesinfhuerfana sch1 using(idclasificacionesinfhuerfana) 
					join siq_clasificacionesinfhuerfana sch2 on sch1.idpadreclasificacionesinfhuerfana=sch2.idclasificacionesinfhuerfana
					where sbu.semestre=".$_REQUEST['semestre']." and sch2.aliasclasificacionesinfhuerfana='".$row2['aliasclasificacionesinfhuerfana']."'";
				$exec= $db->Execute($query);
				while($row = $exec->FetchRow()) {
?>
					<tr id="contentColumns" class="row">
						<td class="column borderR"><?=$row['clasificacionesinfhuerfana']?></td>
						<td class="column borderR" align="center"><?=$row['lunes']?></td>
						<td class="column borderR" align="center"><?=$row['martes']?></td>
						<td class="column borderR" align="center"><?=$row['miercoles']?></td>
						<td class="column borderR" align="center"><?=$row['jueves']?></td>
						<td class="column borderR" align="center"><?=$row['viernes']?></td>
						<td class="column borderR" align="center"><?=$row['sabado']?></td>
					</tr>
<?
					$sum_lunes+=$row['lunes'];
					$sum_martes+=$row['martes'];
					$sum_miercoles+=$row['miercoles'];
					$sum_jueves+=$row['jueves'];
					$sum_viernes+=$row['viernes'];
					$sum_sabado+=$row['sabado'];
				} 
?>
				<tr>
					<th class="borderR">Total</th>
					<th class="borderR"><?=$sum_lunes?></th>
					<th class="borderR"><?=$sum_martes?></th>
					<th class="borderR"><?=$sum_miercoles?></th>
					<th class="borderR"><?=$sum_jueves?></th>
					<th class="borderR"><?=$sum_viernes?></th>
					<th class="borderR"><?=$sum_sabado?></th>
				</tr>
<?
				$sum_tot_lunes+=$sum_lunes;
				$sum_tot_martes+=$sum_martes;
				$sum_tot_miercoles+=$sum_miercoles;
				$sum_tot_jueves+=$sum_jueves;
				$sum_tot_viernes+=$sum_viernes;
				$sum_tot_sabado+=$sum_sabado;
			}
?>
			<tr id="contentColumns" class="row">
				<td colspan='7'>&nbsp;</td>
			</tr>
			<tr class="dataColumns category">
				<th class="borderR" style='font-size:25px'>GRAN TOTAL</th>
				<th class="borderR" style='font-size:25px'><?=$sum_tot_lunes?></th>
				<th class="borderR" style='font-size:25px'><?=$sum_tot_martes?></th>
				<th class="borderR" style='font-size:25px'><?=$sum_tot_miercoles?></th>
				<th class="borderR" style='font-size:25px'><?=$sum_tot_jueves?></th>
				<th class="borderR" style='font-size:25px'><?=$sum_tot_viernes?></th>
				<th class="borderR" style='font-size:25px'><?=$sum_tot_sabado?></th>
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
		<legend>Estadísticas uso de la cueva y las terrazas</legend>
		<label for="semestre" class="grid-2-12">Semestre: <span class="mandatory">(*)</span></label>
                <?php $utils->getSemestresSelect($db,"semestre"); ?>
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
				url: 'formularios/proyeccionSocial/viewBienestarUniversitarioUsoCuevaTerrazas.php',
				async: false,
				data: $('#form<?=$_REQUEST['alias']?>').serialize(),                
				success:function(data){
					$('#respuesta_form<?=$_REQUEST['alias']?>').html(data);
				},
				error: function(data,error,errorThrown){alert(error + errorThrown);}
		});            
	}
</script>
