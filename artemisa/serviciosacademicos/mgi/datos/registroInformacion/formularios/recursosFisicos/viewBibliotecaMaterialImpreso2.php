<?PHP  
session_start();
require_once("../../../templates/template.php");
$db = getBD();
?>
	<fieldset>  
		<table class="previewReport" style="text-align:left;clear:both;margin: 10px 0px;">
			<thead>
				<tr id="dataColumns">
					<th>Material</th>               
					<th>Volúmenes</th>
					<th>Titulos</th>
				</tr>
			</thead>
			<tbody>
<?PHP 
			$query="select tipomaterialimpreso,volumenes,titulos from siq_volumenesytitulosmaterialimpreso join siq_tiposmaterialimpreso using(idtipomaterialimpreso) where anio=".$_REQUEST['anio'];
			$exec= $db->Execute($query);
			while($row = $exec->FetchRow()) {
?>
				<tr id="contentColumns" class="row">
					<td class="column"><?PHP echo $row['tipomaterialimpreso']?></td>
					<td class="column" align="center"><?PHP echo $row['volumenes']?></td>
					<td class="column" align="center"><?PHP echo $row['titulos']?></td>
				</tr>
<?PHP                       } ?>
			</tbody>
		</table>
	</fieldset>
