<?php

if($_GET['semestre'] && $_GET['codigocarrera']) {

    $ruta = "../";
    while (!is_file($ruta.'Connections/sala2.php'))
    {
            $ruta = $ruta."../";
    }
    require_once($ruta.'/consulta/estadisticas/matriculasnew/funciones/obtener_datos.php');
    require_once('./reportes/'.$categoria["alias"].'/functionsGananciaAcademica.php');
    require_once('./reportes/'.$categoria["alias"].'/functionsTiemposCulminacion.php');
    $periodo = $_GET['semestre'];
    $codigocarrera = $_GET['codigocarrera'];
    $codigoestudiante = $_GET['codigoestudiante'];
    $arrayP = str_split($periodo, strlen($periodo)-1);
    $labelPeriodo = $arrayP[0]."-".$arrayP[1];

    $array_matnuevo=obtenerEstudiantes($db,$periodo,$codigocarrera);
    $query_carrera = "select nombrecarrera
                                from carrera 
                                                    where codigocarrera = '$codigocarrera'";
            $row_carrera= $db->GetRow($query_carrera);
            
        if(isset($_GET['codigoestudiante']) && $_GET['codigoestudiante']!="") {
            if(count($array_matnuevo)>0 && is_array($array_matnuevo)){
                //echo "<pre>"; print_r($array_matnuevo);

                $totalEstudiantesCohorte = count($array_matnuevo);
                $estudiantes = clasificarEstudiantes($db,$array_matnuevo,$totalEstudiantesCohorte,true);
            }
            if(count($estudiantes)>0){ 
                    $periodosGrados = count($estudiantes["graduados"]);
                    $contG = 0;
                    $contSemestres=0;
                    if($periodosGrados>0){
                        foreach ($estudiantes["graduados"] as $periodo => $value) {   
                            $contG+=$value["cantidad"];
                            $contSemestres+=$value["semestres"];
                        }
                    }
                    if($contG==0){
                        $contG = 1;
                    }
                    $valores[] = round($contSemestres/$contG, 2);
                    $labels[] = "Promedio Cohorte";
            }
            
            $query_programa = "SELECT CONCAT(eg.nombresestudiantegeneral,' ',eg.apellidosestudiantegeneral) as nombre,
                        e.semestre 
			FROM estudiante e
                    INNER JOIN estudiantegeneral eg ON e.idestudiantegeneral = eg.idestudiantegeneral 
			WHERE e.codigoestudiante=$codigoestudiante ";
            $row_est= $db->GetRow($query_programa);
            $labels[] = $row_est["nombre"];
            $valores[] = $row_est["semestre"];
            
            
                /* Create and populate the pData object */
                $MyData = new pData();  
                $MyData->addPoints($valores,$row_carrera["nombrecarrera"]." Cohorte ".$labelPeriodo);

                $MyData->setAxisName(0,"Número de Semestres");
                $MyData->addPoints($labels,"Labels");
                $MyData->setSerieDescription("Labels","Tipos");
                $MyData->setAbscissa("Labels");
        } else {    
            if(count($array_matnuevo)>0 && is_array($array_matnuevo)){
                //echo "<pre>"; print_r($array_matnuevo);

                $totalEstudiantesCohorte = count($array_matnuevo);
                $estudiantes = clasificarEstudiantes($db,$array_matnuevo,$totalEstudiantesCohorte);
            }
            if(count($estudiantes)>0){ 
                    $periodosGrados = count($estudiantes["graduados"]);
                    $contG = 0;
                    if($periodosGrados>0){
                        foreach ($estudiantes["graduados"] as $periodo => $value) {   
                            $contG+=$value;
                        }
                    }
                    $valores[] = $contG;
                    $labels[] = "Graduados";
                    
                    $periodosGrados = count($estudiantes["sinGrado"]);
                    $contG = 0;
                    if($periodosGrados>0){ 
                        foreach ($estudiantes["sinGrado"] as $key => $value) {    
                            $contG += $value; 
                            $valores[] = $value;
                            $labels[] = $key;
                        }
                    }
            }

            
            /* Create and populate the pData object */
            $MyData = new pData();  
            $MyData->addPoints($valores,$row_carrera["nombrecarrera"]." Cohorte ".$labelPeriodo);

            $MyData->setAxisName(0,"Número de Estudiantes");
            $MyData->addPoints($labels,"Labels");
            $MyData->setSerieDescription("Labels","Tipos");
            $MyData->setAbscissa("Labels");
            
        }
        
$ancho = 700;
 /* Create the pChart object */
 $myPicture = new pImage($ancho,330,$MyData);
  /* Turn of Antialiasing */
 $myPicture->Antialias = FALSE;

 /* Add a border to the picture */
 $myPicture->drawRectangle(0,0,$ancho-1,329,array("R"=>0,"G"=>0,"B"=>0)); 

//$myPicture->drawGradientArea(0,0,700,230,DIRECTION_VERTICAL,array("StartR"=>240,"StartG"=>240,"StartB"=>240,"EndR"=>180,"EndG"=>180,"EndB"=>180,"Alpha"=>100));
 //$myPicture->drawGradientArea(0,0,700,230,DIRECTION_HORIZONTAL,array("StartR"=>240,"StartG"=>240,"StartB"=>240,"EndR"=>180,"EndG"=>180,"EndB"=>180,"Alpha"=>20));
 $myPicture->setFontProperties(array("FontName"=>$fontPath."calibri.ttf","FontSize"=>8));

 /* Draw the scale  */
 $myPicture->setGraphArea(50,30,$ancho-20,300);
 $myPicture->drawScale(array("CycleBackground"=>TRUE,"DrawSubTicks"=>TRUE,"Mode"=>SCALE_MODE_START0,"GridR"=>0,"GridG"=>0,"GridB"=>0,"GridAlpha"=>10));

 /* Turn on shadow computing */ 
 $myPicture->setShadow(TRUE,array("X"=>1,"Y"=>1,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>10));

 /* Draw the chart */
 $settings = array("Gradient"=>TRUE,"DisplayPos"=>LABEL_POS_INSIDE,"DisplayValues"=>TRUE,"DisplayR"=>255,"DisplayG"=>255,"DisplayB"=>255,"DisplayShadow"=>TRUE,"Surrounding"=>10);
 $myPicture->drawBarChart($settings);

 /* Write the chart legend */
 $myPicture->drawLegend($ancho-320,12,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL));
 
   //$myPicture->drawLegend($ancho-240,9,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL,"FontR"=>255,"FontG"=>255,"FontB"=>255));

    /* Render the picture (choose the best way) */
    $myPicture->Render("imagenesGraficas/".$reporte["alias"]."/tiemposCulminacion.png"); 
     ?>
        <img alt="Resultados selectividad" src="<?php echo "imagenesGraficas/".$reporte["alias"]."/tiemposCulminacion.png?random=".time(); ?>" style="border: 1px solid gray;margin-right: 20px;"/>
  <?php       
    exit();

} 
?> 

<form action="" method="post" id="culminacionGrafica" class="report">
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
		var valido= validateForm("#culminacionGrafica");
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
				data: $('#culminacionGrafica').serialize(),                
				success:function(data){	
                                    $("#loading").css("display","none");				
					$('#tableDiv').html(data);					
					
				},
				error: function(data,error,errorThrown){alert(error + errorThrown);}
		});            
	}
        
        $('#culminacionGrafica #modalidad').change(function(event) {
                    getCarreras("#culminacionGrafica");
                });
                
         $('#culminacionGrafica #unidadAcademica').change(function(event) {
                    getEstudiantesGraduados("#culminacionGrafica");
                });
                
                $('#culminacionGrafica #semestre').change(function(event) {
                    getEstudiantesGraduados("#culminacionGrafica");
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
                
                function getEstudiantesGraduados(formName){
                    $(formName + " #estudiante").html("");
                    $(formName + " #estudiante").css("width","auto");   
                        
                    if($(formName + ' #unidadAcademica').val()!=""){
                        var mod = $(formName + ' #unidadAcademica').val();
                        var periodo = $(formName + ' #semestre').val();
                            $.ajax({
                                dataType: 'json',
                                type: 'POST',
                                url: '../searchs/lookForEstudiantesGraduados.php',
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
    
