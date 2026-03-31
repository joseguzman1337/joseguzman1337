<?php

session_start();
require_once("../../../templates/template.php");
$db = getBD();
$utils = new Utils_datos();

if(($_POST['semestre'])) {
	$query_continuada_au="select *	
		from siq_tecnologia
		
		where codigoperiodo='".$_POST['semestre']."'";
	$exec_consulta_au= $db->Execute($query_continuada_au);

	
	if($exec_consulta_au->RecordCount()==0) {
?>
<div id="msg-success" class="msg-success msg-error" ><p>No existe información para la fecha  <?=$_REQUEST['semestre']?> </p></div>
<?
	} else {
				$query_papa = "select idclasificacionesinfhuerfana,clasificacionesinfhuerfana from siq_clasificacionesinfhuerfana where aliasclasificacionesinfhuerfana='T_NECSCA'";
				$papa= $db->Execute($query_papa);
				$totalRows_papa = $papa->RecordCount();
				$row_papa = $papa->FetchRow();

			

?>

<div id='respuesta_form1_un'></div>
			<table align="center" id="estructuraReporte"  class="formData last" width="92%">
		    <thead>             			
			<tr id="dataColumns">
                            <th class="column borderR" ><span>Poblacion que Cubre</span></th>
                            <th class="column borderR"><span>Espacios Físicos</span></th>
                            <th class="column borderR"><span>Cantidad</span></th>                            
			</tr>				
                   </thead>
		    <tbody>
		      <?php 
		      $query_sectores = "select idclasificacionesinfhuerfana,clasificacionesinfhuerfana from siq_clasificacionesinfhuerfana where idpadreclasificacionesinfhuerfana ='".$row_papa['idclasificacionesinfhuerfana']."' order by 1";
		      $sectores= $db->Execute($query_sectores);
		      $totalRows_sectores = $sectores->RecordCount();
		      $query_consulta_eq= "select cantidad from siq_tecnologia where idpadreclasificacionesinfhuerfana ='".$row_papa['idclasificacionesinfhuerfana']."' and codigoperiodo='".$_POST['semestre']."' ";
		      $consulta_eq=$db->Execute($query_consulta_eq);
		      $totalRows_sectores_eq = $consulta_eq->RecordCount();
		      
		      while($row_sectores = $sectores->FetchRow()){ 
		      
			$query_hijos = "select idclasificacionesinfhuerfana,clasificacionesinfhuerfana from siq_clasificacionesinfhuerfana where idpadreclasificacionesinfhuerfana ='".$row_sectores['idclasificacionesinfhuerfana']."' order by 2 ";
		      $hijos= $db->Execute($query_hijos);
		      $totalRows_hijos = $hijos->RecordCount();
		      $cuentadat=$totalRows_hijos +1;
		      
		      
		      
		      ?>
		      <tr id="contentColumns" class="row">
			  <td class="column borderR" rowspan="<?php echo $cuentadat;?>"><?php echo $row_sectores['clasificacionesinfhuerfana']; ?>:<span class="mandatory">(*)</span></td>
		      </tr>
		      <?php
			while($row_hijos= $hijos->FetchRow()){
			$row_consulta_eq = $consulta_eq->FetchRow();
		      ?>		      
		      <tr>
			  <td class="column borderR"><?php echo $row_hijos['clasificacionesinfhuerfana']; ?></td>
			  <td class ="center"><?php echo $row_consulta_eq['cantidad']; ?></td>
			   
		      </tr>	      			  
			<?php
			  }
			}
			?>	
		     </tbody>		     
		  </table>
                
	
<?
	}
	exit;
}

?>
<form action="" method="post" id="form1_eq">
	<span class="mandatory">* Son campos obligatorios</span>
	<fieldset>  
		<legend>Equipos de Cómputo al Servicio de la Comunidad Académica</legend>
		
	<?php
				$query_papa = "select idclasificacionesinfhuerfana,clasificacionesinfhuerfana from siq_clasificacionesinfhuerfana where aliasclasificacionesinfhuerfana='T_NECSCA'";
                $papa= $db->Execute($query_papa);
                $totalRows_papa = $papa->RecordCount();
				$row_papa = $papa->FetchRow();
		?>                
		<legend><?php echo $row_papa['clasificacionesinfhuerfana']; ?></legend>
		<label for="semestre" class="grid-2-12">Semestre: <span class="mandatory">(*)</span></label>
		<?php $utils->getSemestresSelect($db,"semestre");?>
	
	<input type="submit" value="Consultar" class="first small" />	
		<div id='respuesta_form1_eq'></div>
	</fieldset>
</form>
<script type="text/javascript">
	$(':submit').click(function(event) {
		event.preventDefault();
		var valido= validateForm("#form1_eq");
		if(valido){
			sendForm_un();
		}
	});
	function sendForm_un(){
		$.ajax({
				type: 'POST',
				url: './formularios/recursosFisicos/ViewEquiposServicio.php',
				async: false,
				data: $('#form1_eq').serialize(),                
				success:function(data){					
					$('#respuesta_form1_eq').html(data);					
				},
				error: function(data,error,errorThrown){alert(error + errorThrown);}
		});            
	}
</script>