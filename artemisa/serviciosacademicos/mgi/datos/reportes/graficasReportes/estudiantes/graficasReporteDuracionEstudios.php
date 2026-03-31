<?php
if(isset($_REQUEST["codigocarrera"])){
    function duracion ($codigoperiodo,$codigocarrera,$db) {
                    $query="SELECT	 fechainicioperiodo
                                    ,fechavencimientoperiodo 
                            FROM periodo 
                            WHERE codigoperiodo=$codigoperiodo";
                    $exec= $db->Execute($query);
                    $row = $exec->FetchRow();

                    $query="SELECT DISTINCT codigoestudiante
                            FROM registrograduado
                            JOIN estudiante USING(codigoestudiante)
                            WHERE fechagradoregistrograduado BETWEEN '".$row['fechainicioperiodo']."' AND '".$row['fechavencimientoperiodo']."'
                                    AND codigocarrera=$codigocarrera";
                    $exec= $db->Execute($query);
                    $conteoestudiante = $exec->RecordCount();

                    $query2="SELECT	 distinct 
                                    codigoperiodo
                                    ,codigoestudiante
                            FROM ($query) AS sub
                            JOIN notahistorico nh USING(codigoestudiante)";
                    $exec2= $db->Execute($query2);
                    $conteoperiodos = $exec2->RecordCount();

                    return round($conteoperiodos/$conteoestudiante);
            }

    function getValores($db,$carrera,$periodos){
        $labelPeriodos = array();
        $valores = array();
        for($i=0; $i<count($periodos); $i++){    
            //$carreras = getCarrerasModalidadSIC($db, $modalidad["codigomodalidadacademicasic"]);
                        $codigoperiodo = $periodos[$i]["codigoperiodo"];
                            $arrayP = str_split($codigoperiodo, strlen($codigoperiodo)-1);
                            $labelPeriodos[] = $arrayP[0]."-".$arrayP[1];
            $j = 0;
                $retencion = 0;
            //var_dump($datos_estadistica); echo "<br/><br/>";
            //while($row_carreras = $carreras->FetchRow()){

                $retencion += duracion($codigoperiodo,$carrera['codigocarrera'],$db);

                $j = $j + 1;
            //}
            $valores[] = $retencion/$j;
        }
            //var_dump($valores);
        return array("valores"=>array($labelPeriodos,$valores));
    }

    function drawGraphic($db,$periodos,$carrera,$reporte,$fontPath) { 

        /* Create and populate the pData object */
        $MyData = new pData();  
        //while($row_periodos = $periodos->FetchRow()){
        /*while($row_modalidad = $modalidad->FetchRow()){
            $valores = getValores($db,$row_modalidad,$periodos);
            $MyData->addPoints($valores["valores"][1],$row_modalidad["nombremodalidadacademicasic"]);
        } */
        
        $valores = getValores($db,$carrera,$periodos);
        $MyData->addPoints($valores["valores"][1],$carrera["nombrecarrera"]);


        $MyData->setAxisName(0,"número de semestres");
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
        $myPicture->drawText(10,16,"Duración Estudios",array("FontSize"=>9,"Align"=>TEXT_ALIGN_BOTTOMLEFT));

        /* Set the default font */
        $myPicture->setFontProperties(array("FontName"=>$fontPath."calibri.ttf","FontSize"=>8,"R"=>0,"G"=>0,"B"=>0));

        /* Define the chart area */
        //el 60 es donde empieza la grafica de izquierda a derecha y el 40 es de arriba para abajo
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
        $myPicture->drawLegend(30,30,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL,"FontR"=>0,"FontG"=>0,"FontB"=>0));

        /* Render the picture (choose the best way) */
        $myPicture->Render("imagenesGraficas/".$reporte["alias"]."/retencionModalidades.png"); 
        ?>
            <img alt="Resultados selectividad" src="<?php echo "imagenesGraficas/".$reporte["alias"]."/retencionModalidades.png"; ?>" style="border: 1px solid gray;margin-right: 20px;"/>
    <?php }
    $periodos = getPeriodosArray($db,$dates);
$carrera = $utils->getDataEntity("carrera",$_REQUEST["codigocarrera"],"","codigocarrera");
//var_dump($carrera);
            //$modalidad= getModalidades($db); ?>

                <div class="grafica">
                <?php drawGraphic($db,$periodos,$carrera,$reporte,$fontPath);  ?> </div>
<?php } else { 
    $modalidad= getModalidades($db);
    ?>
<form action="generarGrafica.php?id=<?php echo $reporte["idsiq_reporte"]; ?>" method="post" id="forma" name="forma" class="report">
	<br>
	<span class="mandatory">* Son campos obligatorios</span>
	<fieldset>
		<legend></legend>
		<label for="semestre" class="grid-2-12">Modalidad: <span class="mandatory">(*)</span></label>
		<select name="modalidad" id="modalidad" style='font-size:0.8em'>
                    <?php while($row_tipomodalidad = $modalidad->FetchRow()) { ?>
                    <option value="<?php echo $row_tipomodalidad['codigomodalidadacademicasic']?>">
                    <?php echo $row_tipomodalidad['nombremodalidadacademicasic']; ?>
                    </option>
                    <?php } ?>
		</select> 
                
                <label for="codigocarrera" class="grid-2-12">Programa: <span class="mandatory">(*)</span></label>
                <select name="codigocarrera" id="unidadAcademica" class="required" style='font-size:0.8em;width:auto'>
                    <option value="" selected></option>
                </select>
                
                <div class="vacio"></div>
		<input type="submit" value="Consultar" class="first small"  />
		<div id='respuesta_forma'></div>
	</fieldset>
</form>
<script type="text/javascript">
                getCarreras("#forma");
                
                $(':submit').click(function(event) {
                    event.preventDefault();
                    var valido= validateForm("#forma");
                    if(valido){
                        document.forms["forma"].submit();
                    }
                });
                
                 $('#modalidad').change(function(event) {
                    getCarreras("#forma");
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
<?php } ?>
