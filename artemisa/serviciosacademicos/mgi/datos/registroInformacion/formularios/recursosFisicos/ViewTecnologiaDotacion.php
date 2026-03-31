<?php

session_start();
require_once("../../../templates/template.php");
$db = getBD();
$utils = new Utils_datos();

if(($_POST['semestre'])) {
	$query_continuada_au="select *	
		from siq_tecnologia
		
		where codigoperiodo=".$_POST['semestre']."";
	$exec_consulta_au= $db->Execute($query_continuada_au);

	
	if($exec_consulta_au->RecordCount()==0) {
?>
<div id="msg-success" class="msg-success msg-error" ><p>No existe información para la fecha  <?=$_REQUEST['semestre']?> </p></div>
<?PHP
	} else {
				$query_papa = "select idclasificacionesinfhuerfana,clasificacionesinfhuerfana from siq_clasificacionesinfhuerfana where aliasclasificacionesinfhuerfana='T_DSREA'";
				$papa= $db->Execute($query_papa);
				$totalRows_papa = $papa->RecordCount();
				$row_papa = $papa->FetchRow();
?>

<div id='respuesta_form1_un'></div>
                
			<table align="center" id="estructuraReporte"  class="formData last" width="92%">
		    <thead>             			
			<tr id="dataColumns">
                            <th class="column borderR" ><span>Modalidad Académica</span></th>
                            <th class="column borderR"><span>Cantidad</span></th>                            
			</tr>				
            </thead>
		    <tbody>
		      <?php 
		      $query_sectores = "select idclasificacionesinfhuerfana,clasificacionesinfhuerfana from siq_clasificacionesinfhuerfana where idpadreclasificacionesinfhuerfana ='".$row_papa['idclasificacionesinfhuerfana']."' order by 2 ";
		      $sectores= $db->Execute($query_sectores);
		      $totalRows_sectores = $sectores->RecordCount();
		      
		      $query_consulta_au= "select cantidad from siq_tecnologia where idpadreclasificacionesinfhuerfana ='".$row_papa['idclasificacionesinfhuerfana']."' and codigoperiodo='".$_POST['semestre']."'";
		      $consulta_au=$db->Execute($query_consulta_au);
		      $totalRows_sectores_au = $consulta_au->RecordCount();
		      while($row_sectores = $sectores->FetchRow()){
					$row_consulta_au = $consulta_au->FetchRow();     
		      ?>
		      <tr id="contentColumns" class="row">
			  <td class="column borderR" ><?php echo $row_sectores['clasificacionesinfhuerfana']; ?>:<span class="mandatory"></span></td>
			  <td class="center" ><?php echo $row_consulta_au['cantidad']; ?><span class="mandatory"></span></td>
			  </tr>
			<?php 
			$sumaTotal += $row_consulta_au['cantidad'];
			}
			?>	
			<tr id="contentColumns" class="row">
		  		<th class="column borderR total right" >Total:<span class="mandatory"></span></th>
		  		<th class="center total" ><?php echo $sumaTotal; ?><span class="mandatory"></span></th>
		  	</tr>
		     </tbody>
		  </table>
<?PHP
	}
	exit;
}

?>
<form action="" method="post" id="form1_td">
	<span class="mandatory">* Son campos obligatorios</span>
	<fieldset>  
		<legend>Dotación salones</legend>
		
	<?php
				$query_papa = "select idclasificacionesinfhuerfana,clasificacionesinfhuerfana from siq_clasificacionesinfhuerfana where aliasclasificacionesinfhuerfana='T_DSREA'";
                $papa= $db->Execute($query_papa);
                $totalRows_papa = $papa->RecordCount();
				$row_papa = $papa->FetchRow();
		?>                
		<legend><?php echo $row_papa['clasificacionesinfhuerfana']; ?></legend>
		<label for="semestre" class="grid-2-12">Semestre: <span class="mandatory">(*)</span></label>
		<?php $utils->getSemestresSelect($db,"semestre"); 
                 

                ?>
	
	<input type="submit" value="Consultar" class="first small" />	
		<div id='respuesta_form1_td'></div>
	</fieldset>
</form>
<script type="text/javascript">
	$(':submit').click(function(event) {
		event.preventDefault();
		var valido= validateForm("#form1_td");
		if(valido){
			sendForm_un();
		}
	});
	function sendForm_un(){
		$.ajax({
				type: 'POST',
				url: './formularios/recursosFisicos/ViewTecnologiaDotacion.php',
				async: false,
				data: $('#form1_td').serialize(),                
				success:function(data){					
					$('#respuesta_form1_td').html(data);					
				},
				error: function(data,error,errorThrown){alert(error + errorThrown);}
		});            
	}
</script>