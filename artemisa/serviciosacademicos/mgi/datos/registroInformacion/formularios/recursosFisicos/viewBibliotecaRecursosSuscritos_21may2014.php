<? 
session_start();
require_once("../../../templates/template.php");
$db = getBD();
$utils = new Utils_datos();
if($_REQUEST['mes']) {
	$periodo=$_REQUEST['mes'];
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
				if($row2['aliasclasificacionesinfhuerfana']=='bdtc_rsntc_bib')
					$colspan=2;
				else 
					$colspan=4;
?>
				<tr class="dataColumns category">
					<th colspan="<?=$colspan?>" class="borderR"><?=$periodo?> - <?=$row2['clasificacionesinfhuerfana']?></th>               
				</tr>
				<tr class="dataColumns">
<?
					if($row2['aliasclasificacionesinfhuerfana']=='bdtc_rsntc_bib') {
?>  
						<th class="borderR">Base de datos</th>
						<th class="borderR">Suscripciones</th>
<?
					} else {
						if($row2['aliasclasificacionesinfhuerfana']=='bds_rsntc_bib') {
?>  
							<th class="borderR">Descripción</th>
							<th class="borderR">Número de consultas</th>
<?
						} else {
?>  
							<th class="borderR">Área / Facultad</th>
							<th class="borderR">Bases de datos suscritas</th>
<?
						}
?>  
						<th class="borderR">Títulos de libros electrónicos</th>
						<th class="borderR">Títulos de revistas electrónicas</th>
<?
					}
?>  
				</tr>
<?
				$sum_suscripciones=0;
				$sum_numero_consultas=0;
				$sum_bases_datos=0;
				$sum_titulos_libros_electronicos=0;
				$sum_titulos_revistas_electronicas=0;
				$query="select	 sch1.clasificacionesinfhuerfana
						,sbih.suscripciones
						,sbih.numero_consultas
						,sbih.bases_datos
						,sbih.titulos_libros_electronicos
						,sbih.titulos_revistas_electronicas
					from siq_bibliotecainfhuerfana sbih 
					join siq_clasificacionesinfhuerfana sch1 using(idclasificacionesinfhuerfana) 
					join siq_clasificacionesinfhuerfana sch2 on sch1.idpadreclasificacionesinfhuerfana=sch2.idclasificacionesinfhuerfana
					where sbih.periodicidad=".$periodo." and sch2.aliasclasificacionesinfhuerfana='".$row2['aliasclasificacionesinfhuerfana']."'";
				$exec= $db->Execute($query);
				while($row = $exec->FetchRow()) {
?>
					<tr id="contentColumns" class="row">
						<td class="column borderR"><?=$row['clasificacionesinfhuerfana']?></td>
<?
						if($row2['aliasclasificacionesinfhuerfana']=='bdtc_rsntc_bib') {
?>  
							<td class="column borderR" align="center"><?=$row['suscripciones']?></td>
<?
						} else {
							if($row2['aliasclasificacionesinfhuerfana']=='bds_rsntc_bib') {
?>
								<td class="column borderR" align="center"><?=$row['numero_consultas']?></td>
<?
							} else {
?>
								<td class="column borderR" align="center"><?=$row['bases_datos']?></td>
<?
							}
?>
							<td class="column borderR" align="center"><?=$row['titulos_libros_electronicos']?></td>
							<td class="column borderR" align="center"><?=$row['titulos_revistas_electronicas']?></td>
<?
						}
?>  
					</tr>
<?
					$sum_suscripciones+=$row['suscripciones'];
					$sum_numero_consultas+=$row['numero_consultas'];
					$sum_bases_datos+=$row['bases_datos'];
					$sum_titulos_libros_electronicos+=$row['titulos_libros_electronicos'];
					$sum_titulos_revistas_electronicas+=$row['titulos_revistas_electronicas'];
				} 
?>
				<tr>
					<th class="borderR">Total <?=$row2['clasificacionesinfhuerfana']?></th>
<?
					if($row2['aliasclasificacionesinfhuerfana']=='bdtc_rsntc_bib') {
?>  
						<th class="borderR"><?=$sum_suscripciones?></th>
<?
					} else {
						if($row2['aliasclasificacionesinfhuerfana']=='bds_rsntc_bib') {
?>
							<th class="borderR"><?=$sum_numero_consultas?></th>
<?
						} else {
?>
							<th class="borderR"><?=$sum_bases_datos?></th>
<?
						}
?>
						<th class="borderR"><?=$sum_titulos_libros_electronicos?></th>
						<th class="borderR"><?=$sum_titulos_revistas_electronicas?></th>
<?
					}
?>  
				</tr>
<?
			}
?>
		</table>
<?
	}
	exit;
}
?>
<form action="" method="post" id="form<?=$_REQUEST['alias']?>">
	<span class="mandatory">* Son campos obligatorios</span>
	<fieldset>  
		<legend>Recursos suscritos – Número de títulos y consultas</legend>
                <label for="semestre" class="grid-2-12">Semestre: <span class="mandatory">(*)</span></label>
<?		
		$utils->getSemestresSelect($db,"mes");
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
				url: 'formularios/recursosFisicos/viewBibliotecaRecursosSuscritos.php',
				async: false,
				data: $('#form<?=$_REQUEST['alias']?>').serialize(),                
				success:function(data){
					$('#respuesta_form<?=$_REQUEST['alias']?>').html(data);
				},
				error: function(data,error,errorThrown){alert(error + errorThrown);}
		});            
	}
</script>
