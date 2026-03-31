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
			$sum_tot_induccion_biblioteca=0;
			$sum_tot_busqueda_informacion=0;
			$sum_tot_seminario_taller=0;
			$sum_tot_referenciacion=0;
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
					<th colspan="5" class="borderR"><?PHP echo $periodo?></th>               
				</tr>
				<tr class="dataColumns">
					<th class="borderR">Módulos de formación</th>               
					<th class="borderR">Inducción Biblioteca</th>               
					<th class="borderR">Búsqueda de información</th>               
					<th class="borderR">Seminario Taller</th>               
					<th class="borderR">Referenciación</th>               
				</tr>
<?PHP
				$sum_induccion_biblioteca=0;
				$sum_busqueda_informacion=0;
				$sum_seminario_taller=0;
				$sum_referenciacion=0;
				$query="select	 sch1.clasificacionesinfhuerfana
						,sbih.induccion_biblioteca
						,sbih.busqueda_informacion
						,sbih.seminario_taller
						,sbih.referenciacion
					from siq_bibliotecainfhuerfana sbih 
					join siq_clasificacionesinfhuerfana sch1 using(idclasificacionesinfhuerfana) 
					join siq_clasificacionesinfhuerfana sch2 on sch1.idpadreclasificacionesinfhuerfana=sch2.idclasificacionesinfhuerfana
					where sbih.periodicidad=".$periodo." and sch2.aliasclasificacionesinfhuerfana='".$row2['aliasclasificacionesinfhuerfana']."'";
				$exec= $db->Execute($query);
				while($row = $exec->FetchRow()) {
?>
					<tr id="contentColumns" class="row">
						<td class="column borderR"><?PHP echo $row['clasificacionesinfhuerfana']?></td>
						<td class="column borderR" align="center"><?PHP echo $row['induccion_biblioteca']?></td>
						<td class="column borderR" align="center"><?PHP echo $row['busqueda_informacion']?></td>
						<td class="column borderR" align="center"><?PHP echo $row['seminario_taller']?></td>
						<td class="column borderR" align="center"><?PHP echo $row['referenciacion']?></td>
					</tr>
<?PHP
					$sum_induccion_biblioteca+=$row['induccion_biblioteca'];
					$sum_busqueda_informacion+=$row['busqueda_informacion'];
					$sum_seminario_taller+=$row['seminario_taller'];
					$sum_referenciacion+=$row['referenciacion'];
				} 
?>
				<tr>
					<th class="borderR">Total</th>
					<th class="borderR"><?PHP echo $sum_induccion_biblioteca?></th>
					<th class="borderR"><?PHP echo $sum_busqueda_informacion?></th>
					<th class="borderR"><?PHP echo $sum_seminario_taller?></th>
					<th class="borderR"><?PHP echo $sum_referenciacion?></th>
				</tr>
<?PHP
				$sum_tot_induccion_biblioteca+=$sum_induccion_biblioteca;
				$sum_tot_busqueda_informacion+=$sum_busqueda_informacion;
				$sum_tot_seminario_taller+=$sum_seminario_taller;
				$sum_tot_referenciacion+=$sum_referenciacion;
			}
?>
			<tr id="contentColumns" class="row">
				<td colspan='5'>&nbsp;</td>
			</tr>
			<tr class="dataColumns category">
				<th class="borderR" style='font-size:25px'>GRAN TOTAL</th>
				<th class="borderR" style='font-size:25px'><?PHP echo $sum_tot_induccion_biblioteca?></th>
				<th class="borderR" style='font-size:25px'><?PHP echo $sum_tot_busqueda_informacion?></th>
				<th class="borderR" style='font-size:25px'><?PHP echo $sum_tot_seminario_taller?></th>
				<th class="borderR" style='font-size:25px'><?PHP echo $sum_tot_referenciacion?></th>
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
		<legend>Servicios de formación</legend>
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
				url: '<?PHP echo $rutaInc?>formularios/recursosFisicos/viewBibliotecaServiciosFormacion.php',
				async: false,
				data: $('#form<?PHP echo $_REQUEST['alias']?>').serialize(),                
				success:function(data){
					$('#respuesta_form<?PHP echo $_REQUEST['alias']?>').html(data);
				},
				error: function(data,error,errorThrown){alert(error + errorThrown);}
		});            
	}
</script>
