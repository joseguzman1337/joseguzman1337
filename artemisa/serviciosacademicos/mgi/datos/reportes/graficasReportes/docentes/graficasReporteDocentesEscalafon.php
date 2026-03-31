<?php

function getValores($db,$codigoperiodo,$utils){
    $valores = array();
    $total1 = 0;
    $total2 = 0;
    $total3 = 0;
    $total4 = 0;
    $total5 = 0;
    $total6 = 0;
    
    $mes = "9-".$codigoperiodo;
    $sql = "SELECT * FROM siq_formTalentoHumanoDocentesEscalafon WHERE codigoestado=100 AND codigoperiodo='$mes'";
    $row = $db->GetRow($sql);

    if(!($row!=NULL && count($row)>0)){
        $mes = "3-".$codigoperiodo;
        $sql = "SELECT * FROM siq_formTalentoHumanoDocentesEscalafon WHERE codigoestado=100 AND codigoperiodo='$mes'";
        $row = $db->GetRow($sql);
    }
    
    if(!($row!=NULL && count($row)>0)){
        $periodos = $utils->getMesesPeriodo($db,$codigoperiodo,true);
        $sql = "SELECT * FROM siq_formTalentoHumanoDocentesEscalafon WHERE codigoestado=100 AND codigoperiodo IN $periodos ORDER BY SUBSTRING_INDEX(codigoperiodo, '-', -1) DESC, CAST(SUBSTRING_INDEX(codigoperiodo, '-', -1) AS SIGNED)";
        $row = $db->GetRow($sql);
    }
    
        if($row!=NULL && (count($row)>0)){
            $total1 += $row["numAcademicosPTitular"];
            $total2 += $row["numAcademicosPAsociado"];
            $total3 += $row["numAcademicosPAsistente"];
            $total4 += $row["numAcademicosIAsociado"];
            $total5 += $row["numAcademicosIAsistente"];
            $total6 += $row["numAcademicosOtros"];
        }
           
    $valores[] = $total5;
    $valores[] = $total4;
    $valores[] = $total3;
    $valores[] = $total2;
    $valores[] = $total1;
    $valores[] = $total6;
    $labelCategorias = array("Instructor Asistente","Instructor Asociado","Profesor Asistente","Profesor Asociado","Profesor Titular","Otros");
           //var_dump($valores);
    return array("valores"=>array($labelCategorias,$valores));
}


function drawGraphic($db,$periodos,$reporte,$fontPath,$utils) { 
    
    /* Create and populate the pData object */
 $MyData = new pData();  
 
 for($j=0; $j<count($periodos); $j++){
     //var_dump($periodos[$j]);echo "<br/><br/>";
     $valores = getValores($db,$periodos[$j],$utils);
     $MyData->addPoints($valores["valores"][1],$periodos[$j]);
 }
 
 $MyData->setAxisName(0,"Número de Académicos");
 $MyData->addPoints($valores["valores"][0],"Creditos");
 $MyData->setSerieDescription("Creditos","Creditos");
 $MyData->setAbscissa("Creditos");

 /* Create the pChart object */
 $myPicture = new pImage(700,330,$MyData);
  /* Turn of Antialiasing */
 $myPicture->Antialias = FALSE;

 /* Add a border to the picture */
 $myPicture->drawRectangle(0,0,699,329,array("R"=>0,"G"=>0,"B"=>0)); 

//$myPicture->drawGradientArea(0,0,700,230,DIRECTION_VERTICAL,array("StartR"=>240,"StartG"=>240,"StartB"=>240,"EndR"=>180,"EndG"=>180,"EndB"=>180,"Alpha"=>100));
 //$myPicture->drawGradientArea(0,0,700,230,DIRECTION_HORIZONTAL,array("StartR"=>240,"StartG"=>240,"StartB"=>240,"EndR"=>180,"EndG"=>180,"EndB"=>180,"Alpha"=>20));
 $myPicture->setFontProperties(array("FontName"=>$fontPath."calibri.ttf","FontSize"=>8));

 /* Draw the scale  */
 $myPicture->setGraphArea(50,30,680,300);
 $myPicture->drawScale(array("CycleBackground"=>TRUE,"DrawSubTicks"=>TRUE,"Mode"=>SCALE_MODE_START0,"GridR"=>0,"GridG"=>0,"GridB"=>0,"GridAlpha"=>10));

 /* Turn on shadow computing */ 
 $myPicture->setShadow(TRUE,array("X"=>1,"Y"=>1,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>10));

 /* Draw the chart */
 $settings = array("Gradient"=>TRUE,"DisplayPos"=>LABEL_POS_INSIDE,"DisplayValues"=>TRUE,"DisplayR"=>255,"DisplayG"=>255,"DisplayB"=>255,"DisplayShadow"=>TRUE,"Surrounding"=>10);
 $myPicture->drawBarChart($settings);

 /* Write the chart legend */
 $myPicture->drawLegend(575,12,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL));
 
   //$myPicture->drawLegend($ancho-240,9,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL,"FontR"=>255,"FontG"=>255,"FontB"=>255));

    /* Render the picture (choose the best way) */
    $myPicture->Render("imagenesGraficas/".$reporte["alias"]."/docentesEscalafon.png"); 
     ?>
        <img alt="Resultados selectividad" src="<?php echo "imagenesGraficas/".$reporte["alias"]."/docentesEscalafon.png?random=".time(); ?>" style="border: 1px solid gray;margin-right: 20px;"/>
 <?php }
  
$periodos = $utils->getYears($dates["fecha_inicial"],$dates["fecha_final"]);
//var_dump($periodos); 
//$periodos = getPeriodosArray($db,$dates);

             //var_dump($row_modalidad); ?>

            <div class="grafica">
            <?php drawGraphic($db,$periodos,$reporte,$fontPath,$utils); ?> </div>
