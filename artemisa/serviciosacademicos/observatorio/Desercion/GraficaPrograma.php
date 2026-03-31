<?php
include ('Desercion_class.php');  $C_Desercion = new Desercion();
   
    include("../../mgi/pChart/class/pData.class.php");
   
    include("../../mgi/pChart/class/pDraw.class.php");
    
    include("../../mgi/pChart/class/pImage.class.php");
   
    $fontPath = "../../mgi/pChart/fonts/";

global $db;
MainJson();

$CodigoPeriodo  = $_REQUEST['CodigoPeriodo'];
$Cadena = $_REQUEST['Cadena'];
/*******************************************/
$C_Cadena   = explode('-',$Cadena);
//echo '<pre>';print_r($C_Cadena);

$C_Array    = array();


$arrayP = str_split($CodigoPeriodo, strlen($CodigoPeriodo)-1);

$P_Periodo=$arrayP[0]."-".$arrayP[1];

for($i=1;$i<count($C_Cadena);$i++){
    /***********************************/
        $Dato   = $C_Desercion->Carreras($C_Cadena[$i]);
        
        $C_Datos        = $C_Desercion->CadenaPrograma($CodigoPeriodo,$C_Cadena[$i],'1');
        
        //echo '<pre>',print_r($C_Datos);
        
        for($j=0;$j<count($C_Datos);$j++){
            /************************************/
            $C_Porcentaje = $C_Desercion->CadenaPrograma($CodigoPeriodo,$C_Cadena[$i]);
            /*************************************/
        }
        
        //echo '<pre>';print_r($C_Porcentaje);
        
        $C_Suma     = 0;
        
        // echo '<pre>';print_r($C_Porcentaje['Desercion']);
             
            for($n=0;$n<count($C_Porcentaje['Desercion']);$n++){
                if($P_Periodo==$C_Porcentaje['Periodo'][$n]){
                    
                   $X  = str_replace(',','.',$C_Porcentaje['Desercion'][$n]);
                
                   $C_Suma= round(($C_Suma+$X),2);  
                    
                }
            }//for
            
         $Valor = $C_Suma;
         
        $C_Array['Nombre'][]=$Dato[0]['nombrecarrera'];
        $C_Array['Valor'][]=$Valor;
        
    /***********************************/
}//for


//echo '<pre>';print_r($C_Array);die;

//$Periodo_Actual = $C_Desercion->Periodo('Actual','','');

/***************************************/
        $arrayP = str_split($CodigoPeriodo, strlen($CodigoPeriodo)-1);
        
        $P_Periodo=$arrayP[0]."-".$arrayP[1];
        
    
/* Create and populate the pData object */


/*************************************************/
 

 //* Create and populate the pData object */
 $MyData = new pData();  
 $MyData->addPoints($C_Array['Valor'],"");
 $MyData->setAxisName(0,"Porcentaje %");
 $MyData->addPoints($C_Array['Nombre'],"Programas Pregrado");
 //$MyData->addPoints(array("Firefox","Chrome","Internet Explorer","Opera","Safari","Mozilla","SeaMonkey","Camino","Lunascape"),"Browsers");
 $MyData->setSerieDescription("Programas Pregrado","Programas Pregrado");
 $MyData->setAbscissa("Programas Pregrado");
 $MyData->setAbscissaName("");

 
/*************************************************/

$MyData->loadPalette("../palettes/blind.color",TRUE);

 $myPicture = new pImage(1000,1000,$MyData);

 /* Set the default font */
 //$myPicture->setFontProperties(array("FontName"=>"Forgotte.ttf","FontSize"=>10,"R"=>110,"G"=>110,"B"=>110));
$myPicture->setFontProperties(array("FontName"=>$fontPath."verdana.ttf","FontSize"=>8,"R"=>0,"G"=>0,"B"=>0));
$myPicture->drawText(10,16,"Desercion Para Programas Del Periodo ".$P_Periodo,array("FontSize"=>9,"Align"=>TEXT_ALIGN_BOTTOMLEFT));
//

 /* Set the graphical area  */
 $myPicture->setGraphArea(200,200,700,700);
 //$myPicture->setGraphArea(450,50,880,880);

 /* Draw the scale  */
 $AxisBoundaries = array(0=>array("Min"=>0,"Max"=>20));
 $myPicture->drawScale(array("InnerTickWidth"=>0,"OuterTickWidth"=>0,"Mode"=>SCALE_MODE_MANUAL,"ManualScale"=>$AxisBoundaries,"LabelRotation"=>45,"DrawXLines"=>FALSE,"GridR"=>0,"GridG"=>0,"GridB"=>0,"GridTicks"=>0,"GridAlpha"=>30,"AxisAlpha"=>0));

 /* Turn on shadow computing */ 
 $myPicture->setShadow(TRUE,array("X"=>1,"Y"=>1,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>10));

$Palette = array("0"=>array("R"=>188,"G"=>224,"B"=>46,"Alpha"=>100),
                  "1"=>array("R"=>224,"G"=>100,"B"=>46,"Alpha"=>100),
                  "2"=>array("R"=>224,"G"=>214,"B"=>46,"Alpha"=>100),
                  "3"=>array("R"=>46,"G"=>151,"B"=>224,"Alpha"=>100),
                  "4"=>array("R"=>176,"G"=>46,"B"=>224,"Alpha"=>100),
                  "5"=>array("R"=>224,"G"=>46,"B"=>117,"Alpha"=>100),
                  "6"=>array("R"=>92,"G"=>224,"B"=>46,"Alpha"=>100),
                  "7"=>array("R"=>224,"G"=>176,"B"=>46,"Alpha"=>100));

 /* Draw the chart */
 $settings = array("Floating0Serie"=>"Floating 0","Surrounding"=>10,"OverrideColors"=>$Palette);
 $myPicture->drawBarChart($settings);

 /* Render the picture (choose the best way) */
 $myPicture->autoOutput("pictures/example.drawBarChart.span.png"); 

/**************************************************************/
 
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