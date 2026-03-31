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
			$sum_tot_ingresos_biblioteca=0;
			$sum_tot_prestamo_equipos=0;
			$sum_tot_consulta_prestamo_libros=0;
			$sum_tot_consulta_prestamo_revistas=0;
			$sum_tot_consulta_prestamo_trabajos_grado=0;
			$sum_tot_consulta_prestamo_material_especial=0;
			$sum_tot_prestamo_salas_estudio=0;
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
					<th class="borderR">Perfiles / Transacción</th>               
					<th class="borderR">Ingresos a la biblioteca</th>               
					<th class="borderR">Préstamos de equipos</th>               
					<th class="borderR">Consulta y préstamos de libros</th>               
					<th class="borderR">Consulta y préstamos de revistas</th>               
					<th class="borderR">Consulta y préstamos de trabajo de grado</th>               
					<th class="borderR">Consulta y préstamos de material especial</th>               
					<th class="borderR">Prestamos de salas de estudio</th>               
				</tr>
<?
				$sum_ingresos_biblioteca=0;
				$sum_prestamo_equipos=0;
				$sum_consulta_prestamo_libros=0;
				$sum_consulta_prestamo_revistas=0;
				$sum_consulta_prestamo_trabajos_grado=0;
				$sum_consulta_prestamo_material_especial=0;
				$sum_prestamo_salas_estudio=0;
				$query="select	 sch1.clasificacionesinfhuerfana
						,sbih.ingresos_biblioteca
						,sbih.prestamo_equipos
						,sbih.consulta_prestamo_libros
						,sbih.consulta_prestamo_revistas
						,sbih.consulta_prestamo_trabajos_grado
						,sbih.consulta_prestamo_material_especial
						,sbih.prestamo_salas_estudio
					from siq_bibliotecainfhuerfana sbih 
					join siq_clasificacionesinfhuerfana sch1 using(idclasificacionesinfhuerfana) 
					join siq_clasificacionesinfhuerfana sch2 on sch1.idpadreclasificacionesinfhuerfana=sch2.idclasificacionesinfhuerfana
					where sbih.periodicidad=".$periodo." and sch2.aliasclasificacionesinfhuerfana='".$row2['aliasclasificacionesinfhuerfana']."'";
				$exec= $db->Execute($query);
				while($row = $exec->FetchRow()) {
?>
					<tr id="contentColumns" class="row">
						<td class="column borderR"><?=$row['clasificacionesinfhuerfana']?></td>
						<td class="column borderR" align="center"><?=$row['ingresos_biblioteca']?></td>
						<td class="column borderR" align="center"><?=$row['prestamo_equipos']?></td>
						<td class="column borderR" align="center"><?=$row['consulta_prestamo_libros']?></td>
						<td class="column borderR" align="center"><?=$row['consulta_prestamo_revistas']?></td>
						<td class="column borderR" align="center"><?=$row['consulta_prestamo_trabajos_grado']?></td>
						<td class="column borderR" align="center"><?=$row['consulta_prestamo_material_especial']?></td>
						<td class="column borderR" align="center"><?=$row['prestamo_salas_estudio']?></td>
					</tr>
<?
					$sum_ingresos_biblioteca+=$row['ingresos_biblioteca'];
					$sum_prestamo_equipos+=$row['prestamo_equipos'];
					$sum_consulta_prestamo_libros+=$row['consulta_prestamo_libros'];
					$sum_consulta_prestamo_revistas+=$row['consulta_prestamo_revistas'];
					$sum_consulta_prestamo_trabajos_grado+=$row['consulta_prestamo_trabajos_grado'];
					$sum_consulta_prestamo_material_especial+=$row['consulta_prestamo_material_especial'];
					$sum_prestamo_salas_estudio+=$row['prestamo_salas_estudio'];
				} 
?>
				<tr>
					<th class="borderR">Total</th>
					<th class="borderR"><?=$sum_ingresos_biblioteca?></th>
					<th class="borderR"><?=$sum_prestamo_equipos?></th>
					<th class="borderR"><?=$sum_consulta_prestamo_libros?></th>
					<th class="borderR"><?=$sum_consulta_prestamo_revistas?></th>
					<th class="borderR"><?=$sum_consulta_prestamo_trabajos_grado?></th>
					<th class="borderR"><?=$sum_consulta_prestamo_material_especial?></th>
					<th class="borderR"><?=$sum_prestamo_salas_estudio?></th>
				</tr>
<?
				$sum_tot_ingresos_biblioteca+=$sum_ingresos_biblioteca;
				$sum_tot_prestamo_equipos+=$sum_prestamo_equipos;
				$sum_tot_consulta_prestamo_libros+=$sum_consulta_prestamo_libros;
				$sum_tot_consulta_prestamo_revistas+=$sum_consulta_prestamo_revistas;
				$sum_tot_consulta_prestamo_trabajos_grado+=$sum_consulta_prestamo_trabajos_grado;
				$sum_tot_consulta_prestamo_material_especial+=$sum_consulta_prestamo_material_especial;
				$sum_tot_prestamo_salas_estudio+=$sum_prestamo_salas_estudio;
			}
?>
			<tr id="contentColumns" class="row">
				<td colspan='8'>&nbsp;</td>
			</tr>
			<tr class="dataColumns category">
				<th class="borderR" style='font-size:25px'>GRAN TOTAL</th>
				<th class="borderR" style='font-size:25px'><?=$sum_tot_ingresos_biblioteca?></th>
				<th class="borderR" style='font-size:25px'><?=$sum_tot_prestamo_equipos?></th>
				<th class="borderR" style='font-size:25px'><?=$sum_tot_consulta_prestamo_libros?></th>
				<th class="borderR" style='font-size:25px'><?=$sum_tot_consulta_prestamo_revistas?></th>
				<th class="borderR" style='font-size:25px'><?=$sum_tot_consulta_prestamo_trabajos_grado?></th>
				<th class="borderR" style='font-size:25px'><?=$sum_tot_consulta_prestamo_material_especial?></th>
				<th class="borderR" style='font-size:25px'><?=$sum_tot_prestamo_salas_estudio?></th>
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
		<legend>Uso de los recursos físicos</legend>
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
				url: 'formularios/recursosFisicos/viewBibliotecaUsoRecursosFisicos.php',
				async: false,
				data: $('#form<?=$_REQUEST['alias']?>').serialize(),                
				success:function(data){
					$('#respuesta_form<?=$_REQUEST['alias']?>').html(data);
				},
				error: function(data,error,errorThrown){alert(error + errorThrown);}
		});            
	}
</script>
