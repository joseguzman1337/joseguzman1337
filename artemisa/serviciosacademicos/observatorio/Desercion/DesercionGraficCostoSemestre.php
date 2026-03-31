<?php

session_start();

/*include ('Desercion_class.php');  $C_Desercion = new Desercion();
    
include ('DesercionCosto_Class.php');  $C_DesercionCostos = new DesercionCostos();*/

global $db;
MainJson();


//var_dump (is_file('../../mgi/datos/templates/template.php'));die;


$CodigoPeriodo	= $_REQUEST['CodigoPeriodo'];

?>
<div id="DivGrafi">
<?PHP Grafic($CodigoPeriodo);?>
</div>
<br />
<div id="DivAnillo">
<?PHP echo AnilloGrafic($CodigoPeriodo);?>
</div>
<?PHP

function AnilloGrafic($CodigoPeriodo){
    
    include_once ('Desercion_class.php');  $C_Desercion = new Desercion();
    
    include_once ('DesercionCosto_Class.php');  $C_DesercionCostos = new DesercionCostos();
   
    include_once("../../mgi/pChart/class/pData.class.php");
   
    include_once("../../mgi/pChart/class/pDraw.class.php");
    
    include_once("../../mgi/pChart/class/pPie.class.php"); 
    
    include_once("../../mgi/pChart/class/pImage.class.php");
   
    $fontPath = "../../mgi/pChart/fonts/";
    global $db;
    MainJson();
    
    ?>
    <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
    <html>
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
            <title>Grafica Desercion</title>
            <link rel="stylesheet" href="../../mgi/css/cssreset-min.css" type="text/css" /> 
            <link rel="stylesheet" href="../../css/demo_page.css" type="text/css" /> 
            <link rel="stylesheet" href="../../css/demo_table_jui.css" type="text/css" /> 
            <link rel="stylesheet" href="../../css/themes/smoothness/jquery-ui-1.8.4.custom.css" type="text/css" /> 
            <link rel="stylesheet" href="../../mgi/css/styleMonitoreo.css" type="text/css" /> 
            <link rel="stylesheet" href="../../mgi/css/styleDatos.css" type="text/css" /> 
            
            <script type="text/javascript" language="javascript" src="../../mgi/js/jquery.js"></script>
            <script type="text/javascript" language="javascript" src="../../mgi/js/jquery.dataTables.js"></script>
            <script type="text/javascript" language="javascript" src="../../mgi/js/jquery-ui-1.8.21.custom.min.js"></script>   
            <script type="text/javascript" language="javascript" src="../../mgi/js/jquery.fastLiveFilter.js"></script>     
            <script type="text/javascript" language="javascript" src="../../mgi/js/nicEdit.js"></script>
            <script type="text/javascript" language="javascript" src="../../mgi/js/functions.js"></script>  
            <script type="text/javascript" language="javascript" src="../../mgi/js/functionsMonitoreo.js"></script> 
            <script type="text/javascript" language="javascript" src="../../mgi/js/plusTabs.js"></script>
       </head>
       <body class="body">
       <div class="grafica" align="center">
       <?PHP 
        //$CodigoPeriodo	= $_REQUEST['CodigoPeriodo'];
        
        //$CodigoPeriodo  = $CodigoPeriodo.'1-'.$CodigoPeriodo.'2';
        
        
        $C_Carrera  = $C_Desercion->Carreras();
    
        $D_Estudiante  = $C_DesercionCostos->DesercionSemestreInstitucional($CodigoPeriodo,$C_Carrera);
        
        //echo '<pre>';print_r($D_Estudiante);
        
        $C_Estudiante  = array();
        
        for($i=1;$i<=count($D_Estudiante);$i++){
            
            $C_Estudiante['Semestre'][] = $i;
            $C_Estudiante['Valor'][] =$D_Estudiante[$i]['Valor'];
            
        }//for
        
        $SumaValor = 0;
        
        for($j=0;$j<count($C_Estudiante['Valor']);$j++){
            
            $SumaValor = $SumaValor+$C_Estudiante['Valor'][$j];
            
        }
        
        $D_Estidiante   = array();
         for($x=0;$x<count($C_Estudiante['Valor']);$x++){
            
            $S = $x+1;
            
            
            $S_Porcentaje  = (($C_Estudiante['Valor'][$x]*100)/$SumaValor);
            
            $D_Estidiante['Semestre'][] = $S.'  Semestre  '.number_format($S_Porcentaje,'2','.','.').'%';
            $D_Estidiante['Valor'][] =$C_Estudiante['Valor'][$x];
            $D_Estidiante['Porcentaje'][] =number_format($S_Porcentaje,'2','.','.');
            
         }
         
         //echo'<pre>';print_r($D_Estudiante);
        /*
        Si nO genera la Grafica Antes de Modificar el Codigo mirar los permisos de las carpetas que contiene las graficas ddeben ser 777
        */ 
        //echo '<pre>';print_r($D_Estidiante);die;
        /*echo '<pre>';print_r($D_Total); */
        //var_dump($C_Datos);
        /***************************************/
        
        
 /**********************************************************************************************/
 /* Create and populate the pData object */
$MyData = new pData();   
$MyData->addPoints($D_Estidiante['Porcentaje'],"ScoreA");  
$MyData->setSerieDescription("ScoreA","Application A");

/* Define the absissa serie */
$MyData->addPoints($D_Estidiante['Semestre'],"Labels");
$MyData->setAbscissa("Labels");

/* Create the pChart object */
$myPicture = new pImage(1300,800,$MyData);

/* Draw a solid background */
//$Settings = array("R"=>173, "G"=>152, "B"=>217, "Dash"=>1, "DashR"=>193, "DashG"=>172, "DashB"=>237);
$Settings = array("R"=>173, "G"=>152, "B"=>217, "Dash"=>0, "DashR"=>193, "DashG"=>172, "DashB"=>237);
$myPicture->drawFilledRectangle(0,0,1300,800,$Settings);

/* Draw a gradient overlay */
//$Settings = array("StartR"=>209, "StartG"=>150, "StartB"=>231, "EndR"=>111, "EndG"=>3, "EndB"=>138, "Alpha"=>50);
$Settings = array("StartR"=>255, "StartG"=>255, "StartB"=>255, "EndR"=>255, "EndG"=>255, "EndB"=>255, "Alpha"=>100);
$myPicture->drawGradientArea(0,0,1300,800,DIRECTION_VERTICAL,$Settings);
//$myPicture->drawGradientArea(0,0,1300,20,DIRECTION_VERTICAL,array("StartR"=>0,"StartG"=>0,"StartB"=>0,"EndR"=>50,"EndG"=>50,"EndB"=>50,"Alpha"=>100));
$myPicture->drawGradientArea(0,0,1300,20,DIRECTION_VERTICAL,array("StartR"=>0,"StartG"=>0,"StartB"=>0,"EndR"=>50,"EndG"=>50,"EndB"=>50,"Alpha"=>100));

/* Add a border to the picture */
$myPicture->drawRectangle(0,0,1299,799,array("R"=>0,"G"=>0,"B"=>0));  

/* Write the picture title */ 
$myPicture->setFontProperties(array("FontName"=>$fontPath."Silkscreen.ttf","FontSize"=>6));
//$myPicture->setFontProperties(array("FontName"=>$fontPath."verdana.ttf","FontSize"=>8,"R"=>255,"G"=>255,"B"=>255));
$myPicture->drawText(10,13,"Participación Por Semestre ".$NombreCarrera." ".$P_Periodo."",array("R"=>255,"G"=>255,"B"=>255));

/* Set the default font properties */ 
//$myPicture->setFontProperties(array("FontName"=>$fontPath."Forgotte.ttf","FontSize"=>10,"R"=>80,"G"=>80,"B"=>80));
$myPicture->setFontProperties(array("FontName"=>$fontPath."calibri.ttf","FontSize"=>8,"R"=>0,"G"=>0,"B"=>0));

/* Create the pPie object */ 
$PieChart = new pPie($myPicture,$MyData);

/* Define the slice color */
$PieChart->setSliceColor(0,array("R"=>143,"G"=>197,"B"=>0));
$PieChart->setSliceColor(1,array("R"=>97,"G"=>177,"B"=>63));
$PieChart->setSliceColor(2,array("R"=>97,"G"=>113,"B"=>63));


/* Enable shadow computing */ 
$myPicture->setShadow(TRUE,array("X"=>3,"Y"=>3,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>10));

/* Draw a splitted pie chart */ 
$PieChart->draw3DPie(450,400,array("Radius"=>200,"DataGapAngle"=>15,"DataGapRadius"=>6,"Border"=>TRUE,"DrawLabels"=>TRUE,"WriteValues"=>PIE_VALUE_NATURAL));


$PieChart->drawPieLegend(20,700,array("Mode"=>LEGEND_HORIZONTAL,"Style"=>LEGEND_NOBORDER,"Alpha"=>20));


 /* Render the picture (choose the best way) */
 //$myPicture->autoOutput("pictures/example.draw3DRing.png"); 
  $myPicture->Render("GraficasObservatorio/GraficasDesercionSemestral/DesercionSemestralAnillo_".$CodigoPeriodo.".png");
 /************************************************************************************************/
       ?>
       <img alt="Resultados Desrcion" src="<?php echo "GraficasObservatorio/GraficasDesercionSemestral/DesercionSemestralAnillo_".$CodigoPeriodo.".png?random=".time(); ?>" style="border: 1px solid gray;margin-right: 20px;"/>
       
       </div>
       
       </body>
   </html> 
<?PHP  
    
}//AnilloGrafic

function Grafic($CodigoPeriodo){
    
    include_once ('Desercion_class.php');  $C_Desercion = new Desercion();
    
    include_once ('DesercionCosto_Class.php');  $C_DesercionCostos = new DesercionCostos();
   
    include_once("../../mgi/pChart/class/pData.class.php");
   
    include_once("../../mgi/pChart/class/pDraw.class.php");
    
    include_once("../../mgi/pChart/class/pImage.class.php");
   
    $fontPath = "../../mgi/pChart/fonts/";
    global $db;
    MainJson();
    
    ?>
    <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
    <html>
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
            <title>Grafica Desercion</title>
            <link rel="stylesheet" href="../../mgi/css/cssreset-min.css" type="text/css" /> 
            <link rel="stylesheet" href="../../css/demo_page.css" type="text/css" /> 
            <link rel="stylesheet" href="../../css/demo_table_jui.css" type="text/css" /> 
            <link rel="stylesheet" href="../../css/themes/smoothness/jquery-ui-1.8.4.custom.css" type="text/css" /> 
            <link rel="stylesheet" href="../../mgi/css/styleMonitoreo.css" type="text/css" /> 
            <link rel="stylesheet" href="../../mgi/css/styleDatos.css" type="text/css" /> 
            
            <script type="text/javascript" language="javascript" src="../../mgi/js/jquery.js"></script>
            <script type="text/javascript" language="javascript" src="../../mgi/js/jquery.dataTables.js"></script>
            <script type="text/javascript" language="javascript" src="../../mgi/js/jquery-ui-1.8.21.custom.min.js"></script>   
            <script type="text/javascript" language="javascript" src="../../mgi/js/jquery.fastLiveFilter.js"></script>     
            <script type="text/javascript" language="javascript" src="../../mgi/js/nicEdit.js"></script>
            <script type="text/javascript" language="javascript" src="../../mgi/js/functions.js"></script>  
            <script type="text/javascript" language="javascript" src="../../mgi/js/functionsMonitoreo.js"></script> 
            <script type="text/javascript" language="javascript" src="../../mgi/js/plusTabs.js"></script>
       </head>
       <body class="body">
       <div class="grafica" align="center">
       <?PHP 
        //$CodigoPeriodo	= $_REQUEST['CodigoPeriodo'];
        
        //$CodigoPeriodo  = $CodigoPeriodo.'1-'.$CodigoPeriodo.'2';
        
        
        $C_Carrera  = $C_Desercion->Carreras();
    
        $D_Estudiante  = $C_DesercionCostos->DesercionSemestreInstitucional($CodigoPeriodo,$C_Carrera);
        
        //echo '<pre>';print_r($D_Estudiante);
        
        $C_Estudiante  = array();
        
        for($i=1;$i<=count($D_Estudiante);$i++){
            
            $C_Estudiante['Semestre'][] = $i;
            $C_Estudiante['Valor'][] =$D_Estudiante[$i]['Valor'];
            
        }//for
    
        
        /*
        Si nO genera la Grafica Antes de Modificar el Codigo mirar los permisos de las carpetas que contiene las graficas ddeben ser 777
        */ 
        //echo '<pre>';print_r($C_Estudiante);
        /*echo '<pre>';print_r($D_Total); */
        //var_dump($C_Datos);
        /***************************************/
        $arrayP = str_split($CodigoPeriodo, strlen($CodigoPeriodo)-1);
        
        $P_Periodo=$arrayP[0]."-".$arrayP[1];
        
        
        /***************************************/
       
        
        $N=max($C_Estudiante['Valor']);
        //$K=max($D_Total['Porcentaje']);
        
        //echo '<br>N->'.$N;
        /*if($N>$K){
            //echo 'N es mayor que K';
            $Max    = $N;
        }else{
            //echo 'N es Menor que K';
            $Max    = $K;
        }*/
        /*******************************************************************************************************/
        $MyData = new pData();
        
       
        
        //$MyData->addPoints($C_Valores['Valores'],$NombreCarrera." ".$P_Periodo."-".$Ac_Periodo);
        $MyData->addPoints($C_Estudiante['Valor'],"Costo Deserción Institucional Por Semestre en el ".$P_Periodo);
        //$MyData->setSerieTicks("Desercion Pregrado".$P_Periodo."-".$Ac_Periodo,4);   
        
        $MyData->setAxisName(0,"Costo Desercion en $");
        $MyData->addPoints($C_Estudiante['Semestre'],"Labels");
        $MyData->setSerieDescription("Labels","Periodo");
        $MyData->setAbscissa("Labels");
        $MyData->setPalette($NombreCarrera." Deserción ".$P_Periodo,array("R"=>44,"G"=>87,"B"=>0));
        //$MyData->setPalette("Desercion Pregrado".$CodigoPeriodo."-".$Periodo_Actual);
        /******************************************/
        /* Create the pChart object */
            $numCarreras = 1;
            if($numCarreras<=30){
                $ancho = 1100;
            } else if($numCarreras<=50) {
                //toca hacerlo mas largo porque son muchas carreras
                $ancho = 1200;
            } else if($numCarreras<=70) {
                $ancho = 1400;
            } else {
               $ancho = 1600;
            }
        /************************************/
        
        $alto = 1000;
        $myPicture = new pImage($ancho,$alto,$MyData); 
        
        /* Turn of Antialiasing */
        $myPicture->Antialias = FALSE;
        
        /* Draw the background */
        
        /* Overlay with a gradient *///array("StartR"=>0,"StartG"=>0,"StartB"=>0,"EndR"=>50,"EndG"=>50,"EndB"=>50,"Alpha"=>80)
        $myPicture->drawGradientArea(0,0,$ancho,20,DIRECTION_VERTICAL,array("R"=>170, "G"=>183, "B"=>87, "Dash"=>1, "DashR"=>190, "DashG"=>203, "DashB"=>107));
        
        /* Add a border to the picture */
        $myPicture->drawRectangle(0,0,$ancho-1,$alto-1,array("R"=>0,"G"=>0,"B"=>0));
        
        /* Write the chart title */ 
        $myPicture->setFontProperties(array("FontName"=>$fontPath."verdana.ttf","FontSize"=>8,"R"=>255,"G"=>255,"B"=>255));
        
        $myPicture->drawText(10,16,"Costo Deserción Universidad El Bosque",array("FontSize"=>9,"Align"=>TEXT_ALIGN_BOTTOMLEFT));
        
        /* Set the default font */
        $myPicture->setFontProperties(array("FontName"=>$fontPath."calibri.ttf","FontSize"=>8,"R"=>0,"G"=>0,"B"=>0));
        
        /* Define the chart area */
        //el 80 es donde empieza la grafica de izquierda a derecha y el 40 es de arriba para abajo
        //$myPicture->setGraphArea(60,40,$ancho-30,280);
        /*
        (60,40,650,200)
        
        60->Posicion del ajuste a la  izquierda del usuario
        
        */
        $myPicture->setGraphArea(80,60,1050,800);
        
        /* Draw the scale */
        //$scaleSettings = array("XMargin"=>10,"YMargin"=>10,"Floating"=>TRUE,"Mode"=>SCALE_MODE_START0,"GridR"=>200,"GridG"=>200,"GridB"=>200,"DrawSubTicks"=>TRUE,"CycleBackground"=>TRUE);
        /* Draw the basic scale */
        $AxisBoundaries = array(0=>array("Min"=>0,"Max"=>$N));
        $scaleSettings  = array("GridR"=>10,"GridG"=>10,"GridB"=>4000,"DrawSubTicks"=>TRUE,"CycleBackground"=>TRUE,"Mode"=>SCALE_MODE_MANUAL, "ManualScale"=>$AxisBoundaries);
        $myPicture->drawScale($scaleSettings); 
        
        /*$scaleSettings = array("XMargin"=>10,"YMargin"=>10,"Floating"=>TRUE,"Mode"=>SCALE_MODE_ADDALL_START0,"GridR"=>200,"GridG"=>200,"GridB"=>200,"DrawSubTicks"=>TRUE,"CycleBackground"=>TRUE);
        $myPicture->drawScale($scaleSettings);*/ 
        
        /* Turn on Antialiasing */
        $myPicture->Antialias = TRUE;
        
        /* Enable shadow computing */
        $myPicture->setShadow(FALSE);
        
        /* Draw the line chart */
        $myPicture->drawLineChart(array("DisplayValues"=>FALSE,"DisplayColor"=>DISPLAY_AUTO));
        $myPicture->drawPlotChart(array("DisplayValues"=>TRUE,"PlotBorder"=>TRUE,"BorderSize"=>1,"Surrounding"=>-60,"BorderAlpha"=>80));
        
        /* Write the chart legend */
        //este es el nombre de arriba que de largo le puse 590 para que me quedaran los periodos en la punta  $ancho-320,9  //540,20
        $myPicture->drawLegend(320,9,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL,"FontR"=>255,"FontG"=>255,"FontB"=>255));
        /*******************************************************************************************************/
 

 /* Render the picture (choose the best way) */
        $myPicture->Render("GraficasObservatorio/GraficasDesercionSemestral/DesercionSemestral_".$CodigoPeriodo.".png");
        //$myPicture->autoOutput("GraficasObservatorio/GraficasDesercionSemestral/DesercionSemestral".$CodigoCarrera.".png"); 
 /**********************************************************************************************/
 
 /************************************************************************************************/
       ?>
       <img alt="Resultados Desrcion" src="<?php echo "GraficasObservatorio/GraficasDesercionSemestral/DesercionSemestral_".$CodigoPeriodo.".png?random=".time(); ?>" style="border: 1px solid gray;margin-right: 20px;"/>
       
       </div>
       
       </body>
   </html> 
<?PHP  
    
}//function Grafic

    
function MainJson(){
	
	global $db,$userid;
	
	include ('../templates/mainjson.php');
	
	
	$SQL_User='SELECT idusuario as id FROM usuario WHERE usuario="'.$_SESSION['MM_Username'].'"';
	
	if($Usario_id=&$db->Execute($SQL_User)===false){
		echo 'Error en el SQL Userid...<br>';
		die;
	}
	
	$userid=$Usario_id->fields['id'];
	
}

?>    
