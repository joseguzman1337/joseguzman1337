<?php
    session_start();
    include_once('../../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
/*
if($_SESSION){
   
}else{
    session_start();
}*/

$rutaInc = "./";
if(isset($UrlView)){
$rutaInc = "../registroInformacion/";
$_GET['padre'] = $Padre;
}
//var_dump (is_file('../../templates/template.php'));die;
if($UrlView==1 || $UrlView=='1'){
   // require_once("../../templates/template.php");
}else{
    require_once("../../../templates/template.php");   
    $db = getBD();
    $utils = new Utils_datos(); 
}

if($_GET['anio']) {

	$query_papa = "select idclasificacionesinfhuerfana, aliasclasificacionesinfhuerfana,clasificacionesinfhuerfana from siq_clasificacionesinfhuerfana where aliasclasificacionesinfhuerfana='".$_GET['padre']."'";
                $papa= $db->Execute($query_papa);
                $totalRows_papa = $papa->RecordCount();
		$row_papa = $papa->FetchRow();

	$query="select s1.clasificacionesinfhuerfana
			,s2.presupuestado
			,s2.ejecutado
		from siq_ofpresupuestos s2
		join siq_clasificacionesinfhuerfana s1 using(idclasificacionesinfhuerfana)
		where s2.anioperiodo=".$_GET['anio']."
		and s2.idpadreclasificacionesinfhuerfana ='".$row_papa['idclasificacionesinfhuerfana']."'
		and s2.codigoestado like '1%'";
		
	$exec= $db->Execute($query);	
	
	
	if($exec->RecordCount()==0) {
?>
<div id="msg-success" class="msg-success msg-error" ><p>No existe información para el año <?php echo $_REQUEST['anio']; ?></p></div>
<?php
	} else {
?>
<div id="tableDiv">
<table align="center" id="estructuraReporte" class="previewReport formData last" width="92%">
        <thead>            
             <tr class="dataColumns">                 
                    <th class="column" colspan="<?php if ($_GET['padre']==="P_FIN_INST") { echo 6; } else { echo 4; } ?>"><span><?php echo $row_papa['clasificacionesinfhuerfana']; ?> (en millones de pesos)</span></th> 
             </tr>
	     <tr id="dataColumns">
                        <th class="column borderR" ><span>Categoria/Área</span></th>
                        <th class="column borderR"><span>Presupuestado</span></th>
						<?php if ($_GET['padre']==="P_FIN_INST") { echo '<th class="column borderR" ><span>% de Participación</span></th>';}  ?>
                        <th class="column borderR" ><span>Ejecutado</span></th>       
						<?php if ($_GET['padre']==="P_FIN_INST") { echo '<th class="column borderR" ><span>% de Participación</span></th>';}  ?>                     
                        <th class="column borderR" ><span>% de Ejecución</span></th>
	    </tr>	    	     
        </thead>
	<tbody>
	 <?php  $arreglo = $exec->GetArray();
		   foreach($arreglo as $row_conv1) {
			  $total1=$row_conv1['presupuestado']+$row_conv1['ejecutado'];
				$suma1=$suma1+$row_conv1['presupuestado'];
				$suma2=$suma2+$row_conv1['ejecutado'];
				$totalgen=$totalgen+$total1;
		   }
	  foreach($arreglo as $row_conv1) {
	  ?>
	 <tr class="contentColumns" class="row">
              <td class="column borderR" ><?php echo $row_conv1['clasificacionesinfhuerfana']; ?></td>
	      <td class="column center borderR" ><?php echo number_format($row_conv1['presupuestado'],0); ?></td>
			<?php if ($_GET['padre']==="P_FIN_INST") { echo '<td class="column center borderR" >'.number_format($row_conv1['presupuestado']/$suma1*100,2).'</td>';}  ?>
	      <td class="column center borderR" ><?php echo number_format($row_conv1['ejecutado'],0); ?></td>
		  <?php if ($_GET['padre']==="P_FIN_INST") { echo '<td class="column center borderR" >'.number_format($row_conv1['ejecutado']/$suma2*100,2).'</td>';}  ?>
	      <td class="column center" ><?php echo number_format((($row_conv1['ejecutado']/$row_conv1['presupuestado'])*100),2); ?></td>
	 </tr>
	<?php 
	}
	?>	
	</tbody>
	<tfoot>
             <tr id="totalColumns">
                <td class="column total title borderR">Total</td>
		<td class="column total title borderR"><?php echo number_format($suma1,0); ?></td>
		<?php if ($_GET['padre']==="P_FIN_INST") { echo '<td class="column total title borderR" >100</td>';}  ?>
		<td class="column total title borderR"><?php echo number_format($suma2,0); ?></td>
		<?php if ($_GET['padre']==="P_FIN_INST") { echo '<td class="column total title borderR" >100</td>';}  ?>
		<td class="column total title"><?php echo number_format($suma2/$suma1*100,2); ?></td>
	    </tr>
	
	</tfoot>
</table>    
  </div>   
<?php
	}
	exit;


}

?>


<form action="" method="post" id="<?php echo $_GET['padre']; ?>">
	<span class="mandatory">* Son campos obligatorios</span>
	<fieldset>
	<?php $query_papa = "select idclasificacionesinfhuerfana, aliasclasificacionesinfhuerfana,clasificacionesinfhuerfana from siq_clasificacionesinfhuerfana where aliasclasificacionesinfhuerfana='".$_GET['padre']."'";
                $papa= $db->Execute($query_papa);
                $totalRows_papa = $papa->RecordCount();
		$row_papa = $papa->FetchRow();
	?>
		<legend><?php echo $row_papa['clasificacionesinfhuerfana']; ?></legend>
		<label for="anio" class="grid-2-12">Año: <span class="mandatory">(*)</span></label>
		<?php $utils->getYearsSelect("anio"); ?>		
	<input type="hidden" name="padre" value="<?php echo $_GET['padre']; ?>" />
	<input type="submit" id="consulta_<?php echo $_GET['padre']; ?>" value="Consultar" class="first small" />	
		<div id='respuesta_<?php echo $_GET['padre']; ?>'></div>
	</fieldset>
</form>
<script type="text/javascript">

	$('#consulta_<?php echo $_GET['padre']; ?>').click(function(event) {
		event.preventDefault();
		var valido= validateForm("#<?php echo $_GET['padre']; ?>");
		if(valido){
			<?php echo $_GET['padre']; ?>();
		}
	});
	function <?php echo $_GET['padre']; ?>(){
		$.ajax({
				type: 'GET',
				url: '<?PHP echo $rutaInc?>formularios/financieros/viewPresupuestoTodo.php',
				async: false,
				data: $('#<?php echo $_GET['padre']; ?>').serialize(),                
				success:function(data){					
					$('#respuesta_<?php echo $_GET['padre']; ?>').html(data);					
					
				},
				error: function(data,error,errorThrown){alert(error + errorThrown);}
		});            
	}
</script>
