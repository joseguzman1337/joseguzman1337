<?PHP  
session_start();
require_once("../../../templates/template.php");
$db = getBD();
?>
	<fieldset>  
		<table class="previewReport" style="text-align:left;clear:both;margin: 10px 0px;">
			<thead>
				<tr id="dataColumns">
					<th>Origen</th>               
					<th>Cantidad</th>
				</tr>
			</thead>
			<tbody>
<?PHP 
			$query="select origenconveniosserviciosinformacionbiblioteca,cantidad  from siq_conveniosserviciosinformacionbiblioteca join siq_origenconveniosserviciosinformacionbiblioteca using(idorigenconveniosserviciosinformacionbiblioteca) where semestre=".$_REQUEST['semestre'];
			$exec= $db->Execute($query);
			while($row = $exec->FetchRow()) {
?>
				<tr id="contentColumns" class="row">
					<td class="column"><?PHP echo $row['origenconveniosserviciosinformacionbiblioteca']?></td>
					<td class="column" align="center"><?PHP echo $row['cantidad']?></td>
				</tr>
<?PHP                       } ?>
			</tbody>
		</table>
	</fieldset>
