<?php require_once('../../../consulta/estadisticas/matriculasnew/funciones/obtener_datos.php');

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

function getValoresPeriodo($db,$codigoperiodo){
    $modalidad= getModalidades($db);
    $totalRows_modalidad = $modalidad->RecordCount();
    $carrerasValores = array();
    $admitidosValores = array();
    $noValores = array();
    
    $cont = 0;
    while($row = $modalidad->FetchRow()){
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
           $admitidosValores[$cont] = intval($indiceuno*100);
           if($admitidosValores[$cont]>100){
               $admitidosValores[$cont] = 100;
           }
           $noValores[$cont] = 100 - $admitidosValores[$cont];
           $indicedos=$total_matnuevo/$total_admitidos;
           $absorcionValores[$cont] = intval($indiceuno*100);
           if($absorcionValores[$cont]>100){
               $absorcionValores[$cont] = 100;
           }
           $noAbsorcionValores[$cont] = 100 - $absorcionValores[$cont];
           $indicetres=$total_matnuevo/$totalcupo;    
           $seleccionValores[$cont] = intval($indiceuno*100);
           if($seleccionValores[$cont]>100){
               $seleccionValores[$cont] = 100;
           }
           $noSeleccionValores[$cont] = 100 - $seleccionValores[$cont];
           
           /*Acumuladores para los totales por modalidad academica*/
           $array_datostotales[0]['sumainscritos']=$total_inscritos+$array_datostotales[0]['sumainscritos'];
           $array_datostotales[0]['sumaadmitidos']=$total_admitidos+$array_datostotales[0]['sumaadmitidos'];
           $array_datostotales[0]['sumanuevos']=$total_matnuevo+$array_datostotales[0]['sumanuevos'];
           $array_datostotales[0]['sumainnoeval']=$total_insnoeva+$array_datostotales[0]['sumainnoeval'];
           $array_datostotales[0]['sumacupo']=$totalcupo+$array_datostotales[0]['sumacupo'];
       /*Fin del ciclo de carreras*/ 
            $cont = $cont + 1;
       }
       
       /*Ciclo para pintar el total de cada modalidad academica*/
        $indicetotaluno=$array_datostotales[0]['sumaadmitidos']/($array_datostotales[0]['sumainscritos']-$array_datostotales[0]['sumainnoeval']);
        $indicetotaldos=$array_datostotales[0]['sumanuevos']/$array_datostotales[0]['sumaadmitidos'];
        $indicetotaltres=$array_datostotales[0]['sumanuevos']/$array_datostotales[0]['sumacupo'];
        
              $array_datostotales[0]['sumainscritos']; 
              $array_datostotales[0]['sumaadmitidos']; 
              $array_datostotales[0]['sumanuevos']; 
              
              $array_datostotales[0]['sumacupo'];
              number_format($indicetotaluno,2); 
              number_format($indicetotaldos,2); 
              number_format($indicetotaltres,2);

		/*Acumuladores del total de todas las modalidades*/
		$array_totaltotales[0]['inscritos']=$array_datostotales[0]['sumainscritos']+$array_totaltotales[0]['inscritos'];
	        $array_totaltotales[0]['admitidos']=$array_datostotales[0]['sumaadmitidos']+$array_totaltotales[0]['admitidos'];
	        $array_totaltotales[0]['nuevos']=$array_datostotales[0]['sumanuevos']+$array_totaltotales[0]['nuevos'];
	        $array_totaltotales[0]['innoeval']=$array_datostotales[0]['sumainnoeval']+ $array_totaltotales[0]['innoeval'];
	        $array_totaltotales[0]['cupo']=$array_datostotales[0]['sumacupo']+$array_totaltotales[0]['cupo']; 
	   
	   
             unset($array_datostotales); /*Fin del ciclo de modalidades*/ }
             
        /*Ciclo total de totales*/
        $indicetotaltotalesuno=$array_totaltotales[0]['admitidos']/($array_totaltotales[0]['inscritos']-$array_totaltotales[0]['innoeval']);
        $indicetotaltotalesdos=$array_totaltotales[0]['nuevos']/$array_totaltotales[0]['admitidos'];
        $indicetotaltotalestres=$array_totaltotales[0]['nuevos']/$array_totaltotales[0]['cupo'];

        $carrerasValores[$cont] = "Total ".$codigoperiodo;
        $admitidosValores[$cont] = intval($indicetotaltotalesuno*100);
           if($admitidosValores[$cont]>100){
               $admitidosValores[$cont] = 100;
           }
           $noValores[$cont] = 100 - $admitidosValores[$cont];
        $absorcionValores[$cont] = intval($indicetotaltotalesdos*100);
           if($admitidosValores[$cont]>100){
               $admitidosValores[$cont] = 100;
           }
           $noValores[$cont] = 100 - $admitidosValores[$cont];
        $seleccionValores[$cont] = intval($indicetotaltotalestres*100);
           if($admitidosValores[$cont]>100){
               $admitidosValores[$cont] = 100;
           }
           $noValores[$cont] = 100 - $admitidosValores[$cont];
        
    return array("selectividad"=>array($carrerasValores,$admitidosValores,$noValores),
        "absorcion"=>array($carrerasValores,$absorcionValores,$noAbsorcionValores),
        "seleccion"=>array($carrerasValores,$seleccionValores,$noSeleccionValores));
} 


function drawGraphic($db,$codigoperiodo,$reporte) { ?>

    <div class="grafica">
        <h4>Índice de Selectividad <?php echo $codigoperiodo; ?></h4>
        
        <?php
        $valores = getValoresPeriodo($db,$codigoperiodo);
        /*var_dump($valores["selectividad"][1]);
        echo "<br/><br/>";
        var_dump(array(4,VOID,VOID,12,8,3));
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

        $myPicture->Render("imagenesGraficas/".$reporte["archivoReporte"]."/selectividad_".$codigoperiodo.".png"); ?>
        
        <img alt="Resultados selectividad" src="<?php echo "imagenesGraficas/".$reporte["archivoReporte"]."/selectividad_".$codigoperiodo.".png"; ?>" style="border: 1px solid gray;margin-right: 20px;"/>

    </div>

    <div class="grafica">
        <h4>Índice de Absorción <?php echo $codigoperiodo; ?></h4>
        
        <?php


        /* Create and populate the pData object */
        $MyData = new pData();  
        $MyData->addPoints($valores["absorcion"][1],"Admitidos");
        $MyData->addPoints($valores["absorcion"][2],"Admitidos No Matriculados");
        $MyData->setAxisName(0,"%");
        $MyData->addPoints($valores["absorcion"][0],"Labels");
        $MyData->setSerieDescription("Labels","Carreras");
        $MyData->setAbscissa("Labels");

        /* Create the pChart object */
        $myPicture = new pImage(6200,500,$MyData);
       // $myPicture->drawGradientArea(0,0,6200,300,DIRECTION_VERTICAL,array("StartR"=>240,"StartG"=>240,"StartB"=>240,"EndR"=>180,"EndG"=>180,"EndB"=>180,"Alpha"=>100));
      //  $myPicture->drawGradientArea(0,0,6200,300,DIRECTION_HORIZONTAL,array("StartR"=>240,"StartG"=>240,"StartB"=>240,"EndR"=>180,"EndG"=>180,"EndB"=>180,"Alpha"=>20));

        /* Set the default font properties */
        $myPicture->setFontProperties(array("FontName"=>"../../pChart/fonts/pf_arma_five.ttf","FontSize"=>6));

        /* Draw the scale and the chart */
        $myPicture->setGraphArea(60,20,6180,270);
        $myPicture->drawScale(array("DrawSubTicks"=>TRUE,'LabelRotation'=>45,"Mode"=>SCALE_MODE_ADDALL_START0));
       // $myPicture->setShadow(FALSE);
        $myPicture->drawStackedBarChart(array("DisplayValues"=>TRUE,"DisplayColor"=>DISPLAY_AUTO,"Surrounding"=>-15,"InnerSurrounding"=>15));

        /* Write the chart legend */
        //$myPicture->drawLegend(480,210,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL));
        $myPicture->drawLegend(480,5,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL));
        /* Render the picture (choose the best way) */
        //$myPicture->autoOutput("imagenesGraficas/example.png");

        $myPicture->Render("imagenesGraficas/".$reporte["archivoReporte"]."/absorcion_".$codigoperiodo.".png"); ?>
        
        <img alt="Resultados absorcion" src="<?php echo "imagenesGraficas/".$reporte["archivoReporte"]."/absorcion_".$codigoperiodo.".png"; ?>" style="border: 1px solid gray;margin-right: 20px;"/>

    </div>

    <div class="grafica">
        <h4>Índice de Selección <?php echo $codigoperiodo; ?></h4>
        
        <?php


        /* Create and populate the pData object */
        $MyData = new pData();  
        $MyData->addPoints($valores["seleccion"][1],"Matriculados");
        $MyData->addPoints($valores["seleccion"][2],"Cupos");
        $MyData->setAxisName(0,"%");
        $MyData->addPoints($valores["seleccion"][0],"Labels");
        $MyData->setSerieDescription("Labels","Carreras");
        $MyData->setAbscissa("Labels");

        /* Create the pChart object */
        $myPicture = new pImage(6200,500,$MyData);
        //$myPicture->drawGradientArea(0,0,6200,300,DIRECTION_VERTICAL,array("StartR"=>240,"StartG"=>240,"StartB"=>240,"EndR"=>180,"EndG"=>180,"EndB"=>180,"Alpha"=>100));
        //$myPicture->drawGradientArea(0,0,6200,300,DIRECTION_HORIZONTAL,array("StartR"=>240,"StartG"=>240,"StartB"=>240,"EndR"=>180,"EndG"=>180,"EndB"=>180,"Alpha"=>20));

        /* Set the default font properties */
        $myPicture->setFontProperties(array("FontName"=>"../../pChart/fonts/pf_arma_five.ttf","FontSize"=>6));
        //$myPicture->setFontProperties(array("FontName"=>"../../pChart/fonts/pf_arma_five.ttf","FontSize"=>6,"R"=>29,"G"=>70,"B"=>111));
        
        /* Draw the scale and the chart */
        $myPicture->setGraphArea(60,20,6180,270);
        $myPicture->drawScale(array("DrawSubTicks"=>TRUE,'LabelRotation'=>45,"Mode"=>SCALE_MODE_ADDALL_START0));
        //$myPicture->setShadow(TRUE,array("X"=>2,"Y"=>2,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>20));
        //$myPicture->drawText(500,170,"Vertical Text",$TextSettings);
        //$myPicture->setShadow(FALSE);
        
        $myPicture->drawStackedBarChart(array("DisplayValues"=>TRUE,"DisplayColor"=>DISPLAY_AUTO,"Surrounding"=>-15,"InnerSurrounding"=>15));

        /* Write the chart legend */
        $myPicture->drawLegend(480,5,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL));

        /* Render the picture (choose the best way) */
        //$myPicture->autoOutput("imagenesGraficas/example.png");

        $myPicture->Render("imagenesGraficas/".$reporte["archivoReporte"]."/seleccion_".$codigoperiodo.".png"); ?>
        
        <img alt="Resultados seleccion" src="<?php echo "imagenesGraficas/".$reporte["archivoReporte"]."/seleccion_".$codigoperiodo.".png"; ?>" style="border: 1px solid gray;margin-right: 20px;"/>

    </div>

<?php }

$periodos = getPeriodos($db,$dates);
$i = 0;

    while($row_periodo = $periodos->FetchRow()){    
        drawGraphic($db,$row_periodo["codigoperiodo"],$reporte);
        $i = $i + 1;
    }

?>