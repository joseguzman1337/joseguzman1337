<?php 

function getValores($db,$modalidad,$codigoperiodo){
    $carreras = getCarrerasModalidadSIC($db, $modalidad["codigomodalidadacademicasic"]);
    //$labelCarreras = array();
    $valores = array();
    $j = 0;
    $totalAL = 0;
    $totalE = 0;
    //var_dump($datos_estadistica); echo "<br/><br/>";
    while($row_carreras = $carreras->FetchRow()){
        //$labelCarreras[] = $row_carreras["nombrecarrera"];
        $sql = "SELECT * from poblacionespcialbajos WHERE codigoestado=100 AND carrera_id='".$row_carreras['codigocarrera']."'";
        $sql .= " AND periodo='".$codigoperiodo."' ORDER BY entrydate DESC";
        $row = $db->GetRow($sql);
        if($row!=NULL && (count($row)>0)){
            $totalAL += $row["numespeciales"];
            $totalE += $row["numbajos"];
        }
           
        $j = $j + 1;
    }
    $valores[] = $totalAL;
    $valores[] = $totalE;
    $labelCategorias = array("Convenio de poblaciones especiales","Convenio de estratos bajos");
           //var_dump($valores);
    return array("valores"=>array($labelCategorias,$valores));
}


function drawGraphic($db,$periodos,$reporte,$modalidad,$fontPath) { 
    
    /* Create and populate the pData object */
 $MyData = new pData();  
 
 for($j=0; $j<count($periodos); $j++){
     //var_dump($row_periodos["codigoperiodo"]);echo "<br/><br/>";
            $codigoperiodo = $periodos[$j]["codigoperiodo"];
            $arrayP = str_split($codigoperiodo, strlen($codigoperiodo)-1);
            $labelP = $arrayP[0]."-".$arrayP[1];
     $valores = getValores($db,$modalidad,$periodos[$j]["codigoperiodo"]);
     $MyData->addPoints($valores["valores"][1],$labelP);
 }
 
 $MyData->setAxisName(0,"Estudiantes admitidos");
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
 $myPicture->setFontProperties(array("FontName"=>$fontPath."verdana.ttf","FontSize"=>8));

 /* Draw the scale  */
 $myPicture->setGraphArea(50,30,680,300);
 $myPicture->drawScale(array("CycleBackground"=>TRUE,"DrawSubTicks"=>TRUE,"Mode"=>SCALE_MODE_START0,"GridR"=>0,"GridG"=>0,"GridB"=>0,"GridAlpha"=>10));

 /* Turn on shadow computing */ 
 $myPicture->setShadow(TRUE,array("X"=>1,"Y"=>1,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>10));

 /* Draw the chart */
 $settings = array("Gradient"=>TRUE,"DisplayPos"=>LABEL_POS_INSIDE,"DisplayValues"=>TRUE,"DisplayR"=>255,"DisplayG"=>255,"DisplayB"=>255,"DisplayShadow"=>TRUE,"Surrounding"=>10);
 $myPicture->drawBarChart($settings);

 /* Write the chart legend */
 $myPicture->drawLegend(350,12,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL));
 
   //$myPicture->drawLegend($ancho-240,9,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL,"FontR"=>255,"FontG"=>255,"FontB"=>255));

    /* Render the picture (choose the best way) */
    $myPicture->Render("imagenesGraficas/".$reporte["alias"]."/estratosYpoblaciones_".$modalidad["codigomodalidadacademicasic"].".png"); 
     ?>
        <img alt="Resultados selectividad" src="<?php echo "imagenesGraficas/".$reporte["alias"]."/estratosYpoblaciones_".$modalidad["codigomodalidadacademicasic"].".png"; ?>" style="border: 1px solid gray;margin-right: 20px;"/>
 <?php }
  
 
$periodos = getPeriodosArray($db,$dates);

        $modalidad= getModalidades($db);
		//echo $codigoperiodo."<br/><br/>";
         while($row_modalidad = $modalidad->FetchRow()){
             //var_dump($row_modalidad); ?>

            <div class="grafica">
            <h4><?php echo $row_modalidad["nombremodalidadacademicasic"]; ?></h4>
            <?php drawGraphic($db,$periodos,$reporte,$row_modalidad,$fontPath); ?> </div>
        <?php } 

