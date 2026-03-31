<?php
if(isset($_GET['consultar']) && isset($_GET['codigocarrera'])) {

require_once('../../../consulta/estadisticas/matriculasnew/funciones/obtener_datos.php');

/*function getValores($db,$modalidad,$periodos){
        $labelPeriodos = array();
        $valores = array();
    for($i=0; $i<count($periodos); $i++){
        $carreras = getCarrerasModalidadSIC($db, $modalidad["codigomodalidadacademicasic"]);
            $codigoperiodo = $periodos[$i]["codigoperiodo"];
            $arrayP = str_split($codigoperiodo, strlen($codigoperiodo)-1);
        //var_dump(str_split($codigoperiodo, strlen($codigoperiodo)-1));echo "<br/><br/>";
            $labelPeriodos[] = $arrayP[0]."-".$arrayP[1];
        $j = 0;
        $datos_estadistica=new obtener_datos_matriculas($db,$codigoperiodo); 
        //var_dump($datos_estadistica); echo "<br/><br/>";
        while($row_carreras = $carreras->FetchRow()){
            //$labelCarreras[] = $row_carreras["nombrecarrera"];

            $array_matnuevo=$datos_estadistica->obtener_datos_estudiantes_matriculados_nuevos($row_carreras['codigocarrera'],'arreglo');	   
            $query_cupos="SELECT cupo from siq_huerfana_cuposProgramaAcademico where codigocarrera='".$row_carreras['codigocarrera']."' and codigoperiodo='$codigoperiodo'";
            $cupos= $db->Execute($query_cupos);
            $totalRows_cupos = $cupos->RecordCount();
            $row_cupos = $cupos->FetchRow();
            if($row_cupos['cupo']!=""){	
                    $totalcupo+=$row_cupos['cupo'];
            }
            else{
                    $totalcupo+=0;
            }			   
            $total_matnuevo+=count($array_matnuevo);	   

            $j = $j + 1;
        }
             //var_dump($total_matnuevo);echo "<br/><br/>";

            if(($totalcupo) == 0){
                $indicetres = 0;
            } else {
                    $indicetres=$total_matnuevo/$totalcupo;
            }
            $valores[] = $indicetres;
            $total_matnuevo = 0;
            $totalcupo = 0;
    }
    
          // var_dump($valores); echo "<br/>";
    return array("valores"=>array($labelPeriodos,$valores));
}*/

function getValores($db,$modalidad,$periodos){
        $labelPeriodos = array();
        $valores = array();
    for($i=0; $i<count($periodos); $i++){
        $codigoperiodo = $periodos[$i]["codigoperiodo"];
        $arrayP = str_split($codigoperiodo, strlen($codigoperiodo)-1);
        $labelPeriodos[] = $arrayP[0]."-".$arrayP[1];
        
        $datos_estadistica=new obtener_datos_matriculas($db,$codigoperiodo); 
        //var_dump($modalidad["codigomodalidadacademicasic"]); echo "<br/><br/>";
        $query_cupos="SELECT c.codigocarrera, cp.meta as cupo from obs_metas_matriculados cp
        INNER JOIN carrera c ON c.codigocarrera=cp.codigocarrera 
        AND c.codigomodalidadacademicasic='".$modalidad["codigomodalidadacademicasic"]."' 
        WHERE cp.codigoperiodo='$codigoperiodo' and cp.codigoestado=100";

        $array = $db->GetAll($query_cupos);
        $totalcupo = 0;
        foreach ($array as $value) {
            $totalcupo += $value["cupo"];
        }
        //echo $totalcupo;
                
        /*$matriculados=$datos_estadistica->obtener_datos_estudiantes_matriculados_nuevos_modalidad_carrera('conteo',$modalidad["codigomodalidadacademicasic"]);	
        foreach($matriculados as $key=>$value){      			   
            $total_matnuevo+=$value;	
        }*/
        $total_matnuevo=$datos_estadistica->obtener_datos_estudiantes_matriculados_nuevos('','conteo',$modalidad["codigomodalidadacademicasic"]);
             //var_dump($total_matnuevo);echo "<br/><br/>";

            if(($totalcupo) == 0){
                $indicetres = 0;
            } else {
                 $indicetres=($total_matnuevo/$totalcupo)*100;
            }
            $valores[] = round($indicetres, 2);
            $total_matnuevo = 0;
    }
    
          // var_dump($valores); echo "<br/>";
    return array("valores"=>array($labelPeriodos,$valores));
}

function getValoresCarrera($db,$carrera,$periodos){
        $valores = array();
    for($i=0; $i<count($periodos); $i++){
        $codigoperiodo = $periodos[$i]["codigoperiodo"];
        
        $datos_estadistica=new obtener_datos_matriculas($db,$codigoperiodo); 
        //var_dump($modalidad["codigomodalidadacademicasic"]); echo "<br/><br/>";
        $query_cupos="SELECT c.codigocarrera, cp.meta as cupo from obs_metas_matriculados cp
        INNER JOIN carrera c ON c.codigocarrera=cp.codigocarrera 
        AND c.codigocarrera='".$carrera."' 
        where cp.codigoperiodo='$codigoperiodo' and cp.codigoestado=100";

        $array = $db->GetRow($query_cupos);
        $totalcupo = 0;
        foreach ($array as $value) {
            $totalcupo += $value["cupo"];
        }
        
        $total_matnuevo=$datos_estadistica->obtener_datos_estudiantes_matriculados_nuevos($carrera,'conteo');
    
            if(($totalcupo) == 0){
                $indicetres = 0;
            } else {
                 $indicetres=($total_matnuevo/$totalcupo)*100;
            }
            $valores[] = round($indicetres, 2);
            $total_matnuevo = 0;
    }
    
          // var_dump($valores); echo "<br/>";
    return $valores;
}

function drawGraphic($db,$periodos,$reporte,$modalidad,$fontPath) { 

    /* Create and populate the pData object */
    $MyData = new pData();  
     //while($row_periodos = $periodos->FetchRow()){
    while($row_modalidad = $modalidad->FetchRow()){
     //for($j=0; $j<count($periodos); $j++){
         //var_dump($row_periodos["codigoperiodo"]);echo "<br/><br/>";
        //var_dump($row_modalidad["nombremodalidadacademicasic"]);echo "<br/><br/>";
         $valores = getValores($db,$row_modalidad,$periodos);
        //var_dump($valores["valores"][1]);echo "<br/><br/>";
         $MyData->addPoints($valores["valores"][1],$row_modalidad["nombremodalidadacademicasic"]);
     }
     
   
    $MyData->setAxisName(0,"índice (%)");
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
    $alto = 300;
    $myPicture = new pImage($ancho,$alto,$MyData);

    /* Turn of Antialiasing */
    $myPicture->Antialias = FALSE;

    /* Draw the background */
    //$Settings = array("R"=>170, "G"=>183, "B"=>87, "Dash"=>1, "DashR"=>190, "DashG"=>203, "DashB"=>107);
    //$myPicture->drawFilledRectangle(0,0,$ancho,$alto,$Settings);

    /* Overlay with a gradient */
    //$Settings = array("StartR"=>279, "StartG"=>231, "StartB"=>139, "EndR"=>1, "EndG"=>138, "EndB"=>68, "Alpha"=>50);
    //$myPicture->drawGradientArea(0,0,$ancho,$alto,DIRECTION_VERTICAL,$Settings);
    $myPicture->drawGradientArea(0,0,$ancho,20,DIRECTION_VERTICAL,array("StartR"=>0,"StartG"=>0,"StartB"=>0,"EndR"=>50,"EndG"=>50,"EndB"=>50,"Alpha"=>80));

    /* Add a border to the picture */
    $myPicture->drawRectangle(0,0,$ancho-1,$alto-1,array("R"=>0,"G"=>0,"B"=>0));

    /* Write the chart title */ 
    $myPicture->setFontProperties(array("FontName"=>$fontPath."verdana.ttf","FontSize"=>8,"R"=>255,"G"=>255,"B"=>255));
    $myPicture->drawText(10,16,"Índice de Vinculación",array("FontSize"=>9,"Align"=>TEXT_ALIGN_BOTTOMLEFT));

    /* Set the default font */
    $myPicture->setFontProperties(array("FontName"=>$fontPath."calibri.ttf","FontSize"=>8,"R"=>0,"G"=>0,"B"=>0));

    /* Define the chart area */
    //el 80 es donde empieza la grafica de izquierda a derecha y el 40 es de arriba para abajo
    $myPicture->setGraphArea(60,40,$ancho-30,280);

    /* Draw the scale */
    //$scaleSettings = array("XMargin"=>10,"YMargin"=>10,"Floating"=>TRUE,"Mode"=>SCALE_MODE_START0,"GridR"=>200,"GridG"=>200,"GridB"=>200,"DrawSubTicks"=>TRUE,"CycleBackground"=>TRUE,'LabelRotation'=>45);
    $scaleSettings = array("XMargin"=>10,"YMargin"=>10,"Floating"=>TRUE,"Mode"=>SCALE_MODE_START0,"GridR"=>200,"GridG"=>200,"GridB"=>200,"DrawSubTicks"=>TRUE,"CycleBackground"=>TRUE);
    $myPicture->drawScale($scaleSettings);
    //$myPicture->drawScale(array("DrawSubTicks"=>TRUE,'LabelRotation'=>45,"Mode"=>SCALE_MODE_ADDALL_START0));

    /* Turn on Antialiasing */
    $myPicture->Antialias = TRUE;

    /* Enable shadow computing */
    //$myPicture->setShadow(TRUE,array("X"=>1,"Y"=>1,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>10));
    $myPicture->setShadow(FALSE);

    /* Draw the line chart */
    $myPicture->drawLineChart();
    $myPicture->drawPlotChart(array("DisplayValues"=>TRUE,"PlotBorder"=>TRUE,"BorderSize"=>1,"Surrounding"=>-60,"BorderAlpha"=>80));
       
    /* Write the chart legend */
    //este es el nombre de arriba que de largo le puse 590 para que me quedaran los periodos en la punta
    $myPicture->drawLegend($ancho-280,9,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL,"FontR"=>255,"FontG"=>255,"FontB"=>255));

    /* Render the picture (choose the best way) */
    $myPicture->Render("imagenesGraficas/".$reporte["alias"]."/vinculacionModalidades.png"); 
    //$myPicture->autoOutput("imagenesGraficas/example.drawLineChart.plots.png"); ?>
        <img alt="Resultados selectividad" src="<?php echo "imagenesGraficas/".$reporte["alias"]."/vinculacionModalidades.png?random=".time(); ?>" style="border: 1px solid gray;margin: 0 20px;"/>
 <?php }
 function drawGraphicModalidad($db,$periodos,$reporte,$modalidad,$carrera,$fontPath) { 
    
    /* Create and populate the pData object */
    $MyData = new pData();  
     $valores = getValores($db,$modalidad,$periodos);
    $MyData->addPoints($valores["valores"][1],$modalidad["nombremodalidadacademicasic"]);
        if($carrera!==""){
         $query_carrera = "select nombrecarrera
                                from carrera where codigocarrera = '$carrera'";
        $row_carrera= $db->GetRow($query_carrera);
        $valoresC = getValoresCarrera($db,$carrera,$periodos);
        $MyData->addPoints($valoresC,$row_carrera["nombrecarrera"]);
    }
    $MyData->setAxisName(0,"índice (%)");
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
    $alto = 300;
    $myPicture = new pImage($ancho,$alto,$MyData);

    /* Turn of Antialiasing */
    $myPicture->Antialias = FALSE;

    /* Draw the background */
    //$Settings = array("R"=>170, "G"=>183, "B"=>87, "Dash"=>1, "DashR"=>190, "DashG"=>203, "DashB"=>107);
    //$myPicture->drawFilledRectangle(0,0,$ancho,$alto,$Settings);

    /* Overlay with a gradient */
    //$Settings = array("StartR"=>279, "StartG"=>231, "StartB"=>139, "EndR"=>1, "EndG"=>138, "EndB"=>68, "Alpha"=>50);
    //$myPicture->drawGradientArea(0,0,$ancho,$alto,DIRECTION_VERTICAL,$Settings);
    $myPicture->drawGradientArea(0,0,$ancho,20,DIRECTION_VERTICAL,array("StartR"=>0,"StartG"=>0,"StartB"=>0,"EndR"=>50,"EndG"=>50,"EndB"=>50,"Alpha"=>80));

    /* Add a border to the picture */
    $myPicture->drawRectangle(0,0,$ancho-1,$alto-1,array("R"=>0,"G"=>0,"B"=>0));

    /* Write the chart title */ 
    $myPicture->setFontProperties(array("FontName"=>$fontPath."verdana.ttf","FontSize"=>8,"R"=>255,"G"=>255,"B"=>255));
    $myPicture->drawText(10,16,"Índice de Vinculación",array("FontSize"=>9,"Align"=>TEXT_ALIGN_BOTTOMLEFT));

    /* Set the default font */
    $myPicture->setFontProperties(array("FontName"=>$fontPath."calibri.ttf","FontSize"=>8,"R"=>0,"G"=>0,"B"=>0));

    /* Define the chart area */
    //el 80 es donde empieza la grafica de izquierda a derecha y el 40 es de arriba para abajo
    $myPicture->setGraphArea(60,40,$ancho-30,280);

    /* Draw the scale */
    //$scaleSettings = array("XMargin"=>10,"YMargin"=>10,"Floating"=>TRUE,"Mode"=>SCALE_MODE_START0,"GridR"=>200,"GridG"=>200,"GridB"=>200,"DrawSubTicks"=>TRUE,"CycleBackground"=>TRUE,'LabelRotation'=>45);
    $scaleSettings = array("XMargin"=>10,"YMargin"=>10,"Floating"=>TRUE,"Mode"=>SCALE_MODE_START0,"GridR"=>200,"GridG"=>200,"GridB"=>200,"DrawSubTicks"=>TRUE,"CycleBackground"=>TRUE);
    $myPicture->drawScale($scaleSettings);
    //$myPicture->drawScale(array("DrawSubTicks"=>TRUE,'LabelRotation'=>45,"Mode"=>SCALE_MODE_ADDALL_START0));

    /* Turn on Antialiasing */
    $myPicture->Antialias = TRUE;

    /* Enable shadow computing */
    //$myPicture->setShadow(TRUE,array("X"=>1,"Y"=>1,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>10));
    $myPicture->setShadow(FALSE);

    /* Draw the line chart */
    $myPicture->drawLineChart();
    $myPicture->drawPlotChart(array("DisplayValues"=>TRUE,"PlotBorder"=>TRUE,"BorderSize"=>1,"Surrounding"=>-60,"BorderAlpha"=>80,"DisplayColor"=>DISPLAY_AUTO));
       
    /* Write the chart legend */
    //este es el nombre de arriba que de largo le puse 590 para que me quedaran los periodos en la punta
    $myPicture->drawLegend($ancho-280,9,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL,"FontR"=>255,"FontG"=>255,"FontB"=>255));

    /* Render the picture (choose the best way) */
    $myPicture->Render("imagenesGraficas/".$reporte["alias"]."/vinculacionModalidadCarrera.png"); 
    //$myPicture->autoOutput("imagenesGraficas/example.drawLineChart.plots.png"); ?>
        <img alt="Resultados selectividad" src="<?php echo "imagenesGraficas/".$reporte["alias"]."/vinculacionModalidadCarrera.png?random=".time(); ?>" style="border: 1px solid gray;margin: 0 20px;"/>
  <?php }
 //$start4 = microtime(true);
$periodos = getPeriodosArray($db,$dates);

if($_GET["modalidad"]==""){
        $modalidad= getModalidades($db);
		//echo $codigoperiodo."<br/><br/>";
         //while($row_modalidad = $modalidad->FetchRow()){
             //var_dump($row_modalidad);
            //drawGraphic($db,$periodos,$reporte,$row_modalidad,$fontPath); ?>

            <div class="grafica">
            <!--<h4><?php //echo $row_modalidad["nombremodalidadacademicasic"]; ?></h4>-->
            <?php //drawGraphic($db,$periodos,$reporte,$row_modalidad,$fontPath); 
             drawGraphic($db,$periodos,$reporte,$modalidad,$fontPath); ?> </div>
      <?php   } else {
        $query_tipomodalidad = "select nombremodalidadacademicasic, codigomodalidadacademicasic 
             from modalidadacademicasic where codigomodalidadacademicasic=".$_GET["modalidad"];
		$modalidad = $db->GetRow($query_tipomodalidad);?>

            <div class="grafica">
            <?php drawGraphicModalidad($db,$periodos,$reporte,$modalidad,$_GET["codigocarrera"],$fontPath);   ?> </div>
     <?php   }
     
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
		$totalRows_tipomodalidad = $tipomodalidad->RecordCount();
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
    