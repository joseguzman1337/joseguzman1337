<?php

/*echo "<pre>";
print_r($_GET);
echo "</pre>";*/


$codigoperiodoini=$dates["periodo_inicial"];
$codigoperiodofin=$dates["periodo_final"];


require_once('../../../consulta/estadisticas/matriculasnew/funciones/obtener_datos.php');
/* Query rango de Periodo */
 $query_nomcarrera = "select codigoperiodo from periodo where codigoperiodo between '".$codigoperiodoini."' and '".$codigoperiodofin."'";
                $nomcarrera= $db->Execute($query_nomcarrera);
                $totalRows_nomcarrera = $nomcarrera->RecordCount();

/* Query Modalidad academica de la tabla modalidadacademicasic para sacar la asociacion como esta en el documento */
$query_modalidad="select nombremodalidadacademicasic, codigomodalidadacademicasic from modalidadacademicasic where codigomodalidadacademicasic not in('000',100,101,400)";
$modalidad= $db->Execute($query_modalidad);
$totalRows_modalidad = $modalidad->RecordCount();
?>

<table align="left" id="estructuraReporte" class="previewReport" style="text-align:left;clear:both;margin: 10px 0px;">
        <thead>            
             <tr class="dataColumns">
                 
                    <th class="column" rowspan="2"><span>PROGRAMA</span></th>
		     <?php
			/*Recorrido de Consulta para imprimir los periodos*/
			$cue=1; 
			while($row_nomcarrera = $nomcarrera->FetchRow()){ 
			$array_periodo[$cue]=$row_nomcarrera['codigoperiodo'];
			$anioperiodo=substr($row_nomcarrera['codigoperiodo'],-1);			
			if($anioperiodo==1)
			$anioperiodo='I';
			else
			$anioperiodo='II';
			$anio=substr($row_nomcarrera['codigoperiodo'], 0, -1);			
			?>
			<th class="column" colspan="8"><?php echo "AÑO - PERIODO ".$anioperiodo." - AÑO ".$anio; ?></span></th>
			 <?php
			$cue++;
			 } ?>
             </tr>
	     <tr class="dataColumns">
		<?php for($i=1; $i<= $totalRows_nomcarrera; $i++){
		/*ciclo para pintar los nombres de los items*/
		 ?>
		<th class="column"><span>NÚMERO DE INSCRITOS</span></th>
		<th class="column"><span>NÚMERO DE ADMITIDOS</span></th>
		<th class="column"><span>NÚMERO DE MATRICULADOS NUEVOS</span></th>
		<th class="column"><span>NÚMERO DE ESTUDIANTES BECADOS</span></th>
		<th class="column"><span>NÚMERO DE CUPOS</span></th>
		<th class="column"><span>1.INDICE DE SELECTIVIDAD</span></th>
		<th class="column"><span>2.INDICE DE ABSORCIÓN</span></th>
		<th class="column"><span>3.INDICE DE SELECCIÓN</span></th>
		<?php	
		}
		 ?>
	    </tr>
        </thead>
        <tbody>
	<?php while($row_modalidad = $modalidad->FetchRow()){
	/*Inicio ciclo que pinta los bloques de modalidad*/
	 ?>
	 <tr class="contentColumns" class="row">
              <td class="column" colspan="50"><?php echo $row_modalidad['nombremodalidadacademicasic']; ?></td>       
         </tr>
	<?php 
	$query_carreras="select nombrecarrera, codigocarrera from carrera 
	where now() between fechainiciocarrera and fechavencimientocarrera
	and codigomodalidadacademicasic ='".$row_modalidad['codigomodalidadacademicasic']."'";
	$carreras= $db->Execute($query_carreras);
	$totalRows_carreras = $carreras->RecordCount();
	
	while($row_carreras = $carreras->FetchRow()){
	/*Inicio ciclo que pinta las carreras en la modalidad correspondiente*/
	?>
	<tr class="contentColumns" class="row">
              <td class="column"><?php echo $row_carreras['nombrecarrera']; ?></td>
         	
	<?php 	
	   for($j=1; $j<=$totalRows_nomcarrera; $j++){
	   /*ciclo para pintar los resultados de cadad carrera con respecto al item solicitado
	   En esta parte del codigo se utiliza la funcion de Obtener datos que es la misma que se utiliza en las estadisticas	
	  */
	   $codigoperiodo=$array_periodo[$j]; 
    	   $datos_estadistica=new obtener_datos_matriculas($db,$codigoperiodo);
	   $array_insc=$datos_estadistica->ObtenerDatosCuentaOperacionPrincipalIncluyeInscritosSinPago($codigoperiodo,$row_carreras['codigocarrera'],153,'arreglo');
	   $array_admnomat=$datos_estadistica->seguimiento_inscripcionvsmatriculadosnuevos($row_carreras['codigocarrera'],'arreglo');
	   $array_admnoing=$datos_estadistica->ObtenerDatosCuentaOperacionPrincipalAdmitidosQueNoIngresaron($codigoperiodo,$row_carreras['codigocarrera'],153,'arreglo');
	   $array_matnuevo=$datos_estadistica->obtener_datos_estudiantes_matriculados_nuevos($row_carreras['codigocarrera'],'arreglo');
	   $array_insnoeva=$datos_estadistica->ObtenerDatosCuentaOperacionPrincipalInscritosNoEvaluado($codigoperiodo,$row_carreras['codigocarrera'],153,'arreglo');
	   $query_cupos="SELECT cupo from siq_huerfana_cuposProgramaAcademico where codigocarrera='".$row_carreras['codigocarrera']."' and codigoperiodo='$codigoperiodo'";
           $cupos= $db->Execute($query_cupos);
           $totalRows_cupos = $cupos->RecordCount();
	   $row_cupos = $cupos->FetchRow();
	   if($row_cupos['cupo']!=""){	
	   $totalcupo=$row_cupos['cupo'];
	   }
	   else{
	   $totalcupo=0;
	   }		
	   $total_inscritos=count($array_insc);
	   $total_admnomat=count($array_admnomat);
	   $total_admnoing=count($array_admnoing);
	   $total_matnuevo=count($array_matnuevo);
	   $total_insnoeva=count($array_insnoeva);
	   $total_admitidos=$total_admnomat+$total_admnoing+$total_matnuevo;
	   $indiceuno=$total_admitidos/($total_inscritos-$total_insnoeva);
	   $indicedos=$total_matnuevo/$total_admitidos;
	   $indicetres=$total_matnuevo/$totalcupo;
	
	?>
	      <td class="column"><?php echo $total_inscritos; ?></td>
	      <td class="column"><?php echo $total_admitidos; ?></td>
	      <td class="column"><?php echo $total_matnuevo; ?></td>
              <td class="column"><?php echo ""; ?></td>
              <td class="column"><?php echo $totalcupo; ?></td>
              <td class="column"><?php echo number_format($indiceuno,2); ?></td>
              <td class="column"><?php echo number_format($indicedos,2); ?></td>
              <td class="column"><?php echo number_format($indicetres,2); ?></td>  	
	<?php 
	/*Acumuladores para los totales por modalidad academica*/
	$array_datostotales[$j]['sumainscritos']=$total_inscritos+$array_datostotales[$j]['sumainscritos'];
	$array_datostotales[$j]['sumaadmitidos']=$total_admitidos+$array_datostotales[$j]['sumaadmitidos'];
	$array_datostotales[$j]['sumanuevos']=$total_matnuevo+$array_datostotales[$j]['sumanuevos'];
	$array_datostotales[$j]['sumainnoeval']=$total_insnoeva+$array_datostotales[$j]['sumainnoeval'];
	$array_datostotales[$j]['sumacupo']=$totalcupo+$array_datostotales[$j]['sumacupo'];
	
	}
	?>
	</tr>
<?php
/*fin del ciclo de carrera*/
	}
	?>
	<thead>
             <tr class="totalColumns">
                <td class="column total title">Total <?php echo $row_modalidad['nombremodalidadacademicasic']; ?></td>
		<?php
           for($k=1; $k<=$totalRows_nomcarrera; $k++){ 
		/*Ciclo para pintar el total de cada modalidad academica*/
		$indicetotaluno=$array_datostotales[$k]['sumaadmitidos']/($array_datostotales[$k]['sumainscritos']-$array_datostotales[$k]['sumainnoeval']);
           	$indicetotaldos=$array_datostotales[$k]['sumanuevos']/$array_datostotales[$k]['sumaadmitidos'];
           	$indicetotaltres=$array_datostotales[$k]['sumanuevos']/$array_datostotales[$k]['sumacupo'];
	   ?>	
              <td class="column total title" style="text-align:center"><?php echo $array_datostotales[$k]['sumainscritos']; ?></td>
              <td class="column total title" style="text-align:center"><?php echo $array_datostotales[$k]['sumaadmitidos']; ?></td>
              <td class="column total title" style="text-align:center"><?php echo $array_datostotales[$k]['sumanuevos']; ?></td>
              <td class="column total title" style="text-align:center"><?php echo ""; ?></td>
              <td class="column total title" style="text-align:center"><?php echo $array_datostotales[$k]['sumacupo']; ?></td>
              <td class="column total title" style="text-align:center"><?php echo number_format($indicetotaluno,2); ?></td>
              <td class="column total title" style="text-align:center"><?php echo number_format($indicetotaldos,2); ?></td>
              <td class="column total title" style="text-align:center"><?php echo number_format($indicetotaltres,2); ?></td>
	  <?php
		/*Acumuladores del total de todas las modalidades*/
		    $array_totaltotales[$k]['inscritos']=$array_datostotales[$k]['sumainscritos']+$array_totaltotales[$k]['inscritos'];
	        $array_totaltotales[$k]['admitidos']=$array_datostotales[$k]['sumaadmitidos']+$array_totaltotales[$k]['admitidos'];
	        $array_totaltotales[$k]['nuevos']=$array_datostotales[$k]['sumanuevos']+$array_totaltotales[$k]['nuevos'];
	        $array_totaltotales[$k]['innoeval']=$array_datostotales[$k]['sumainnoeval']+ $array_totaltotales[$k]['innoeval'];
	        $array_totaltotales[$k]['cupo']=$array_datostotales[$k]['sumacupo']+$array_totaltotales[$k]['cupo'];
 
	   }
	   unset($array_datostotales)
	  ?>
            </tr>
        </thead>
	<?php
	/*Fin del ciclo de modalidades*/ 
	 }
	 ?>
        </tbody>        
	<tfoot>
             <tr class="totalColumns">
                <td class="column total title">Total</td>                
                <?php 
		for($l=1; $l<=$totalRows_nomcarrera; $l++){
		/*Ciclo total de totales*/
                $indicetotaltotalesuno=$array_totaltotales[$l]['admitidos']/($array_totaltotales[$l]['inscritos']-$array_totaltotales[$l]['innoeval']);
                $indicetotaltotalesdos=$array_totaltotales[$l]['nuevos']/$array_totaltotales[$l]['admitidos'];
                $indicetotaltotalestres=$array_totaltotales[$l]['nuevos']/$array_totaltotales[$l]['cupo'];
           	?> 
                    <td style="text-align:center"><?php echo $array_totaltotales[$l]['inscritos']; ?></td>
                    <td style="text-align:center"><?php echo $array_totaltotales[$l]['admitidos']; ?></td>
                    <td style="text-align:center"><?php echo $array_totaltotales[$l]['nuevos']; ?></td>
                    <td style="text-align:center"><?php echo ""; ?></td>
                    <td style="text-align:center"><?php echo $array_totaltotales[$l]['cupo']; ?></td>
                    <td style="text-align:center"><?php echo number_format($indicetotaltotalesuno,2); ?></td>
                    <td style="text-align:center"><?php echo number_format($indicetotaltotalesdos,2); ?></td>
                    <td style="text-align:center"><?php echo number_format($indicetotaltotalestres,2); ?></td>
		<?php 
		}
		?>
            </tr>
        </tfoot>
    </table>
