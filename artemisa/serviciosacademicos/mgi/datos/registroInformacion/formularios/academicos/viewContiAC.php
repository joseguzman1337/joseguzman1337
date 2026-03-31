<?php

session_start();
require_once("../../../templates/template.php");
$db = getBD();
$utils = new Utils_datos();

if(($_POST['anio'])&&($_POST['mes'])) {
	$query_continuada_ac="select *	
		from abiertocerradomeses
		
		where anio=".$_POST['anio']." and mes=".$_POST['mes']."";
	$exec_consulta_ac= $db->Execute($query_continuada_ac);
	$query_continuada_ac="select *
			from abiertocerradomeses
			where anio	=".$_POST['anio']."and mes=".$_POST['mes']."";
	$exec_continuada_ac= $db->Execute($exec_continuada_num);
	
	if($exec_consulta_ac->RecordCount()==0) {
?>
<div id="msg-success" class="msg-success msg-error" ><p>No existe información para la fecha  <?=$_REQUEST['anio']?> <?=$_REQUEST['mes']?></p></div>
<?
	} else {
$query_papa = "select idclasificacion,clasificacion from infoEducacionContinuada where alias='abierto'";
			$papa= $db->Execute($query_papa);
			$totalRows_papa = $papa->RecordCount();
			$row_papa = $papa->FetchRow();
?>
<div id='respuesta_form1_num'></div>
                
                <table align="center" class="formData last" width="92%" >
	                    <thead>            
	                        <tr class="dataColumns">
	                            <th class="column" colspan="2"><span>Programas de Educación Continuada (abiertos o cerrados)</span></th>                                    
	                        </tr>
	                         
	                        <tr class="dataColumns category" >
	                            <th  class="column borderR"  ><span >Tipos de Programas</span></th>
	                    		<th class="column borderR" 	 ><span>Cantidad</span></th>
	                    		<!--<th class="column borderR"   ><span>Procentaje</span></th>-->
	                    	</tr>
	                   	</thead>
                    	
                    <tbody>              	 
                        <?php 
                        			$query_sectores = "select idclasificacion,clasificacion from infoEducacionContinuada where idpadreclasificacion ='".$row_papa['idclasificacion']."'";
			                       	$sectores= $db->Execute($query_sectores);
			                     	$totalRows_sectores = $sectores->RecordCount();
					      			$i=0;
					      			$query_consulta_ac="select cantidad,procentaje
														from educacionabiertocerrado where anio=".$_POST['anio']." and mes=".$_POST['mes']."";
					      			$consulta_ac=$db->Execute($query_consulta_ac);
					      			
				      			while($row_sectores=$sectores->FetchRow()){
									$row_consulta_ac=$consulta_ac->FetchRow();
								?> 
								<tr id="contentColumns" class="row">
										<td class="column borderR" ><?php echo $row_sectores['clasificacion']; ?>:<span class="mandatory">(*)</span></td><div class="vacio"></div>
										<input type="hidden" name="tipo_programa[] "value="<?php echo $row_sectores['idclasificacion']; ?>"/>
										<td class="column borderR" ><?php echo $row_consulta_ac['cantidad']; ?></td>
										<!--<td class="column borderR" ><?php //echo $row_consulta_ac['procentaje']; ?></td>-->
								</tr>
					    <?PHP  }/*while($row_sectores=$sectores->FetchRow())*/?>
                    </tbody>    
                </table>
<?
	}#else
	exit;
}

?>
<form action="" method="post" id="form1_ac">
	<span class="mandatory">* Son campos obligatorios</span>
	<fieldset>  
		<legend>Programas de Educación Continuada (abiertos o cerrados)</legend>
		
		<label for="anio" class="grid-2-12">Año: <span class="mandatory">(*)</span></label>
		<?php $utils->getYearsSelect("anio"); ?>
		
		<label for="mes" class="grid-2-12">Mes: <span class="mandatory">(*)</span></label>
		<?php $utils->getMonthsSelect("mes");  ?>	
	
	<input type="submit" value="Consultar" class="first small" />	
		<div id='respuesta_form1_ac'></div>
	</fieldset>
</form>
<script type="text/javascript">
	$(':submit').click(function(event) {
		event.preventDefault();
		var valido= validateForm("#form1_ac");
		if(valido){
			sendForm_ac();
		}
	});
	function sendForm_ac(){
		$.ajax({
				type: 'POST',
				url: './formularios/academicos/viewContiAC.php',
				async: false,
				data: $('#form1_ac').serialize(),                
				success:function(data){					
					$('#respuesta_form1_ac').html(data);					
				},
				error: function(data,error,errorThrown){alert(error + errorThrown);}
		});            
	}
</script>