<?php

function getValores($db,$codigoperiodo,$utils){
    $valores = array();
    $total1 = 0;
    $total2 = 0;
    $total3 = 0;
    
    $mes = "9-".$codigoperiodo;
    $sql = "SELECT * FROM siq_formTalentoHumanoNumeroPersonas WHERE codigoestado=100 AND codigoperiodo='$mes'";
    $row = $db->GetRow($sql);

    if(!($row!=NULL && count($row)>0)){
        $mes = "3-".$codigoperiodo;
        $sql = "SELECT * FROM siq_formTalentoHumanoNumeroPersonas WHERE codigoestado=100 AND codigoperiodo='$mes'";
        $row = $db->GetRow($sql);
    }
    

    if(!($row!=NULL && count($row)>0)){
        $periodos = $utils->getMesesPeriodo($db,$codigoperiodo,true);

        $sql = "SELECT * FROM siq_formTalentoHumanoNumeroPersonas WHERE codigoestado=100 AND codigoperiodo IN $periodos ORDER BY SUBSTRING_INDEX(codigoperiodo, '-', -1) DESC, CAST(SUBSTRING_INDEX(codigoperiodo, '-', -1) AS SIGNED)";
        //echo $sql;
        $row = $db->GetRow($sql);
    }
    
    if($row!=NULL && count($row)>0){
            $total1 += $row["numAcademicosSemestral"];
            $total2 += $row["numAcademicosAnual"];
            $total3 += $row["numAcademicosNucleoProfesoral"];
   }
           
    $valores[] = $total1;
    $valores[] = $total2;
    $valores[] = $total3;
    $labelCategorias = array("Académicos Adjuntos","Académicos","Núcleo Académico");
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
 $myPicture->drawLegend(510,12,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL));
 
   //$myPicture->drawLegend($ancho-240,9,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL,"FontR"=>255,"FontG"=>255,"FontB"=>255));

    /* Render the picture (choose the best way) */
    $myPicture->Render("imagenesGraficas/".$reporte["alias"]."/docentesVinculacion.png"); 
     ?>
        <img alt="Resultados selectividad" src="<?php echo "imagenesGraficas/".$reporte["alias"]."/docentesVinculacion.png?random=".time(); ?>" style="border: 1px solid gray;margin-right: 20px;"/>
 <?php }
  
$periodos = $utils->getYears($dates["fecha_inicial"],$dates["fecha_final"]);
//var_dump($periodos); 
//$periodos = getPeriodosArray($db,$dates);

             //var_dump($row_modalidad); ?>

            <div class="grafica">
            <?php drawGraphic($db,$periodos,$reporte,$fontPath,$utils); ?> </div>
