<?php

include ('DesercionCosto_Class.php');  $C_DesercionCostos = new DesercionCostos();

    include("../../mgi/pChart/class/pData.class.php");
   
    include("../../mgi/pChart/class/pDraw.class.php");
    
    include("../../mgi/pChart/class/pImage.class.php");
   
    $fontPath = "../../mgi/pChart/fonts/";

global $db;
MainJson();

/*$Periodo = '20122';
$Modalidad = '200';
$CodigoCarrera = '5';

$Reporte    ='3';*///0->edad 1->NSE 2->Genero 3->Procedencia

$Periodo  = $_REQUEST['Periodo'];
$Modalidad  = $_REQUEST['Modalida'];
$CodigoCarrera  = $_REQUEST['Carrera_id'];
$Reporte  = $_REQUEST['Reporte'];

$Valores  =   $C_DesercionCostos->DemograficoDetalle($Periodo,$Modalidad,$CodigoCarrera);

//echo '<pre>';print_r($Valores);

$D_Data  = array();

    if($Reporte==0){
        
        $Porcentaje_Menor = (($Valores['Menor']*100)/$Valores['Total']);
        $Porcentaje_Media = (($Valores['Media']*100)/$Valores['Total']);
        $Porcentaje_Alta  = (($Valores['Alta']*100)/$Valores['Total']);
        $Porcentaje_Extra = (($Valores['Extra']*100)/$Valores['Total']);
        
        $Porcentaje_Extra_1 = (($Valores['Extra_1']*100)/$Valores['Total']);
        $Porcentaje_Extra_2 = (($Valores['Extra_2']*100)/$Valores['Total']);
        $Porcentaje_Extra_3 = (($Valores['Extra_3']*100)/$Valores['Total']);
        $Porcentaje_Extra_4 = (($Valores['Extra_4']*100)/$Valores['Total']);
        
        $D_Data['Nombres'][]='<=16';//<016
        $D_Data['Nombres'][]='17-20';//17-20
        $D_Data['Nombres'][]='21-25';//21-25
        $D_Data['Nombres'][]='26-30';//26-30
        $D_Data['Nombres'][]='31-35';//26-30
        $D_Data['Nombres'][]='35-40';//26-30
        $D_Data['Nombres'][]='41-45';//26-30
        $D_Data['Nombres'][]='>=45';//26-30
        
        $D_Data['porcentaje'][]=number_format($Porcentaje_Menor,'2','.','.');
        $D_Data['porcentaje'][]=number_format($Porcentaje_Media,'2','.','.');
        $D_Data['porcentaje'][]=number_format($Porcentaje_Alta,'2','.','.');
        $D_Data['porcentaje'][]=number_format($Porcentaje_Extra,'2','.','.');
        $D_Data['porcentaje'][]=number_format($Porcentaje_Extra_1,'2','.','.');
        $D_Data['porcentaje'][]=number_format($Porcentaje_Extra_2,'2','.','.');
        $D_Data['porcentaje'][]=number_format($Porcentaje_Extra_3,'2','.','.');
        $D_Data['porcentaje'][]=number_format($Porcentaje_Extra_4,'2','.','.');
        
        $Nombre  = 'Edad';
        
    }//Edad
    
    if($Reporte==1){
        
        $Porcentaje_NoAplica = (($Valores['No_Aplica']*100)/$Valores['Total']);
        $Porcentaje_Uno      = (($Valores['Uno']*100)/$Valores['Total']);
        $Porcentaje_Dos      = (($Valores['Dos']*100)/$Valores['Total']);
        $Porcentaje_Tres     = (($Valores['Tres']*100)/$Valores['Total']);
        $Porcentaje_Cuatro   = (($Valores['Cuatro']*100)/$Valores['Total']);
        $Porcentaje_Cinco    = (($Valores['Cinco']*100)/$Valores['Total']);
        $Porcentaje_Seis     = (($Valores['Seis']*100)/$Valores['Total']);
        
        $D_Data['Nombres'][]='No Aplica';//<016
        $D_Data['Nombres'][]='1';//17-20
        $D_Data['Nombres'][]='2';//21-25
        $D_Data['Nombres'][]='3';//26-30
        $D_Data['Nombres'][]='4';//26-30
        $D_Data['Nombres'][]='5';//26-30
        $D_Data['Nombres'][]='6';//26-30
        
        $D_Data['porcentaje'][]=number_format($Porcentaje_NoAplica,'2','.','.');
        $D_Data['porcentaje'][]=number_format($Porcentaje_Uno,'2','.','.');
        $D_Data['porcentaje'][]=number_format($Porcentaje_Dos,'2','.','.');
        $D_Data['porcentaje'][]=number_format($Porcentaje_Tres,'2','.','.');
        $D_Data['porcentaje'][]=number_format($Porcentaje_Cuatro,'2','.','.');
        $D_Data['porcentaje'][]=number_format($Porcentaje_Cinco,'2','.','.');
        $D_Data['porcentaje'][]=number_format($Porcentaje_Seis,'2','.','.');
        
        $Nombre  = 'Nivel SocioEconomico';
        
    }//NSE
    
    if($Reporte==2){
        
        $Porcentaje_F     = (($Valores['F']*100)/$Valores['Total']);
        $Porcentaje_M     = (($Valores['M']*100)/$Valores['Total']);
        
        $D_Data['Nombres'][]='Femenino';//<016
        $D_Data['Nombres'][]='Masculino';//17-20
        
        $D_Data['porcentaje'][]=number_format($Porcentaje_F,'2','.','.');
        $D_Data['porcentaje'][]=number_format($Porcentaje_M,'2','.','.');
        
        $Nombre  = 'Genero';
        
    }//Genero
    
    if($Reporte==3){
        
        $Porcentaje_Bogota     = (($Valores['Bogota']*100)/$Valores['Total']);
        $Porcentaje_Nacional   = (($Valores['Nacional']*100)/$Valores['Total']);
        $Porcentaje_Extranjero = (($Valores['Extranjero']*100)/$Valores['Total']);
        
        $D_Data['Nombres'][]='Bogota';//<016
        $D_Data['Nombres'][]='Nacional';//17-20
        $D_Data['Nombres'][]='Extranjero';//17-20
        
        $D_Data['porcentaje'][]=number_format($Porcentaje_Bogota,'2','.','.');
        $D_Data['porcentaje'][]=number_format($Porcentaje_Nacional,'2','.','.');
        $D_Data['porcentaje'][]=number_format($Porcentaje_Extranjero,'2','.','.');
        
        $Nombre  = 'Procedencia';  
        
    }//Procedencia
    //echo '<pre>';print_r($D_Data);die;
    
    
    
  
    
    
    
    /* Create and populate the pData object */
 $MyData = new pData();  
 $MyData->addPoints($D_Data['porcentaje'],"Porcentaje");
 $MyData->setAxisName(0,"Porcentaje %");
 $MyData->addPoints($D_Data['Nombres'],$Nombre);
 //$MyData->addPoints(array("Firefox","Chrome","Internet Explorer","Opera","Safari","Mozilla","SeaMonkey","Camino","Lunascape"),"Browsers");
 $MyData->setSerieDescription($Nombre,$Nombre);
 $MyData->setAbscissa($Nombre);
 $MyData->setAbscissaName($Nombre);

 /* Create the pChart object */
 $myPicture = new pImage(1000,1000,$MyData);
 $myPicture->drawGradientArea(0,0,0,500,DIRECTION_HORIZONTAL,array("StartR"=>240,"StartG"=>240,"StartB"=>240,"EndR"=>180,"EndG"=>180,"EndB"=>180,"Alpha"=>100));
 $myPicture->drawGradientArea(0,0,0,500,DIRECTION_VERTICAL,array("StartR"=>240,"StartG"=>240,"StartB"=>240,"EndR"=>180,"EndG"=>180,"EndB"=>180,"Alpha"=>20));
 $myPicture->setFontProperties(array("FontName"=>$fontPath."verdana.ttf","FontSize"=>14));

 /* Draw the chart scale */ 
 $myPicture->setGraphArea(100,80,900,900);
 $myPicture->drawScale(array("CycleBackground"=>TRUE,"DrawSubTicks"=>TRUE,"GridR"=>0,"GridG"=>0,"GridB"=>0,"GridAlpha"=>10));//,"LabelRotation"=>45

 /* Turn on shadow computing */ 
 $myPicture->setShadow(TRUE,array("X"=>1,"Y"=>1,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>10));

 /* Create the per bar palette */
 $Palette = array("0"=>array("R"=>188,"G"=>224,"B"=>46,"Alpha"=>100),
                  "1"=>array("R"=>224,"G"=>100,"B"=>46,"Alpha"=>100),
                  "2"=>array("R"=>224,"G"=>214,"B"=>46,"Alpha"=>100),
                  "3"=>array("R"=>46,"G"=>151,"B"=>224,"Alpha"=>100),
                  "4"=>array("R"=>176,"G"=>46,"B"=>224,"Alpha"=>100),
                  "5"=>array("R"=>224,"G"=>46,"B"=>117,"Alpha"=>100),
                  "6"=>array("R"=>92,"G"=>224,"B"=>46,"Alpha"=>100),
                  "7"=>array("R"=>224,"G"=>176,"B"=>46,"Alpha"=>100));

 /* Draw the chart */ 
 $myPicture->drawBarChart(array("DisplayPos"=>LABEL_POS_INSIDE,"DisplayValues"=>TRUE,"Rounded"=>TRUE,"Surrounding"=>30,"OverrideColors"=>$Palette));

 /* Write the legend */ 
 //$myPicture->drawLegend(0,215,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL));

 /* Render the picture (choose the best way) */
 $myPicture->autoOutput("pictures/example.drawBarChart.palette.png");
    

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