<?PHP  
session_start();
require_once("../../../templates/template.php");
$db = getBD();
?>
	<fieldset>  
		<legend>Bases de datos – Número de títulos y consultas</legend>
		<table class="previewReport" style="text-align:left;clear:both;margin: 10px 0px;">
<?PHP 
			$query="select idclasificacionesinfhuerfana,clasificacionesinfhuerfana,conteo from siq_clasificacionesinfhuerfana ch join (select idpadreclasificacionesinfhuerfana,count(*)+1 as conteo from siq_clasificacionesinfhuerfana group by idpadreclasificacionesinfhuerfana) sub on ch.idclasificacionesinfhuerfana=sub.idpadreclasificacionesinfhuerfana";
			$exec= $db->Execute($query);
			while($row = $exec->FetchRow()) {
				if($row['idclasificacionesinfhuerfana']==1) {
?>
					<thead>
						<tr id="dataColumns">
							<th>Tipo de material</th>               
							<th>Base de datos por suscripción</th>
							<th>Nro. títulos revistas</th>
							<th>Nro. títulos libros</th>
							<th>Nro. consultas</th>
						</tr>
					</thead>
<?PHP 				}
				if($row['idclasificacionesinfhuerfana']==19) {
?>					
					<thead>
						<tr id="dataColumns">
							<th>Tipo de material</th>                
							<th>Base de datos espacializadas</th>
							<th colspan="2">Contenido</th>
							<th>Nro. consultas</th>
						</tr>
					</thead>
<?PHP 				}
				if($row['idclasificacionesinfhuerfana']==25) {
?>					
					<thead>
						<tr id="dataColumns">
							<th>Tipo de material</th>               
							<th>Objetivos virtuales de aprendizaje</th>
							<th colspan="2">Contenido</th>
							<th>Nro. consultas</th>
						</tr>
					</thead>
<?PHP 				}
				if($row['idclasificacionesinfhuerfana']==30) {
?>					
					<thead>
						<tr id="dataColumns">
							<th>Tipo de material</th>               
							<th>Recursos de referenciación</th>
							<th colspan="3">Creación de nuevas cuentas</th>
						</tr>
					</thead>
<?PHP 				}
?>
				<tbody>
					<tr id="contentColumns" class="row">
						<td class="column" rowspan="<?PHP echo $row['conteo']?>"><?PHP echo $row['clasificacionesinfhuerfana']?></td>
					</tr>
<?PHP 
				$query2="select clasificacionesinfhuerfana,revistas,libros,consultas,contenido,cuentas from siq_dbnrotitulosyconsultas join siq_clasificacionesinfhuerfana using(idclasificacionesinfhuerfana) where semestre=".$_REQUEST['semestre']." and idpadreclasificacionesinfhuerfana=".$row['idclasificacionesinfhuerfana'];
				$exec2= $db->Execute($query2);
				while($row2 = $exec2->FetchRow()) {
?>
					<tr id="contentColumns" class="row">
						<td class="column"><?PHP echo $row2['clasificacionesinfhuerfana']?></td>
<?PHP 						if($row['idclasificacionesinfhuerfana']==1) {
?>
							<td class="column" align="center"><?PHP echo $row2['revistas']?></td>
							<td class="column" align="center"><?PHP echo $row2['libros']?></td>
							<td class="column" align="center"><?PHP echo $row2['consultas']?></td>
<?PHP 						}
						if($row['idclasificacionesinfhuerfana']==19 || $row['idclasificacionesinfhuerfana']==25) {
?>
							<td class="column" align="center" colspan="2"><?PHP echo $row2['contenido']?></td>
							<td class="column" align="center"><?PHP echo $row2['consultas']?></td>
<?PHP 						}
						if($row['idclasificacionesinfhuerfana']==30) {
?>
							<td class="column" align="center" colspan="3"><?PHP echo $row2['cuentas']?></td>
<?PHP 						}
?>
					</tr>
<?PHP 				} ?>
				</tbody>
<?PHP 			} ?>
		</table>
	</fieldset>
