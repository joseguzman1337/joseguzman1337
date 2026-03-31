<?php

if($_GET['semestre'] && $_GET['codigocarrera']) {

$ruta = "../";
while (!is_file($ruta.'Connections/sala2.php'))
{
        $ruta = $ruta."../";
}
require_once($ruta.'/funciones/notas/funcionequivalenciapromedio.php');
require_once($ruta.'/funciones/notas/redondeo.php');
require_once($ruta.'/consulta/estadisticas/matriculasnew/funciones/obtener_datos.php');
require_once('./reportes/'.$categoria["alias"].'/functionsGananciaAcademica.php');
require($ruta.'Connections/sala2.php');
/* Query rango de Periodo */
$periodo = $_GET['semestre'];
$carrera = $_GET['codigocarrera'];
$arrayP = str_split($periodo, strlen($periodo)-1);
$labelPeriodo = $arrayP[0]."-".$arrayP[1];

$array_matnuevo=obtenerEstudiantes($db,$periodo,$carrera);
    $promedios = array();
 if(count($array_matnuevo)>0 && is_array($array_matnuevo)){
    //echo "<pre>"; print_r($array_matnuevo);
    
    $totalEstudiantesCohorte = count($array_matnuevo);
    $data = obtenerMaxSemestreCarrera($db,$carrera,$periodo);
    $maxSemestre = $data["semestre"];
    //echo "<pre>"; print_r($maxSemestre); echo "<br/><br/>";
    for($i=1; $i<=$maxSemestre; $i++){
        $sumaPromedios = 0;
        $totalEstudiantesSemestre = 0;
        for($z=0; $z<$totalEstudiantesCohorte; $z++){
            $codigoestudiante = $array_matnuevo[$z]['codigoestudiante'];
            $nota = obtenerPromedioEstudiantes($db,$codigoestudiante,$carrera,$i,$database_sala, $sala,$ruta);
            $sumaPromedios += $nota;
            if($nota!=0){
                $totalEstudiantesSemestre += 1;
            }
        }
        //echo "<pre>"; print_r($sumaPromedios); echo "<br/><br/>";
        if($sumaPromedios!=0){
            $promedios["semestres"][] = $i;
            $promedios["notas"][] = round($sumaPromedios/$totalEstudiantesSemestre, 2);
        }
    }
 }
 
    $query_carrera = "select nombrecarrera
                                from carrera 
                                                    where codigocarrera = '$carrera'";
    $row_carrera= $db->GetRow($query_carrera);
//var_dump($_GET['codigoestudiante']);
?>
<div class="grafica">
<?php if(!isset($_GET['codigoestudiante']) || $_GET['codigoestudiante']=="") {
    
    /* Create and populate the pData object */
    $MyData = new pData(); 
    //var_dump($promediosSemestre);
    //var_dump($row_carrera);
    $MyData->addPoints($promedios["notas"],$row_carrera["nombrecarrera"]." Cohorte ".$labelPeriodo);
     
    //var_dump($semestres);
    $MyData->setAxisName(0,"promedio");
    $MyData->addPoints($promedios["semestres"],"Labels");
    $MyData->setSerieDescription("Labels","Semestres");
    $MyData->setAbscissa("Labels");
    $MyData->setPalette($row_carrera["nombrecarrera"]." Cohorte ".$labelPeriodo,array("R"=>44,"G"=>87,"B"=>0));

    /* Create the pChart object */
    $numCarreras = $maxSemestre;
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

    /* Draw the background */

    /* Overlay with a gradient */
    $myPicture->drawGradientArea(0,0,$ancho,20,DIRECTION_VERTICAL,array("StartR"=>0,"StartG"=>0,"StartB"=>0,"EndR"=>50,"EndG"=>50,"EndB"=>50,"Alpha"=>80));

    /* Add a border to the picture */
    $myPicture->drawRectangle(0,0,$ancho-1,$alto-1,array("R"=>0,"G"=>0,"B"=>0));

    /* Write the chart title */ 
    $myPicture->setFontProperties(array("FontName"=>$fontPath."verdana.ttf","FontSize"=>8,"R"=>255,"G"=>255,"B"=>255));
    $myPicture->drawText(10,16,"Ganancia Académica",array("FontSize"=>9,"Align"=>TEXT_ALIGN_BOTTOMLEFT));

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
    $myPicture->drawLineChart(array("DisplayValues"=>FALSE,"DisplayColor"=>DISPLAY_AUTO));
    $myPicture->drawPlotChart(array("DisplayValues"=>TRUE,"PlotBorder"=>TRUE,"BorderSize"=>1,"Surrounding"=>-60,"BorderAlpha"=>80));
    
    /* Write the chart legend */
    //este es el nombre de arriba que de largo le puse 590 para que me quedaran los periodos en la punta
    $myPicture->drawLegend($ancho-320,9,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL,"FontR"=>255,"FontG"=>255,"FontB"=>255));
    
    /*if(is_file('imagenesGraficas/'.$reporte["alias"].'/gananciaAcademica.png')){
        unlink('imagenesGraficas/'.$reporte["alias"].'/gananciaAcademica.png');
    }**/
    /* Render the picture (choose the best way) */
    $myPicture->Render("imagenesGraficas/".$reporte["alias"]."/gananciaAcademica.png"); 
    //$myPicture->autoOutput("imagenesGraficas/example.drawLineChart.plots.png"); 
    ?>
        <img alt="Resultados ganancia" src="<?php echo "imagenesGraficas/".$reporte["alias"]."/gananciaAcademica.png?random=".time(); ?>" style="border: 1px solid gray;margin-right: 20px;"/>
       
 <?php 
} else {
    /***máximo semestre en el periodo especificado***/
    $data = obtenerMaxSemestreEstudiante($db,$_GET['codigoestudiante']);
    $maxSemestre = $data["semestre"];
    //echo "<br/>";var_dump($maxSemestre);
    $notaspromedio = array();
    for($i=1; $i<=$maxSemestre; $i++){
        /*$query = "SELECT MAX(p.codigoperiodo) as max from prematricula p 
            INNER JOIN estudiante e ON e.codigoestudiante=p.codigoestudiante AND e.codigocarrera='".$carrera."' 
            WHERE p.codigoestudiante=".$_GET['codigoestudiante']." AND p.semestreprematricula='".$i."' 
                AND p.codigoestadoprematricula IN (40,41) ";
        $row = $db->GetRow($query);
        $periodosemestral = $row["max"];*/
        $codigoestudiante = $_GET['codigoestudiante'];
        //require($ruta.'/funciones/notas/calculopromediosemestral.php');
        $nota = obtenerPromedioEstudiantes($db,$codigoestudiante,$carrera,$i,$database_sala, $sala,$ruta);
        if($nota!=0){
            $notaspromedio[] = round($nota,2);
        } else {
            $notaspromedio[] = VOID;
        }
    }
       // echo "<br/>";var_dump($notaspromedio);
    /*$query_carrera = "select nombrecarrera
                                from carrera 
                                                    where codigocarrera = '$carrera'";
    $row_carrera= $db->GetRow($query_carrera);*/
    
    /* Create and populate the pData object */
    $MyData = new pData(); 
    //var_dump($promedios);
    //var_dump($notaspromedio);
    $MyData->addPoints($promedios["notas"],"Carrera Cohorte ".$labelPeriodo);
    $MyData->addPoints($notaspromedio,"Estudiante");
     
    //var_dump($semestres);
    $MyData->setAxisName(0,"promedio");
    $MyData->addPoints($promedios["semestres"],"Labels");
    $MyData->setSerieDescription("Labels","Semestres");
    $MyData->setAbscissa("Labels");
    $MyData->setPalette("Carrera Cohorte ".$labelPeriodo,array("R"=>44,"G"=>87,"B"=>0));
    $MyData->setPalette("Estudiante",array("R"=>132,"G"=>0,"B"=>46));

    /* Create the pChart object */
    $numCarreras = $maxSemestre;
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

    /* Draw the background */

    /* Overlay with a gradient */
    $myPicture->drawGradientArea(0,0,$ancho,20,DIRECTION_VERTICAL,array("StartR"=>0,"StartG"=>0,"StartB"=>0,"EndR"=>50,"EndG"=>50,"EndB"=>50,"Alpha"=>80));

    /* Add a border to the picture */
    $myPicture->drawRectangle(0,0,$ancho-1,$alto-1,array("R"=>0,"G"=>0,"B"=>0));

    /* Write the chart title */ 
    $myPicture->setFontProperties(array("FontName"=>$fontPath."verdana.ttf","FontSize"=>8,"R"=>255,"G"=>255,"B"=>255));
    $myPicture->drawText(10,16,"Ganancia Académica",array("FontSize"=>9,"Align"=>TEXT_ALIGN_BOTTOMLEFT));

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
    $myPicture->drawLineChart(array("DisplayValues"=>FALSE));
    //$myPicture->drawPlotChart(array("DisplayValues"=>FALSE,"PlotBorder"=>TRUE,"BorderSize"=>1,"Surrounding"=>-60,"BorderAlpha"=>80));
    
    /* Write the chart legend */
    //este es el nombre de arriba que de largo le puse 590 para que me quedaran los periodos en la punta
    $myPicture->drawLegend($ancho-200,9,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL,"FontR"=>255,"FontG"=>255,"FontB"=>255));
    
    /*if(is_file('imagenesGraficas/'.$reporte["alias"].'/gananciaAcademica.png')){
        unlink('imagenesGraficas/'.$reporte["alias"].'/gananciaAcademica.png');
    }**/
    /* Render the picture (choose the best way) */
    $myPicture->Render("imagenesGraficas/".$reporte["alias"]."/gananciaAcademica.png"); 
    //$myPicture->autoOutput("imagenesGraficas/example.drawLineChart.plots.png"); 
    ?>
        <img alt="Resultados ganancia" src="<?php echo "imagenesGraficas/".$reporte["alias"]."/gananciaAcademica.png?random=".time(); ?>" style="border: 1px solid gray;margin-right: 20px;"/>
       
 <?php 
} ?>
</div>
<?php //echo "<pre>";print_r($notaspromedio);

exit();

} 
?>   


<form action="" method="post" id="gananciaGrafica" class="report">
	<span class="mandatory">* Son campos obligatorios</span>
	<fieldset>  
		
		<label for="semestre" class="fixedLabel">Semestre/Cohorte: <span class="mandatory">(*)</span></label>
		<?php $utils->getSemestresSelect($db,"semestre"); ?>
		<label for="modalidad" class="fixedLabel">Modalidad Academica: <span class="mandatory">(*)</span></label>		
		
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
                
                <label for="unidadAcademica" class="fixedLabel">Unidad Académica: <span class="mandatory">(*)</span></label>
                <select name="codigocarrera" id="unidadAcademica" class="required" style='font-size:0.8em;width:auto'>
                    <option value="" selected></option>
                </select>	
                
                <label for="estudiante" class="fixedLabel">Estudiante: <span class="mandatory">(*)</span></label>
                <select name="codigoestudiante" id="estudiante" style='font-size:0.8em;width:auto'>
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
		var valido= validateForm("#gananciaGrafica");
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
				data: $('#gananciaGrafica').serialize(),                
				success:function(data){	
                                    $("#loading").css("display","none");				
					$('#tableDiv').html(data);					
					
				},
				error: function(data,error,errorThrown){alert(error + errorThrown);}
		});            
	}
        
        $('#gananciaGrafica #modalidad').change(function(event) {
                    getCarreras("#gananciaGrafica");
                });
                
         $('#gananciaGrafica #unidadAcademica').change(function(event) {
                    getEstudiantes("#gananciaGrafica");
                });
                
                $('#gananciaGrafica #semestre').change(function(event) {
                    getEstudiantes("#gananciaGrafica");
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
                
                function getEstudiantes(formName){
                    $(formName + " #estudiante").html("");
                    $(formName + " #estudiante").css("width","auto");   
                        
                    if($(formName + ' #unidadAcademica').val()!=""){
                        var mod = $(formName + ' #unidadAcademica').val();
                        var periodo = $(formName + ' #semestre').val();
                            $.ajax({
                                dataType: 'json',
                                type: 'POST',
                                url: '../searchs/lookForEstudiantesMatriculadosPrimeraVez.php',
                                data: { carrera: mod, periodo: periodo },     
                                success:function(data){
                                     var html = '<option value="" selected></option>';
                                     var i = 0;
                                        while(data.length>i){
                                            html = html + '<option value="'+data[i]["value"]+'" >'+data[i]["label"]+'</option>';
                                            i = i + 1;
                                        }                                    
                            
                                        $(formName + " #estudiante").html(html);
                                        $(formName + " #estudiante").css("width","500px");                                        
                                },
                                error: function(data,error,errorThrown){alert(error + errorThrown);}
                            });  
                    }
                }
</script>    
    
    