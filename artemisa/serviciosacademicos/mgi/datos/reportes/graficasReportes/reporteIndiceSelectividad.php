<?php require_once('../../../consulta/estadisticas/matriculasnew/funciones/obtener_datos.php');

function getValoresPeriodo($db,$codigoperiodo,$row){
    $modalidad= getModalidades($db);
    $totalRows_modalidad = $modalidad->RecordCount();
    $carrerasValores = array();
    $admitidosValores = array();
    $noValores = array();
    
    $cont = 0;
    //while($row = $modalidad->FetchRow()){
       $carreras = getCarrerasModalidadSIC($db,$row["codigomodalidadacademicasic"]);
       $totalRows_carreras = $carreras->RecordCount();
       while($row_carreras = $carreras->FetchRow()){
            $carrerasValores[$cont] = $row_carreras["nombrecarrera"];
           $datos_estadistica=new obtener_datos_matriculas($db,$codigoperiodo);
           $array_insc=$datos_estadistica->ObtenerDatosCuentaOperacionPrincipalIncluyeInscritosSinPago($codigoperiodo,$row_carreras['codigocarrera'],153,'arreglo');
           $array_admnomat=$datos_estadistica->seguimiento_inscripcionvsmatriculadosnuevos($row_carreras['codigocarrera'],'arreglo');
           $array_admnoing=$datos_estadistica->ObtenerDatosCuentaOperacionPrincipalAdmitidosQueNoIngresaron($codigoperiodo,$row_carreras['codigocarrera'],153,'arreglo');
           $array_matnuevo=$datos_estadistica->obtener_datos_estudiantes_matriculados_nuevos($row_carreras['codigocarrera'],'arreglo');
           $array_insnoeva=$datos_estadistica->ObtenerDatosCuentaOperacionPrincipalInscritosNoEvaluado($codigoperiodo,$row_carreras['codigocarrera'],153,'arreglo');
           
           $total_inscritos=count($array_insc);
           $total_admnomat=count($array_admnomat);
           $total_admnoing=count($array_admnoing);
           $total_matnuevo=count($array_matnuevo);
           $total_insnoeva=count($array_insnoeva);
           $total_admitidos=$total_admnomat+$total_admnoing+$total_matnuevo;
           $indiceuno=$total_admitidos/($total_inscritos-$total_insnoeva);
           $admitidosValores[$cont] = intval($indiceuno*100);
           if($admitidosValores[$cont]>100){
               $admitidosValores[$cont] = 100;
           }
           $noValores[$cont] = 100 - $admitidosValores[$cont];
           
           /*Acumuladores para los totales por modalidad academica*/
           $array_datostotales[0]['sumainscritos']=$total_inscritos+$array_datostotales[0]['sumainscritos'];
           $array_datostotales[0]['sumaadmitidos']=$total_admitidos+$array_datostotales[0]['sumaadmitidos'];
           $array_datostotales[0]['sumainnoeval']=$total_insnoeva+$array_datostotales[0]['sumainnoeval'];
       /*Fin del ciclo de carreras*/ 
            $cont = $cont + 1;
       }
       
       /*Ciclo para pintar el total de cada modalidad academica*/
        $indicetotaluno=$array_datostotales[0]['sumaadmitidos']/($array_datostotales[0]['sumainscritos']-$array_datostotales[0]['sumainnoeval']);
        $indicetotaldos=$array_datostotales[0]['sumanuevos']/$array_datostotales[0]['sumaadmitidos'];
        
              $array_datostotales[0]['sumainscritos']; 
              $array_datostotales[0]['sumaadmitidos']; 
              
              number_format($indicetotaluno,2); 

		/*Acumuladores del total de todas las modalidades*/
		$array_totaltotales[0]['inscritos']=$array_datostotales[0]['sumainscritos']+$array_totaltotales[0]['inscritos'];
	        $array_totaltotales[0]['admitidos']=$array_datostotales[0]['sumaadmitidos']+$array_totaltotales[0]['admitidos'];
	        $array_totaltotales[0]['innoeval']=$array_datostotales[0]['sumainnoeval']+ $array_totaltotales[0]['innoeval'];
	   
	   
             unset($array_datostotales); /*Fin del ciclo de modalidades*/ //}
             
        /*Ciclo total de totales*/
        $indicetotaltotalesuno=$array_totaltotales[0]['admitidos']/($array_totaltotales[0]['inscritos']-$array_totaltotales[0]['innoeval']);

        $carrerasValores[$cont] = "Total ".$codigoperiodo;
        $admitidosValores[$cont] = intval($indicetotaltotalesuno*100);
           if($admitidosValores[$cont]>100){
               $admitidosValores[$cont] = 100;
           }
           $noValores[$cont] = 100 - $admitidosValores[$cont];
        var_dump($noValores);
    return array("selectividad"=>array($carrerasValores,$admitidosValores,$noValores));
} 


function drawGraphic($db,$codigoperiodo,$reporte,$modalidad) { ?>

    <div class="grafica">
        <h4>Índice de Selectividad <?php echo $codigoperiodo; ?></h4>
        
        <?php
        $valores = getValoresPeriodo($db,$codigoperiodo,$modalidad);
        print_r($valores["selectividad"]);
        echo "<br/><br/>";
        /*var_dump(array(4,VOID,VOID,12,8,3));
        echo "<br/><br/>";
        var_dump($valores["selectividad"][2]);
        echo "<br/><br/>";
        var_dump($valores["selectividad"][0]);
        echo "<br/><br/>";*/

        /* Create and populate the pData object */
        $MyData = new pData();  
        $MyData->addPoints($valores["selectividad"][1],"Admitidos");
        $MyData->addPoints($valores["selectividad"][2],"No admitidos");
        $MyData->setAxisName(0,"%");
        $MyData->addPoints($valores["selectividad"][0],"Labels");
        $MyData->setSerieDescription("Labels","Carreras");
        $MyData->setAbscissa("Labels");

        /* Create the pChart object */
        $myPicture = new pImage(6200,500,$MyData);
       // $myPicture->drawGradientArea(0,0,6200,300,DIRECTION_VERTICAL,array("StartR"=>240,"StartG"=>240,"StartB"=>240,"EndR"=>180,"EndG"=>180,"EndB"=>180,"Alpha"=>100));
       // $myPicture->drawGradientArea(0,0,6200,300,DIRECTION_HORIZONTAL,array("StartR"=>240,"StartG"=>240,"StartB"=>240,"EndR"=>180,"EndG"=>180,"EndB"=>180,"Alpha"=>20));

        /* Set the default font properties */
        $myPicture->setFontProperties(array("FontName"=>"../../pChart/fonts/pf_arma_five.ttf","FontSize"=>6));

        /* Draw the scale and the chart */
        $myPicture->setGraphArea(60,20,6180,270);
        $myPicture->drawScale(array("DrawSubTicks"=>TRUE,'LabelRotation'=>45,"Mode"=>SCALE_MODE_ADDALL_START0));
        $myPicture->setShadow(FALSE);
        $myPicture->drawStackedBarChart(array("DisplayValues"=>TRUE,"DisplayColor"=>DISPLAY_AUTO,"Surrounding"=>-15,"InnerSurrounding"=>15));

        /* Write the chart legend */
        //$myPicture->drawLegend(5980,100,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_VERTICAL));
        $myPicture->drawLegend(480,5,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL));   
        /* Render the picture (choose the best way) */
        //$myPicture->autoOutput("imagenesGraficas/example.png");

        $myPicture->Render("imagenesGraficas/".$reporte["alias"]."/selectividad_".$codigoperiodo."_".$modalidad["codigomodalidadacademicasic"].".png"); ?>
        
        <img alt="Resultados selectividad" src="<?php echo "imagenesGraficas/".$reporte["alias"]."/selectividad_".$codigoperiodo."_".$modalidad["codigomodalidadacademicasic"].".png"; ?>" style="border: 1px solid gray;margin-right: 20px;"/>

    </div>


<?php }

$periodos = getPeriodos($db,$dates);
$i = 0;

    while($row_periodo = $periodos->FetchRow()){    
        $codigoperiodo = $row_periodo["codigoperiodo"];
		
		$modalidad= getModalidades($db);
		
		$cont = 0;
        while($row_modalidad = $modalidad->FetchRow()){
            drawGraphic($db,$row_periodo["codigoperiodo"],$reporte,$row_modalidad); ?>
            <div class="grafica">
            <h4>Índice de Selectividad <?php echo $codigoperiodo; ?></h4>
            <img alt="Resultados selectividad" src="<?php echo "imagenesGraficas/". $reporte["alias"] ."/selectividad_".$codigoperiodo."_".$row_modalidad["codigomodalidadacademicasic"].".png"; ?>" style="border: 1px solid gray;margin-right: 20px;"/>
            </div>
        <?php   } $i = $i + 1;
     }

?>

<div id="prueba">
</div>

<script type="text/javascript">
     $(document).ready(function() {
        
        //$('#prueba').load('./graficasReportes/_tempReporteIndicesEstudiantes.php?id=row_<?php //echo $reporte["idsiq_reporte"]; ?>&codigoperiodo=20111')
     
        //$('#prueba').load('./graficasReportes/<?php //echo $reporte["archivoReporte"]; ?>.php?id=row_<?php //echo $reporte["idsiq_reporte"]; ?>&codigoperiodo=20111');
    });
</script>