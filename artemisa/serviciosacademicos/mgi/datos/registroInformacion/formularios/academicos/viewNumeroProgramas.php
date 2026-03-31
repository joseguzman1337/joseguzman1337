<?php

session_start();
require_once("../../../templates/template.php");
$db = getBD();
$utils = new Utils_datos();

if(($_POST['anio'])&&($_POST['mes'])) {
	$query_continuada_num="select *	
		from numeroProgramaMesesContinuada
		
		where anio=".$_POST['anio']." and mes=".$_POST['mes']."";
	$exec_consulta_num= $db->Execute($query_continuada_num);
	$query_continuada_num="select *
			from numeroProgramaMesesContinuada
			where anio	=".$_POST['anio']."and mes=".$_POST['mes']."";
	$exec_continuada_num= $db->Execute($exec_continuada_num);
	
	if($exec_consulta_num->RecordCount()==0) {
?>
<div id="msg-success" class="msg-success msg-error" ><p>No existe información para la fecha  <?=$_REQUEST['anio']?> <?=$_REQUEST['mes']?></p></div>
<?
	} else {


				$query_papa = "select idclasificacion,clasificacion from infoEducacionContinuada where alias='ofreci'";
				$papa= $db->Execute($query_papa);
				$totalRows_papa = $papa->RecordCount();
				$row_papa = $papa->FetchRow();

?>

<div id='respuesta_form1_num'></div>
                
                <table align="center" class="formData last" width="92%" >
	                    <thead>            
	                        <tr class="dataColumns">
	                            <th class="column" colspan="5"><span>Número de programas ofrecidos por la división</span></th>                                    
	                        </tr>
	                        <tr class="dataColumns category">
	                            <th class="column borderR"  ><span>Tipos de Programas</span></th>
	                    		<th class="column borderR"  ><span>Salud</span></th>
	                    		<th class="column borderR"  ><span>Calidad de vida</span></th>
	                    		<th class="column borderR" ><span>Núcleo Estratégico</span></th>
	                    		<th class="column borderR" ><span>Unidad Académica</span></th>
	                    	</tr>
	                   	</thead>
                    	
                    <tbody>              	 
                        <?php 
                     				$query_sectores = "select idclasificacion,clasificacion from infoEducacionContinuada where idpadreclasificacion ='".$row_papa['idclasificacion']."'";
			                       	$sectores= $db->Execute($query_sectores);
			                     	$totalRows_sectores = $sectores->RecordCount();
					      			$i=0;
					      			$query_consulta_num="select cantidad_salud,cantidad_vida,cantidad_nucleo,cantidad_academica,mes,anio,estadoprograma
											from numeroOfrecidoscontinuada where anio=".$_POST['anio']." and mes=".$_POST['mes']."";
					      			$consulta_num=$db->Execute($query_consulta_num);
					      			 
				      			while($row_sectores=$sectores->FetchRow()){
									$row_consulta_num=$consulta_num->FetchRow();
								?> 
								<tr id="contentColumns" class="row">
								
										<td class="column borderR" ><?php echo $row_sectores['clasificacion']; ?>:<span class="mandatory">(*)</span></td>
										<input type="hidden" name="tipo_programa[] "value="<?php echo $row_sectores['idclasificacion']; ?>"/>
										<td class="column borderR" ><?php echo $row_consulta_num['cantidad_salud']; ?></td>
										<td class="column borderR" ><?php echo $row_consulta_num['cantidad_vida']; ?></td>
										<td class="column borderR" ><?php echo $row_consulta_num['cantidad_nucleo']; ?></td>
										<td class="column borderR" ><?php echo $row_consulta_num['cantidad_academica']; ?></td>		
								
								</tr>
					    <?PHP  }/*while($row_sectores=$sectores->FetchRow())*/?>
                    </tbody>    
                </table>
<?
	}
	exit;
}
?>
<form action="" method="post" id="form1_num">
	<span class="mandatory">* Son campos obligatorios</span>
	<fieldset>  
		<legend>Número de programas ofertados por la División de Educación Continuada</legend>
		
		<label for="anio" class="grid-2-12">Año: <span class="mandatory">(*)</span></label>
		<?php $utils->getYearsSelect("anio"); ?>
		
		<label for="mes" class="grid-2-12">Mes: <span class="mandatory">(*)</span></label>
		<?php $utils->getMonthsSelect("mes");  ?>	
	
	<input type="submit" value="Consultar" class="first small" />	
		<div id='respuesta_form1_num'></div>
	</fieldset>
</form>
<script type="text/javascript">
	$(':submit').click(function(event) {
		event.preventDefault();
		var valido= validateForm("#form1_num");
		if(valido){
			sendForm_num();
		}
	});
	function sendForm_num(){
		$.ajax({
				type: 'POST',
				url: './formularios/academicos/viewNumeroProgramas.php',
				async: false,
				data: $('#form1_num').serialize(),                
				success:function(data){					
					$('#respuesta_form1_num').html(data);					
				},
				error: function(data,error,errorThrown){alert(error + errorThrown);}
		});            
	}
</script>
