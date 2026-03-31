<?php

require_once('../../../consulta/estadisticas/matriculasnew/funciones/obtener_datos.php');

function getPeriodos($db,$dates){
    $query="select codigoperiodo from periodo where fechainicioperiodo>='".$dates["fecha_inicial"]."' AND fechavencimientoperiodo<='".$dates["fecha_final"]."' ORDER BY codigoperiodo ASC";
    return $db->Execute($query);
}

function getPeriodosArray($db,$dates){
    $query="select codigoperiodo from periodo where fechainicioperiodo>='".$dates["fecha_inicial"]."' AND fechavencimientoperiodo<='".$dates["fecha_final"]."' ORDER BY codigoperiodo ASC";
    return $db->GetAll($query);
}

function getModalidades($db){
    $query_modalidad="select nombremodalidadacademicasic, codigomodalidadacademicasic from modalidadacademicasic where codigomodalidadacademicasic not in('000',100,101,400) ";
    return $db->Execute($query_modalidad);
}

function getCarrerasModalidadSIC($db,$modalidad){
     $query_nomcarrera = "select nombrecarrera, codigocarrera from carrera 
	where now() between fechainiciocarrera and fechavencimientocarrera
	and codigomodalidadacademicasic ='".$modalidad."' ORDER BY nombrecarrera ASC"; 
     return $db->Execute($query_nomcarrera);     
}

function generarReportePeriodo($db,$codigoperiodo){ 
    $modalidad= getModalidades($db);
    $totalRows_modalidad = $modalidad->RecordCount();
    ?>
    <div class="tableDiv">
    <table align="left" id="estructuraReporte" class="previewReport" style="text-align:left;clear:both;margin: 10px 0px;font-size:0.8em;" width="70%" >
        <thead>            
             <tr class="dataColumns">
                 <th class="column" rowspan="2"><span>PROGRAMA</span></th>
			<th class="column" colspan="8"><span><?php echo $codigoperiodo; ?></span></th>
             </tr>
             <tr class="dataColumns">
		<th class="column"><span>NÚMERO DE INSCRITOS</span></th>
		<th class="column"><span>NÚMERO DE ADMITIDOS</span></th>
		<th class="column"><span>NÚMERO DE MATRICULADOS NUEVOS</span></th>
		<th class="column"><span>NÚMERO DE ESTUDIANTES BECADOS</span></th>
		<th class="column"><span>NÚMERO DE CUPOS</span></th>
		<th class="column"><span>1.INDICE DE SELECTIVIDAD</span></th>
		<th class="column"><span>2.INDICE DE ABSORCIÓN</span></th>
		<th class="column"><span>3.INDICE DE SELECCIÓN</span></th>
	    </tr>
        </thead>
        <tbody>
            <?php while($row = $modalidad->FetchRow()){ ?>
            <tr class="row" id="contentColumns">
                <th class="column category" colspan="9"><?php echo $row['nombremodalidadacademicasic']; ?></th>     
            </tr>
            <?php $carreras = getCarrerasModalidadSIC($db,$row["codigomodalidadacademicasic"]);
                $totalRows_carreras = $carreras->RecordCount();
                while($row_carreras = $carreras->FetchRow()){ ?>
            <tr class="contentColumns" class="row">
              <td class="column"><?php echo $row_carreras['nombrecarrera']; ?></td>
	<?php /*Inicio ciclo que pinta las carreras en la modalidad correspondiente*/
                
                    /*ciclo para pintar los resultados de cadad carrera con respecto al item solicitado
                    En esta parte del codigo se utiliza la funcion de Obtener datos que es la misma que se utiliza en las estadisticas	
                    */
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
                        <td class="column" style="text-align:center"><?php echo $total_inscritos; ?></td>
                        <td class="column" style="text-align:center"><?php echo $total_admitidos; ?></td>
                        <td class="column" style="text-align:center"><?php echo $total_matnuevo; ?></td>
                        <td class="column" style="text-align:center"><?php echo ""; ?></td>
                        <td class="column" style="text-align:center"><?php echo $totalcupo; ?></td>
                        <td class="column" style="text-align:center"><?php echo number_format($indiceuno,2); ?></td>
                        <td class="column" style="text-align:center"><?php echo number_format($indicedos,2); ?></td>
                        <td class="column" style="text-align:center"><?php echo number_format($indicetres,2); ?></td>  	
                    <?php 
                    /*Acumuladores para los totales por modalidad academica*/
                    $array_datostotales[0]['sumainscritos']=$total_inscritos+$array_datostotales[0]['sumainscritos'];
                    $array_datostotales[0]['sumaadmitidos']=$total_admitidos+$array_datostotales[0]['sumaadmitidos'];
                    $array_datostotales[0]['sumanuevos']=$total_matnuevo+$array_datostotales[0]['sumanuevos'];
                    $array_datostotales[0]['sumainnoeval']=$total_insnoeva+$array_datostotales[0]['sumainnoeval'];
                    $array_datostotales[0]['sumacupo']=$totalcupo+$array_datostotales[0]['sumacupo'];
 ?> 
             
	<?php
	/*Fin del ciclo de carreras*/ 
                }
                ?>
             </tr> 
             <tr class="dataColumns">
                <th class="column total title">Total <?php echo $row['nombremodalidadacademicasic']; ?></th>
		<?php
          
		/*Ciclo para pintar el total de cada modalidad academica*/
		$indicetotaluno=$array_datostotales[0]['sumaadmitidos']/($array_datostotales[0]['sumainscritos']-$array_datostotales[0]['sumainnoeval']);
           	$indicetotaldos=$array_datostotales[0]['sumanuevos']/$array_datostotales[0]['sumaadmitidos'];
           	$indicetotaltres=$array_datostotales[0]['sumanuevos']/$array_datostotales[0]['sumacupo'];
	   ?>	
              <th class="column total title" style="text-align:center"><?php echo $array_datostotales[0]['sumainscritos']; ?></th>
              <th class="column total title" style="text-align:center"><?php echo $array_datostotales[0]['sumaadmitidos']; ?></th>
              <th class="column total title" style="text-align:center"><?php echo $array_datostotales[0]['sumanuevos']; ?></th>
              <th class="column total title" style="text-align:center"><?php echo ""; ?></td>
              <th class="column total title" style="text-align:center"><?php echo $array_datostotales[0]['sumacupo']; ?></th>
              <th class="column total title" style="text-align:center"><?php echo number_format($indicetotaluno,2); ?></th>
              <th class="column total title" style="text-align:center"><?php echo number_format($indicetotaldos,2); ?></th>
              <th class="column total title" style="text-align:center"><?php echo number_format($indicetotaltres,2); ?></th>
	  <?php
		/*Acumuladores del total de todas las modalidades*/
		$array_totaltotales[0]['inscritos']=$array_datostotales[0]['sumainscritos']+$array_totaltotales[0]['inscritos'];
	        $array_totaltotales[0]['admitidos']=$array_datostotales[0]['sumaadmitidos']+$array_totaltotales[0]['admitidos'];
	        $array_totaltotales[0]['nuevos']=$array_datostotales[0]['sumanuevos']+$array_totaltotales[0]['nuevos'];
	        $array_totaltotales[0]['innoeval']=$array_datostotales[0]['sumainnoeval']+ $array_totaltotales[0]['innoeval'];
	        $array_totaltotales[0]['cupo']=$array_datostotales[0]['sumacupo']+$array_totaltotales[0]['cupo']; 
	   
	   
	  ?>
            </tr>
             <?php unset($array_datostotales); /*Fin del ciclo de modalidades*/  } ?>
        </tbody>  
        <tfoot>
             <tr id="totalColumns">
                <td class="column total title">Total</td>                
                <?php 
		/*Ciclo total de totales*/
                $indicetotaltotalesuno=$array_totaltotales[0]['admitidos']/($array_totaltotales[0]['inscritos']-$array_totaltotales[0]['innoeval']);
                $indicetotaltotalesdos=$array_totaltotales[0]['nuevos']/$array_totaltotales[0]['admitidos'];
                $indicetotaltotalestres=$array_totaltotales[0]['nuevos']/$array_totaltotales[0]['cupo'];
           	?> 
                    <td style="text-align:center"><?php echo $array_totaltotales[0]['inscritos']; ?></td>
                    <td style="text-align:center"><?php echo $array_totaltotales[0]['admitidos']; ?></td>
                    <td style="text-align:center"><?php echo $array_totaltotales[0]['nuevos']; ?></td>
                    <td style="text-align:center"><?php echo ""; ?></td>
                    <td style="text-align:center"><?php echo $array_totaltotales[0]['cupo']; ?></td>
                    <td style="text-align:center"><?php echo number_format($indicetotaltotalesuno,2); ?></td>
                    <td style="text-align:center"><?php echo number_format($indicetotaltotalesdos,2); ?></td>
                    <td style="text-align:center"><?php echo number_format($indicetotaltotalestres,2); ?></td>
            </tr>
        </tfoot>
    </table>
    </div>
<?php }

$periodos = getPeriodos($db,$dates);
$i = 0;
if($codigoperiodoPDF==null){
    while($row_periodo = $periodos->FetchRow()){    
        generarReportePeriodo($db,$row_periodo["codigoperiodo"]);
        $i = $i + 1;
    }
} else {
    generarReportePeriodo($db,$codigoperiodoPDF);
}

?>
