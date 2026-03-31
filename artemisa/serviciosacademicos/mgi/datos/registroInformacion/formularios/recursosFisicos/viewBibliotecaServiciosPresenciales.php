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
			$sum_tot_prestamo_sala=0;
			$sum_tot_prestamo_externo=0;
			$sum_tot_prestamo_interbibliotecario=0;
			$sum_tot_renovaciones_presenciales=0;
			$sum_tot_sugerencias_recibidas=0;
			$sum_tot_cartas_presentacion=0;
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
					<th colspan="8" class="borderR"><?PHP  echo $periodo?></th>               
				</tr>
				<tr class="dataColumns">
					<th class="borderR">Servicios</th>               
					<th class="borderR">Préstamo en sala</th>               
					<th class="borderR">Préstamo externo</th>               
					<th class="borderR">Préstamo Interbibliotecario</th>               
					<th class="borderR">Renovaciones presenciales</th>               
					<th class="borderR">Sugerencias recibidas</th>               
					<th class="borderR">Cartas de presentación</th>              
					<th class="borderR">Formación a usuarios</th>              
				</tr>
<?PHP 
				$sum_prestamo_sala=0;
				$sum_prestamo_externo=0;
				$sum_prestamo_interbibliotecario=0;
				$sum_renovaciones_presenciales=0;
				$sum_sugerencias_recibidas=0;
				$sum_cartas_presentacion=0;
				$sum_formacion_usuarios=0;
				$query="select	 sch1.clasificacionesinfhuerfana
						,sbih.prestamo_sala
						,sbih.prestamo_externo
						,sbih.prestamo_interbibliotecario
						,sbih.renovaciones_presenciales
						,sbih.sugerencias_recibidas
						,sbih.cartas_presentacion
						,sbih.formacion_usuarios
					from siq_bibliotecainfhuerfana sbih 
					join siq_clasificacionesinfhuerfana sch1 using(idclasificacionesinfhuerfana) 
					join siq_clasificacionesinfhuerfana sch2 on sch1.idpadreclasificacionesinfhuerfana=sch2.idclasificacionesinfhuerfana
					where sbih.periodicidad=".$periodo." and sch2.aliasclasificacionesinfhuerfana='".$row2['aliasclasificacionesinfhuerfana']."'";
				$exec= $db->Execute($query);
				while($row = $exec->FetchRow()) {
?>
					<tr id="contentColumns" class="row">
						<td class="column borderR"><?PHP  echo $row['clasificacionesinfhuerfana']?></td>
						<td class="column borderR" align="center"><?PHP  echo $row['prestamo_sala']?></td>
						<td class="column borderR" align="center"><?PHP  echo $row['prestamo_externo']?></td>
						<td class="column borderR" align="center"><?PHP  echo $row['prestamo_interbibliotecario']?></td>
						<td class="column borderR" align="center"><?PHP  echo $row['renovaciones_presenciales']?></td>
						<td class="column borderR" align="center"><?PHP  echo $row['sugerencias_recibidas']?></td>
						<td class="column borderR" align="center"><?PHP  echo $row['cartas_presentacion']?></td>
						<td class="column borderR" align="center"><?PHP  echo $row['formacion_usuarios']?></td>
					</tr>
<?PHP 
					$sum_prestamo_sala+=$row['prestamo_sala'];
					$sum_prestamo_externo+=$row['prestamo_externo'];
					$sum_prestamo_interbibliotecario+=$row['prestamo_interbibliotecario'];
					$sum_renovaciones_presenciales+=$row['renovaciones_presenciales'];
					$sum_sugerencias_recibidas+=$row['sugerencias_recibidas'];
					$sum_cartas_presentacion+=$row['cartas_presentacion'];
					$sum_formacion_usuarios+=$row['formacion_usuarios'];
				} 
?>
				<tr>
					<th class="borderR">Total</th>
					<th class="borderR"><?PHP  echo $sum_prestamo_sala?></th>
					<th class="borderR"><?PHP  echo $sum_prestamo_externo?></th>
					<th class="borderR"><?PHP  echo $sum_prestamo_interbibliotecario?></th>
					<th class="borderR"><?PHP  echo $sum_renovaciones_presenciales?></th>
					<th class="borderR"><?PHP  echo $sum_sugerencias_recibidas?></th>
					<th class="borderR"><?PHP  echo $sum_cartas_presentacion?></th>
					<th class="borderR"><?PHP  echo $sum_formacion_usuarios?></th>
				</tr>
<?PHP 
				$sum_tot_prestamo_sala+=$sum_prestamo_sala;
				$sum_tot_prestamo_externo+=$sum_prestamo_externo;
				$sum_tot_prestamo_interbibliotecario+=$sum_prestamo_interbibliotecario;
				$sum_tot_renovaciones_presenciales+=$sum_renovaciones_presenciales;
				$sum_tot_sugerencias_recibidas+=$sum_sugerencias_recibidas;
				$sum_tot_cartas_presentacion+=$sum_cartas_presentacion;
				$sum_tot_formacion_usuarios+=$sum_formacion_usuarios;
			}
?>
			<tr id="contentColumns" class="row">
				<td colspan='8'>&nbsp;</td>
			</tr>
			<tr class="dataColumns category">
				<th class="borderR" style='font-size:25px'>GRAN TOTAL</th>
				<th class="borderR" style='font-size:25px'><?PHP  echo $sum_tot_prestamo_sala?></th>
				<th class="borderR" style='font-size:25px'><?PHP  echo $sum_tot_prestamo_externo?></th>
				<th class="borderR" style='font-size:25px'><?PHP  echo $sum_tot_prestamo_interbibliotecario?></th>
				<th class="borderR" style='font-size:25px'><?PHP  echo $sum_tot_renovaciones_presenciales?></th>
				<th class="borderR" style='font-size:25px'><?PHP  echo $sum_tot_sugerencias_recibidas?></th>
				<th class="borderR" style='font-size:25px'><?PHP  echo $sum_tot_cartas_presentacion?></th>
				<th class="borderR" style='font-size:25px'><?PHP  echo $sum_tot_formacion_usuarios?></th>
			</tr>
		</table>
<?PHP 
	}
	exit;
}
?>
<form action="" method="post" id="form<?PHP  echo $_REQUEST['alias']?>">
	<span class="mandatory">* Son campos obligatorios</span>
	<fieldset>  
		<legend>Servicios presenciales</legend>
		<label for="periodo" class="grid-2-12">Periodo: <span class="mandatory">(*)</span></label>
<?PHP 		
		$utils->getMonthsSelect("mes"); 
		$utils->getYearsSelect("anio"); 
?>
		<input type="hidden" name="alias" value="<?PHP  echo $_REQUEST['alias']?>" />
		<div class="tooltip" title="Consultar volúmenes y títulos de colecciones">
		<input type="submit" value="Consultar" class="first small" />
	</div>
		<div id='respuesta_form<?PHP  echo $_REQUEST['alias']?>'></div>
	</fieldset>
</form>
<script type="text/javascript">
	$(':submit').click(function(event) {
		event.preventDefault();
		var valido= validateForm("#form<?PHP  echo $_REQUEST['alias']?>");
		if(valido){
			sendForm();
		}
	});
	function sendForm(){
		$.ajax({
				type: 'GET',
				url: '<?PHP echo $rutaInc?>formularios/recursosFisicos/viewBibliotecaServiciosPresenciales.php',
				async: false,
				data: $('#form<?PHP  echo $_REQUEST['alias']?>').serialize(),                
				success:function(data){
					$('#respuesta_form<?PHP  echo $_REQUEST['alias']?>').html(data);
				},
				error: function(data,error,errorThrown){alert(error + errorThrown);}
		});            
	}
</script>
