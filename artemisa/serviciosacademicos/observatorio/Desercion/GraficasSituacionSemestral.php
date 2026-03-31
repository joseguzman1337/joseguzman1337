<?php

session_start();

//var_dump (is_file('../../mgi/datos/templates/template.php'));die;

    include ('Desercion_class.php');  $C_Desercion = new Desercion();
   
    include("../../mgi/pChart/class/pData.class.php");
   
    include("../../mgi/pChart/class/pDraw.class.php");
    
    include("../../mgi/pChart/class/pPie.class.php");
    
    include("../../mgi/pChart/class/pImage.class.php");
    
    
   
    $fontPath = "../../mgi/pChart/fonts/";
    global $db;
    MainJson();
    
        $CodigoPeriodo	= $_REQUEST['CodigoPeriodo'];
        $CodigoCarrera  = $_REQUEST['CodigoCarrera'];
        
        $arrayP = str_split($CodigoPeriodo, strlen($CodigoPeriodo)-1);
        
        $P_Periodo=$arrayP[0]."-".$arrayP[1];
        
        $C_Datos        = $C_Desercion->CausasDesercion($CodigoPeriodo,$CodigoCarrera,'1');
        
        
$query_carrera = "select 
                                 nombrecarrera
                          from carrera 
                          where codigocarrera = '".$CodigoCarrera."'";
                          
        $row_carrera= $db->GetRow($query_carrera);
        
        $NombreCarrera=$row_carrera["nombrecarrera"];



/* Create and populate the pData object */
$MyData = new pData();   
$MyData->addPoints($C_Datos['Porcentaje'],"ScoreA");  
$MyData->setSerieDescription("ScoreA","Application A");

/* Define the absissa serie */
$MyData->addPoints($C_Datos['Nombre'],"Labels");
$MyData->setAbscissa("Labels");

/* Create the pChart object */
$myPicture = new pImage(900,800,$MyData);

/* Draw a solid background */
$Settings = array("R"=>173, "G"=>152, "B"=>217, "Dash"=>1, "DashR"=>193, "DashG"=>172, "DashB"=>237);
$myPicture->drawFilledRectangle(0,0,900,800,$Settings);

/* Draw a gradient overlay */
$Settings = array("StartR"=>209, "StartG"=>150, "StartB"=>231, "EndR"=>111, "EndG"=>3, "EndB"=>138, "Alpha"=>50);
$myPicture->drawGradientArea(0,0,900,800,DIRECTION_VERTICAL,$Settings);
$myPicture->drawGradientArea(0,0,900,20,DIRECTION_VERTICAL,array("StartR"=>0,"StartG"=>0,"StartB"=>0,"EndR"=>50,"EndG"=>50,"EndB"=>50,"Alpha"=>100));

/* Add a border to the picture */
$myPicture->drawRectangle(0,0,899,799,array("R"=>0,"G"=>0,"B"=>0));  

/* Write the picture title */ 
$myPicture->setFontProperties(array("FontName"=>$fontPath."Silkscreen.ttf","FontSize"=>6));
//$myPicture->setFontProperties(array("FontName"=>$fontPath."verdana.ttf","FontSize"=>8,"R"=>255,"G"=>255,"B"=>255));
$myPicture->drawText(10,13,"Causas de Desercion de ".$NombreCarrera." ".$P_Periodo."",array("R"=>255,"G"=>255,"B"=>255));

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
$PieChart->draw3DPie(450,400,array("Radius"=>200,"DataGapAngle"=>10,"DataGapRadius"=>6,"Border"=>TRUE,"DrawLabels"=>TRUE,"WriteValues"=>PIE_VALUE_NATURAL));


$PieChart->drawPieLegend(20,700,array("Mode"=>LEGEND_HORIZONTAL,"Style"=>LEGEND_NOBORDER,"Alpha"=>20));


/* Render the picture (choose the best way) */
$myPicture->autoOutput("pictures/example.draw3DPie.png");

        
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
