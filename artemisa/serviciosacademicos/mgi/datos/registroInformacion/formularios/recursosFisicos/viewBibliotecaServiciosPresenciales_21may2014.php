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
			$sum_tot_consulta_sala=0;
			$sum_tot_prestamo_externo=0;
			$sum_tot_prestamo_interbibliotecario=0;
			$sum_tot_cartas_presentacion=0;
			$sum_tot_prestamo_equipos=0;
			$sum_tot_prestamo_salas_estudio=0;
			$sum_tot_formacion_usuarios=0;
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
					<th colspan="8" class="borderR"><?=$periodo?></th>               
				</tr>
				<tr class="dataColumns">
					<th class="borderR">Perfiles / Servicios presenciales</th>               
					<th class="borderR">Consulta en sala</th>               
					<th class="borderR">Préstamo externo</th>               
					<th class="borderR">Préstamo interbibliotecario</th>               
					<th class="borderR">Cartas de presentación</th>               
					<th class="borderR">Préstamo de equipos</th>               
					<th class="borderR">Préstamo de salas de estudio</th>              
					<th class="borderR">Formación a usuarios</th>              
				</tr>
<?
				$sum_consulta_sala=0;
				$sum_prestamo_externo=0;
				$sum_prestamo_interbibliotecario=0;
				$sum_cartas_presentacion=0;
				$sum_prestamo_equipos=0;
				$sum_prestamo_salas_estudio=0;
				$sum_formacion_usuarios=0;
				$query="select	 sch1.clasificacionesinfhuerfana
						,sbih.consulta_sala
						,sbih.prestamo_externo
						,sbih.prestamo_interbibliotecario
						,sbih.cartas_presentacion
						,sbih.prestamo_equipos
						,sbih.prestamo_salas_estudio
						,sbih.formacion_usuarios
					from siq_bibliotecainfhuerfana sbih 
					join siq_clasificacionesinfhuerfana sch1 using(idclasificacionesinfhuerfana) 
					join siq_clasificacionesinfhuerfana sch2 on sch1.idpadreclasificacionesinfhuerfana=sch2.idclasificacionesinfhuerfana
					where sbih.periodicidad=".$periodo." and sch2.aliasclasificacionesinfhuerfana='".$row2['aliasclasificacionesinfhuerfana']."'";
				$exec= $db->Execute($query);
				while($row = $exec->FetchRow()) {
?>
					<tr id="contentColumns" class="row">
						<td class="column borderR"><?=$row['clasificacionesinfhuerfana']?></td>
						<td class="column borderR" align="center"><?=$row['consulta_sala']?></td>
						<td class="column borderR" align="center"><?=$row['prestamo_externo']?></td>
						<td class="column borderR" align="center"><?=$row['prestamo_interbibliotecario']?></td>
						<td class="column borderR" align="center"><?=$row['cartas_presentacion']?></td>
						<td class="column borderR" align="center"><?=$row['prestamo_equipos']?></td>
						<td class="column borderR" align="center"><?=$row['prestamo_salas_estudio']?></td>
						<td class="column borderR" align="center"><?=$row['formacion_usuarios']?></td>
					</tr>
<?
					$sum_consulta_sala+=$row['consulta_sala'];
					$sum_prestamo_externo+=$row['prestamo_externo'];
					$sum_prestamo_interbibliotecario+=$row['prestamo_interbibliotecario'];
					$sum_cartas_presentacion+=$row['cartas_presentacion'];
					$sum_prestamo_equipos+=$row['prestamo_equipos'];
					$sum_prestamo_salas_estudio+=$row['prestamo_salas_estudio'];
					$sum_formacion_usuarios+=$row['formacion_usuarios'];
				} 
?>
				<tr>
					<th class="borderR">Total</th>
					<th class="borderR"><?=$sum_consulta_sala?></th>
					<th class="borderR"><?=$sum_prestamo_externo?></th>
					<th class="borderR"><?=$sum_prestamo_interbibliotecario?></th>
					<th class="borderR"><?=$sum_cartas_presentacion?></th>
					<th class="borderR"><?=$sum_prestamo_equipos?></th>
					<th class="borderR"><?=$sum_prestamo_salas_estudio?></th>
					<th class="borderR"><?=$sum_formacion_usuarios?></th>
				</tr>
<?
				$sum_tot_consulta_sala+=$sum_consulta_sala;
				$sum_tot_prestamo_externo+=$sum_prestamo_externo;
				$sum_tot_prestamo_interbibliotecario+=$sum_prestamo_interbibliotecario;
				$sum_tot_cartas_presentacion+=$sum_cartas_presentacion;
				$sum_tot_prestamo_equipos+=$sum_prestamo_equipos;
				$sum_tot_prestamo_salas_estudio+=$sum_prestamo_salas_estudio;
				$sum_tot_formacion_usuarios+=$sum_formacion_usuarios;
			}
?>
			<tr id="contentColumns" class="row">
				<td colspan='8'>&nbsp;</td>
			</tr>
			<tr class="dataColumns category">
				<th class="borderR" style='font-size:25px'>GRAN TOTAL</th>
				<th class="borderR" style='font-size:25px'><?=$sum_tot_consulta_sala?></th>
				<th class="borderR" style='font-size:25px'><?=$sum_tot_prestamo_externo?></th>
				<th class="borderR" style='font-size:25px'><?=$sum_tot_prestamo_interbibliotecario?></th>
				<th class="borderR" style='font-size:25px'><?=$sum_tot_cartas_presentacion?></th>
				<th class="borderR" style='font-size:25px'><?=$sum_tot_prestamo_equipos?></th>
				<th class="borderR" style='font-size:25px'><?=$sum_tot_prestamo_salas_estudio?></th>
				<th class="borderR" style='font-size:25px'><?=$sum_tot_formacion_usuarios?></th>
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
		<legend>Servicios presenciales</legend>
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
				url: 'formularios/recursosFisicos/viewBibliotecaServiciosPresenciales.php',
				async: false,
				data: $('#form<?=$_REQUEST['alias']?>').serialize(),                
				success:function(data){
					$('#respuesta_form<?=$_REQUEST['alias']?>').html(data);
				},
				error: function(data,error,errorThrown){alert(error + errorThrown);}
		});            
	}
</script>
