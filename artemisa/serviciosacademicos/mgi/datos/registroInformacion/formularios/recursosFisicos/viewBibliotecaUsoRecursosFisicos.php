<?PHP 
if($_SESSION){
   
}else{
    session_start();
}

$rutaInc = "./";
if(isset($UrlView)){
$rutaInc = "../registroInformacion/";
}
//var_dump (is_file('../../templates/template.php'));die;
if($UrlView==1 || $UrlView=='1'){
   // require_once("../../templates/template.php");
}else{
    require_once("../../../templates/template.php");   
    $db = getBD();
    $utils = new Utils_datos(); 
}
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
		<div id="msg-success" class="msg-success msg-error" ><p>No existe información almacenada para el periodo <?PHP  echo $periodo?></p></div>

<?PHP 
	} else {
?>
                <table align="center" class="formData last" width="92%">
<?PHP 
			$sum_tot_cant_usuarios_ing_biblioteca=0;
			$sum_tot_prestamo_equipos=0;
			$sum_tot_prestamo_libros=0;
			$sum_tot_prestamo_revistas=0;
			$sum_tot_prestamo_trabajos_grado=0;
			$sum_tot_prestamo_material_especial=0;
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
					<th colspan="7" class="borderR"><?PHP echo $periodo?></th>               
				</tr>
				<tr class="dataColumns">
					<th class="borderR">Perfiles / Transacción</th>               
					<th class="borderR">Cantidad de usuarios que ingresaron a la biblioteca</th>               
					<th class="borderR">Préstamos de equipos</th>               
					<th class="borderR">Préstamos de libros</th>               
					<th class="borderR">Préstamos de revistas</th>               
					<th class="borderR">Préstamos de trabajo de grado</th>               
					<th class="borderR">Préstamos de material especial</th>               
				</tr>
<?PHP 
				$sum_cant_usuarios_ing_biblioteca=0;
				$sum_prestamo_equipos=0;
				$sum_prestamo_libros=0;
				$sum_prestamo_revistas=0;
				$sum_prestamo_trabajos_grado=0;
				$sum_prestamo_material_especial=0;
				$query="select	 sch1.clasificacionesinfhuerfana
						,sbih.cant_usuarios_ing_biblioteca
						,sbih.prestamo_equipos
						,sbih.prestamo_libros
						,sbih.prestamo_revistas
						,sbih.prestamo_trabajos_grado
						,sbih.prestamo_material_especial
					from siq_bibliotecainfhuerfana sbih 
					join siq_clasificacionesinfhuerfana sch1 using(idclasificacionesinfhuerfana) 
					join siq_clasificacionesinfhuerfana sch2 on sch1.idpadreclasificacionesinfhuerfana=sch2.idclasificacionesinfhuerfana
					where sbih.periodicidad=".$periodo." and sch2.aliasclasificacionesinfhuerfana='".$row2['aliasclasificacionesinfhuerfana']."'";
				$exec= $db->Execute($query);
				while($row = $exec->FetchRow()) {
?>
					<tr id="contentColumns" class="row">
						<td class="column borderR"><?PHP echo $row['clasificacionesinfhuerfana']?></td>
						<td class="column borderR" align="center"><?PHP  echo $row['cant_usuarios_ing_biblioteca']?></td>
						<td class="column borderR" align="center"><?PHP echo $row['prestamo_equipos']?></td>
						<td class="column borderR" align="center"><?PHP  echo $row['prestamo_libros']?></td>
						<td class="column borderR" align="center"><?PHP echo $row['prestamo_revistas']?></td>
						<td class="column borderR" align="center"><?PHP echo $row['prestamo_trabajos_grado']?></td>
						<td class="column borderR" align="center"><?PHP echo $row['prestamo_material_especial']?></td>
					</tr>
<?PHP 
					$sum_cant_usuarios_ing_biblioteca+=$row['cant_usuarios_ing_biblioteca'];
					$sum_prestamo_equipos+=$row['prestamo_equipos'];
					$sum_prestamo_libros+=$row['prestamo_libros'];
					$sum_prestamo_revistas+=$row['prestamo_revistas'];
					$sum_prestamo_trabajos_grado+=$row['prestamo_trabajos_grado'];
					$sum_prestamo_material_especial+=$row['prestamo_material_especial'];
				} 
?>
				<tr>
					<th class="borderR">Total</th>
					<th class="borderR"><?PHP echo $sum_cant_usuarios_ing_biblioteca?></th>
					<th class="borderR"><?PHP echo $sum_prestamo_equipos?></th>
					<th class="borderR"><?PHP echo $sum_prestamo_libros?></th>
					<th class="borderR"><?PHP echo $sum_prestamo_revistas?></th>
					<th class="borderR"><?PHP echo $sum_prestamo_trabajos_grado?></th>
					<th class="borderR"><?PHP echo $sum_prestamo_material_especial?></th>
				</tr>
<?PHP 
				$sum_tot_cant_usuarios_ing_biblioteca+=$sum_cant_usuarios_ing_biblioteca;
				$sum_tot_prestamo_equipos+=$sum_prestamo_equipos;
				$sum_tot_prestamo_libros+=$sum_prestamo_libros;
				$sum_tot_prestamo_revistas+=$sum_prestamo_revistas;
				$sum_tot_prestamo_trabajos_grado+=$sum_prestamo_trabajos_grado;
				$sum_tot_prestamo_material_especial+=$sum_prestamo_material_especial;
			}
?>
			<tr id="contentColumns" class="row">
				<td colspan='7'>&nbsp;</td>
			</tr>
			<tr class="dataColumns category">
				<th class="borderR" style='font-size:25px'>GRAN TOTAL</th>
				<th class="borderR" style='font-size:25px'><?PHP echo $sum_tot_cant_usuarios_ing_biblioteca?></th>
				<th class="borderR" style='font-size:25px'><?PHP echo $sum_tot_prestamo_equipos?></th>
				<th class="borderR" style='font-size:25px'><?PHP echo $sum_tot_prestamo_libros?></th>
				<th class="borderR" style='font-size:25px'><?PHP echo $sum_tot_prestamo_revistas?></th>
				<th class="borderR" style='font-size:25px'><?PHP echo $sum_tot_prestamo_trabajos_grado?></th>
				<th class="borderR" style='font-size:25px'><?PHP echo $sum_tot_prestamo_material_especial?></th>
			</tr>
		</table>
<?PHP 
	}
	exit;
}
?>
<form action="" method="post" id="form<?PHP echo $_REQUEST['alias']?>">
	<span class="mandatory">* Son campos obligatorios</span>
	<fieldset>  
		<legend>Uso de los recursos físicos</legend>
		<label for="periodo" class="grid-2-12">Periodo: <span class="mandatory">(*)</span></label>
<?PHP 		
		$utils->getMonthsSelect("mes"); 
		$utils->getYearsSelect("anio"); 
?>
		<input type="hidden" name="alias" value="<?PHP echo $_REQUEST['alias']?>" />
		<div class="tooltip" title="Consultar volúmenes y títulos de colecciones">
		<input type="submit" value="Consultar" class="first small" />
		</div>
		<div id='respuesta_form<?PHP echo $_REQUEST['alias']?>'></div>
	</fieldset>
</form>
<script type="text/javascript">
	$(':submit').click(function(event) {
		event.preventDefault();
		var valido= validateForm("#form<?PHP echo $_REQUEST['alias']?>");
		if(valido){
			sendForm();
		}
	});
	function sendForm(){
		$.ajax({
				type: 'GET',
				url: '<?PHP echo $rutaInc?>formularios/recursosFisicos/viewBibliotecaUsoRecursosFisicos.php',
				async: false,
				data: $('#form<?PHP echo $_REQUEST['alias']?>').serialize(),                
				success:function(data){
					$('#respuesta_form<?PHP echo $_REQUEST['alias']?>').html(data);
				},
				error: function(data,error,errorThrown){alert(error + errorThrown);}
		});            
	}
</script>
