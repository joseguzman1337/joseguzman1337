<?php

if($_GET['semestre']) {

require_once("../../../templates/template.php");
$db = getBD();
//$utils = new Utils_datos();


/* Query rango de Periodo */
$codigoperiodo = $_GET['semestre'];
$query_periodof="select * from periodo where codigoperiodo='$codigoperiodo'";
$periodof= $db->Execute($query_periodof);
$totalRows_periodof = $periodof->RecordCount();
$row_periodof = $periodof->FetchRow();

$fechainicioperiodo=$row_periodof['fechainicioperiodo'];
$fechavencimientoperiodo=$row_periodof['fechavencimientoperiodo'];

/* Query Modalidad academica de la tabla modalidadacademicasic para sacar la asociacion como esta en el documento */
//$start1 = microtime(true);
if($_GET['modalidad']!='todos'){
$query_modalidad="select nombremodalidadacademicasic, codigomodalidadacademicasic from modalidadacademicasic where codigomodalidadacademicasic ='".$_GET['modalidad']."'";
}
else{
$query_modalidad="select nombremodalidadacademicasic, codigomodalidadacademicasic from modalidadacademicasic where codigomodalidadacademicasic not in('000',100,101,400)";
}
$modalidad= $db->Execute($query_modalidad);
$totalRows_modalidad = $modalidad->RecordCount();



	//echo "<br/><br/>";echo "1 <pre>";print_r($datos_estadistica->seguimiento_inscripcionvsmatriculadosnuevos(132,'arreglo'));echo "<br/><br/>";  
?>
<table align="left" id="estructuraReporte" class="previewReport" style="text-align:left;clear:both;margin: 10px 0px;width:100%">
        <thead>            
             <tr class="dataColumns">
                 
                    <th class="column" rowspan="2" style="width:34%;"><span>PROGRAMA</span></th>
		     <?php
			/*Recorrido de Consulta para imprimir los periodos*/
			$anioperiodo=substr($codigoperiodo,-1);			
			if($anioperiodo==1)
			$anioperiodo='I';
			else
			$anioperiodo='II';
			$anio=substr($codigoperiodo, 0, -1);			
			?>
			<th class="column" colspan="2" style="width:66%;text-align:center;"><?php echo " AÑO ".$anio." - PERIODO ".$anioperiodo; ?></span></th>
             </tr>
	     <tr class="dataColumns">
		<th class="column" style="width:22%;"><span>Número de Egresados</span></th>
		<th class="column" style="width:22%;"><span>Porcentaje de egresados que figuran en la base de datos</span></th>				
	    </tr>
        </thead>
        <tbody>
	<?php while($row_modalidad = $modalidad->FetchRow()){            
           /*Inicio ciclo que pinta los bloques de modalidad*/
	 ?>
	 <tr class="contentColumns row dataColumns">
              <td class="column category" colspan="3" style="width:100%;"><b><?php echo $row_modalidad['nombremodalidadacademicasic']; ?></b></td>       
         </tr>
	<?php 
	if($codigoperiodo < '20061'){
	  $query_carreras="select count(r.idregistrograduadoantiguo) as total_est,c.nombrecarrera, c.codigocarrera
	    from carrera c
	    left join registrograduadoantiguo r on r.codigocarrera=c.codigocarrera and r.fechagradoregistrograduadoantiguo between '$fechainicioperiodo' and '$fechavencimientoperiodo'
	    where now() between c.fechainiciocarrera and c.fechavencimientocarrera
	    and c.codigomodalidadacademicasic ='".$row_modalidad['codigomodalidadacademicasic']."'
	    group by c.codigocarrera
	    order by nombrecarrera";
	}
	else{
	  $query_carreras="select count(r.idregistrograduado) as total_est,c.nombrecarrera, c.codigocarrera
	    from carrera c
	    join estudiante e on e.codigocarrera=c.codigocarrera
	    left join registrograduado r on r.codigoestudiante=e.codigoestudiante and r.fechagradoregistrograduado between '$fechainicioperiodo' and '$fechavencimientoperiodo'
		    where now() between c.fechainiciocarrera and c.fechavencimientocarrera
		    and c.codigomodalidadacademicasic ='".$row_modalidad['codigomodalidadacademicasic']."'    
	    group by c.codigocarrera
	    order by nombrecarrera";  
	}
	$carreras= $db->Execute($query_carreras);
	//$totalRows_carreras = $carreras->RecordCount();
	while($row_carreras = $carreras->FetchRow()){
	/*Inicio ciclo que pinta las carreras en la modalidad correspondiente*/       	    
	$sumatoria_est=$row_carreras['total_est']+$sumatoria_est;
	             
	?>
	<tr class="contentColumns" class="row">
              <td class="column" style="width:34%;"><?php echo $row_carreras['nombrecarrera']; ?></td>
	      <td class="column" style="text-align:center;width:22%;"><?php echo $row_carreras['total_est'];?></td>
	      <td class="column" style="text-align:center;width:22%;"><?php if($row_carreras['total_est']!=0) echo "100%"; else echo "0%";?></td>                           
	</tr>
<?php //fin if
/*fin del ciclo de carrera*/
           }
	?>
             <tr class="dataColumns category">
                <th class="column total title" style="width:34%;"><b>Total <?php echo $row_modalidad['nombremodalidadacademicasic']; ?></b></th>		
              <th class="column total title" style="text-align:center;width:22%;"><b><?php echo $sumatoria_est; ?></b></th>
              <th class="column total title" style="text-align:center;width:22%;"><b><?php if($sumatoria_est!=0) echo "100%"; else echo "0%";?></b></th>              
                            
	  <?php
		/*Acumuladores del total de todas las modalidades*/
		$suma_total_est=$sumatoria_est+$suma_total_est;
	         
	   unset($sumatoria_est);
	  ?>
            </tr>
	<?php
	/*Fin del ciclo de modalidades*/ 
	 }
	 ?>
        </tbody>        
	<tfoot>
             <tr class="totalColumns">
                <td class="column total title" style="width:34%;"><b>Total</b></td>                
                <td style="text-align:center;width:22%;"><b><?php echo $suma_total_est; ?></b></td>
                <td style="text-align:center;width:22%;"><b><?php if($suma_total_est!=0) echo "100%"; else echo "0%";?></b></td>                                    
            </tr>
        </tfoot>
    </table>
<?php
/*$end1 = microtime(true);
$time = $end1 - $start1;
echo "<br/><br/>";echo('totales tardo '. $time . ' seconds to execute.');*/
exit();

}
?>

<form action="" method="post" id="r_egresados" class="report">
	<span class="mandatory">* Son campos obligatorios</span>
	<fieldset>  
		
		<label for="semestre" class="grid-2-12">Semestre: <span class="mandatory">(*)</span></label>
		<?php $utils->getSemestresSelect($db,"semestre"); ?>
		<label for="modalidad" class="grid-2-12">Modalidad Academica: <span class="mandatory">(*)</span></label>		
		
		<?php
		$query_tipomodalidad = "select nombremodalidadacademicasic, codigomodalidadacademicasic from modalidadacademicasic where codigomodalidadacademicasic not in('000',100,101,400)";
		$tipomodalidad = $db->Execute($query_tipomodalidad);
		$totalRows_tipomodalidad = $tipomodalidad->RecordCount();
		?>		
		<select name="modalidad" id="modalidad" style='font-size:0.8em'>
		<option value="todos">Todas</option>
		<?php while($row_tipomodalidad = $tipomodalidad->FetchRow()) {
		?>
		<option value="<?php echo $row_tipomodalidad['codigomodalidadacademicasic']?>">
		<?php echo $row_tipomodalidad['nombremodalidadacademicasic']; ?>
		</option>
		<?php
		}
		?>
		</select>
	
	<input type="submit" value="Consultar" class="first small"/>
        <img src="../../images/ajax-loader.gif" style="display:none;clear:both;margin:20px auto;" id="loading"/>	
		<div id='tableDiv'></div>
	</fieldset>
</form>
<script type="text/javascript">
	$(':submit').click(function(event) {
		event.preventDefault();
		var valido= validateForm("#r_egresados");
		if(valido){
			sendForm();
		}
	});
	function sendForm(){
            $('#tableDiv').html("");
            $("#loading").css("display","block");
		$.ajax({
				type: 'GET',
				url: './reportes/estudiantes/viewReporteEgresados.php',
				async: false,
				data: $('#r_egresados').serialize(),                
				success:function(data){			
                                    $("#loading").css("display","none");		
					$('#tableDiv').html(data);					
					
				},
				error: function(data,error,errorThrown){alert(error + errorThrown);}
		});            
	}
</script>
