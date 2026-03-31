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
   /* $carrerasValores = array();
    $admitidosValores = array();
    $noValores = array();*/
    
    $cont = 0;
    while($row = $modalidad->FetchRow()){
       $carreras = getCarrerasModalidadSIC($db,$row["codigomodalidadacademicasic"]);
       $totalRows_carreras = $carreras->RecordCount();
       while($row_carreras = $carreras->FetchRow()){
           $Valores['carr'][$cont] = $row_carreras["nombrecarrera"];
           
           $query_estrato = "SELECT count(est.idestrato) as cantidad
                              FROM estudianteestadistica ee, carrera c, estudiante e, estudiantegeneral eg,
                            estratohistorico est, estrato es
                              where e.idestudiantegeneral=eg.idestudiantegeneral
                            and est.idestudiantegeneral=eg.idestudiantegeneral and es.idestrato=est.idestrato
                              and e.codigocarrera=c.codigocarrera
                              and ee.codigoestudiante=e.codigoestudiante
                              and ee.codigoperiodo =".$codigoperiodo."
                              and e.codigocarrera=".$row_carreras['codigocarrera']."
                              and ee.codigoprocesovidaestudiante= 400
                              and ee.codigoestado like '1%'
                            and est.idestrato in(1,2)";
          // echo $query_estrato;
           $estrato= $db->Execute($query_estrato);
           $totalRows_estrato = $estrato->RecordCount();
           $row_estrato= $estrato->FetchRow();
           $estrato=$row_estrato['cantidad'];  
           $Valores['estra'][$cont] = $estrato;
           
           $query_poblacion = "SELECT count(e.codigocarrera) as cantidad
                                FROM estudiantepoblacionespecial ep, estudiante e 
                                where ep.codigoestudiante=e.codigoestudiante and ep.codigoperiodo=".$codigoperiodo." 
                                and codigocarrera=".$row_carreras['codigocarrera']." ";
         //  echo $query_poblacion.'<br>';
           $poblacion= $db->Execute($query_poblacion);
           $totalRows_poblacion = $poblacion->RecordCount();
           $row_poblacion= $poblacion->FetchRow();
           $poblacion=$row_poblacion['cantidad']; 
           $Valores['pobla'][$cont]=$poblacion;
           $cont = $cont + 1;

       /*Fin del ciclo de carreras*/ 
           
           }
      }
    
   /* return array("selectividad"=>array($carrerasValores),
        "poblaciones"=>array($poblacionValores),
        "estratos"=>array($estratoValores));*/
    return $Valores;
} 


function drawGraphic($db,$codigoperiodo,$reporte) { ?>

    <div class="grafica">
        <h4>Periodo <?php echo $codigoperiodo; ?></h4>
        
        <?php
        $valores = getValoresPeriodo($db,$codigoperiodo);
       /* print_r($valores["carr"]);
        print_r($valores["pobla"]);
        print_r($valores["estra"]);


        /* Create and populate the pData object */
        $MyData = new pData();  
        $MyData->addPoints($valores["pobla"],"Número de estudiantes admitidos por convenio de poblaciones especiales");
        $MyData->addPoints($valores["estra"],"Número de estudiantes admitidos por convenio de estratos bajos");
        $MyData->setAxisName(0,"%");
        $MyData->addPoints($valores["carr"],"Labels");
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
        $myPicture->drawBarChart(array("DisplayValues"=>TRUE,"DisplayColor"=>DISPLAY_AUTO,"Rounded"=>TRUE,"Surrounding"=>60));
        //$myPicture->drawStackedBarChart(array("DisplayValues"=>TRUE,"DisplayColor"=>DISPLAY_AUTO,"Surrounding"=>-15,"InnerSurrounding"=>15));

        /* Write the chart legend */
        //$myPicture->drawLegend(5980,100,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_VERTICAL));
        $myPicture->drawLegend(480,5,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL));   
        /* Render the picture (choose the best way) */
        //$myPicture->autoOutput("imagenesGraficas/example.png");

        $myPicture->Render("imagenesGraficas/".$reporte["archivoReporte"]."/poblacion_".$codigoperiodo.".png"); ?>
        
        <img alt="Resultados selectividad" src="<?php echo "imagenesGraficas/".$reporte["archivoReporte"]."/poblacion_".$codigoperiodo.".png"; ?>" style="border: 1px solid gray;margin-right: 20px;"/>

    </div>


   
<?php 
$j++;
}

$periodos = getPeriodos($db,$dates);
$i = 0;

    while($row_periodo = $periodos->FetchRow()){    
        drawGraphic($db,$row_periodo["codigoperiodo"],$reporte);
        $i = $i + 1;
    }

?>