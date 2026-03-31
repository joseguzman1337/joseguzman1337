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
				if($row2['aliasclasificacionesinfhuerfana']=='re_rsntc_bib' || $row2['aliasclasificacionesinfhuerfana']=='le_rsntc_bib' || $row2['aliasclasificacionesinfhuerfana']=='bdxs_rsntc_bib')
					$colspan=5;
				if($row2['aliasclasificacionesinfhuerfana']=='bde_rsntc_bib' || $row2['aliasclasificacionesinfhuerfana']=='bdaa_rsntc_bib' || $row2['aliasclasificacionesinfhuerfana']=='ova_rsntc_bib' || $row2['aliasclasificacionesinfhuerfana']=='bdc_rsntc_bib')
					$colspan=3;
				if($row2['aliasclasificacionesinfhuerfana']=='gr_rsntc_bib') 
					$colspan=2;
?>
				<tr class="dataColumns category">
					<th colspan="<?PHP echo $colspan?>" class="borderR"><?PHP echo $periodo?> - <?PHP echo $row2['clasificacionesinfhuerfana']?></th>               
				</tr>
				<tr class="dataColumns">
					<th class="borderR">Descripción</th>
<?PHP
					if($row2['aliasclasificacionesinfhuerfana']=='re_rsntc_bib' || $row2['aliasclasificacionesinfhuerfana']=='le_rsntc_bib' || $row2['aliasclasificacionesinfhuerfana']=='bdxs_rsntc_bib') {
?>  
						<th class="borderR">No. Títulos Revista Imp.</th>
						<th class="borderR">No. Títulos Revista Elec.</th>
						<th class="borderR">No. Títulos Libros</th>
						<th class="borderR">Número de consultas</th>
<?PHP
					}
					if($row2['aliasclasificacionesinfhuerfana']=='bde_rsntc_bib' || $row2['aliasclasificacionesinfhuerfana']=='bdaa_rsntc_bib' || $row2['aliasclasificacionesinfhuerfana']=='ova_rsntc_bib') {
?>  
						<th class="borderR">Material especial</th>
						<th class="borderR">Número de consultas</th>
<?PHP
					}
					if($row2['aliasclasificacionesinfhuerfana']=='bdc_rsntc_bib') {
?>  
						<th class="borderR">Revistas indexadas</th>
						<th class="borderR">Número de consultas</th>
<?PHP
					}
					if($row2['aliasclasificacionesinfhuerfana']=='gr_rsntc_bib') {
?>  
						<th class="borderR">No. de cuentas creadas</th>
<?PHP
					}
?>  
				</tr>
<?PHP
				$sum_nro_titulos_revista_imp=0;
				$sum_nro_titulos_revista_elec=0;
				$sum_nro_titulos_libros=0;
				$sum_nro_consultas=0;
				$sum_material_especial=0;
				$sum_revistas_indexadas=0;
				$sum_nro_ctas_creadas=0;
				$query="select	 sch1.clasificacionesinfhuerfana
						,sbih.nro_titulos_revista_imp
						,sbih.nro_titulos_revista_elec
						,sbih.nro_titulos_libros
						,sbih.nro_consultas
						,sbih.material_especial
						,sbih.revistas_indexadas
						,sbih.nro_ctas_creadas
					from siq_bibliotecainfhuerfana sbih 
					join siq_clasificacionesinfhuerfana sch1 using(idclasificacionesinfhuerfana) 
					join siq_clasificacionesinfhuerfana sch2 on sch1.idpadreclasificacionesinfhuerfana=sch2.idclasificacionesinfhuerfana
					where sbih.periodicidad=".$periodo." and sch2.aliasclasificacionesinfhuerfana='".$row2['aliasclasificacionesinfhuerfana']."'";
				$exec= $db->Execute($query);
				while($row = $exec->FetchRow()) {
?>
					<tr id="contentColumns" class="row">
						<td class="column borderR"><?PHP echo $row['clasificacionesinfhuerfana']?></td>
<?PHP
						if($row2['aliasclasificacionesinfhuerfana']=='re_rsntc_bib' || $row2['aliasclasificacionesinfhuerfana']=='le_rsntc_bib' || $row2['aliasclasificacionesinfhuerfana']=='bdxs_rsntc_bib') {
?>  
							<td class="column borderR" align="center"><?PHP echo $row['nro_titulos_revista_imp']?></td>
							<td class="column borderR" align="center"><?PHP echo $row['nro_titulos_revista_elec']?></td>
							<td class="column borderR" align="center"><?PHP echo $row['nro_titulos_libros']?></td>
							<td class="column borderR" align="center"><?PHP echo $row['nro_consultas']?></td>
<?PHP
						}
						if($row2['aliasclasificacionesinfhuerfana']=='bde_rsntc_bib' || $row2['aliasclasificacionesinfhuerfana']=='bdaa_rsntc_bib' || $row2['aliasclasificacionesinfhuerfana']=='ova_rsntc_bib') {
?>  
							<td class="column borderR" align="center"><?PHP echo $row['material_especial']?></td>
							<td class="column borderR" align="center"><?PHP echo $row['nro_consultas']?></td>
<?PHP
						}
						if($row2['aliasclasificacionesinfhuerfana']=='bdc_rsntc_bib') {
?>  
							<td class="column borderR" align="center"><?PHP echo $row['revistas_indexadas']?></td>
							<td class="column borderR" align="center"><?PHP echo $row['nro_consultas']?></td>
<?PHP
						}
						if($row2['aliasclasificacionesinfhuerfana']=='gr_rsntc_bib') {
?>  
							<td class="column borderR" align="center"><?PHP echo $row['nro_ctas_creadas']?></td>
<?PHP
						}
?>  
					</tr>
<?PHP
					$sum_nro_titulos_revista_imp+=$row['nro_titulos_revista_imp'];
					$sum_nro_titulos_revista_elec+=$row['nro_titulos_revista_elec'];
					$sum_nro_titulos_libros+=$row['nro_titulos_libros'];
					$sum_nro_consultas+=$row['nro_consultas'];
					$sum_material_especial+=$row['material_especial'];
					$sum_revistas_indexadas+=$row['revistas_indexadas'];
					$sum_nro_ctas_creadas+=$row['nro_ctas_creadas'];
				} 
?>
				<tr>
					<th class="borderR">Total <?PHP echo $row2['clasificacionesinfhuerfana']?></th>
<?PHP
					if($row2['aliasclasificacionesinfhuerfana']=='re_rsntc_bib' || $row2['aliasclasificacionesinfhuerfana']=='le_rsntc_bib' || $row2['aliasclasificacionesinfhuerfana']=='bdxs_rsntc_bib') {
?>  
						<th class="borderR"><?PHP echo $sum_nro_titulos_revista_imp?></th>
						<th class="borderR"><?PHP echo $sum_nro_titulos_revista_elec?></th>
						<th class="borderR"><?PHP echo $sum_nro_titulos_libros?></th>
						<th class="borderR"><?PHP echo $sum_nro_consultas?></th>
<?PHP
					}
					if($row2['aliasclasificacionesinfhuerfana']=='bde_rsntc_bib' || $row2['aliasclasificacionesinfhuerfana']=='bdaa_rsntc_bib' || $row2['aliasclasificacionesinfhuerfana']=='ova_rsntc_bib') {
?>  
						<th class="borderR"><?PHP echo $sum_material_especial?></th>
						<th class="borderR"><?PHP echo $sum_nro_consultas?></th>
<?PHP
					}
					if($row2['aliasclasificacionesinfhuerfana']=='bdc_rsntc_bib') {
?>  
						<th class="borderR"><?PHP echo $sum_revistas_indexadas?></th>
						<th class="borderR"><?PHP echo $sum_nro_consultas?></th>
<?PHP
					}
					if($row2['aliasclasificacionesinfhuerfana']=='gr_rsntc_bib') {
?>  
						<th class="borderR"><?PHP echo $sum_nro_ctas_creadas?></th>
<?PHP
					}
?>  
				</tr>
<?PHP
			}
?>
		</table>
<?PHP
	}
	exit;
}
?>
<form action="" method="post" id="form<?PHP echo $_REQUEST['alias']?>">
	<span class="mandatory">* Son campos obligatorios</span>
	<fieldset>  
		<legend>Recursos suscritos – Número de títulos y consultas</legend>
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
				url: '<?PHP echo $rutaInc?>formularios/recursosFisicos/viewBibliotecaRecursosSuscritos.php',
				async: false,
				data: $('#form<?PHP echo $_REQUEST['alias']?>').serialize(),                
				success:function(data){
					$('#respuesta_form<?PHP echo $_REQUEST['alias']?>').html(data);
				},
				error: function(data,error,errorThrown){alert(error + errorThrown);}
		});            
	}
</script>
