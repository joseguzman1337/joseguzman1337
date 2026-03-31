<?php

session_start();
require_once("../../../templates/template.php");
$db = getBD();
$utils = new Utils_datos();

if(($_POST['anio'])&&($_POST['mes'])) {
	$query_continuada="select *	
		from programaEducacionContinuada
		
		where anio=".$_POST['anio']." and mes=".$_POST['mes']."";
	$exec_consulta= $db->Execute($query_continuada);
	$query_continuada="select *
			from programaEducacionContinuada
			where anio	=".$_POST['anio']."and mes=".$_POST['mes']."";
	$exec_continuada= $db->Execute($exec_continuada);
	
	if($exec_consulta->RecordCount()==0) {
?>
<div id="msg-success" class="msg-success msg-error" ><p>No existe información para la fecha  <?=$_REQUEST['anio']?> <?=$_REQUEST['mes']?></p></div>
<?
	} else {
			
			$query_papa = "select idclasificacion,clasificacion from infoEducacionContinuada where alias='ofreci'";
			$papa= $db->Execute($query_papa);
			$totalRows_papa = $papa->RecordCount();
			$row_papa = $papa->FetchRow();
?>

<div id='respuesta_form1'></div>
                
                <table align="center" class="formData last" width="92%" >
                    <thead>            
                        <tr class="dataColumns">
                            <th class="column" colspan="13"><span>Número programas y de asistentes ofertados por la División de Educación Continuada</span></th>                                    
                        </tr>
                         
                        <tr class="dataColumns category">
                            <th class="column borderR" rowspan="3" ><span>Tipos de Programas</span></th>
                    		<th class="column borderR" rowspan="3" ><span>Categoria</span></th>
                    		<th class="column borderR" colspan="6" ><span>Modalidad</span></th>
                    		<th class="column borderR" rowspan="3"><span>Número Asistentes</span></th>
                    		<th class="column borderR" colspan="5" ><span>Componente Internacional</span>
                    		</th>
                    	</tr>
                   		<tr>
                    		<th class="column borderR" colspan="1" rowspan="2" >ABI</th>
                    		<th class="column borderR " colspan="1" rowspan="2">CER</th>
                    		<th class="column borderR" colspan="1" rowspan="2">PRE</th>
                    		<th class="column borderR"colspan="1" rowspan="2">VIR</th>
                    		<th class="column borderR"colspan="1" rowspan="2">SEMI</th>
                    		<th class="column borderR " colspan="1" rowspan="2">Cantidad</th>
                    		<th class="column borderR" colspan="2" >Participantes</th>
                    		<th class="column borderR " colspan="2">Conferencistas</th>
                    		
                    		
                            </tr>
                    		<th class="column borderR" colspan="1" >Pais</th>
                    		<th class="column borderR " colspan="1">Cantidad</th>
                    		<th class="column borderR" colspan="1" >Pais</th>
                    		<th class="column borderR " colspan="1">Cantidad</th>
                    </thead> 
                    	
                    <tbody>              	 
                        <?php 
                     	$query_sectores = "select idclasificacion,clasificacion from infoEducacionContinuada where idpadreclasificacion ='".$row_papa['idclasificacion']."'";
                       	$sectores= $db->Execute($query_sectores);
                     	$totalRows_sectores = $sectores->RecordCount();
                     	$query_consulta="select categoria,num_abierto,num_cerrado,num_pres,num_vir,num_sem,numero_asistentes,cantidad_participantes,pais_participantes,
                                    	cantidad_conferencistas,pais_conferencistas from programaEducacionContinuada where anio=".$_POST['anio']." and mes=".$_POST['mes']."";
                     	$consulta=$db->Execute($query_consulta);
                     	$i=0;
		      		
		      			while($row_sectores=$sectores->FetchRow()){
							$row_consulta=$consulta->FetchRow();
								?> 
								<tr id="contentColumns" class="row">
								<td class="column borderR" ><?php echo $row_sectores['clasificacion']; ?>:<span class="mandatory">(*)</span></td>
								<td class="column borderR" ><?php echo $row_consulta['categoria']; ?></td>
								<td class="column borderR" ><?php echo $row_consulta['num_abierto']; ?></td>
								<td class="column borderR" ><?php echo $row_consulta['num_cerrado']; ?></td>
								<?php $total_modalidad=($row_consulta['num_abierto'])+($row_consulta['num_cerrado']); ?>
								<td class="column borderR" ><?php echo $row_consulta['num_pres']; ?></td>
								<td class="column borderR" ><?php echo $row_consulta['num_vir']; ?></td>
								<td class="column borderR" ><?php echo $row_consulta['num_sem']; ?></td>
								<td class="column borderR" ><?php echo $total_modalidad ?></td>
								<td class="column borderR" ><?php echo $row_consulta['numero_asistentes']; ?></td>
								<td class="column borderR" ><?php echo $row_consulta['pais_participantes']; ?></td>
								<td class="column borderR" ><?php echo $row_consulta['cantidad_participantes']; ?></td>
								<td class="column borderR" ><?php echo $row_consulta['pais_conferencistas']; ?></td>
								<td class="column borderR" ><?php echo $row_consulta['cantidad_conferencistas']; ?></td>
								</tr>
					    <?PHP  }/*while($row_sectores=$sectores->FetchRow())*/?>
                    </tbody>    
                </table>
<?
	}
	exit;


}

?>
<form action="" method="post" id="form1">
	<span class="mandatory">* Son campos obligatorios</span>
	<fieldset>  
		<legend>Programas y de asistentes ofertados por la División de Educación Continuada</legend>
		
		<label for="anio" class="grid-2-12">Año: <span class="mandatory">(*)</span></label>
		<?php $utils->getYearsSelect("anio"); ?>
		
		<label for="mes" class="grid-2-12">Mes: <span class="mandatory">(*)</span></label>
		<?php $utils->getMonthsSelect("mes");  ?>	
	
	<input type="submit" value="Consultar" class="first small" />	
		<div id='respuesta_form1'></div>
	</fieldset>
</form>
<script type="text/javascript">
	$(':submit').click(function(event) {
		event.preventDefault();
		var valido= validateForm("#form1");
		if(valido){
			sendForm_ofre();
		}
	});
	function sendForm_ofre(){
		$.ajax({
				type: 'POST',
				url: './formularios/academicos/viewEducontinuadaProgramas.php',
				async: false,
				data: $('#form1').serialize(),                
				success:function(data){					
					$('#respuesta_form1').html(data);					
				},
				error: function(data,error,errorThrown){alert(error + errorThrown);}
		});            
	}
</script>
