<?php
    session_start();
    include_once('../../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
//session_start();

if(!isset($reporteEspecifico)){
require_once("../../../templates/template.php");
}
$db = getBD();
$utils = new Utils_datos();
//}

$rutaInc = "./";
if(isset($reporteEspecifico)){
	$rutaInc = "../registroInformacion/";
}



 
if($_GET['anio']) {
	
	$query_papa = "select idclasificacionesinfhuerfana, aliasclasificacionesinfhuerfana,clasificacionesinfhuerfana from siq_clasificacionesinfhuerfana where aliasclasificacionesinfhuerfana='P_EJE_PROG_BIEN'";
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
                    <th class="column" colspan="5"><span>Presupuesto Ejecutado en los Programas de Bienestar (en millones de pesos)</span></th> 
             </tr>
	     <tr id="dataColumns">
                        <th class="column borderR" ><span>Área</span></th>
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
	      <td class="column center borderR" ><?php echo number_format($row_conv1['presupuestado'],0); ?></td>
	      <td class="column center borderR" ><?php echo number_format($row_conv1['ejecutado'],0); ?></td>
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
		<td class="column total title borderR"><?php echo number_format($suma2,0); ?></td>
		<td class="column total title"><?php echo number_format($suma2/$suma1*100,2); ?></td>
	    </tr>
	
	</tfoot>	
</table>
<?php
	}
	exit;


}

?>


<form action="" method="post" id="formbienes">

	<span class="mandatory">* Son campos obligatorios</span>
	<fieldset>  
		<legend>Presupuesto Ejecutado en los Programas de Bienestar</legend>				
		<label for="anio" class="grid-2-12">Año: <span class="mandatory">(*)</span></label>
		<?php $utils->getYearsSelect("anio");  ?>
	<input type="submit" id="consbien" value="Consultar" class="first small"/>
		<div id='respuesta_formbienes'></div>
	</fieldset>
	
</form>
<script type="text/javascript">
	$('#consbien').click(function(event) {
		event.preventDefault();
		var valido= validateForm("#formbienes");
		if(valido){
			sendForm();
		}
	});
	function sendForm(){
		$.ajax({
				type: 'GET',
				url: '<?php echo $rutaInc;?>formularios/financieros/viewPresupuestoBienestar.php',
				async: false,
				data: $('#formbienes').serialize(),                
				success:function(data){					
					$('#respuesta_formbienes').html(data);					
					
				},
				error: function(data,error,errorThrown){alert(error + errorThrown);}
		});            
	}
</script>