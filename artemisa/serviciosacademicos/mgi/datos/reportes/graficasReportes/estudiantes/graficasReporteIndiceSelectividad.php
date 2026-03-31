<?php

if(isset($_GET['consultar']) && isset($_GET['codigocarrera'])) {
require_once('../../../consulta/estadisticas/matriculasnew/funciones/obtener_datos.php');

function getValores($db,$modalidad,$periodos){
    //$start3 = microtime(true);
    
    $labelPeriodos = array();
    $valores = array();
    $valores2 = array();
    for($i=0; $i<count($periodos); $i++){
        //$carreras = getCarrerasModalidadSIC($db, $modalidad["codigomodalidadacademicasic"]);
        $codigoperiodo = $periodos[$i]["codigoperiodo"];
            $arrayP = str_split($codigoperiodo, strlen($codigoperiodo)-1);
            $labelPeriodos[] = $arrayP[0]."-".$arrayP[1];
        $j = 0;
        $datos_estadistica=new obtener_datos_matriculas($db,$codigoperiodo); 

        $total_inscritos=$datos_estadistica->ObtenerDatosCuentaOperacionPrincipalIncluyeInscritosSinPago($codigoperiodo,'',153,'conteo',$modalidad["codigomodalidadacademicasic"]);

        $total_admnoing=$datos_estadistica->ObtenerDatosCuentaOperacionPrincipalAdmitidosQueNoIngresaron($codigoperiodo,'',153,'conteo',$modalidad["codigomodalidadacademicasic"]);

        //echo       $total_admnoing."<br/><br/>";   $total_admnoing = 0;

        $total_insnoeva=$datos_estadistica->ObtenerDatosCuentaOperacionPrincipalInscritosNoEvaluado($codigoperiodo,'',153,'conteo',$modalidad["codigomodalidadacademicasic"]);	   

        $total_admnomat = $datos_estadistica->seguimiento_inscripcionvsmatriculadosnuevos_modalidad($modalidad["codigomodalidadacademicasic"],$codigoperiodo,'conteo');

        $total_matnuevo = $datos_estadistica->obtener_datos_estudiantes_matriculados_nuevos("",'conteo',$modalidad["codigomodalidadacademicasic"]);
     
        /*$start4 = microtime(true);
        echo       $total_matnuevo."<br/><br/>";   $total_matnuevo = 0;
        while($row_carreras = $carreras->FetchRow()){

            //$array_insc=$datos_estadistica->ObtenerDatosCuentaOperacionPrincipalIncluyeInscritosSinPago($codigoperiodo,$row_carreras['codigocarrera'],153,'arreglo');
            //$array_admnomat=$datos_estadistica->seguimiento_inscripcionvsmatriculadosnuevos($row_carreras['codigocarrera'],'arreglo');
            //$array_admnoing=$datos_estadistica->ObtenerDatosCuentaOperacionPrincipalAdmitidosQueNoIngresaron($codigoperiodo,$row_carreras['codigocarrera'],153,'arreglo');
            //$array_matnuevo=$datos_estadistica->obtener_datos_estudiantes_matriculados_nuevos($row_carreras['codigocarrera'],'arreglo');
            //$array_insnoeva=$datos_estadistica->ObtenerDatosCuentaOperacionPrincipalInscritosNoEvaluado($codigoperiodo,$row_carreras['codigocarrera'],153,'arreglo');	   
            //$total_inscritos+=count($array_insc);
            //$total_admnomat+=count($array_admnomat);
            //$total_admnoing+=count($array_admnoing);
            //$total_matnuevo+=count($array_matnuevo);
            //$total_insnoeva+=count($array_insnoeva);
           

            $j = $j + 1;
        }
        $end4 = microtime(true);
        $time = $end4 - $start4;
        echo "<br/><br/>";echo('totales por carrera ' .$codigoperiodo.' tardo '. $time . ' seconds to execute.');
        //echo       $total_matnuevo." el 2 <br/><br/>";   */
            $total_admitidos=$total_admnomat+$total_admnoing+$total_matnuevo;
            if(($total_inscritos-$total_insnoeva) == 0){
                $indiceuno = 0;
            } else {
                    $indiceuno=$total_admitidos/($total_inscritos-$total_insnoeva);
            }
            
            if($total_inscritos==0){
                $indice2 = 0;                
            }else {
                $indice2=$total_admitidos/($total_inscritos);
            }
            /*echo "<pre>";print_r($modalidad["codigomodalidadacademicasic"]); echo "<br/><br/>";
            echo "<pre>";print_r($total_admitidos); echo "<br/><br/>";
            echo "<pre>";print_r($total_inscritos); echo "<br/><br/>";
            echo "<pre>";print_r($total_insnoeva); echo "<br/><br/>";
            echo "<pre>";print_r($indiceuno); echo "<br/><br/>";*/
            //var_dump($indiceuno); echo "<br/><br/>";
            $valores[] =  round($indiceuno*100, 2);
            $valores2[] = round($indice2*100, 2);
            $total_inscritos=0;
            $total_admnomat=0;
            $total_admnoing=0;
            $total_matnuevo=0;
            $total_insnoeva=0;
    }
           //var_dump($valores);
        //$end3 = microtime(true);
        //$time = $end3 - $start3;
        //echo "<br/><br/>";echo('valor para ' .$modalidad["nombremodalidadacademicasic"].' tardo '. $time . ' seconds to execute.');
    return array("valores"=>array($labelPeriodos,$valores,$valores2));
}

function getValoresCarrera($db,$carrera,$periodos){
    //$start3 = microtime(true);
    
    $labelPeriodos = array();
    $valores = array();
    $valores2 = array();
    for($i=0; $i<count($periodos); $i++){
        //$carreras = getCarrerasModalidadSIC($db, $modalidad["codigomodalidadacademicasic"]);
        $codigoperiodo = $periodos[$i]["codigoperiodo"];
        $datos_estadistica=new obtener_datos_matriculas($db,$codigoperiodo); 

        $total_inscritos=$datos_estadistica->ObtenerDatosCuentaOperacionPrincipalIncluyeInscritosSinPago($codigoperiodo,$carrera,153,'conteo');

        $total_admnoing=$datos_estadistica->ObtenerDatosCuentaOperacionPrincipalAdmitidosQueNoIngresaron($codigoperiodo,$carrera,153,'conteo');

        //echo       $total_admnoing."<br/><br/>";   $total_admnoing = 0;

        $total_insnoeva=$datos_estadistica->ObtenerDatosCuentaOperacionPrincipalInscritosNoEvaluado($codigoperiodo,$carrera,153,'conteo');	   

        $total_admnomat = $datos_estadistica->seguimiento_inscripcionvsmatriculadosnuevos($carrera,'conteo');

        $total_matnuevo = $datos_estadistica->obtener_datos_estudiantes_matriculados_nuevos($carrera,'conteo');
     
            $total_admitidos=$total_admnomat+$total_admnoing+$total_matnuevo;
            if(($total_inscritos-$total_insnoeva) == 0){
                $indiceuno = 0;
            } else {
                    $indiceuno=$total_admitidos/($total_inscritos-$total_insnoeva);
            }
            
            if($total_inscritos==0){
                $indice2 = 0;                
            }else {
                $indice2=$total_admitidos/($total_inscritos);
            }
            $valores[] = round($indiceuno*100, 2);
            $valores2[] = round($indice2*100, 2);
            $total_inscritos=0;
            $total_admnomat=0;
            $total_admnoing=0;
            $total_matnuevo=0;
            $total_insnoeva=0;
    }
           //var_dump($valores);
        //$end3 = microtime(true);
        //$time = $end3 - $start3;
        //echo "<br/><br/>";echo('valor para ' .$modalidad["nombremodalidadacademicasic"].' tardo '. $time . ' seconds to execute.');
    return array($valores,$valores2);
}

function drawGraphic($db,$periodos,$reporte,$modalidad,$fontPath) { 
    
    /* Create and populate the pData object */
    $MyData = new pData();  
    $MyData2 = new pData(); 
    
    //$start2 = microtime(true);
    //var_dump($modalidad);
     //while($row_periodos = $periodos->FetchRow()){
     while($row_modalidad = $modalidad->FetchRow()){
         //var_dump($row_modalidad["nombremodalidadacademicasic"]);echo "<br/><br/>";
         //var_dump($row_periodos["codigoperiodo"]);echo "<br/><br/>";
         $valores = getValores($db,$row_modalidad,$periodos);
         //echo "<pre>";print_r($valores["valores"]);
         $MyData->addPoints($valores["valores"][1],$row_modalidad["nombremodalidadacademicasic"]);
         $MyData2->addPoints($valores["valores"][2],$row_modalidad["nombremodalidadacademicasic"]);
     }    
     
     //$end2 = microtime(true);
       // $time = $end2 - $start2;
        //echo "<br/><br/>";echo('todos los valores tardaron ' . $time . ' seconds to execute.');
   
    $MyData->setAxisName(0,"índice");
    $MyData->addPoints($valores["valores"][0],"Labels");
    $MyData->setSerieDescription("Labels","Carreras");
    $MyData->setAbscissa("Labels");
    
    $MyData2->setAxisName(0,"índice");
    $MyData2->addPoints($valores["valores"][0],"Labels");
    $MyData2->setSerieDescription("Labels","Carreras");
    $MyData2->setAbscissa("Labels");

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
    $myPicture2 = new pImage($ancho,$alto,$MyData2);

    /* Turn on Antialiasing */
    $myPicture->Antialias = TRUE;
    $myPicture2->Antialias = TRUE;


    /* Overlay with a gradient */
    $myPicture->drawGradientArea(0,0,$ancho,20,DIRECTION_VERTICAL,array("StartR"=>0,"StartG"=>0,"StartB"=>0,"EndR"=>50,"EndG"=>50,"EndB"=>50,"Alpha"=>80));
    $myPicture2->drawGradientArea(0,0,$ancho,20,DIRECTION_VERTICAL,array("StartR"=>0,"StartG"=>0,"StartB"=>0,"EndR"=>50,"EndG"=>50,"EndB"=>50,"Alpha"=>80));

    /* Add a border to the picture */
    $myPicture->drawRectangle(0,0,$ancho-1,$alto-1,array("R"=>0,"G"=>0,"B"=>0));
    $myPicture2->drawRectangle(0,0,$ancho-1,$alto-1,array("R"=>0,"G"=>0,"B"=>0));

    /* Write the chart title */ 
    $myPicture->setFontProperties(array("FontName"=>$fontPath."verdana.ttf","FontSize"=>8,"R"=>255,"G"=>255,"B"=>255));
    $myPicture->drawText(10,16,"Índice de Selectividad",array("FontSize"=>9,"Align"=>TEXT_ALIGN_BOTTOMLEFT));
    $myPicture2->setFontProperties(array("FontName"=>$fontPath."verdana.ttf","FontSize"=>8,"R"=>255,"G"=>255,"B"=>255));
    $myPicture2->drawText(10,16,"Índice de Selectividad",array("FontSize"=>9,"Align"=>TEXT_ALIGN_BOTTOMLEFT));

    /* Set the default font */
    $myPicture->setFontProperties(array("FontName"=>$fontPath."calibri.ttf","FontSize"=>8,"R"=>0,"G"=>0,"B"=>0));
    $myPicture2->setFontProperties(array("FontName"=>$fontPath."calibri.ttf","FontSize"=>8,"R"=>0,"G"=>0,"B"=>0));

    /* Define the chart area */
    //el 80 es donde empieza la grafica de izquierda a derecha y el 40 es de arriba para abajo
    $myPicture->setGraphArea(60,40,$ancho-30,280);
    $myPicture2->setGraphArea(60,40,$ancho-30,280);

    /* Draw the scale */
    $scaleSettings = array("XMargin"=>10,"YMargin"=>10,"Floating"=>TRUE,"Mode"=>SCALE_MODE_START0,"GridR"=>200,"GridG"=>200,"GridB"=>200,"DrawSubTicks"=>TRUE,"CycleBackground"=>TRUE);
    $myPicture->drawScale($scaleSettings);
    $myPicture2->drawScale($scaleSettings);
    //$myPicture->drawScale(array("DrawSubTicks"=>TRUE,'LabelRotation'=>45,"Mode"=>SCALE_MODE_ADDALL_START0));

    /* Enable shadow computing */
    $myPicture->setShadow(FALSE);
    $myPicture2->setShadow(FALSE);

    /* Draw the line chart */
    $myPicture->drawLineChart();
    $myPicture2->drawLineChart();
    $myPicture->drawPlotChart(array("DisplayValues"=>TRUE,"PlotBorder"=>TRUE,"BorderSize"=>1,"Surrounding"=>-60,"BorderAlpha"=>80));
    $myPicture2->drawPlotChart(array("DisplayValues"=>TRUE,"PlotBorder"=>TRUE,"BorderSize"=>1,"Surrounding"=>-60,"BorderAlpha"=>80));
    //$myPicture->drawPlotChart(array("DisplayValues"=>FALSE,"PlotBorder"=>TRUE,"BorderSize"=>2,"Surrounding"=>-60,"BorderAlpha"=>80));
       
    /* Write the chart legend */
    //este es el nombre de arriba que de largo le puse 590 para que me quedaran los periodos en la punta
    $myPicture->drawLegend($ancho-280,9,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL,"FontR"=>255,"FontG"=>255,"FontB"=>255));

    $myPicture2->drawLegend($ancho-280,9,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL,"FontR"=>255,"FontG"=>255,"FontB"=>255));

    /* Render the picture (choose the best way) */
    $myPicture->Render("imagenesGraficas/".$reporte["alias"]."/selectividadModalidadesBosque.png"); 
    $myPicture2->Render("imagenesGraficas/".$reporte["alias"]."/selectividadModalidadesCNA.png"); 
    //$myPicture->autoOutput("imagenesGraficas/example.drawLineChart.plots.png"); ?>
    <h4 style="margin-left:20px;">Índice de Selectividad CNA</h4>
    <img alt="Resultados selectividad CNA" src="<?php echo "imagenesGraficas/".$reporte["alias"]."/selectividadModalidadesCNA.png?random=".time(); ?>" style="border: 1px solid gray;margin: 0 20px;"/>

    <h4 style="margin-top:30px;margin-left:20px;">Índice de Selectividad Universidad</h4>
        <img alt="Resultados selectividad" src="<?php echo "imagenesGraficas/".$reporte["alias"]."/selectividadModalidadesBosque.png?random=".time(); ?>" style="border: 1px solid gray;margin: 0 20px;"/>
 <?php }
 
 function drawGraphicModalidad($db,$periodos,$reporte,$modalidad,$carrera,$fontPath) { 
    
    /* Create and populate the pData object */
    $MyData = new pData();  
    $MyData2 = new pData(); 
    
     $valores = getValores($db,$modalidad,$periodos);
         //echo "<pre>";print_r($valores["valores"]);
     $MyData->addPoints($valores["valores"][1],$modalidad["nombremodalidadacademicasic"]);
     $MyData2->addPoints($valores["valores"][2],$modalidad["nombremodalidadacademicasic"]);
     
     if($carrera!==""){
         $query_carrera = "select nombrecarrera
                                from carrera where codigocarrera = '$carrera'";
        $row_carrera= $db->GetRow($query_carrera);
        $valoresC = getValoresCarrera($db,$carrera,$periodos);
        //echo "<pre>";print_r($valoresC);
        $MyData->addPoints($valoresC[0],$row_carrera["nombrecarrera"]);
         $MyData2->addPoints($valoresC[1],$row_carrera["nombrecarrera"]);
    }   
     
    $MyData->setAxisName(0,"índice (%)");
    $MyData->addPoints($valores["valores"][0],"Labels");
    $MyData->setSerieDescription("Labels","Carreras");
    $MyData->setAbscissa("Labels");
    $MyData->setSerieOnAxis($modalidad["nombremodalidadacademicasic"],0);
    //$MyData->setSeriePicture($modalidad["nombremodalidadacademicasic"],"../../images/circle4.png"); 
    //$MyData->setSerieOnAxis($row_carrera["nombrecarrera"],0);
    
    $MyData2->setAxisName(0,"índice");
    $MyData2->addPoints($valores["valores"][0],"Labels");
    $MyData2->setSerieDescription("Labels","Carreras");
    $MyData2->setAbscissa("Labels");
    //$MyData2->setSerieWeight($modalidad["nombremodalidadacademicasic"],2); 
    $MyData2->setSeriePicture($modalidad["nombremodalidadacademicasic"],"../../images/circle4.png"); 
    //$MyData2->setSerieShape($modalidad["nombremodalidadacademicasic"],SERIE_SHAPE_FILLEDSQUARE); 

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
    $myPicture2 = new pImage($ancho,$alto,$MyData2);

    /* Turn on Antialiasing */
    $myPicture->Antialias = TRUE;
    $myPicture2->Antialias = TRUE;


    /* Overlay with a gradient */
    $myPicture->drawGradientArea(0,0,$ancho,20,DIRECTION_VERTICAL,array("StartR"=>0,"StartG"=>0,"StartB"=>0,"EndR"=>50,"EndG"=>50,"EndB"=>50,"Alpha"=>80));
    $myPicture2->drawGradientArea(0,0,$ancho,20,DIRECTION_VERTICAL,array("StartR"=>0,"StartG"=>0,"StartB"=>0,"EndR"=>50,"EndG"=>50,"EndB"=>50,"Alpha"=>80));

    /* Add a border to the picture */
    $myPicture->drawRectangle(0,0,$ancho-1,$alto-1,array("R"=>0,"G"=>0,"B"=>0));
    $myPicture2->drawRectangle(0,0,$ancho-1,$alto-1,array("R"=>0,"G"=>0,"B"=>0));

    /* Write the chart title */ 
    $myPicture->setFontProperties(array("FontName"=>$fontPath."verdana.ttf","FontSize"=>8,"R"=>255,"G"=>255,"B"=>255));
    $myPicture->drawText(10,16,"Índice de Selectividad",array("FontSize"=>9,"Align"=>TEXT_ALIGN_BOTTOMLEFT));
    $myPicture2->setFontProperties(array("FontName"=>$fontPath."verdana.ttf","FontSize"=>8,"R"=>255,"G"=>255,"B"=>255));
    $myPicture2->drawText(10,16,"Índice de Selectividad",array("FontSize"=>9,"Align"=>TEXT_ALIGN_BOTTOMLEFT));

    /* Set the default font */
    $myPicture->setFontProperties(array("FontName"=>$fontPath."calibri.ttf","FontSize"=>8,"R"=>0,"G"=>0,"B"=>0));
    $myPicture2->setFontProperties(array("FontName"=>$fontPath."calibri.ttf","FontSize"=>8,"R"=>0,"G"=>0,"B"=>0));

    /* Define the chart area */
    //el 80 es donde empieza la grafica de izquierda a derecha y el 40 es de arriba para abajo
    $myPicture->setGraphArea(60,40,$ancho-30,280);
    $myPicture2->setGraphArea(60,40,$ancho-30,280);

    /* Draw the scale */
    $scaleSettings = array("XMargin"=>10,"YMargin"=>10,"Floating"=>TRUE,"Mode"=>SCALE_MODE_START0,"GridR"=>200,"GridG"=>200,"GridB"=>200,"DrawSubTicks"=>TRUE,"CycleBackground"=>TRUE);
    $myPicture->drawScale($scaleSettings);
    $myPicture2->drawScale($scaleSettings);
    //$myPicture->drawScale(array("DrawSubTicks"=>TRUE,'LabelRotation'=>45,"Mode"=>SCALE_MODE_ADDALL_START0));

    /* Enable shadow computing */
    $myPicture->setShadow(FALSE);
    $myPicture2->setShadow(FALSE);

    /* Draw the line chart */
    $myPicture->drawLineChart();
    $myPicture2->drawLineChart();
    $myPicture->drawPlotChart(array("DisplayValues"=>TRUE,"PlotBorder"=>TRUE,"BorderSize"=>1,"Surrounding"=>-60,"BorderAlpha"=>80));
    $myPicture2->drawPlotChart(array("DisplayValues"=>TRUE,"PlotBorder"=>TRUE,"BorderSize"=>1,"Surrounding"=>-60,"BorderAlpha"=>80));

    //$myPicture->drawPlotChart(array("DisplayValues"=>FALSE,"PlotBorder"=>TRUE,"BorderSize"=>2,"Surrounding"=>-60,"BorderAlpha"=>80));
       
    /* Write the chart legend */
    //este es el nombre de arriba que de largo le puse 590 para que me quedaran los periodos en la punta
    $myPicture->drawLegend($ancho-280,8,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL,"FontR"=>255,"FontG"=>255,"FontB"=>255));

    $myPicture2->drawLegend($ancho-280,8,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL,"FontR"=>255,"FontG"=>255,"FontB"=>255));

    /* Render the picture (choose the best way) */
    $myPicture->Render("imagenesGraficas/".$reporte["alias"]."/selectividadModalidadesBosqueCarrera.png"); 
    $myPicture2->Render("imagenesGraficas/".$reporte["alias"]."/selectividadModalidadesCNACarrera.png"); 
    //$myPicture->autoOutput("imagenesGraficas/example.drawLineChart.plots.png"); ?>
    <h4 style="margin-left:20px;">Índice de Selectividad CNA</h4>
    <img alt="Resultados selectividad CNA" src="<?php echo "imagenesGraficas/".$reporte["alias"]."/selectividadModalidadesCNACarrera.png?random=".time(); ?>" style="border: 1px solid gray;margin: 0 20px;"/>

    <h4 style="margin-top:30px;margin-left:20px;">Índice de Selectividad Universidad</h4>
        <img alt="Resultados selectividad" src="<?php echo "imagenesGraficas/".$reporte["alias"]."/selectividadModalidadesBosqueCarrera.png?random=".time(); ?>" style="border: 1px solid gray;margin: 0 20px;"/>
 <?php }
 //$start = microtime(true);

$periodos = getPeriodosArray($db,$dates);

 if($_GET["modalidad"]==""){
        $modalidad= getModalidades($db); ?>

            <div class="grafica">
            <?php drawGraphic($db,$periodos,$reporte,$modalidad,$fontPath); /*<img alt="Resultados selectividad" src="<?php echo "imagenesGraficas/". $reporte["alias"] ."/selectividad_".$codigoperiodo."_".$row_modalidad["codigomodalidadacademicasic"].".png"; ?>" style="border: 1px solid gray;margin-right: 20px;"/>
            */ ?> </div>
        <?php  } else {
         $query_tipomodalidad = "select nombremodalidadacademicasic, codigomodalidadacademicasic 
             from modalidadacademicasic where codigomodalidadacademicasic=".$_GET["modalidad"];
		$modalidad = $db->GetRow($query_tipomodalidad);?>

            <div class="grafica">
            <?php drawGraphicModalidad($db,$periodos,$reporte,$modalidad,$_GET["codigocarrera"],$fontPath);   ?> </div>
     <?php   }

//$end = microtime(true);
//$time = $end - $start;
//echo('script took ' . $time . ' seconds to execute.');
        
       exit();

} ?>

<form action="" method="post" id="absorcionGrafica" class="report">
	<span class="mandatory">* Son campos obligatorios</span>
        <input type="hidden" name="consultar" value="1" />
	<fieldset>  
		
		<label for="modalidad" class="fixedLabel">Modalidad Academica: </label>		
		
		<?php
		$query_tipomodalidad = "select nombremodalidadacademicasic, codigomodalidadacademicasic from modalidadacademicasic where codigomodalidadacademicasic not in('000',100,101,400)";
		$tipomodalidad = $db->Execute($query_tipomodalidad);
		?>		
		<select name="modalidad" id="modalidad" style='font-size:0.8em'>
		<option value=""></option>
		<?php while($row_tipomodalidad = $tipomodalidad->FetchRow()) {
		?>
		<option value="<?php echo $row_tipomodalidad['codigomodalidadacademicasic']?>">
		<?php echo $row_tipomodalidad['nombremodalidadacademicasic']; ?>
		</option>
		<?php
		}
		?>
		</select>
                
                <label for="unidadAcademica" class="fixedLabel">Unidad Académica: </label>
                <select name="codigocarrera" id="unidadAcademica" style='font-size:0.8em;width:auto'>
                    <option value="" selected></option>
                </select>			
		
                <div class="vacio"></div>
	
	<input type="submit" value="Consultar" class="first small" style="margin-left:220px" />	
        <img src="../../images/ajax-loader.gif" style="display:none;clear:both;margin:20px auto;" id="loading"/>
		<div id='tableDiv'></div>
	</fieldset>
</form>
<script type="text/javascript">
	$(':submit').click(function(event) {
		event.preventDefault();
		var valido= validateForm("#absorcionGrafica");
		if(valido){
			sendForm();
		}
	});
	function sendForm(){
            $('#tableDiv').html("");
            $("#loading").css("display","block");
		$.ajax({
				type: 'GET',
				url: 'generarGrafica.php?id=<?php echo $reporte["idsiq_reporte"]; ?>',
				async: false,
				data: $('#absorcionGrafica').serialize(),                
				success:function(data){	
                                     var $str1 = $(data);//this turns your string into real html 
                                    $("#loading").css("display","none");	
                                    $('#tableDiv').html("<div class='grafica' style='margin-bottom:0;'>"+$str1.find('.grafica').eq(0).html()+"</div>");					
					
				},
				error: function(data,error,errorThrown){alert(error + errorThrown);}
		});            
	}
        
        $('#absorcionGrafica #modalidad').change(function(event) {
                    getCarreras("#absorcionGrafica");
                });
                
         $('#absorcionGrafica #unidadAcademica').change(function(event) {
                    getEstudiantes("#absorcionGrafica");
                });
                
                function getCarreras(formName){
                    $(formName + " #unidadAcademica").html("");
                    $(formName + " #unidadAcademica").css("width","auto");   
                        
                    if($(formName + ' #modalidad').val()!=""){
                        var mod = $(formName + ' #modalidad').val();
                            $.ajax({
                                dataType: 'json',
                                type: 'POST',
                                url: '../searchs/lookForCareersByModalidadSIC.php',
                                data: { modalidad: mod },     
                                success:function(data){
                                     var html = '<option value="" selected></option>';
                                     var i = 0;
                                        while(data.length>i){
                                            html = html + '<option value="'+data[i]["value"]+'" >'+data[i]["label"]+'</option>';
                                            i = i + 1;
                                        }                                    
                            
                                        $(formName + " #unidadAcademica").html(html);
                                        $(formName + " #unidadAcademica").css("width","500px");                                        
                                },
                                error: function(data,error,errorThrown){alert(error + errorThrown);}
                            });  
                    }
                }
</script>    
    
