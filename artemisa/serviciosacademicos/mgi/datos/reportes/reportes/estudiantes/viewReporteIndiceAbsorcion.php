<?php

if($_GET['semestre']) {

require_once("../../../templates/template.php");
$db = getBD();
//$utils = new Utils_datos();

require_once('../../../../../consulta/estadisticas/matriculasnew/funciones/obtener_datos.php');
/* Query rango de Periodo */
$codigoperiodo = $_GET['semestre'];

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
$datos_estadistica=new obtener_datos_matriculas($db,$codigoperiodo);	
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
			<th class="column" colspan="3" style="width:66%;text-align:center;"><?php echo " AÑO ".$anio." - PERIODO ".$anioperiodo; ?></span></th>
             </tr>
	     <tr class="dataColumns">
		<th class="column" style="width:22%;"><span>NÚMERO DE ADMITIDOS</span></th>
		<th class="column" style="width:22%;"><span>NÚMERO DE MATRICULADOS NUEVOS</span></th>		
		<th class="column" style="width:22%;"><span>INDICE DE ABSORCIÓN</span></th>		
	    </tr>
        </thead>
        <tbody>
	<?php while($row_modalidad = $modalidad->FetchRow()){
            $matriculados=$datos_estadistica->obtener_datos_estudiantes_matriculados_nuevos_modalidad_carrera('conteo',$row_modalidad["codigomodalidadacademicasic"]);	
           $array_admnoing=$datos_estadistica->ObtenerDatosCuentaOperacionPrincipalAdmitidosQueNoIngresaron_modalidad_carrera('conteo',$codigoperiodo,153,$row_modalidad["codigomodalidadacademicasic"]);
           $array_admnomat=$datos_estadistica->seguimiento_inscripcionvsmatriculadosnuevos_modalidad_carrera($row_modalidad["codigomodalidadacademicasic"],$codigoperiodo,'conteo');
           /*Inicio ciclo que pinta los bloques de modalidad*/
	 ?>
	 <tr class="contentColumns row dataColumns">
              <td class="column category" colspan="4" style="width:100%;"><b><?php echo $row_modalidad['nombremodalidadacademicasic']; ?></b></td>       
         </tr>
	<?php 
	$query_carreras="select nombrecarrera, codigocarrera from carrera 
	where now() between fechainiciocarrera and fechavencimientocarrera
	and codigomodalidadacademicasic ='".$row_modalidad['codigomodalidadacademicasic']."' order by nombrecarrera";
	$carreras= $db->Execute($query_carreras);
	//$totalRows_carreras = $carreras->RecordCount();
	while($row_carreras = $carreras->FetchRow()){
	/*Inicio ciclo que pinta las carreras en la modalidad correspondiente*/       	    
	   //$total_admnomat=$datos_estadistica->seguimiento_inscripcionvsmatriculadosnuevos($row_carreras['codigocarrera'],'conteo');
	   //$array_admnoing=$datos_estadistica->ObtenerDatosCuentaOperacionPrincipalAdmitidosQueNoIngresaron($codigoperiodo,$row_carreras['codigocarrera'],153,'arreglo');
	   //$array_matnuevo=$datos_estadistica->obtener_datos_estudiantes_matriculados_nuevos($row_carreras['codigocarrera'],'arreglo');	   	   
	   //$total_admnomat=count($array_admnomat);
	   //$total_admnoing=count($array_admnoing);
	   //$total_matnuevo=count($array_matnuevo);	
           if(isset($array_admnomat[$row_carreras['codigocarrera']])&&$array_admnomat[$row_carreras['codigocarrera']]!=""){	
                $total_admnomat=$array_admnomat[$row_carreras['codigocarrera']];
	   }
	   else{
                $total_admnomat=0;
	   }
           if(isset($array_admnoing[$row_carreras['codigocarrera']])&&$array_admnoing[$row_carreras['codigocarrera']]!=""){	
                $total_admnoing=$array_admnoing[$row_carreras['codigocarrera']];
	   }
	   else{
                $total_admnoing=0;
	   }
           if(isset($matriculados[$row_carreras['codigocarrera']])&&$matriculados[$row_carreras['codigocarrera']]!=""){	
                $total_matnuevo=$matriculados[$row_carreras['codigocarrera']];
	   }
	   else{
                $total_matnuevo=0;
	   }
	   $total_admitidos=$total_admnomat+$total_admnoing+$total_matnuevo;	   
	   $indicedos=$total_matnuevo/$total_admitidos;	  
           if($total_admitidos>0){
            /*Acumuladores para los totales por modalidad academica*/	
            $array_datostotales['sumaadmitidos']=$total_admitidos+$array_datostotales['sumaadmitidos'];
            $array_datostotales['sumanuevos']=$total_matnuevo+$array_datostotales['sumanuevos'];
	?>
	<tr class="contentColumns" class="row">
              <td class="column" style="width:34%;"><?php echo $row_carreras['nombrecarrera']; ?></td>
	      <td class="column" style="text-align:center;width:22%;"><?php echo $total_admitidos; ?></td>
	      <td class="column" style="text-align:center;width:22%;"><?php echo $total_matnuevo; ?></td>              
              <td class="column" style="text-align:center;width:22%;"><?php echo number_format($indicedos*100,2)."%"; ?></td>    
	</tr>
<?php }//fin if
/*fin del ciclo de carrera*/
           }
	?>
             <tr class="dataColumns category">
                <th class="column total title" style="width:34%;"><b>Total <?php echo $row_modalidad['nombremodalidadacademicasic']; ?></b></th>
		<?php

		/*Ciclo para pintar el total de cada modalidad academica*/		
           	$indicetotaldos=$array_datostotales['sumanuevos']/$array_datostotales['sumaadmitidos'];           	
	   ?>	
              <th class="column total title" style="text-align:center;width:22%;"><b><?php echo $array_datostotales['sumaadmitidos']; ?></b></th>
              <th class="column total title" style="text-align:center;width:22%;"><b><?php echo $array_datostotales['sumanuevos']; ?></b></th>              
              <th class="column total title" style="text-align:center;width:22%;"><b><?php echo number_format($indicetotaldos*100,2)."%"; ?></b></th>              
	  <?php
		/*Acumuladores del total de todas las modalidades*/
		    
	        $array_totaltotales['admitidos']=$array_datostotales['sumaadmitidos']+$array_totaltotales['admitidos'];
	        $array_totaltotales['nuevos']=$array_datostotales['sumanuevos']+$array_totaltotales['nuevos'];	        
 
	   unset($array_datostotales)
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
                <?php 
	
		/*Ciclo total de totales*/                
                $indicetotaltotalesdos=$array_totaltotales['nuevos']/$array_totaltotales['admitidos'];                
           	?> 
                    <td style="text-align:center;width:22%;"><b><?php echo $array_totaltotales['admitidos']; ?></b></td>
                    <td style="text-align:center;width:22%;"><b><?php echo $array_totaltotales['nuevos']; ?></b></td>                    
                    <td style="text-align:center;width:22%;"><b><?php echo number_format($indicetotaltotalesdos*100,2)."%"; ?></b></td>                    
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

<form action="" method="post" id="absorcion" class="report">
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
		var valido= validateForm("#absorcion");
		if(valido){
			sendForm();
		}
	});
	function sendForm(){
            $('#tableDiv').html("");
            $("#loading").css("display","block");
		$.ajax({
				type: 'GET',
				url: './reportes/estudiantes/viewReporteIndiceAbsorcion.php',
				async: false,
				data: $('#absorcion').serialize(),                
				success:function(data){			
                                    $("#loading").css("display","none");		
					$('#tableDiv').html(data);					
					
				},
				error: function(data,error,errorThrown){alert(error + errorThrown);}
		});            
	}
</script>
