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
			$sum_tot_preguntele_bibliotecologo=0;
			$sum_tot_seguidores_facebook=0;
			$sum_tot_canal_youtube=0;
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
					<th colspan="5" class="borderR"><?PHP echo $periodo?></th>               
				</tr>
				<tr class="dataColumns">
					<th class="borderR">Servicios</th>
					<th class="borderR">Pregúntele al bibliotecólogo</th>
					<th class="borderR">Seguidores en Facebook</th>
					<th class="borderR">Canal Youtube</th>
					<th class="borderR">Seguidores en Twitter</th>
				</tr>
<?PHP
				$sum_preguntele_bibliotecologo=0;
				$sum_seguidores_facebook=0;
				$sum_canal_youtube=0;
				$sum_seguidores_twitter=0;
				$query="select	 sch1.clasificacionesinfhuerfana
						,sbih.preguntele_bibliotecologo
						,sbih.seguidores_facebook
						,sbih.canal_youtube
						,sbih.seguidores_twitter
					from siq_bibliotecainfhuerfana sbih 
					join siq_clasificacionesinfhuerfana sch1 using(idclasificacionesinfhuerfana) 
					join siq_clasificacionesinfhuerfana sch2 on sch1.idpadreclasificacionesinfhuerfana=sch2.idclasificacionesinfhuerfana
					where sbih.periodicidad=".$periodo." and sch2.aliasclasificacionesinfhuerfana='".$row2['aliasclasificacionesinfhuerfana']."'";
				$exec= $db->Execute($query);
				while($row = $exec->FetchRow()) {
?>
					<tr id="contentColumns" class="row">
						<td class="column borderR"><?PHP echo $row['clasificacionesinfhuerfana']?></td>
						<td class="column borderR" align="center"><?PHP echo $row['preguntele_bibliotecologo']?></td>
						<td class="column borderR" align="center"><?PHP echo $row['seguidores_facebook']?></td>
						<td class="column borderR" align="center"><?PHP echo $row['canal_youtube']?></td>
						<td class="column borderR" align="center"><?PHP echo $row['seguidores_twitter']?></td>
					</tr>
<?PHP
					$sum_preguntele_bibliotecologo+=$row['preguntele_bibliotecologo'];
					$sum_seguidores_facebook+=$row['seguidores_facebook'];
					$sum_canal_youtube+=$row['canal_youtube'];
					$sum_seguidores_twitter+=$row['seguidores_twitter'];
				} 
?>
				<tr>
					<th class="borderR">Total</th>
					<th class="borderR"><?PHP echo $sum_preguntele_bibliotecologo?></th>
					<th class="borderR"><?PHP echo $sum_seguidores_facebook?></th>
					<th class="borderR"><?PHP echo $sum_canal_youtube?></th>
					<th class="borderR"><?PHP echo $sum_seguidores_twitter?></th>
				</tr>
<?PHP
				$sum_tot_preguntele_bibliotecologo+=$sum_preguntele_bibliotecologo;
				$sum_tot_seguidores_facebook+=$sum_seguidores_facebook;
				$sum_tot_canal_youtube+=$sum_canal_youtube;
				$sum_tot_seguidores_twitter+=$sum_seguidores_twitter;
			}
?>
			<tr id="contentColumns" class="row">
				<td colspan='5'>&nbsp;</td>
			</tr>
			<tr class="dataColumns category">
				<th class="borderR" style='font-size:25px'>GRAN TOTAL</th>
				<th class="borderR" style='font-size:25px'><?PHP echo $sum_tot_preguntele_bibliotecologo?></th>
				<th class="borderR" style='font-size:25px'><?PHP echo $sum_tot_seguidores_facebook?></th>
				<th class="borderR" style='font-size:25px'><?PHP echo $sum_tot_canal_youtube?></th>
				<th class="borderR" style='font-size:25px'><?PHP echo $sum_tot_seguidores_twitter?></th>
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
		<legend>Servicios WEB 2.0</legend>
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
				url: '<?PHP echo $rutaInc?>formularios/recursosFisicos/viewBibliotecaServiciosWeb.php',
				async: false,
				data: $('#form<?PHP echo $_REQUEST['alias']?>').serialize(),                
				success:function(data){
					$('#respuesta_form<?PHP echo $_REQUEST['alias']?>').html(data);
				},
				error: function(data,error,errorThrown){alert(error + errorThrown);}
		});            
	}
</script>
