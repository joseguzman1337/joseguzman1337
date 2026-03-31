<?php
session_start();
require_once("../../../templates/template.php");
$db = getBD();
$utils = new Utils_datos();

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

<table align="center" id="estructuraReporte" class="previewReport formData last" width="92%">
        <thead>            
             <tr class="dataColumns">                 
                    <th class="column" colspan="5"><span><?php echo $row_papa['clasificacionesinfhuerfana']; ?></span></th> 
             </tr>
	     <tr id="dataColumns">
                        <th class="column borderR" ><span>Categoria/Área</span></th>
                        <th class="column borderR"><span>Presupuestado</span></th>
                        <th class="column borderR" ><span>Ejecutado</span></th>                            
                        <th class="column borderR" ><span>% de Ejecución</span></th>
	    </tr>	    	     
        </thead>
	<tbody>
	 <?php 
	  while($row_conv1= $exec->FetchRow()){
	    $total1=$row_conv1['presupuestado']+$row_conv1['ejecutado'];
	    $suma1=$suma1+$row_conv1['presupuestado'];
	    $suma2=$suma2+$row_conv1['ejecutado'];
	    $totalgen=$totalgen+$total1;
	  ?>
	 <tr class="contentColumns" class="row">
              <td class="column borderR" ><?php echo $row_conv1['clasificacionesinfhuerfana']; ?></td>
	      <td class="column center" ><?php echo $row_conv1['presupuestado']; ?></td>
	      <td class="column center borderR" ><?php echo $row_conv1['ejecutado']; ?></td>
	      <td class="column center" ><?php echo "pendiente"; ?></td>
	 </tr>
	<?php 
	}
	?>	
	</tbody>
	<tfoot>
             <tr id="totalColumns">
                <td class="column total title borderR">Total</td>
		<td class="column total title"><?php echo $suma1; ?></td>
		<td class="column total title borderR"><?php echo $suma2; ?></td>
		<td class="column total title"><?php echo "pendiente"; ?></td>
	    </tr>
	
	</tfoot>
</table>
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
				url: './formularios/financieros/viewPresupuestoTodo.php',
				async: false,
				data: $('#<?php echo $_GET['padre']; ?>').serialize(),                
				success:function(data){					
					$('#respuesta_<?php echo $_GET['padre']; ?>').html(data);					
					
				},
				error: function(data,error,errorThrown){alert(error + errorThrown);}
		});            
	}
</script>
