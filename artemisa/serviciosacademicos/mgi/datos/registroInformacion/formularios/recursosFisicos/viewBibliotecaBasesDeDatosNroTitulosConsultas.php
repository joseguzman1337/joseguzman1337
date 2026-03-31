<?PHP  
session_start();
require_once("../../../templates/template.php");
$db = getBD();
$utils = new Utils_datos();
if($_REQUEST['semestre']) {
	$query="select id from siq_dbnrotitulosyconsultas where semestre=".$_REQUEST['semestre'];
	$exec= $db->Execute($query);
	if($exec->RecordCount()==0) {
?>
                <div id="msg-success" class="msg-success msg-error" ><p>No existe información almacenada para el periodo <?PHP echo $_REQUEST['semestre']?></p></div>
<?PHP 
	} else {
?>
		<table align="center" class="formData last" width="92%">
			<tr id="dataColumns">
				<th colspan="5" style="font-size:20px"><?PHP echo $_REQUEST['semestre']?></th>
			</tr>
<?PHP 
			$query="select idclasificacionesinfhuerfana
					,clasificacionesinfhuerfana
					,aliasclasificacionesinfhuerfana
					,conteo
				from siq_clasificacionesinfhuerfana ch 
				join (	select idpadreclasificacionesinfhuerfana
						,count(*)+1 as conteo 
					from siq_clasificacionesinfhuerfana
					group by idpadreclasificacionesinfhuerfana
				) sub on ch.idclasificacionesinfhuerfana=sub.idpadreclasificacionesinfhuerfana
				where aliasclasificacionesinfhuerfana in ('ryle','bdde','ovda','rdr')";
			$exec= $db->Execute($query);
			while($row = $exec->FetchRow()) {
?>
				<tr id="dataColumns">
<?PHP 
					if($row['aliasclasificacionesinfhuerfana']=='ryle') {
?>
						<th>Tipo de material</th>               
						<th>Base de datos por suscripción</th>
						<th>Nro. títulos revistas</th>
						<th>Nro. títulos libros</th>
						<th>Nro. consultas</th>
<?PHP 				
					}
					if($row['aliasclasificacionesinfhuerfana']=='bdde') {
?>					
						<th>Tipo de material</th>               
						<th>Base de datos espacializadas</th>
						<th colspan="2">Contenido</th>
						<th>Nro. consultas</th>
<?PHP 				
					}
					if($row['aliasclasificacionesinfhuerfana']=='ovda') {
?>					
						<th>Tipo de material</th>               
						<th>Objetivos virtuales de aprendizaje</th>
						<th colspan="2">Contenido</th>
						<th>Nro. consultas</th>
<?PHP 				
					}
					if($row['aliasclasificacionesinfhuerfana']=='rdr') {
?>					
						<th>Tipo de material</th>               
						<th>Recursos de referenciación</th>
						<th colspan="3">Creación de nuevas cuentas</th>
<?PHP 				
					}
?>
				</tr>
				<tr id="contentColumns" class="row">
					<td class="column borderR" rowspan="<?PHP echo $row['conteo']?>"><?PHP echo $row['clasificacionesinfhuerfana']?></td>
				</tr>
<?PHP 
				$query2="select clasificacionesinfhuerfana
						,revistas
						,libros
						,consultas
						,contenido
						,cuentas 
					from siq_dbnrotitulosyconsultas 
					join siq_clasificacionesinfhuerfana using(idclasificacionesinfhuerfana) 
					where semestre=".$_REQUEST['semestre']."
						and idpadreclasificacionesinfhuerfana=".$row['idclasificacionesinfhuerfana'];
				$exec2= $db->Execute($query2);
				$sum_revistas=0;
				$sum_libros=0;
				$sum_consultas=0;
				$sum_contenido=0;
				$sum_cuentas=0;
				while($row2 = $exec2->FetchRow()) {
?>
					<tr id="contentColumns" class="row">
						<td class="column"><?PHP echo $row2['clasificacionesinfhuerfana']?></td>
<?PHP 
						if($row['aliasclasificacionesinfhuerfana']=='ryle') {
?>
							<td class="column" align="center"><?PHP echo $row2['revistas']?></td>
							<td class="column" align="center"><?PHP echo $row2['libros']?></td>
							<td class="column" align="center"><?PHP echo $row2['consultas']?></td>
<?PHP 
						}
						if($row['aliasclasificacionesinfhuerfana']=='bdde' || $row['aliasclasificacionesinfhuerfana']=='ovda') {
?>
							<td class="column" align="center" colspan="2"><?PHP echo $row2['contenido']?></td>
							<td class="column" align="center"><?PHP echo $row2['consultas']?></td>
<?PHP 	
						}
						if($row['aliasclasificacionesinfhuerfana']=='rdr') {
?>
							<td class="column" align="center" colspan="3"><?PHP echo $row2['cuentas']?></td>
<?PHP 		
						}
?>
					</tr>
<?PHP 	
					$sum_revistas+=$row2['revistas'];	
					$sum_libros+=$row2['libros'];	
					$sum_consultas+=$row2['consultas'];	
					$sum_contenido+=$row2['contenido'];	
					$sum_cuentas+=$row2['cuentas'];	
				} 
?>
				<tr id="dataColumns">
<?PHP 
					if($row['aliasclasificacionesinfhuerfana']=='ryle') {
?>
						<th colspan="2">Total</th>               
						<th><?PHP echo $sum_revistas?></th>
						<th><?PHP echo $sum_libros?></th>
						<th><?PHP echo $sum_consultas?></th>
<?PHP 				
					}
					if($row['aliasclasificacionesinfhuerfana']=='bdde') {
?>					
						<th colspan="2">Total</th>               
						<th colspan="2"><?PHP echo $sum_contenido?></th>
						<th><?PHP echo $sum_consultas?></th>
<?PHP 				
					}
					if($row['aliasclasificacionesinfhuerfana']=='ovda') {
?>					
						<th colspan="2">Total</th>               
						<th colspan="2"><?PHP echo $sum_contenido?></th>
						<th><?PHP echo $sum_consultas?></th>
<?PHP 				
					}
					if($row['aliasclasificacionesinfhuerfana']=='rdr') {
?>					
						<th colspan="2">Total</th>               
						<th colspan="3"><?PHP echo $sum_cuentas?></th>
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
<form action="" method="post" id="form2">
	<span class="mandatory">* Son campos obligatorios</span>
	<fieldset>  
		<legend>Bases de datos – Número de títulos y consultas</legend>
		<label for="semestre" class="grid-2-12">Semestre: <span class="mandatory">(*)</span></label>
		<?php $utils->getSemestresSelect($db,"semestre"); ?>
		<input type="submit" value="Consultar" class="first small" />
		<div id='respuesta_form2'></div>
	</fieldset>
</form>
<script type="text/javascript">
	$(':submit').click(function(event) {
		event.preventDefault();
		var valido= validateForm("#form2");
		if(valido){
			sendForm();
		}
	});
	function sendForm(){
		$.ajax({
			type: 'GET',
			url: 'formularios/recursosFisicos/viewBibliotecaBasesDeDatosNroTitulosConsultas.php',
			async: false,
			data: $('#form2').serialize(),                
			success:function(data){
				$('#respuesta_form2').html(data);
			},
			error: function(data,error,errorThrown){alert(error + errorThrown);}
		});            
	}
</script>
