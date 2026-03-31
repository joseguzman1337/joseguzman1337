<?php

function estudiantes_siguen ($codigoperiodo,$codigocarrera,$db) {
		$query="SELECT codigoperiodo 
			FROM (
				Select codigoperiodo 
				From periodo 
				Where codigoperiodo<$codigoperiodo 
				Order By codigoperiodo Desc 
				Limit 3
			) sub 
			ORDER BY codigoperiodo 
			LIMIT 1";
		$exec= $db->Execute($query);
		$row = $exec->FetchRow();
		$codigoperiodo_cohorte=$row['codigoperiodo'];

		$query="SELECT codigoestudiante
			FROM (
				Select Distinct ee.codigoestudiante
				From estudianteestadistica ee
				, carrera c
				, estudiante e
				, estudiantegeneral eg
				Where e.codigocarrera = $codigocarrera
					And e.codigocarrera=c.codigocarrera
					And ee.codigoestudiante=e.codigoestudiante
					And eg.idestudiantegeneral=e.idestudiantegeneral
					And ee.codigoperiodo = '$codigoperiodo_cohorte'
					And ee.codigoprocesovidaestudiante= 400
					And ee.codigoestado Like '1%'
					And eg.idestudiantegeneral Not In (	select idestudiantegeneral 
										from estudiante e 
										join estudiantegeneral eg using(idestudiantegeneral) 
										where codigoperiodo < '$codigoperiodo_cohorte'
									)
			) sub1
			JOIN (
				Select Distinct ee.codigoestudiante
				From estudianteestadistica ee
				, carrera c
				, estudiante e
				Where e.codigocarrera = $codigocarrera
					And e.codigocarrera=c.codigocarrera
					And ee.codigoestudiante=e.codigoestudiante
					And ee.codigoperiodo = '$codigoperiodo'
					And ee.codigoprocesovidaestudiante= 401
					And ee.codigoestado Like '1%'
			) sub2 USING(codigoestudiante)";
		$exec= $db->Execute($query);
		return $exec->RecordCount();
	}

	function desercion ($codigoperiodo,$codigocarrera,$db) {
		$query="SELECT codigoperiodo 
			FROM (
				Select codigoperiodo 
				From periodo 
				Where codigoperiodo<$codigoperiodo 
				Order By codigoperiodo Desc 
				Limit 3
			) sub 
			ORDER BY codigoperiodo 
			LIMIT 1";
		$exec= $db->Execute($query);
		$row = $exec->FetchRow();
		$codigoperiodo_cohorte=$row['codigoperiodo'];

		$query="SELECT codigoestudiante
			FROM (
				Select Distinct ee.codigoestudiante
				From estudianteestadistica ee
				, carrera c
				, estudiante e
				, estudiantegeneral eg
				Where e.codigocarrera = $codigocarrera
					And e.codigocarrera=c.codigocarrera
					And ee.codigoestudiante=e.codigoestudiante
					And eg.idestudiantegeneral=e.idestudiantegeneral
					And ee.codigoperiodo = '$codigoperiodo_cohorte'
					And ee.codigoprocesovidaestudiante= 400
					And ee.codigoestado Like '1%'
					And eg.idestudiantegeneral Not In (	select idestudiantegeneral 
										from estudiante e 
										join estudiantegeneral eg using(idestudiantegeneral) 
										where codigoperiodo < '$codigoperiodo_cohorte'
									)
			) sub1
			LEFT JOIN (
				Select distinct ee.codigoestudiante
				From estudianteestadistica ee
				, carrera c
				, estudiante e
				Where e.codigocarrera = $codigocarrera
					And e.codigocarrera=c.codigocarrera
					And ee.codigoestudiante=e.codigoestudiante
					And ee.codigoperiodo = '$codigoperiodo'
					And ee.codigoprocesovidaestudiante= 401
					And ee.codigoestado Like '1%'
			) sub2 USING(codigoestudiante)
			WHERE sub2.codigoestudiante IS NULL";
		$exec= $db->Execute($query);
		return $exec->RecordCount();
	}
	 
	function retencion ($codigoperiodo,$codigocarrera,$db) {
		$estudiantes_siguen=estudiantes_siguen($codigoperiodo,$codigocarrera,$db);
		$estudiantes_desertan=desercion($codigoperiodo,$codigocarrera,$db);
		$total_estudiantes=$estudiantes_siguen+$estudiantes_desertan;
		return round(($estudiantes_siguen*100)/$total_estudiantes);
	}

function getValores($db,$modalidad,$periodos){
    $labelPeriodos = array();
    $valores = array();
    for($i=0; $i<count($periodos); $i++){      
        $carreras = getCarrerasModalidadSIC($db, $modalidad["codigomodalidadacademicasic"]);
            $codigoperiodo = $periodos[$i]["codigoperiodo"];
                $arrayP = str_split($codigoperiodo, strlen($codigoperiodo)-1);
                $labelPeriodos[] = $arrayP[0]."-".$arrayP[1];
        $j = 0;
        $retencion = 0;
        //var_dump($datos_estadistica); echo "<br/><br/>";
        while($row_carreras = $carreras->FetchRow()){

            $retencion += retencion($codigoperiodo,$row_carreras['codigocarrera'],$db);

            $j = $j + 1;
        }
        $valores[] = $retencion/$j;
    //echo "<br/><br/>".$codigoperiodo;
    //echo "<pre>";print_r($retencion);
    }
     //echo "<pre>";var_dump($valores);
    return array("valores"=>array($labelPeriodos,$valores));
}

function drawGraphic($db,$periodos,$reporte,$modalidad,$fontPath) { 
    
    /* Create and populate the pData object */
    $MyData = new pData();  
     while($row_modalidad = $modalidad->FetchRow()){
         $valores = getValores($db,$row_modalidad,$periodos);
         $MyData->addPoints($valores["valores"][1],$row_modalidad["nombremodalidadacademicasic"]);
     } 
     
   
    $MyData->setAxisName(0,"Tasa");
     $MyData->addPoints($valores["valores"][0],"Labels");
    $MyData->setSerieDescription("Labels","Carreras");
    $MyData->setAbscissa("Labels");

    /* Create the pChart object */
    $numCarreras = count($valores["valores"][0]);
    if($numCarreras<=30){
        $ancho = 700;
    } else if($numCarreras<=50) {
        //toca hacerlo mas largo porque son muchas carreras
        $ancho = 1200;
    } else if($numCarreras<=70) {
        $ancho = 1400;
    } else {
       $ancho = 1600;
    }
    //var_dump($numCarreras);
    $alto = 310;
    $myPicture = new pImage($ancho,$alto,$MyData);

    /* Turn of Antialiasing */
    $myPicture->Antialias = FALSE;

    /* Overlay with a gradient */
    $myPicture->drawGradientArea(0,0,$ancho,20,DIRECTION_VERTICAL,array("StartR"=>0,"StartG"=>0,"StartB"=>0,"EndR"=>50,"EndG"=>50,"EndB"=>50,"Alpha"=>80));

    /* Add a border to the picture */
    $myPicture->drawRectangle(0,0,$ancho-1,$alto-1,array("R"=>0,"G"=>0,"B"=>0));

    /* Write the chart title */ 
    $myPicture->setFontProperties(array("FontName"=>$fontPath."verdana.ttf","FontSize"=>8,"R"=>255,"G"=>255,"B"=>255));
    $myPicture->drawText(10,16,"Tasa de Retención",array("FontSize"=>8,"Align"=>TEXT_ALIGN_BOTTOMLEFT));

    /* Set the default font */
    $myPicture->setFontProperties(array("FontName"=>$fontPath."calibri.ttf","FontSize"=>8,"R"=>0,"G"=>0,"B"=>0));

    /* Define the chart area */
    //el 80 es donde empieza la grafica de izquierda a derecha y el 40 es de arriba para abajo
    $myPicture->setGraphArea(60,40,$ancho-30,280);

    /* Draw the scale */
    $scaleSettings = array("XMargin"=>10,"YMargin"=>10,"Floating"=>TRUE,"Mode"=>SCALE_MODE_START0,"GridR"=>200,"GridG"=>200,"GridB"=>200,"DrawSubTicks"=>TRUE,"CycleBackground"=>TRUE);
    $myPicture->drawScale($scaleSettings);

    /* Turn on Antialiasing */
    $myPicture->Antialias = TRUE;

    /* Enable shadow computing */
    $myPicture->setShadow(FALSE);

    /* Draw the line chart */
    $myPicture->drawLineChart();
    $myPicture->drawPlotChart(array("PlotSize"=>1,"DisplayValues"=>FALSE,"PlotBorder"=>TRUE,"BorderSize"=>2,"Surrounding"=>-60,"BorderAlpha"=>80));
       
    /* Write the chart legend */
    //este es el nombre de arriba que de largo le puse 590 para que me quedaran los periodos en la punta
    $myPicture->drawLegend($ancho-280,9,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL,"FontR"=>255,"FontG"=>255,"FontB"=>255));

    /* Render the picture (choose the best way) */
    $myPicture->Render("imagenesGraficas/".$reporte["alias"]."/retencionModalidades.png"); 
     ?>
        <img alt="Resultados selectividad" src="<?php echo "imagenesGraficas/".$reporte["alias"]."/retencionModalidades.png"; ?>" style="border: 1px solid gray;margin-right: 20px;"/>
 <?php }
$periodos = getPeriodosArray($db,$dates);

        $modalidad= getModalidades($db); ?>

            <div class="grafica">
            <?php drawGraphic($db,$periodos,$reporte,$modalidad,$fontPath);  ?> </div>
