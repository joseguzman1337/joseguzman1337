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
		<div id="msg-success" class="msg-success msg-error" ><p>No existe información almacenada para el periodo <?PHP echo $periodo?></p></div>

<?PHP
	} else {
?>
                <table align="center" class="formData last" width="92%">
<?PHP
			$sum_tot_obtencion_articulos=0;
			$sum_tot_buzon_sugerencias=0;
			$sum_tot_renovacion_linea=0;
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
					<th colspan="4" class="borderR"><?PHP echo $periodo?></th>               
				</tr>
				<tr class="dataColumns">
					<th class="borderR">Servicios digitales</th>               
					<th class="borderR">Obtención de artículos</th>               
					<th class="borderR">Buzón de sugerencias</th>               
					<th class="borderR">Renovación en línea</th>               
				</tr>
<?PHP
				$sum_obtencion_articulos=0;
				$sum_buzon_sugerencias=0;
				$sum_renovacion_linea=0;
				$query="select	 sch1.clasificacionesinfhuerfana
						,sbih.obtencion_articulos
						,sbih.buzon_sugerencias
						,sbih.renovacion_linea
					from siq_bibliotecainfhuerfana sbih 
					join siq_clasificacionesinfhuerfana sch1 using(idclasificacionesinfhuerfana) 
					join siq_clasificacionesinfhuerfana sch2 on sch1.idpadreclasificacionesinfhuerfana=sch2.idclasificacionesinfhuerfana
					where sbih.periodicidad=".$periodo." and sch2.aliasclasificacionesinfhuerfana='".$row2['aliasclasificacionesinfhuerfana']."'";
				$exec= $db->Execute($query);
				while($row = $exec->FetchRow()) {
?>
					<tr id="contentColumns" class="row">
						<td class="column borderR"><?PHP echo $row['clasificacionesinfhuerfana']?></td>
						<td class="column borderR" align="center"><?PHP echo $row['obtencion_articulos']?></td>
						<td class="column borderR" align="center"><?PHP echo $row['buzon_sugerencias']?></td>
						<td class="column borderR" align="center"><?PHP echo $row['renovacion_linea']?></td>
					</tr>
<?PHP
					$sum_obtencion_articulos+=$row['obtencion_articulos'];
					$sum_buzon_sugerencias+=$row['buzon_sugerencias'];
					$sum_renovacion_linea+=$row['renovacion_linea'];
				} 
?>
				<tr>
					<th class="borderR">Total</th>
					<th class="borderR"><?PHP echo $sum_obtencion_articulos?></th>
					<th class="borderR"><?PHP echo $sum_buzon_sugerencias?></th>
					<th class="borderR"><?PHP echo $sum_renovacion_linea?></th>
				</tr>
<?PHP
				$sum_tot_obtencion_articulos+=$sum_obtencion_articulos;
				$sum_tot_buzon_sugerencias+=$sum_buzon_sugerencias;
				$sum_tot_renovacion_linea+=$sum_renovacion_linea;
			}
?>
			<tr id="contentColumns" class="row">
				<td colspan='4'>&nbsp;</td>
			</tr>
			<tr class="dataColumns category">
				<th class="borderR" style='font-size:25px'>GRAN TOTAL</th>
				<th class="borderR" style='font-size:25px'><?PHP echo $sum_tot_obtencion_articulos?></th>
				<th class="borderR" style='font-size:25px'><?PHP echo $sum_tot_buzon_sugerencias?></th>
				<th class="borderR" style='font-size:25px'><?PHP echo $sum_tot_renovacion_linea?></th>
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
		<legend>Servicios de Digitales</legend>
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
				url: '<?PHP echo $rutaInc?>formularios/recursosFisicos/viewBibliotecaServiciosDigitales.php',
				async: false,
				data: $('#form<?PHP echo $_REQUEST['alias']?>').serialize(),                
				success:function(data){
					$('#respuesta_form<?PHP echo $_REQUEST['alias']?>').html(data);
				},
				error: function(data,error,errorThrown){alert(error + errorThrown);}
		});            
	}
</script>
