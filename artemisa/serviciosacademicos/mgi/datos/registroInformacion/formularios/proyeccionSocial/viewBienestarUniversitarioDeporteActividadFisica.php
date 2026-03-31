<?php 
session_start();
require_once("../../../templates/template.php");
require_once("./functionsBienestar.php"); 
$db = getBD();
$utils = new Utils_datos();
if($_REQUEST['semestre']) {
	$query="select sbu.id
		from siq_bienestaruniversitario sbu 
		join siq_clasificacionesinfhuerfana sch1 using(idclasificacionesinfhuerfana) 
		join siq_clasificacionesinfhuerfana sch2 on sch1.idpadreclasificacionesinfhuerfana=sch2.idclasificacionesinfhuerfana
		join siq_clasificacionesinfhuerfana sch3 on sch2.idpadreclasificacionesinfhuerfana=sch3.idclasificacionesinfhuerfana
		where sbu.semestre=".$_REQUEST['semestre']." and sch3.aliasclasificacionesinfhuerfana='".$_REQUEST['alias']."'";

	$exec= $db->Execute($query);
	if($exec->RecordCount()==0) {
?>
		<div id="msg-success" class="msg-success msg-error" ><p>No existe información almacenada para el periodo <?php echo $_REQUEST['semestre']?></p></div>

<?php
	} else {
?>
                <table align="center" class="formData last" width="92%">
<?php
			$sum_tot_pregrado=0;
			$sum_tot_posgrado=0;
			$sum_tot_egresados=0;
			$sum_tot_docentes=0;
			$sum_tot_administrativos=0;
			$sum_tot_familiares=0;
			$sum_tot_encuentros_presentacion_oficiales=0;
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
					<th colspan="8" class="borderR"><?php echo $_REQUEST['semestre']?> - <?php echo $row2['clasificacionesinfhuerfana']?></th>               
				</tr>
				<tr class="dataColumns">
					<th rowspan="2" class="borderR">Servicio o actividad</th>               
					<th colspan="3" class="borderR">Estudiantes</th>               
					<th rowspan="2" class="borderR">Docentes</th>               
					<th rowspan="2" class="borderR">Administrativos</th>
					<th rowspan="2" class="borderR">Familiares</th>
					<th rowspan="2" class="borderR">Nro. de encuentros o presentaciones oficiales</th>
				</tr>
				<tr class="dataColumns ">
					<th class="borderR">Pregado</th>               
					<th class="borderR">Posgrado</th>
					<th class="borderR">Egresados</th>
				</tr>
		
<?php
				$sum_pregrado=0;
				$sum_posgrado=0;
				$sum_egresados=0;
				$sum_docentes=0;
				$sum_administrativos=0;
				$sum_familiares=0;
				$sum_encuentros_presentacion_oficiales=0;
				$query="select	 sch1.clasificacionesinfhuerfana
						,sbu.pregrado
						,sbu.posgrado
						,sbu.egresados
						,sbu.docentes
						,sbu.administrativos
						,sbu.familiares
						,sbu.encuentros_presentacion_oficiales
					from siq_bienestaruniversitario sbu 
					join siq_clasificacionesinfhuerfana sch1 using(idclasificacionesinfhuerfana) 
					join siq_clasificacionesinfhuerfana sch2 on sch1.idpadreclasificacionesinfhuerfana=sch2.idclasificacionesinfhuerfana
					where sbu.semestre=".$_REQUEST['semestre']." and sch2.aliasclasificacionesinfhuerfana='".$row2['aliasclasificacionesinfhuerfana']."' 
                                            and sbu.codigoestado=100";
				$exec= $db->Execute($query);
				while($row = $exec->FetchRow()) {
?>
					<tr id="contentColumns" class="row">
						<td class="column borderR"><?php echo $row['clasificacionesinfhuerfana']?></td>
						<td class="column borderR" align="center"><?php echo $row['pregrado']?></td>
						<td class="column borderR" align="center"><?php echo $row['posgrado']?></td>
						<td class="column borderR" align="center"><?php echo $row['egresados']?></td>
						<td class="column borderR" align="center"><?php echo $row['docentes']?></td>
						<td class="column borderR" align="center"><?php echo $row['administrativos']?></td>
						<td class="column borderR" align="center"><?php echo $row['familiares']?></td>
						<td class="column borderR" align="center"><?php echo $row['encuentros_presentacion_oficiales']?></td>
					</tr>
<?php
					$sum_pregrado+=$row['pregrado'];
					$sum_posgrado+=$row['posgrado'];
					$sum_egresados+=$row['egresados'];
					$sum_docentes+=$row['docentes'];
					$sum_administrativos+=$row['administrativos'];
					$sum_familiares+=$row['familiares'];
					$sum_encuentros_presentacion_oficiales+=$row['encuentros_presentacion_oficiales'];
				} 
?>
				<tr>
					<th class="borderR">Total</th>
					<th class="borderR"><?php echo $sum_pregrado?></th>
					<th class="borderR"><?php echo $sum_posgrado?></th>
					<th class="borderR"><?php echo $sum_egresados?></th>
					<th class="borderR"><?php echo $sum_docentes?></th>
					<th class="borderR"><?php echo $sum_administrativos?></th>
					<th class="borderR"><?php echo $sum_familiares?></th>
					<th class="borderR"><?php echo $sum_encuentros_presentacion_oficiales?></th>
				</tr>
<?php
				$sum_tot_pregrado+=$sum_pregrado;
				$sum_tot_posgrado+=$sum_posgrado;
				$sum_tot_egresados+=$sum_egresados;
				$sum_tot_docentes+=$sum_docentes;
				$sum_tot_administrativos+=$sum_administrativos;
				$sum_tot_familiares+=$sum_familiares;
				$sum_tot_encuentros_presentacion_oficiales+=$sum_encuentros_presentacion_oficiales;
			}
?>
			<tr id="contentColumns" class="row">
				<td colspan='8'>&nbsp;</td>
			</tr>
			<tr class="dataColumns category">
				<th class="borderR" style='font-size:25px'>GRAN TOTAL</th>
				<th class="borderR" style='font-size:25px'><?php echo $sum_tot_pregrado?></th>
				<th class="borderR" style='font-size:25px'><?php echo $sum_tot_posgrado?></th>
				<th class="borderR" style='font-size:25px'><?php echo $sum_tot_egresados?></th>
				<th class="borderR" style='font-size:25px'><?php echo $sum_tot_docentes?></th>
				<th class="borderR" style='font-size:25px'><?php echo $sum_tot_administrativos?></th>
				<th class="borderR" style='font-size:25px'><?php echo $sum_tot_familiares?></th>
				<th class="borderR" style='font-size:25px'><?php echo $sum_tot_encuentros_presentacion_oficiales?></th>
			</tr>
		</table>
<?php
	}
	exit;
}
?>
<form action="" method="post" id="form<?php echo $_REQUEST['alias']?>">
	<span class="mandatory">* Son campos obligatorios</span>
	<fieldset>  
		<legend>Estadísticas área de deportes y actividad física</legend>
		<label class="fixedLabel">Mes: <span class="mandatory">(*)</span></label>
                <?php $utils->getMonthsSelect(); ?>
                
                <label class="fixedLabel" style="clear:none;width:90px">Año: <span class="mandatory">(*)</span></label>
                <?php $utils->getYearsSelect("anio"); ?>
            <input type="hidden" name="semestre" value="" id="semestre" />             
                
		<!--<label for="semestre" class="grid-2-12">Semestre: <span class="mandatory">(*)</span></label>-->
		<?php //$utils->getSemestresSelect($db,"semestre"); ?>
		<input type="hidden" name="alias" value="<?php echo $_REQUEST['alias']?>" />
		<input type="submit" value="Consultar" class="first small" />
		<div id='respuesta_form<?php echo $_REQUEST['alias']?>'></div>
	</fieldset>
</form>
<script type="text/javascript">
	$('#form<?php echo $_REQUEST['alias']?> :submit').click(function(event) {
		event.preventDefault();
		var valido= validateForm("#form<?php echo $_REQUEST['alias']?>");
		if(valido){
			sendForm1();
		}
	});
	function sendForm1(){
            var periodo = $('#form<?php echo $_REQUEST['alias']?> #mes').val()+$('#form<?php echo $_REQUEST['alias']?> #anio').val();
                $('#form<?php echo $_REQUEST['alias']?> #semestre').val(periodo);
		$.ajax({
				type: 'GET',
				url: 'formularios/proyeccionSocial/viewBienestarUniversitarioDeporteActividadFisica.php',
				async: false,
				data: $('#form<?php echo $_REQUEST['alias']?>').serialize(),                
				success:function(data){
					$('#respuesta_form<?php echo $_REQUEST['alias']?>').html(data);
				},
				error: function(data,error,errorThrown){alert(error + errorThrown);}
		});            
	}
</script>
