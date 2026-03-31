<?PHP  
session_start();
require_once("../../../templates/template.php");
$db = getBD();
?>
	<fieldset>  
		<table class="previewReport" style="text-align:left;clear:both;margin: 10px 0px;">
			<thead>
				<tr id="dataColumns">
					<th>Facultad</th>               
					<th>Suscripción</th>
					<th>Open Access</th>
				</tr>
			</thead>
			<tbody>
<?PHP 
			$query="select tipodbxareatematica,suscripcion,openaccess from siq_dbdisponiblexareatematica join siq_tiposdbxareatematica using(idtipodbxareatematica) where anio=".$_REQUEST['anio'];
			$exec= $db->Execute($query);
			while($row = $exec->FetchRow()) {
?>
				<tr id="contentColumns" class="row">
					<td class="column"><?PHP echo $row['tipodbxareatematica']?></td>
					<td class="column" align="center"><?PHP echo $row['suscripcion']?></td>
					<td class="column" align="center"><?PHP echo $row['openaccess']?></td>
				</tr>
<?PHP                       } ?>
			</tbody>
		</table>
	</fieldset>
