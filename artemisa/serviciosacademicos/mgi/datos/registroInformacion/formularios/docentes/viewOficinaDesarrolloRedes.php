<?php

if($_SESSION){
   
}else{
    session_start();
}

$rutaInc = "./";
if(isset($UrlView)){
$rutaInc = "../registroInformacion/";

} else {
	$UrlView = 0;
}
//var_dump (is_file('../../templates/template.php'));die;
if($UrlView==1 || $UrlView=='1'){
   // require_once("../../templates/template.php");
}
if($db===null){
	 require_once("../../../templates/template.php"); 
	$db = getBD();   
 $utils = new Utils_datos(); 
}

if($_GET['anio']) {
	$query="select	nombrecarrera
			,ambitonacional
			,ambitointernacional
		from siq_redesofdesarrollo
		join carrera using(codigocarrera) 
		where anio=".$_GET['anio']." and codigoestado like '1%'";
	$exec= $db->Execute($query);
	$records = $exec->RecordCount();
	//var_dump($records);
	//var_dump($UrlView);
	if($exec->RecordCount()==0 && (($_REQUEST["UrlView"]==1 || $_REQUEST["UrlView"]=='1'))) {
			//si es el reporte, toca ir a buscar la data de las unidades académicas
				$query_sectores = "Select codigocarrera 
					from carrera 
					where codigomodalidadacademica=200 
					and now() between fechainiciocarrera and fechavencimientocarrera 
					and codigocarrera<>1 
					order by nombrecarrera";
					
				$query="select nombrecarrera
					,SUM(numNacional) as ambitonacional
					,SUM(numInternacional) as ambitointernacional
				from siq_formUnidadesAcademicasRedes
				join carrera using(codigocarrera) 
				where codigoperiodo=".$_GET['anio']."2 and codigoestado like '1%' 
				AND codigocarrera IN ($query_sectores) 
				GROUP BY codigocarrera ";		
//echo $query;				
			$exec= $db->Execute($query);
			$records = $exec->RecordCount();
			if($exec->RecordCount()==0) {				
				$query="select nombrecarrera
					,SUM(numNacional) as ambitonacional
					,SUM(numInternacional) as ambitointernacional
				from siq_formUnidadesAcademicasRedes
				join carrera using(codigocarrera) 
				where codigoperiodo=".$_GET['anio']."1 and codigoestado like '1%' 
				AND codigocarrera IN ($query_sectores) 
				GROUP BY codigocarrera";		
//echo $query;								
				$exec= $db->Execute($query);
				$records = $exec->RecordCount();
			} //if recordCount
	} //if vacio pero era reporte
		if($records==0){
?>
		<div id="msg-success" class="msg-success msg-error" ><p>No existe informaci&oacute;n  para el a&ntilde;o <?php echo $_REQUEST['anio']?></p></div>
               
<?PHP	 
	 } else {
?>
<div id="tableDiv">
<table align="center" id="estructuraReporte" class="previewReport formData last" width="92%">
        <thead>            
             <tr class="dataColumns">                 
                    <th class="column" colspan="5"><span>N&uacute;mero de redes nacionales e internacionales por programa acad&eacute;mico</span></th> 
             </tr>
	     <tr class="dataColumns category">
		<th class="column borderR" rowspan="2"><span>Programa</span></th>
		<th class="column" colspan="2"><span>&Aacute;mbito</span></th>		
	    </tr>
	    <tr class="dataColumns category">
		<th class="column"><span>Nacional</span></th>
		<th class="column borderR"><span>Internacional</span></th>
	    </tr>	     
        </thead>
	<tbody>
	 <?php 
	  while($row_conv1= $exec->FetchRow()){	    
	    $suma1=$suma1+$row_conv1['ambitonacional'];
	    $suma2=$suma2+$row_conv1['ambitointernacional'];
	   	    
	  ?>
	 <tr class="contentColumns" class="row">
              <td class="column borderR" ><?php echo $row_conv1['nombrecarrera']; ?></td>
	      <td class="column center borderR" ><?php echo $row_conv1['ambitonacional']; ?></td>
	      <td class="column center" ><?php echo $row_conv1['ambitointernacional']; ?></td>	      
	 </tr>
	<?php 
	}
	?>	
	</tbody>
	<tfoot>
             <tr id="totalColumns">
                <td class="column total title borderR">Total</td>
		<td class="column total title borderR"><?php echo number_format($suma1); ?></td>
		<td class="column total title"><?php echo number_format($suma2); ?></td>		
	    </tr>
	</tfoot>
</table>
</div>
<?PHP
	} 
	//echo "hola <br/><pre>";
	//print_r($db);
	exit;


}

?>


<form action="" method="post" id="form5" class="report">
	<span class="mandatory">* Son campos obligatorios</span>
	<fieldset>  
		<legend>N&uacute;mero de Redes Nacionales e Internacionales por Programa Acad&eacute;mico</legend>
		<label for="anio" class="grid-2-12">A&ntilde;o: <span class="mandatory">(*)</span></label>
		<?php $utils->getYearsSelect("anio"); ?>
	
	<input type="submit" value="Consultar" class="first small" />		
	<input type="hidden" name="UrlView" value="<?php echo $UrlView; ?>" />
		<div id='respuesta_form5'></div>
	</fieldset>
</form>
<script type="text/javascript">
	$(':submit').click(function(event) {
		event.preventDefault();
		var valido= validateForm("#form5");
		if(valido){
			sendForm();
		}
	});
	function sendForm(){
		$.ajax({
				type: 'GET',
				url: '<?PHP echo $rutaInc?>formularios/docentes/viewOficinaDesarrolloRedes.php',
				async: false,
				data: $('#form5').serialize(),                
				success:function(data){					
					$('#respuesta_form5').html(data);					
					
				},
				error: function(data,error,errorThrown){alert(error + errorThrown);}
		});            
	}
</script>
