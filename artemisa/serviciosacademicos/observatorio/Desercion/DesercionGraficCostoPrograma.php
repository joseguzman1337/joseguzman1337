<?php

session_start();


//var_dump (is_file('../../mgi/datos/templates/template.php'));die;

    include ('Desercion_class.php');  $C_Desercion = new Desercion();
    
    include ('DesercionCosto_Class.php');  $C_DesercionCostos = new DesercionCostos();
   
    include("../../mgi/pChart/class/pData.class.php");
   
    include("../../mgi/pChart/class/pDraw.class.php");
    
    include("../../mgi/pChart/class/pImage.class.php");
   
    $fontPath = "../../mgi/pChart/fonts/";
    global $db;
    MainJson();
    
    $CodigoPeriodo	= $_REQUEST['CodigoPeriodo'];
        /*$CodigoCarrera  = $_REQUEST['CodigoCarrera'];*/
        
        //$CodigoPeriodo  = '2008';
        //$CodigoCarrera  = '5';
        
        $Periodo_Actual = $C_Desercion->Periodo('Actual','','');
        //$C_Datos        = $C_Desercion->CadenaPrograma($CodigoPeriodo,$CodigoCarrera);
        
        $CodigoBusqueda  = $CodigoPeriodo;
        
        //$PeriodoAnual   = $C_Desercion->PeriodosAnuales($CodigoBusqueda);
        
        //echo '<pre>';print_r($PeriodoAnual);
        
        $C_Carrera  = $C_Desercion->Carreras();
        
        $C_Valores    = array();
        
        for($j=0;$j<count($C_Carrera);$j++){//for
        
            $Periodo   = $CodigoBusqueda;
            
            $Carrera_id    = $C_Carrera[$j]['codigocarrera'];
            
            $Valor_Actual  = $C_DesercionCostos->CostoActual($Carrera_id);
        
            $D_Anual = $C_Desercion->ConsultaDesercionAnual($Carrera_id,$Periodo);
            
            $Num_Desercion  = $D_Anual[$Carrera_id]['Desercion'][0];
            
            $ValorReal  = $Num_Desercion*$Valor_Actual;
            
             
            $C_Valores['Carrera'][]  = $Carrera_id;
            $C_Valores['Nombre'][]   = $C_Carrera[$j]['nombrecarrera'];
            $C_Valores['Labes'][]    = $j+1;
            $C_Valores['Valores'][]  = $ValorReal;//number_format($ValorReal,'2','.','.');
        
        }//for Carrera
    
     //echo '<pre>';print_r($C_Valores);
     
     
     $c = 1;
     
     while($c!=0){
        $c = 0;
        for($i=0;$i<count($C_Valores['Valores']);$i++){
            
            if($C_Valores['Valores'][$i]>=$C_Valores['Valores'][$i+1]){
                
            }else{
                $tem = $C_Valores['Valores'][$i];
                $C_Valores['Valores'][$i] = $C_Valores['Valores'][$i+1];
                $C_Valores['Valores'][$i+1] = $tem;
                
                $tem_l= $C_Valores['Labes'][$i];
                $C_Valores['Labes'][$i] = $C_Valores['Labes'][$i+1];
                $C_Valores['Labes'][$i+1] = $tem_l;
                
                $tem_m = $C_Valores['Nombre'][$i];
                $C_Valores['Nombre'][$i] = $C_Valores['Nombre'][$i+1];
                $C_Valores['Nombre'][$i+1] = $tem_m;
                
                $tem_c = $C_Valores['Carrera'][$i];
                $C_Valores['Carrera'][$i] = $C_Valores['Carrera'][$i+1];
                $C_Valores['Carrera'][$i+1] = $tem_c;
                
                $c++;
            }//if
            
        }//for
        
     }//while
   
   //echo '<pre>';print_r($C_Valores);die;
   
     
    $arrayP = str_split($CodigoBusqueda, strlen($CodigoBusqueda)-1);
        
        $P_Periodo=$arrayP[0]."-".$arrayP[1];
        
        
        /***************************************/
       
        
        $N=max($C_Valores['Valores']);
        
     
        /*******************************************************************************************************/
        
     $MyData = new pData();  
     $MyData->addPoints($C_Valores['Valores'],"");
     $MyData->setAxisName(0,"Valor en $");
     $MyData->addPoints($C_Valores['Nombre'],"Programas Academicos");
     $MyData->setSerieDescription("Programas Academicos","Programas Academicos");
     $MyData->setAbscissa("Programas Academicos");
     $MyData->setAbscissaName("Programas Academicos");
     $MyData->loadPalette("../palettes/blind.color",TRUE);
     /* Create the pChart object */
     
     if(count($C_Valores['Valores'])<10){
        
        $alto = 2000;
        $ancho = 2000;
        $x     = ($alto/2)+20;
        
     }else{
        
        $ancho = 2000;
        $alto = 2000;
        $x     = ($alto/2)+20;
     }
     
     $myPicture = new pImage($alto,$ancho,$MyData);
     
     $Settings = array("StartR"=>255, "StartG"=>255, "StartB"=>255, "EndR"=>255, "EndG"=>255, "EndB"=>255, "Alpha"=>100);
     //$myPicture->drawGradientArea(0,0,$alto,$ancho,DIRECTION_VERTICAL,array("StartR"=>240,"StartG"=>240,"StartB"=>240,"EndR"=>180,"EndG"=>180,"EndB"=>180,"Alpha"=>100));
     $myPicture->drawGradientArea(0,0,$alto,$ancho,DIRECTION_VERTICAL,$Settings);
     $myPicture->drawGradientArea(0,0,$alto,$ancho,DIRECTION_HORIZONTAL,array("StartR"=>240,"StartG"=>240,"StartB"=>240,"EndR"=>180,"EndG"=>180,"EndB"=>180,"Alpha"=>20));
     $myPicture->setFontProperties(array("FontName"=>$fontPath."verdana.ttf","FontSize"=>8));
    
     /* Draw the chart scale */ 
     $myPicture->setGraphArea(150,20,$alto-300,$ancho-500);
     
      $scaleSettings = array("GridR"=>0,"GridG"=>0,"GridB"=>0,"DrawSubTicks"=>TRUE,"CycleBackground"=>TRUE,"Mode"=>SCALE_MODE_START0,"LabelRotation"=>45);
     $myPicture->drawScale($scaleSettings);
     //$myPicture->drawScale(array("CycleBackground"=>TRUE,"DrawSubTicks"=>TRUE,"GridR"=>0,"GridG"=>0,"GridB"=>0,"GridAlpha"=>10,"Pos"=>SCALE_POS_TOPBOTTOM,"Mode"=>SCALE_MODE_START0 ,"ManualScale"=>$AxisBoundaries));
    
     /* Draw the scale */
    
   
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
     $myPicture->drawBarChart(array("DisplayPos"=>LABEL_POS_INSIDE,"DisplayValues"=>TRUE,"Rounded"=>TRUE,"Surrounding"=>30,"OverrideColors"=>$Palette,"DrawLabels"=>TRUE));
    
       $myPicture->Render("GraficasObservatorio/.GraficaCosto.png"); 
      
     ?>
     <div aling="center">
        <img alt="Resultados " src="<?php echo "GraficasObservatorio/.GraficaCosto.png?random=".time(); ?>" style="border: 1px solid gray;margin-right: 20px;"/>
     </div>
     <br />
    
<?PHP 
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
