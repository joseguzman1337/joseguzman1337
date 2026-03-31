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
        
        $C_Periodods    = explode('-',$CodigoPeriodo);
        
        //echo '<pre>';print_r($C_Periodods);die;
        
        $arrayP = str_split($C_Periodods[0], strlen($C_Periodods[0])-1);
        
        $P_Periodo_ini =$arrayP[0]."-".$arrayP[1];
        
        $arrayD = str_split($C_Periodods[1], strlen($C_Periodods[1])-1);
        
        $P_Periodo_fin =$arrayD[0]."-".$arrayD[1];
        
        
        $P_Periodo   = $P_Periodo_ini.' :: '.$P_Periodo_fin;
        
           
        $C_Datos_ini  = $C_Desercion->CausasDesercion($C_Periodods[0],$CodigoCarrera,'1');
        
        $C_Datos_fin  = $C_Desercion->CausasDesercion($C_Periodods[1],$CodigoCarrera,'1');
            
        
       /* echo '<pre>';print_r($C_Datos_ini);
        echo '<pre>';print_r($C_Datos_fin);*/
        
        $D_DesercionAnual  = array();
        
        for($Q=0;$Q<count($C_Datos_ini['Porcentaje']);$Q++){
            
            $D_DesercionAnual['Porcentaje'][] = $C_Datos_ini['Porcentaje'][$Q];
            $D_DesercionAnual['Nombre'][] = $C_Datos_ini['Nombre'][$Q];
            $D_DesercionAnual['Codigo'][] = $C_Datos_ini['Codigo'][$Q];
            $D_DesercionAnual['Count'][] = $C_Datos_ini['Num'][$Q];
            
        }//for
        for($j=0;$j<count($C_Datos_fin['Porcentaje']);$j++){
            
            $D_DesercionAnual['Porcentaje'][] = $C_Datos_fin['Porcentaje'][$j];
            $D_DesercionAnual['Nombre'][] = $C_Datos_fin['Nombre'][$j];
            $D_DesercionAnual['Codigo'][] = $C_Datos_fin['Codigo'][$j];
            $D_DesercionAnual['Count'][] = $C_Datos_fin['Num'][$j];
            
        }//for
        
        //echo '<pre>';print_r($D_DesercionAnual);die;
    
        
        $R_Final    = array(); 
        $F_Array    = array();
        
        for($T=0;$T<count($D_DesercionAnual['Codigo']);$T++){
            
            /*****************************************************/
            switch($D_DesercionAnual['Codigo'][$T]){
                        case '100':{
                                    $R_Final['P_Academica']['Porcentaje'] +=$D_DesercionAnual['Porcentaje'][$T]; 
                                    $R_Final['P_Academica']['Nombre'] =$D_DesercionAnual['Nombre'][$T]; 
                                    $R_Final['P_Academica']['Codigo'] =$D_DesercionAnual['Codigo'][$T]; 
                                    $R_Final['P_Academica']['Count'] +=$D_DesercionAnual['Count'][$T]; 
                                    
                        }break;
                        case '101':{
                                    $R_Final['P_Disciplinaria']['Porcentaje'] +=$D_DesercionAnual['Porcentaje'][$T]; 
                                    $R_Final['P_Disciplinaria']['Nombre'] =$D_DesercionAnual['Nombre'][$T]; 
                                    $R_Final['P_Disciplinaria']['Codigo'] =$D_DesercionAnual['Codigo'][$T];
                                    $R_Final['P_Disciplinaria']['Count'] +=$D_DesercionAnual['Count'][$T]; 
                        }break;
                        case '102':{
                                    $R_Final['P_Administrativa']['Porcentaje'] +=$D_DesercionAnual['Porcentaje'][$T]; 
                                    $R_Final['P_Administrativa']['Nombre'] =$D_DesercionAnual['Nombre'][$T]; 
                                    $R_Final['P_Administrativa']['Codigo'] =$D_DesercionAnual['Codigo'][$T];
                                    $R_Final['P_Administrativa']['Count'] +=$D_DesercionAnual['Count'][$T];
                        }break;    
                        case '103':{
                                    $R_Final['P_Voluntaria']['Porcentaje'] +=$D_DesercionAnual['Porcentaje'][$T]; 
                                    $R_Final['P_Voluntaria']['Nombre'] =$D_DesercionAnual['Nombre'][$T]; 
                                    $R_Final['P_Voluntaria']['Codigo'] =$D_DesercionAnual['Codigo'][$T];
                                    $R_Final['P_Voluntaria']['Count'] +=$D_DesercionAnual['Count'][$T];
                        }break;
                         case '104':{
                                    $R_Final['Egresado']['Porcentaje'] +=$D_DesercionAnual['Porcentaje'][$T]; 
                                    $R_Final['Egresado']['Nombre'] =$D_DesercionAnual['Nombre'][$T]; 
                                    $R_Final['Egresado']['Codigo'] =$D_DesercionAnual['Codigo'][$T];
                                    $R_Final['Egresado']['Count'] +=$D_DesercionAnual['Count'][$T];
                        }break;
                        case '105':{
                                    $R_Final['Admitido_no']['Porcentaje'] +=$D_DesercionAnual['Porcentaje'][$T]; 
                                    $R_Final['Admitido_no']['Nombre'] =$D_DesercionAnual['Nombre'][$T]; 
                                    $R_Final['Admitido_no']['Codigo'] =$D_DesercionAnual['Codigo'][$T]; 
                                    $R_Final['Admitido_no']['Count'] +=$D_DesercionAnual['Count'][$T];
                        }break;
                        case '106':{
                                    $R_Final['Preinscrito']['Porcentaje'] +=$D_DesercionAnual['Porcentaje'][$T]; 
                                    $R_Final['Preinscrito']['Nombre'] =$D_DesercionAnual['Nombre'][$T]; 
                                    $R_Final['Preinscrito']['Codigo'] =$D_DesercionAnual['Codigo'][$T];
                                    $R_Final['Preinscrito']['Count'] +=$D_DesercionAnual['Count'][$T];
                        }break;
                        case '107':{
                                    $R_Final['Inscrito']['Porcentaje'] +=$D_DesercionAnual['Porcentaje'][$T]; 
                                    $R_Final['Inscrito']['Nombre'] =$D_DesercionAnual['Nombre'][$T]; 
                                    $R_Final['Inscrito']['Codigo'] =$D_DesercionAnual['Codigo'][$T];
                                    $R_Final['Inscrito']['Count'] +=$D_DesercionAnual['Count'][$T];
                        }break;
                        case '108':{
                                    $R_Final['Reserva_Cupo']['Porcentaje'] +=$D_DesercionAnual['Porcentaje'][$T]; 
                                    $R_Final['Reserva_Cupo']['Nombre'] =$D_DesercionAnual['Nombre'][$T]; 
                                    $R_Final['Reserva_Cupo']['Codigo'] =$D_DesercionAnual['Codigo'][$T];
                                    $R_Final['Reserva_Cupo']['Count'] +=$D_DesercionAnual['Count'][$T];
                        }break;
                        case '109':{
                                    $R_Final['Registro_Anulado']['Porcentaje'] +=$D_DesercionAnual['Porcentaje'][$T]; 
                                    $R_Final['Registro_Anulado']['Nombre'] =$D_DesercionAnual['Nombre'][$T]; 
                                    $R_Final['Registro_Anulado']['Codigo'] =$D_DesercionAnual['Codigo'][$T];
                                    $R_Final['Registro_Anulado']['Count'] +=$D_DesercionAnual['Count'][$T];
                        }break;
                        case '110':{
                                    $R_Final['PendienteConsejo']['Porcentaje'] +=$D_DesercionAnual['Porcentaje'][$T]; 
                                    $R_Final['PendienteConsejo']['Nombre'] =$D_DesercionAnual['Nombre'][$T];    
                                    $R_Final['PendienteConsejo']['Codigo'] =$D_DesercionAnual['Codigo'][$T];
                                    $R_Final['PendienteConsejo']['Count'] +=$D_DesercionAnual['Count'][$T];
                        }break;
                        case '111':{
                                    $R_Final['InsSinPago']['Porcentaje'] +=$D_DesercionAnual['Porcentaje'][$T]; 
                                    $R_Final['InsSinPago']['Nombre'] =$D_DesercionAnual['Nombre'][$T]; 
                                    $R_Final['InsSinPago']['Codigo'] =$D_DesercionAnual['Codigo'][$T];
                                    $R_Final['InsSinPago']['Count'] +=$D_DesercionAnual['Count'][$T];
                        }break;
                        case '112':{
                                    $R_Final['CursoEduNoFormal']['Porcentaje'] +=$D_DesercionAnual['Porcentaje'][$T]; 
                                    $R_Final['CursoEduNoFormal']['Nombre'] =$D_DesercionAnual['Nombre'][$T]; 
                                    $R_Final['CursoEduNoFormal']['Codigo'] =$D_DesercionAnual['Codigo'][$T];
                                    $R_Final['CursoEduNoFormal']['Count'] +=$D_DesercionAnual['Count'][$T];
                        }break;
                        case '113':{
                                    $R_Final['No_Admitido']['Porcentaje'] +=$D_DesercionAnual['Porcentaje'][$T]; 
                                    $R_Final['No_Admitido']['Nombre'] =$D_DesercionAnual['Nombre'][$T]; 
                                    $R_Final['No_Admitido']['Codigo'] =$D_DesercionAnual['Codigo'][$T];
                                    $R_Final['No_Admitido']['Count'] +=$D_DesercionAnual['Count'][$T];
                        }break;
                        case '114':{
                                    $R_Final['EnProcesoFinanciacion']['Porcentaje'] +=$D_DesercionAnual['Porcentaje'][$T]; 
                                    $R_Final['EnProcesoFinanciacion']['Nombre'] =$D_DesercionAnual['Nombre'][$T]; 
                                    $R_Final['EnProcesoFinanciacion']['Codigo'] =$D_DesercionAnual['Codigo'][$T];
                                    $R_Final['EnProcesoFinanciacion']['Count'] +=$D_DesercionAnual['Count'][$T];
                        }break;
                        case '115':{
                                    $R_Final['Lista_Espera']['Porcentaje'] +=$D_DesercionAnual['Porcentaje'][$T]; 
                                    $R_Final['Lista_Espera']['Nombre'] =$D_DesercionAnual['Nombre'][$T]; 
                                    $R_Final['Lista_Espera']['Codigo'] =$D_DesercionAnual['Codigo'][$T];
                                    $R_Final['Lista_Espera']['Count'] +=$D_DesercionAnual['Count'][$T];
                        }break;
                        case '200':{
                                    $R_Final['Prueba_Academica']['Porcentaje'] +=$D_DesercionAnual['Porcentaje'][$T]; 
                                    $R_Final['Prueba_Academica']['Nombre'] =$D_DesercionAnual['Nombre'][$T]; 
                                    $R_Final['Prueba_Academica']['Codigo'] =$D_DesercionAnual['Codigo'][$T];
                                    $R_Final['Prueba_Academica']['Count'] +=$D_DesercionAnual['Count'][$T];
                        }break;
                        case '300':{
                                    $R_Final['Admitido']['Porcentaje'] +=$D_DesercionAnual['Porcentaje'][$T]; 
                                    $R_Final['Admitido']['Nombre'] =$D_DesercionAnual['Nombre'][$T]; 
                                    $R_Final['Admitido']['Codigo'] =$D_DesercionAnual['Codigo'][$T];
                                    $R_Final['Admitido']['Count'] +=$D_DesercionAnual['Count'][$T];
                        }break;
                        case '301':{
                                    $R_Final['Normal']['Porcentaje'] +=$D_DesercionAnual['Porcentaje'][$T]; 
                                    $R_Final['Normal']['Nombre'] =$D_DesercionAnual['Nombre'][$T]; 
                                    $R_Final['Normal']['Codigo'] =$D_DesercionAnual['Codigo'][$T];
                                    $R_Final['Normal']['Count'] +=$D_DesercionAnual['Count'][$T];
                        }break;
                        case '302':{
                                    $R_Final['SolicitudReservaCupo']['Porcentaje'] +=$D_DesercionAnual['Porcentaje'][$T]; 
                                    $R_Final['SolicitudReservaCupo']['Nombre'] =$D_DesercionAnual['Nombre'][$T]; 
                                    $R_Final['SolicitudReservaCupo']['Codigo'] =$D_DesercionAnual['Codigo'][$T];
                                    $R_Final['SolicitudReservaCupo']['Count'] +=$D_DesercionAnual['Count'][$T];
                        }break;
                        case '400':{
                                    $R_Final['Graduado']['Porcentaje'] +=$D_DesercionAnual['Porcentaje'][$T]; 
                                    $R_Final['Graduado']['Nombre'] =$D_DesercionAnual['Nombre'][$T]; 
                                    $R_Final['Graduado']['Codigo'] =$D_DesercionAnual['Codigo'][$T];
                                    $R_Final['Graduado']['Count'] +=$D_DesercionAnual['Count'][$T];
                        }break;
                        case '500':{
                                    $R_Final['EnProceso_Grado']['Porcentaje'] +=$D_DesercionAnual['Porcentaje'][$T]; 
                                    $R_Final['EnProceso_Grado']['Nombre'] =$D_DesercionAnual['Nombre'][$T]; 
                                    $R_Final['EnProceso_Grado']['Codigo'] =$D_DesercionAnual['Codigo'][$T];
                                    $R_Final['EnProceso_Grado']['Count'] +=$D_DesercionAnual['Count'][$T];
                        }break;
                    }//switch
            /****************************************************/
            if($T==(count($D_DesercionAnual['Codigo'])-1)){
                /***************************************************************************/
                if($R_Final['P_Academica']['Porcentaje']){
                    $F_Array['Porcentaje'][]=$R_Final['P_Academica']['Porcentaje'];
                    $F_Array['Nombre'][]=$R_Final['P_Academica']['Nombre'];
                    $F_Array['Codigo'][]=$R_Final['P_Academica']['Codigo'];
                    $F_Array['Count'][]=$R_Final['P_Academica']['Count'];
                }
                if($R_Final['P_Disciplinaria']['Porcentaje']){
                    $F_Array['Porcentaje'][]=$R_Final['P_Disciplinaria']['Porcentaje'];
                    $F_Array['Nombre'][]=$R_Final['P_Disciplinaria']['Nombre'];
                    $F_Array['Codigo'][]=$R_Final['P_Disciplinaria']['Codigo'];
                    $F_Array['Count'][]=$R_Final['P_Disciplinaria']['Count'];
                }
                if($R_Final['P_Administrativa']['Porcentaje']){
                    $F_Array['Porcentaje'][]=$R_Final['P_Administrativa']['Porcentaje'];
                    $F_Array['Nombre'][]=$R_Final['P_Administrativa']['Nombre'];
                    $F_Array['Codigo'][]=$R_Final['P_Administrativa']['Codigo'];
                    $F_Array['Count'][]=$R_Final['P_Administrativa']['Count'];
                }
                if($R_Final['P_Voluntaria']['Porcentaje']){
                    $F_Array['Porcentaje'][]=$R_Final['P_Voluntaria']['Porcentaje'];
                    $F_Array['Nombre'][]=$R_Final['P_Voluntaria']['Nombre'];
                    $F_Array['Codigo'][]=$R_Final['P_Voluntaria']['Codigo'];
                    $F_Array['Count'][]=$R_Final['P_Voluntaria']['Count'];
                }
                if($R_Final['Egresado']['Porcentaje']){
                    $F_Array['Porcentaje'][]=$R_Final['Egresado']['Porcentaje'];
                    $F_Array['Nombre'][]=$R_Final['Egresado']['Nombre'];
                    $F_Array['Codigo'][]=$R_Final['Egresado']['Codigo'];
                    $F_Array['Count'][]=$R_Final['Egresado']['Count'];
                }
                if($R_Final['Admitido_no']['Porcentaje']){
                    $F_Array['Porcentaje'][]=$R_Final['Admitido_no']['Porcentaje'];
                    $F_Array['Nombre'][]=$R_Final['Admitido_no']['Nombre'];
                    $F_Array['Codigo'][]=$R_Final['Admitido_no']['Codigo'];
                    $F_Array['Count'][]=$R_Final['Admitido_no']['Count'];
                }
                if($R_Final['Preinscrito']['Porcentaje']){
                    $F_Array['Porcentaje'][]=$R_Final['Preinscrito']['Porcentaje'];
                    $F_Array['Nombre'][]=$R_Final['Preinscrito']['Nombre'];
                    $F_Array['Codigo'][]=$R_Final['Preinscrito']['Codigo'];
                    $F_Array['Count'][]=$R_Final['Preinscrito']['Count'];
                }
                if($R_Final['Inscrito']['Porcentaje']){
                    $F_Array['Porcentaje'][]=$R_Final['Inscrito']['Porcentaje'];
                    $F_Array['Nombre'][]=$R_Final['Inscrito']['Nombre'];
                    $F_Array['Codigo'][]=$R_Final['Inscrito']['Codigo'];
                    $F_Array['Count'][]=$R_Final['Inscrito']['Count'];
                }
                if($R_Final['Reserva_Cupo']['Porcentaje']){
                    $F_Array['Porcentaje'][]=$R_Final['Reserva_Cupo']['Porcentaje'];
                    $F_Array['Nombre'][]=$R_Final['Reserva_Cupo']['Nombre'];
                    $F_Array['Codigo'][]=$R_Final['Reserva_Cupo']['Codigo'];
                    $F_Array['Count'][]=$R_Final['Reserva_Cupo']['Count'];
                }
                if($R_Final['Registro_Anulado']['Porcentaje']){
                    $F_Array['Porcentaje'][]=$R_Final['Registro_Anulado']['Porcentaje'];
                    $F_Array['Nombre'][]=$R_Final['Registro_Anulado']['Nombre'];
                    $F_Array['Codigo'][]=$R_Final['Registro_Anulado']['Codigo'];
                    $F_Array['Count'][]=$R_Final['Registro_Anulado']['Count'];
                }
                if($R_Final['PendienteConsejo']['Porcentaje']){
                    $F_Array['Porcentaje'][]=$R_Final['PendienteConsejo']['Porcentaje'];
                    $F_Array['Nombre'][]=$R_Final['PendienteConsejo']['Nombre'];
                    $F_Array['Codigo'][]=$R_Final['PendienteConsejo']['Codigo'];
                    $F_Array['Count'][]=$R_Final['PendienteConsejo']['Count'];
                }
                if($R_Final['InsSinPago']['Porcentaje']){
                    $F_Array['Porcentaje'][]=$R_Final['InsSinPago']['Porcentaje'];
                    $F_Array['Nombre'][]=$R_Final['InsSinPago']['Nombre'];
                    $F_Array['Codigo'][]=$R_Final['InsSinPago']['Codigo'];
                    $F_Array['Count'][]=$R_Final['InsSinPago']['Count'];
                }
                if($R_Final['CursoEduNoFormal']['Porcentaje']){
                    $F_Array['Porcentaje'][]=$R_Final['CursoEduNoFormal']['Porcentaje'];
                    $F_Array['Nombre'][]=$R_Final['CursoEduNoFormal']['Nombre'];
                    $F_Array['Codigo'][]=$R_Final['CursoEduNoFormal']['Codigo'];
                    $F_Array['Count'][]=$R_Final['CursoEduNoFormal']['Count'];
                }
                if($R_Final['No_Admitido']['Porcentaje']){
                    $F_Array['Porcentaje'][]=$R_Final['No_Admitido']['Porcentaje'];
                    $F_Array['Nombre'][]=$R_Final['No_Admitido']['Nombre'];
                    $F_Array['Codigo'][]=$R_Final['No_Admitido']['Codigo'];
                    $F_Array['Count'][]=$R_Final['No_Admitido']['Count'];
                }
                if($R_Final['EnProcesoFinanciacion']['Porcentaje']){
                    $F_Array['Porcentaje'][]=$R_Final['EnProcesoFinanciacion']['Porcentaje'];
                    $F_Array['Nombre'][]=$R_Final['EnProcesoFinanciacion']['Nombre'];
                    $F_Array['Codigo'][]=$R_Final['EnProcesoFinanciacion']['Codigo'];
                    $F_Array['Count'][]=$R_Final['EnProcesoFinanciacion']['Count'];
                }
                if($R_Final['Lista_Espera']['Porcentaje']){
                    $F_Array['Porcentaje'][]=$R_Final['Lista_Espera']['Porcentaje'];
                    $F_Array['Nombre'][]=$R_Final['Lista_Espera']['Nombre'];
                    $F_Array['Codigo'][]=$R_Final['Lista_Espera']['Codigo'];
                    $F_Array['Count'][]=$R_Final['Lista_Espera']['Count'];
                }
                if($R_Final['Prueba_Academica']['Porcentaje']){
                    $F_Array['Porcentaje'][]=$R_Final['Prueba_Academica']['Porcentaje'];
                    $F_Array['Nombre'][]=$R_Final['Prueba_Academica']['Nombre'];
                    $F_Array['Codigo'][]=$R_Final['Prueba_Academica']['Codigo'];
                    $F_Array['Count'][]=$R_Final['Prueba_Academica']['Count'];
                }
                if($R_Final['Admitido']['Porcentaje']){
                    $F_Array['Porcentaje'][]=$R_Final['Admitido']['Porcentaje'];
                    $F_Array['Nombre'][]=$R_Final['Admitido']['Nombre'];
                    $F_Array['Codigo'][]=$R_Final['Admitido']['Codigo'];
                    $F_Array['Count'][]=$R_Final['Admitido']['Count'];
                }
                if($R_Final['Normal']['Porcentaje']){
                    $F_Array['Porcentaje'][]=$R_Final['Normal']['Porcentaje'];
                    $F_Array['Nombre'][]=$R_Final['Normal']['Nombre'];
                    $F_Array['Codigo'][]=$R_Final['Normal']['Codigo'];
                    $F_Array['Count'][]=$R_Final['Normal']['Count'];
                }
                if($R_Final['SolicitudReservaCupo']['Porcentaje']){
                    $F_Array['Porcentaje'][]=$R_Final['SolicitudReservaCupo']['Porcentaje'];
                    $F_Array['Nombre'][]=$R_Final['SolicitudReservaCupo']['Nombre'];
                    $F_Array['Codigo'][]=$R_Final['SolicitudReservaCupo']['Codigo'];
                    $F_Array['Count'][]=$R_Final['SolicitudReservaCupo']['Count'];
                }
                if($R_Final['Graduado']['Porcentaje']){
                   $F_Array['Porcentaje'][]=$R_Final['Graduado']['Porcentaje']; 
                   $F_Array['Nombre'][]=$R_Final['Graduado']['Nombre'];
                   $F_Array['Codigo'][]=$R_Final['Graduado']['Codigo'];
                   $F_Array['Count'][]=$R_Final['Graduado']['Count'];
                }
                 if($R_Final['EnProceso_Grado']['Porcentaje']){
                   $F_Array['Porcentaje'][]=$R_Final['EnProceso_Grado']['Porcentaje']; 
                   $F_Array['Nombre'][]=$R_Final['EnProceso_Grado']['Nombre'];
                   $F_Array['Codigo'][]=$R_Final['EnProceso_Grado']['Codigo'];
                   $F_Array['Count'][]=$R_Final['EnProceso_Grado']['Count'];
                }
                
            }
            
        }//for
        
        //echo '<pre>';print_r($R_Final);
        //echo '<pre>';print_r($F_Array);die;
        
        $V_Cien = 0;
        
        for($x=0;$x<count($F_Array['Count']);$x++){
            
            $V_Cien   = $V_Cien+$F_Array['Count'][$x];
            
        }
        
       
        for($n=0;$n<count($F_Array['Count']);$n++){
            
            $Porcentaje  = (($F_Array['Count'][$n]*100)/$V_Cien);
            
            $F_Array['Porcentaje'][$n] = number_format($Porcentaje,'2','.','.');
            
        }
        
       // echo '<pre>';print_r($F_Array);die;
        
        
$query_carrera = "select 
                                 nombrecarrera
                          from carrera 
                          where codigocarrera = '".$CodigoCarrera."'";
                          
        $row_carrera= $db->GetRow($query_carrera);
        
        $NombreCarrera=$row_carrera["nombrecarrera"];



/* Create and populate the pData object */
$MyData = new pData();   
$MyData->addPoints($F_Array['Porcentaje'],"ScoreA");  
$MyData->setSerieDescription("ScoreA","Application A");

/* Define the absissa serie */
$MyData->addPoints($F_Array['Nombre'],"Labels");
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
