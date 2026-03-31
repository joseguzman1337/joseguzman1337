<?php

session_start();
require_once("../../../templates/template.php");
$db = getBD();
$utils = new Utils_datos();

if(($_POST['anio'])&&($_POST['mes'])) {
	$query_continuada_un="select *	
		from continuadaacademicameses
		
		where anio=".$_POST['anio']." and mes=".$_POST['mes']."";
	$exec_consulta_un= $db->Execute($query_continuada_un);
	$query_continuada_un="select *
			from continuadaacademicameses
			where anio	=".$_POST['anio']."and mes=".$_POST['mes']."";
	$exec_continuada_un= $db->Execute($exec_continuada_un);
	
	if($exec_consulta_un->RecordCount()==0) {
?>
<div id="msg-success" class="msg-success msg-error" ><p>No existe información para la fecha  <?=$_REQUEST['anio']?> <?=$_REQUEST['mes']?></p></div>
<?
	} else {


			

?>

<div id='respuesta_form1_un'></div>
                
			 <table align="center" class="formData last" width="95%" >
	                    <thead>            
		                      <tr class="dataColumns">
	                            <th class="column" colspan="9"><span>Programas de Educación Continuada por Unidad Académica</span></th>                                    
	                        </tr>
	                        <tr class="dataColumns category">
	                            <th class="column borderR center" rowspan="2" width="1%" ><span>Programa</span></th>
	                            <th class="column borderR center" colspan="3" width="1%" ><span>Número de Cursos</span>
	                    		<th class="column borderR center" colspan="5" width="1%"><span>Modalidad</span></th>
	                    	</tr>
	                    	<tr >
	                   			<th class="column borderR center" width="1%" >Cursos</th>
	                    		<th class="column borderR center " width="1%" >Diplomados</th>
	                    		<th class="column borderR center" width="1%" >Eventos de <br/> Actualización</th>
	                    		<th class="column borderR center"  width="1%">ABI</th>
	                    		<th class="column borderR center" width="1%">CER</th>	
	                    		<th class="column borderR center"width="1%" >PRE</th>
	                    		<th class="column borderR center"width="1%">VIR</th>
	                    		<th class="column borderR center"width="1%">SEMI</th>
	                    	</tr>
	                    	 
                    </thead> 
                    	
                    <tbody>              	 
                        <?php 
                     	
                     				$query_sectores = "SELECT codigocarrera,nombrecarrera,codigomodalidadacademicasic 
    													FROM carrera 
    													WHERE codigomodalidadacademicasic = '200' and fechavencimientocarrera > '2013-05-29'";
			                       	$sectores= $db->Execute($query_sectores);
			                     	$totalRows_sectores = $sectores->RecordCount();
					      			$i=0;
					      			
					      			$query_consulta_un="select cant_curso,cant_diplomado,cant_evento,num_abierto,num_cerrado,num_pres,num_vir,num_sem
											from educacionacademica where anio=".$_POST['anio']." and mes=".$_POST['mes']."";
					      			$consulta_un=$db->Execute($query_consulta_un);
					      			
				      			while($row_sectores=$sectores->FetchRow()){
									$row_consulta_un=$consulta_un->FetchRow();
								?> 
								<tr id="contentColumns" class="row">
								
										<td class="column borderR" ><?php echo $row_sectores['nombrecarrera']; ?>:<span class="mandatory">(*)</span>
                                         <input type="hidden" name="tipo_programa[] "value="<?php echo $row_sectores['codigocarrera']; ?>"/></td>
										
										<td class="column borderR" ><?php echo $row_consulta_un['cant_curso']; ?></td>
										<td class="column borderR" ><?php echo $row_consulta_un['cant_diplomado']; ?></td>
										<td class="column borderR" ><?php echo $row_consulta_un['cant_evento']; ?></td>
										<td class="column borderR" ><?php echo $row_consulta_un['num_abierto']; ?></td>
										<td class="column borderR" ><?php echo $row_consulta_un['num_cerrado']; ?></td>
										<td class="column borderR" ><?php echo $row_consulta_un['num_pres']; ?></td>
										<td class="column borderR" ><?php echo $row_consulta_un['num_vir']; ?></td>
										<td class="column borderR" ><?php echo $row_consulta_un['num_sem']; ?></td>
								
								</tr>
					    <?PHP  }/*while($row_sectores=$sectores->FetchRow())*/?>
                    </tbody>    
                </table>
<?
	}
	exit;


}

?>
<form action="" method="post" id="form1_un">
	<span class="mandatory">* Son campos obligatorios</span>
	<fieldset>  
		<legend>Programas de Educación Continuada por Unidad Académica</legend>
		
		<label for="anio" class="grid-2-12">Año: <span class="mandatory">(*)</span></label>
		<?php $utils->getYearsSelect("anio"); ?>
		
		<label for="mes" class="grid-2-12">Mes: <span class="mandatory">(*)</span></label>
		<?php $utils->getMonthsSelect("mes");  ?>	
	
	<input type="submit" value="Consultar" class="first small" />	
		<div id='respuesta_form1_un'></div>
	</fieldset>
</form>
<script type="text/javascript">
	$(':submit').click(function(event) {
		event.preventDefault();
		var valido= validateForm("#form1_un");
		if(valido){
			sendForm_un();
		}
	});
	function sendForm_un(){
		$.ajax({
				type: 'POST',
				url: './formularios/academicos/viewContiUnidad.php',
				async: false,
				data: $('#form1_un').serialize(),                
				success:function(data){					
					$('#respuesta_form1_un').html(data);					
				},
				error: function(data,error,errorThrown){alert(error + errorThrown);}
		});            
	}
</script>