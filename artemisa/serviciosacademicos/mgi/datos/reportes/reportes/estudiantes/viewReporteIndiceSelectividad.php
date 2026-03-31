<?php


if($_GET['semestre']) {

require_once("../../../templates/template.php");
$db = getBD();
$codigoperiodo = $_GET['semestre'];
//$utils = new Utils_datos();
//$start1 = microtime(true);
require_once('../../../../../consulta/estadisticas/matriculasnew/funciones/obtener_datos.php');
/* Query rango de Periodo */
 $query_nomcarrera = "select * from periodo where codigoperiodo ='".$_GET['semestre']."'";
                $nomcarrera= $db->Execute($query_nomcarrera);
                $rowPeriodo = $nomcarrera->FetchRow();
                //$totalRows_nomcarrera = $nomcarrera->RecordCount();

/* Query Modalidad academica de la tabla modalidadacademicasic para sacar la asociacion como esta en el documento */
if($_GET['modalidad']!='todos'){
$query_modalidad="select nombremodalidadacademicasic, codigomodalidadacademicasic from modalidadacademicasic where codigomodalidadacademicasic ='".$_GET['modalidad']."'";
}
else{
$query_modalidad="select nombremodalidadacademicasic, codigomodalidadacademicasic from modalidadacademicasic where codigomodalidadacademicasic not in('000',100,101,400)";
}
$modalidad= $db->Execute($query_modalidad);
//$totalRows_modalidad = $modalidad->RecordCount();
$datos_estadistica=new obtener_datos_matriculas($db,$codigoperiodo);
?>
<table align="left" id="estructuraReporte" class="previewReport" style="text-align:left;clear:both;margin: 10px 0px;">
        <thead>            
             <tr class="dataColumns">
                 
                    <th class="column" rowspan="2" style="width:30%;"><span>PROGRAMA</span></th>
		     <?php
			/*Recorrido de Consulta para imprimir los periodos*/
			$anioperiodo=substr($codigoperiodo,-1);					
			if($anioperiodo==1)
			$anioperiodo='I';
			else
			$anioperiodo='II';
			$anio=substr($codigoperiodo, 0, -1);			
			?>
			<th class="column" colspan="5"><?php echo " AÑO ".$anio." - PERIODO ".$anioperiodo; ?></span></th>
             </tr>
	     <tr class="dataColumns">
		<th class="column" style="width:14%;"><span>NÚMERO DE ADMITIDOS</span></th>
		<th class="column" style="width:14%;"><span>NÚMERO DE INSCRITOS</span></th>
		<th class="column" style="width:14%;"><span>INDICE DE SELECTIVIDAD (CNA)</span></th>
		<th class="column" style="width:14%;"><span>NÚMERO DE INSCRITOS EVALUADOS</span></th>
		<th class="column" style="width:14%;"><span>INDICE DE SELECTIVIDAD (UNIVERSIDAD)</span></th>
	    </tr>
        </thead>
        <tbody>
	<?php while($row_modalidad = $modalidad->FetchRow()){
	/*Inicio ciclo que pinta los bloques de modalidad*/
            $array_admnomat=$datos_estadistica->seguimiento_inscripcionvsmatriculadosnuevos_modalidad_carrera($row_modalidad["codigomodalidadacademicasic"],$codigoperiodo,'conteo');
           $array_admnoing=$datos_estadistica->ObtenerDatosCuentaOperacionPrincipalAdmitidosQueNoIngresaron_modalidad_carrera('conteo',$codigoperiodo,153,$row_modalidad["codigomodalidadacademicasic"]);
           $matriculados=$datos_estadistica->obtener_datos_estudiantes_matriculados_nuevos_modalidad_carrera('conteo',$row_modalidad["codigomodalidadacademicasic"]);	
          
	 ?>
	 <tr class="contentColumns" class="row">
              <td class="column" colspan="6" style="width:100%;"><b><?php echo $row_modalidad['nombremodalidadacademicasic']; ?></b></td>       
         </tr>
	<?php 
	$query_carreras="select nombrecarrera, codigocarrera from carrera 
	where ('".$rowPeriodo["fechavencimientoperiodo"]."' between fechainiciocarrera and fechavencimientocarrera 
            OR '".$rowPeriodo["fechainicioperiodo"]."' between fechainiciocarrera and fechavencimientocarrera)
	and codigomodalidadacademicasic ='".$row_modalidad['codigomodalidadacademicasic']."' order by nombrecarrera";
       
	$carreras= $db->Execute($query_carreras);
	$totalRows_carreras = $carreras->RecordCount();
	
	while($row_carreras = $carreras->FetchRow()){
	/*Inicio ciclo que pinta las carreras en la modalidad correspondiente*/
	?>
	<tr class="contentColumns" class="row">
              <td class="column" style="width:30%;"><?php echo $row_carreras['nombrecarrera']; ?></td>
         	
	<?php 	
	   /*ciclo para pintar los resultados de cadad carrera con respecto al item solicitado
	   En esta parte del codigo se utiliza la funcion de Obtener datos que es la misma que se utiliza en las estadisticas	
	  */
	   $array_insc=$datos_estadistica->ObtenerDatosCuentaOperacionPrincipalIncluyeInscritosSinPago($codigoperiodo,$row_carreras['codigocarrera'],153,'arreglo');
	   //$array_admnomat=$datos_estadistica->seguimiento_inscripcionvsmatriculadosnuevos($row_carreras['codigocarrera'],'arreglo');
	   //$array_admnoing=$datos_estadistica->ObtenerDatosCuentaOperacionPrincipalAdmitidosQueNoIngresaron($codigoperiodo,$row_carreras['codigocarrera'],153,'arreglo');
	   //$array_matnuevo=$datos_estadistica->obtener_datos_estudiantes_matriculados_nuevos($row_carreras['codigocarrera'],'arreglo');
	   $array_insnoeva=$datos_estadistica->ObtenerDatosCuentaOperacionPrincipalInscritosNoEvaluado($codigoperiodo,$row_carreras['codigocarrera'],153,'arreglo');	   
	   $total_inscritos=count($array_insc);
	   //$total_admnomat=count($array_admnomat);
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
	   $total_insnoeva=count($array_insnoeva);
	   $total_inseva=$total_inscritos-$total_insnoeva;
	   $total_admitidos=$total_admnomat+$total_admnoing+$total_matnuevo;
	   $indiceuno=$total_admitidos/($total_inseva);
	   $indicecna=$total_admitidos/($total_inscritos);
	
	?>
	      <td class="column" style="text-align:center;width:14%;"><?php echo $total_admitidos; ?></td>
	      <td class="column" style="text-align:center;width:14%;"><?php echo $total_inscritos; ?></td>
	      <td class="column" style="text-align:center;width:14%;"><?php echo number_format($indicecna*100,2)."%"; ?></td>
	      <td class="column" style="text-align:center;width:14%;"><?php echo $total_inseva; ?></td>
              <td class="column" style="text-align:center;width:14%;"><?php echo number_format($indiceuno*100,2)."%"; ?></td>              
	<?php 
	/*Acumuladores para los totales por modalidad academica*/
	$array_datostotales['sumainscritos']=$total_inscritos+$array_datostotales['sumainscritos'];
	$array_datostotales['sumaadmitidos']=$total_admitidos+$array_datostotales['sumaadmitidos'];
	$array_datostotales['sumanuevos']=$total_matnuevo+$array_datostotales['sumanuevos'];
	$array_datostotales['sumaineval']=$total_inseva+$array_datostotales['sumaineval'];	
	
	?>
	</tr>
<?php
/*fin del ciclo de carrera*/
	}
	?>
         <tr class="dataColumns category">
                <th class="column total title" style="text-align:center;width:30%;"><b>Total <?php echo $row_modalidad['nombremodalidadacademicasic']; ?></b></th>
		<?php
		/*Ciclo para pintar el total de cada modalidad academica*/
		$indicetotaluno=$array_datostotales['sumaadmitidos']/($array_datostotales['sumaineval']);           	
		$indicetotalcna=$array_datostotales['sumaadmitidos']/($array_datostotales['sumainscritos']);
	   ?>	
              <th class="column total title" style="text-align:center;width:14%;"><b><?php echo $array_datostotales['sumaadmitidos']; ?></b></th>
              <th class="column total title" style="text-align:center;width:14%;"><b><?php echo $array_datostotales['sumainscritos']; ?></b></th>
              <th class="column total title" style="text-align:center;width:14%;"><b><?php echo number_format($indicetotalcna*100,2)."%"; ?></b></th>
              <th class="column total title" style="text-align:center;width:14%;"><b><?php echo $array_datostotales['sumaineval']; ?></b></th>
              <th class="column total title" style="text-align:center;width:14%;"><b><?php echo number_format($indicetotaluno*100,2)."%"; ?></b></th>              
	  <?php
		/*Acumuladores del total de todas las modalidades*/
		    $array_totaltotales['inscritos']=$array_datostotales['sumainscritos']+$array_totaltotales['inscritos'];
	        $array_totaltotales['admitidos']=$array_datostotales['sumaadmitidos']+$array_totaltotales['admitidos'];
	        $array_totaltotales['nuevos']=$array_datostotales['sumanuevos']+$array_totaltotales['nuevos'];
	        $array_totaltotales['ineval']=$array_datostotales['sumaineval']+ $array_totaltotales['ineval'];	        
 
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
                <td class="column total title" style="text-align:center;width:30%;"><b>Total</b></td>                
                <?php 
		/*Ciclo total de totales*/
                $indicetotaltotalesuno=$array_totaltotales['admitidos']/($array_totaltotales['ineval']);
                $indicetotaltotalescna=$array_totaltotales['admitidos']/($array_totaltotales['inscritos']);                
           	?> 
                    <td style="text-align:center;width:14%;"><?php echo $array_totaltotales['admitidos']; ?></td>
                    <td style="text-align:center;width:14%;"><?php echo $array_totaltotales['inscritos']; ?></td>
                    <td style="text-align:center;width:14%;"><?php echo number_format($indicetotaltotalescna*100,2)."%"; ?></td>                    
                    <td style="text-align:center;width:14%;"><?php echo $array_totaltotales['ineval']; ?></td>
                    <td style="text-align:center;width:14%;"><?php echo number_format($indicetotaltotalesuno*100,2)."%"; ?></td>     
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



<form action="" method="post" id="selectividad" class="report">
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
		var valido= validateForm("#selectividad");
		if(valido){
			sendForm();
		}
	});
	function sendForm(){
            $('#tableDiv').html("");
            $("#loading").css("display","block");
		$.ajax({
				type: 'GET',
				url: './reportes/estudiantes/viewReporteIndiceSelectividad.php',
				async: false,
				data: $('#selectividad').serialize(),                
				success:function(data){		
                                    $("#loading").css("display","none");			
					$('#tableDiv').html(data);					
					
				},
				error: function(data,error,errorThrown){alert(error + errorThrown);}
		});            
	}
</script>

