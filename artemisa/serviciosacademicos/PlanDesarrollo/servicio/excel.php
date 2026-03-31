<?php
require_once(realpath ( dirname(__FILE__)."/../../../sala/config/Configuration.php" ));
$Configuration = Configuration::getInstance();
require_once (PATH_SITE."/lib/Factory.php");
require_once(PATH_ROOT."/assets/lib/phpexcel/PHPExcel.php");
require_once(PATH_ROOT."/assets/lib/phpexcel/PHPExcel/IOFactory.php"); 
require_once(PATH_ROOT."/assets/lib/phpexcel/PHPExcel/Writer/Excel2007.php"); 
require_once(PATH_ROOT."/serviciosacademicos/PlanDesarrollo/tools/includes.php");
require_once(PATH_ROOT."/serviciosacademicos/PlanDesarrollo/control/ControlLineaEstrategica.php");
require_once(PATH_ROOT."/serviciosacademicos/PlanDesarrollo/control/ControlViewPlanReporteLinea.php");
require_once(PATH_ROOT."/serviciosacademicos/PlanDesarrollo/control/ControlViewPlanDiferencia.php");
require_once(PATH_ROOT."/serviciosacademicos/PlanDesarrollo/control/ControlPrograma.php");
require_once(PATH_ROOT."/serviciosacademicos/PlanDesarrollo/control/ControlPlanProgramaLinea.php");
require_once(PATH_ROOT."/serviciosacademicos/PlanDesarrollo/control/ControlIndicador.php");
require_once(PATH_ROOT."/serviciosacademicos/PlanDesarrollo/control/ControlMeta.php");
require_once(PATH_ROOT."/serviciosacademicos/PlanDesarrollo/control/controlAvancesIndicadorPlanDesarrollo.php");
/*
error_reporting(E_ALL);
ini_set('display_errors', '1');
*/
session_start( );
if( isset ( $_SESSION["datoSesion"] ) ){
        $user = $_SESSION["datoSesion"];
        $idPersona = $user[ 0 ];
        $luser = $user[ 1 ];
        $lrol = $user[3];
        $txtCodigoFacultad = $user[4];
        $persistencia = new Singleton( );
        $persistencia = $persistencia->unserializar( $user[ 5 ] );
        $persistencia->conectar( );
}else{
        header("Location:error.php");
}	

$controlplandesarrollo = new ControlPlanDesarrollo( $persistencia );
$controlLineaEstrategica = new ControlLineaEstrategica( $persistencia ); 
$controlPlanProgramaLinea = new ControlPlanProgramaLinea( $persistencia );
$controlViewPlanReporteLineas = new ControlViewPlanReporteLinea( $persistencia );
$controlViewPlanDiferencia = new ControlViewPlanDiferencia( $persistencia );
$controlIndicador = new ControlIndicador( $persistencia );
$controlMeta = new ControlMeta( $persistencia );
$controlAvancesIndicadorPlanDesarrollo = new controlAvancesIndicadorPlanDesarrollo( $persistencia ); 	
$controlPrograma = new ControlPrograma( $persistencia );
// Create new PHPExcel object 
$reporteExcel = new PHPExcel();
// Set properties 
$reporteExcel->getProperties()->setCreator("SALA"); 
$reporteExcel->getProperties()->setTitle("REPORTE");
$reporteExcel->getDefaultStyle() ->getBorders() ->getTop() ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN); 
$reporteExcel->getDefaultStyle() ->getBorders() ->getBottom() ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN); 
$reporteExcel->getDefaultStyle() ->getBorders() ->getLeft() ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$reporteExcel->getDefaultStyle() ->getBorders() ->getRight() ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN); 
 // Add data 
$reporteExcel->setActiveSheetIndex(0);
$tipoReporte = $_REQUEST['tiporeporte'];

switch( $tipoReporte ){
    case '1':{
        
        $facultad = mysql_real_escape_string($_REQUEST['facultad']);
        $periodo = mysql_real_escape_string($_REQUEST['periodo']); 
        $carrera = mysql_real_escape_string($_REQUEST['carrera']);
        $linea = mysql_real_escape_string($_REQUEST['linea']);
        
        if ( $linea == 0 ) { 
            $lineasE = $controlPlanProgramaLinea->verLinea( $facultad , $periodo , $carrera );  
        } else {
            $lineasE = $controlPlanProgramaLinea->verLinea( $facultad , $periodo , $carrera , $linea );  
        }
        
        if($periodo<>0){
            
            $reporteExcel->getActiveSheet()->getStyle("A1:J1")->getFont()->setBold(true);   
            $reporteExcel->getActiveSheet()->SetCellValue('A1', 'Línea Estratégica');
            $reporteExcel->getActiveSheet()->SetCellValue('B1', 'Programa');
            $reporteExcel->getActiveSheet()->SetCellValue('C1', 'Proyecto');
            $reporteExcel->getActiveSheet()->SetCellValue('D1', 'Indicador');
            $reporteExcel->getActiveSheet()->SetCellValue('E1', 'Meta');
            $reporteExcel->getActiveSheet()->SetCellValue('F1', 'Alcance de la Meta');
            $reporteExcel->getActiveSheet()->SetCellValue('G1', 'Avance');
            $reporteExcel->getActiveSheet()->SetCellValue('H1', 'Alcance Avance');
            $reporteExcel->getActiveSheet()->SetCellValue('I1', 'Valoración');
            $reporteExcel->getActiveSheet()->SetCellValue('J1', 'Evidencias');
            
            $lineas = $controlPlanProgramaLinea->verLinea( $facultad, $periodo , $carrera );   
            $codigoCarrera = $carrera;
            $n = 1;
            //$c= 1;
            
            foreach( $lineasE as $ln ){
                 
                $idLinea = $ln->getLineaEstrategica( )->getIdLineaEstrategica( );
                $nombreLinea = $ln->getLineaEstrategica( )->getNombreLineaEstrategica( );
                $programas = $controlPlanProgramaLinea->verPrograma( $facultad , $idLinea , $codigoCarrera , $periodo );
                $npro = 1;
                $numeroProgramas = sizeof( $programas );
                $conteoProyectosPrograma = 0;
                
                foreach( $programas as $prg ){
                    $acumuladoPorcentajeProyecto = 0;
                    $avanceProyecto = 0;
                    
                    $idPrograma = $prg->getPrograma( )->getIdProgramaPlanDesarrollo( );
                    $nombrePrograma = $prg->getPrograma()->getNombrePrograma();
                    $proyectos = $controlPlanProgramaLinea->verProyecto( $facultad , $idLinea , $idPrograma ,  $codigoCarrera , $periodo );
                    
                    $np = 1;
                    $numeroProyectos = sizeof( $proyectos );
                    $proyectoPorcentaje="";
                  
                    foreach( $proyectos as $pry )	{//foreach proyectos
                        $acumuladoPorcentajeMeta  = 0;
                        $numeroMetasecundarias = 0;
                        $idProyecto = $pry->getProyecto()->getProyectoPlanDesarrolloId() ;
                        $nombreProyecto= $pry ->getProyecto()->getNombreProyectoPlanDesarrollo();
                        $porcentajeProyecto = $pry ->getPorcentaje();
                        $porcenjateMetaNumero = $pry->getPorcentaje();
                        $valorMeta = 0;
                        if($porcentajeProyecto == '') {
                                $porcentajeProyecto = 0;
                        }
                        
                        $indicadores = $controlIndicador ->verIndicadorMeta( $idProyecto , $periodo );
                        $ni = 1;
                        $numeroIndicadores = sizeof( $indicadores );
                       
                        foreach ( $indicadores as $indic ){
                            $idIndicador = $indic->getIndicadorPlanDesarrolloId( );
                            $nombreIndicador  =$indic->getNombreIndicador( );
                            $tipoIndicador = $indic->getTipoIndicador( );
                            $NombreIndicador = $indic->getNombreIndicador( );
                            
                            if($tipoIndicador == 1){
                                    $tipoIndicador='Cuantitativo';
                            }else{
                                    $tipoIndicador='Cualitativo';
                            }
                            
                            $meta = $controlMeta->metaProyectoAvance( $facultad , $codigoCarrera , $idProyecto , $idIndicador , $idLinea , $idPrograma ,$periodo );
                            $nm = 1;
                            $numeroMetas = sizeof( $meta );
                            foreach ($meta as $mt ) {

                                $idMeta = $mt->getMetaIndicadorPlanDesarrolloId( );
                                $nombreMeta = $mt->getNombreMetaPlanDesarrollo( );
                                $alcanceMeta = $mt->getAlcanceMeta( );
                                $vigenciaMeta = $mt->getVigenciaMeta( );
                                $porcentajeMeta = $mt->getPorcentaje( );
                                $indicador = $mt->getIndicador( );
                                if( $porcentajeMeta == '') {
                                    $porcentajeMeta = 0;
                                }
                                
                                if( $porcenjateMetaNumero == 0 ){
                                 $valorMeta = 0;
                                }else{
                                 $valorMeta = round((100/$porcenjateMetaNumero),2);
                                }
                                if( $tipoIndicador == 'Cuantitativo' ) {
                                   
                                } else{
                                    $alcanceMeta = $alcanceMeta.'%'; 		
                                }
                                $metaSecundarias = $controlMeta->buscarMetaSecundariaFecha( $idMeta , $periodo );
                                $nms = 1;
                                $numeroMetasecundaria = sizeof( $metaSecundarias );
                                $avance =  round((($valorMeta/100) * $porcentajeMeta),2);
                                
                                foreach ($metaSecundarias as $secundarias) {
                                    $nombreMetaSecundaria = $secundarias->getNombreMetaSecundaria();
                                    $alcance = $secundarias->getValorMetaSecundaria();
                                    $porcentajeMeta = $secundarias->getAvanceResponsableMetaSecundaria();
                                    $numeroMetasecundarias = $numeroMetasecundarias + 1;
                                    $valorMeta = round((100/$porcenjateMetaNumero),2);
                                    $idMetaSecundaria = $secundarias->getMetaSecundariaPlanDesarrolloId();
                                    if( $alcance == 0 ){
                                        $avanceReal = 0;
                                    } else {
                                        $avanceReal = ( $porcentajeMeta / $alcance )*100;
                                    }      
                                    
                                    if( $avanceReal > 100 ){
                                        $avanceReal = 100;
                                    }
                                    
                                    if($alcance == 0){
                                        $avance = 0;
                                    } else {
                                        $avance = ( $porcentajeMeta * 100 )/$alcance;
                                    }
                                    $porcentajeAvance=round((($valorMeta/100) * $avanceReal),2);
                                    $acumuladoPorcentajeMeta =  $acumuladoPorcentajeMeta + $porcentajeAvance;
                                    $listaEvidencias = $controlAvancesIndicadorPlanDesarrollo->ListaArchivosAnual( $idMetaSecundaria , $periodo);
                                    $numeroArchivos = sizeof($listaEvidencias);
                                    if( $numeroArchivos == 0 ){
                                        $n++;
                                        $reporteExcel->getActiveSheet()->SetCellValue('A'.$n, $nombreLinea );
                                        $reporteExcel->getActiveSheet()->SetCellValue('B'.$n, $nombrePrograma );
                                        $reporteExcel->getActiveSheet()->SetCellValue('C'.$n, $nombreProyecto );
                                        $reporteExcel->getActiveSheet()->SetCellValue('D'.$n, $NombreIndicador.'--'.$tipoIndicador);
                                        $reporteExcel->getActiveSheet()->SetCellValue('E'.$n, $nombreMeta);
                                        $reporteExcel->getActiveSheet()->SetCellValue('F'.$n, $alcanceMeta);
                                        $reporteExcel->getActiveSheet()->SetCellValue('G'.$n, $nombreMetaSecundaria);
                                        $reporteExcel->getActiveSheet()->SetCellValue('H'.$n, $alcance);
                                        $reporteExcel->getActiveSheet()->SetCellValue('I'.$n, $avance);
                                        $reporteExcel->getActiveSheet()->SetCellValue('J'.$n, "");
                                    }else{
                                        foreach ( $listaEvidencias as $lista ){
                                            $n++;
                                            $reporteExcel->getActiveSheet()->SetCellValue('A'.$n, $nombreLinea );
                                            $reporteExcel->getActiveSheet()->SetCellValue('B'.$n, $nombrePrograma );
                                            $reporteExcel->getActiveSheet()->SetCellValue('C'.$n, $nombreProyecto );
                                            $reporteExcel->getActiveSheet()->SetCellValue('D'.$n, $NombreIndicador.'--'.$tipoIndicador);
                                            $reporteExcel->getActiveSheet()->SetCellValue('E'.$n, $nombreMeta);
                                            $reporteExcel->getActiveSheet()->SetCellValue('F'.$n, $alcanceMeta);
                                            $reporteExcel->getActiveSheet()->SetCellValue('G'.$n, $nombreMetaSecundaria);
                                            $reporteExcel->getActiveSheet()->SetCellValue('H'.$n, $alcance);
                                            $reporteExcel->getActiveSheet()->SetCellValue('I'.$n, round($avance,2));
                                            $reporteExcel->getActiveSheet()->SetCellValue('J'.$n, $lista->getEvidencia());
                                            
                                            
                                        }
                                    //fin foreach $listaEvidencias
                                   }
                                    
                                                                       
                                }//fin foreach $metaSecundarias
                               
                            }//fin foreach $meta
                           
                        } // fin foreach $indicadores
                        
                    }// fin foreach $poryectos

                }//fin foreach $programas                     
                $border_style= array('borders' => array('bottom' => array('style' =>PHPExcel_Style_Border::BORDER_THICK,'color' => array('argb' => '008000'),)));
                $reporteExcel->getActiveSheet()->getStyle("A".$n.":J".$n)->applyFromArray($border_style);
            }//fin foreach $lineas
            
            
        } else {
            
            $reporteExcel->getActiveSheet()->getStyle("A1:H1")->getFont()->setBold(true); 
            $reporteExcel->getActiveSheet()->SetCellValue('A1', 'Línea Estratégica');
            $reporteExcel->getActiveSheet()->SetCellValue('B1', 'Programa');
            $reporteExcel->getActiveSheet()->SetCellValue('C1', 'Proyecto');
            $reporteExcel->getActiveSheet()->SetCellValue('D1', 'Indicador');
            $reporteExcel->getActiveSheet()->SetCellValue('E1', 'Meta');
            $reporteExcel->getActiveSheet()->SetCellValue('F1', 'Alcance de la Meta');
            $reporteExcel->getActiveSheet()->SetCellValue('G1', 'Valoración');
            $reporteExcel->getActiveSheet()->SetCellValue('H1', 'Evidencias');
            
            $lineas = $controlPlanProgramaLinea->verLinea( $facultad, $periodo , $carrera );   
            $codigoCarrera = $carrera;
            $n =1;
            
             foreach( $lineasE as $ln ){
                $idLinea = $ln->getLineaEstrategica( )->getIdLineaEstrategica( );
                $nombreLinea = $ln->getLineaEstrategica( )->getNombreLineaEstrategica( );
                $programas = $controlPlanProgramaLinea->verPrograma( $facultad , $idLinea , $codigoCarrera , $periodo );
                $npro = 1;
                $numeroProgramas = sizeof( $programas );
                $conteoProyectosPrograma = 0;
                
                $programas = $controlPlanProgramaLinea->verPrograma( $facultad , $idLinea , $codigoCarrera , $periodo );
                foreach( $programas as $prg ){
                    
                    $idPrograma = $prg->getPrograma( )->getIdProgramaPlanDesarrollo( );
                    $nombrePrograma = $prg->getPrograma()->getNombrePrograma();
                    $proyectos = $controlPlanProgramaLinea->verProyecto( $facultad , $idLinea , $idPrograma ,  $codigoCarrera , $periodo );
                    
                    foreach( $proyectos as $pry )	{
                        $idProyecto = $pry->getProyecto()->getProyectoPlanDesarrolloId() ;
                        $nombreProyecto= $pry ->getProyecto()->getNombreProyectoPlanDesarrollo();
                        
                        $indicadores = $controlIndicador ->verIndicadorMeta( $idProyecto );
                        foreach ( $indicadores as $indic ){
                            $idIndicador = $indic->getIndicadorPlanDesarrolloId( );
                            $nombreIndicador  =$indic->getNombreIndicador( );
                            $tipoIndicador = $indic->getTipoIndicador( );
                            if($tipoIndicador == 1){

                                    $tipoIndicador='Cuantitativo';
                            }else{
                                    $tipoIndicador='Cualitativo';
                            }
                            
                            $meta = $controlMeta->metaProyecto( $facultad , $codigoCarrera , $idProyecto , $idIndicador , $idLinea , $idPrograma );
                            foreach ($meta as $mt ) {
                                $idMeta = $mt->getMetaIndicadorPlanDesarrolloId( );
                                $nombreMeta = $mt->getNombreMetaPlanDesarrollo( );
                                $alcanceMeta = $mt->getAlcanceMeta( );
                                $vigenciaMeta = $mt->getVigenciaMeta( );
                                $porcentajeMeta = $mt->getPorcentaje( );
                                $indicador = $mt->getIndicador( );
                                
                                if( $porcentajeMeta == '') {
                                        $porcentajeMeta = 0;
                                }
                                
                                $listaArchivos = $controlAvancesIndicadorPlanDesarrollo->ListaArchivosTotal($idMeta);
                                $numeroArchivo = sizeof($listaArchivos ); 
                                if( $numeroArchivo == 0){
                                    $n++;
                                    $reporteExcel->getActiveSheet()->SetCellValue('A'.$n, $nombreLinea );
                                    $reporteExcel->getActiveSheet()->SetCellValue('B'.$n, $nombrePrograma );
                                    $reporteExcel->getActiveSheet()->SetCellValue('C'.$n, $nombreProyecto );
                                    $reporteExcel->getActiveSheet()->SetCellValue('D'.$n, $nombreIndicador.'--'.$tipoIndicador );
                                    $reporteExcel->getActiveSheet()->SetCellValue('E'.$n, $nombreMeta );
                                    $reporteExcel->getActiveSheet()->SetCellValue('F'.$n, $alcanceMeta );
                                    $reporteExcel->getActiveSheet()->SetCellValue('G'.$n, $porcentajeMeta );
                                    $reporteExcel->getActiveSheet()->SetCellValue('H'.$n, "");
                                
                                }
                                else {
                                    foreach($listaArchivos as $lista ){
                                        $n++;
                                        $reporteExcel->getActiveSheet()->SetCellValue('A'.$n, $nombreLinea );
                                        $reporteExcel->getActiveSheet()->SetCellValue('B'.$n, $nombrePrograma );
                                        $reporteExcel->getActiveSheet()->SetCellValue('C'.$n, $nombreProyecto );
                                        $reporteExcel->getActiveSheet()->SetCellValue('D'.$n, $nombreIndicador.'--'.$tipoIndicador );
                                        $reporteExcel->getActiveSheet()->SetCellValue('E'.$n, $nombreMeta );
                                        $reporteExcel->getActiveSheet()->SetCellValue('F'.$n, $alcanceMeta );
                                        $reporteExcel->getActiveSheet()->SetCellValue('G'.$n, $porcentajeMeta );
                                        $reporteExcel->getActiveSheet()->SetCellValue('H'.$n, $lista ->getEvidencia());

                                    }
                                }
                                
                            }//fin foreach $meta

                        }//fin foreach $indicador
                           
                    }//fin foreach $proyecto                   
                    
                }//fin foreach $programas
                $border_style= array('borders' => array('bottom' => array('style' =>PHPExcel_Style_Border::BORDER_THICK,'color' => array('argb' => '008000'),)));
                $reporteExcel->getActiveSheet()->getStyle("A".$n.":H".$n)->applyFromArray($border_style);
             }// fin foreach $lineasE
            
        }
 
        
            
    }break;

    case '2':{

    }break;

    case '3':{

        $reporteExcel->getActiveSheet()->getColumnDimensionByColumn('A')->setWidth('80');
        foreach(range('B','K') as $columnID ) {
            $reporteExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
        }
        
        $reporteExcel->getActiveSheet()->getStyle("A1:K1")->getFont()->setBold(true);        
        $reporteExcel->getActiveSheet()->SetCellValue('A1', 'Plan Desarrollo');
        $reporteExcel->getActiveSheet()->SetCellValue('B1', 'Misión');
        $reporteExcel->getActiveSheet()->SetCellValue('C1', 'Planeación');
        $reporteExcel->getActiveSheet()->SetCellValue('D1', 'Talento Humano');
        $reporteExcel->getActiveSheet()->SetCellValue('E1', 'Educación');
        $reporteExcel->getActiveSheet()->SetCellValue('F1', 'Investigación');
        $reporteExcel->getActiveSheet()->SetCellValue('G1', 'Responsabilidad');
        $reporteExcel->getActiveSheet()->SetCellValue('H1', 'Éxito Estudiantil');   
        $reporteExcel->getActiveSheet()->SetCellValue('I1', 'Bienestar Universitario');
        $reporteExcel->getActiveSheet()->SetCellValue('J1', 'Internacionalizacion');
        $reporteExcel->getActiveSheet()->SetCellValue('K1', 'Cumplimiento del plan');     
      
        $planDesarrollo  = $controlplandesarrollo->ConsultarPalnesDesarrollo();	
        $periodo = mysql_real_escape_string($_REQUEST['periodo']);
        $lineasEstrategicas = $controlLineaEstrategica ->consultarLineaEstrategica();
        $numeroPlanes = sizeof( $planDesarrollo );
        $acumuladorPorcentaje = 0;
        $identificadorPlan = 0;
        $i=0;
        $acumuladorLinea1 = 0;
        $acumuladorLinea2 = 0;
        $acumuladorLinea3 = 0;
        $acumuladorLinea4 = 0;
        $acumuladorLinea5 = 0;
        $acumuladorLinea6 = 0;
        $acumuladorLinea7 = 0;
        $acumuladorLinea8 = 0;
        $acumuladorLinea9 = 0;
        
        foreach( $planDesarrollo as $planes ) { 
          $i++;
            if( $i == 1 ){
                    $lnP1 = $controlViewPlanReporteLineas->alcanceMetasReporte( $planes->PlanDesarrolloId , 1 );
                    $lnP2 = $controlViewPlanReporteLineas->alcanceMetasReporte( $planes->PlanDesarrolloId , 2 );
                    $lnP3 = $controlViewPlanReporteLineas->alcanceMetasReporte( $planes->PlanDesarrolloId , 3 );
                    $lnP4 = $controlViewPlanReporteLineas->alcanceMetasReporte( $planes->PlanDesarrolloId , 4 );
                    $lnP5 = $controlViewPlanReporteLineas->alcanceMetasReporte( $planes->PlanDesarrolloId , 5 );
                    $lnP6 = $controlViewPlanReporteLineas->alcanceMetasReporte( $planes->PlanDesarrolloId , 6 );
                    $lnP7 = $controlViewPlanReporteLineas->alcanceMetasReporte( $planes->PlanDesarrolloId , 7 );
                    $lnP8 = $controlViewPlanReporteLineas->alcanceMetasReporte( $planes->PlanDesarrolloId , 8 );
                    $lnP9 = $controlViewPlanReporteLineas->alcanceMetasReporte( $planes->PlanDesarrolloId , 9 );
                    
                    $acumuladorLinea1 = $acumuladorLinea1 + $lnP1->conteo;
                    $acumuladorLinea2 = $acumuladorLinea2 + $lnP2->conteo;
                    $acumuladorLinea3 = $acumuladorLinea3 + $lnP3->conteo;
                    $acumuladorLinea4 = $acumuladorLinea4 + $lnP4->conteo;
                    $acumuladorLinea5 = $acumuladorLinea5 + $lnP5->conteo;
                    $acumuladorLinea6 = $acumuladorLinea6 + $lnP6->conteo;
                    $acumuladorLinea7 = $acumuladorLinea7 + $lnP7->conteo;
                    $acumuladorLinea8 = $acumuladorLinea8 + $lnP8->conteo;
                    $acumuladorLinea9 = $acumuladorLinea9 + $lnP9->conteo;
                
            } else {
                    $reporteExcel->getActiveSheet()->SetCellValue('A'.$i, $planes->NombrePlanDesarrollo);
                    
                    if ( $periodo == 0 ) {
                        $ln1 = $controlViewPlanReporteLineas->alcanceMetasReporte( $planes->PlanDesarrolloId , 1 );
                        $ln2 = $controlViewPlanReporteLineas->alcanceMetasReporte( $planes->PlanDesarrolloId , 2 );
                        $ln3 = $controlViewPlanReporteLineas->alcanceMetasReporte( $planes->PlanDesarrolloId , 3 );
                        $ln4 = $controlViewPlanReporteLineas->alcanceMetasReporte( $planes->PlanDesarrolloId , 4 );
                        $ln5 = $controlViewPlanReporteLineas->alcanceMetasReporte( $planes->PlanDesarrolloId , 5 );
                        $ln6 = $controlViewPlanReporteLineas->alcanceMetasReporte( $planes->PlanDesarrolloId , 6 );
                        $ln7 = $controlViewPlanReporteLineas->alcanceMetasReporte( $planes->PlanDesarrolloId , 7 );
                        $ln8 = $controlViewPlanReporteLineas->alcanceMetasReporte( $planes->PlanDesarrolloId , 8 );
                        $ln9 = $controlViewPlanReporteLineas->alcanceMetasReporte( $planes->PlanDesarrolloId , 9 );
                        
                    } else {
                        $ln1 = $controlViewPlanReporteLineas->alcanceAvancesAnuales( $planes->PlanDesarrolloId , 1 , $periodo );
                        $ln2 = $controlViewPlanReporteLineas->alcanceAvancesAnuales( $planes->PlanDesarrolloId , 2 , $periodo );
                        $ln3 = $controlViewPlanReporteLineas->alcanceAvancesAnuales( $planes->PlanDesarrolloId , 3 , $periodo );
                        $ln4 = $controlViewPlanReporteLineas->alcanceAvancesAnuales( $planes->PlanDesarrolloId , 4 , $periodo );
                        $ln5 = $controlViewPlanReporteLineas->alcanceAvancesAnuales( $planes->PlanDesarrolloId , 5 , $periodo );
                        $ln6 = $controlViewPlanReporteLineas->alcanceAvancesAnuales( $planes->PlanDesarrolloId , 6 , $periodo );
                        $ln7 = $controlViewPlanReporteLineas->alcanceAvancesAnuales( $planes->PlanDesarrolloId , 7 , $periodo );
                        $ln8 = $controlViewPlanReporteLineas->alcanceAvancesAnuales( $planes->PlanDesarrolloId , 8 , $periodo );
                        $ln9 = $controlViewPlanReporteLineas->alcanceAvancesAnuales( $planes->PlanDesarrolloId , 9 , $periodo );
                    }
                    
                    $porcentajeLinea = $ln1->conteo+$ln2->conteo+$ln3->conteo+$ln4->conteo+$ln5->conteo+$ln6->conteo+$ln7->conteo+$ln8->conteo+$ln9->conteo;
                    $porcentaje = $porcentajeLinea/9;
                    
                    if( $porcentaje > 100 ){
                        $reporteExcel->getActiveSheet()->getStyle('K'.$i)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('84c3be');
                        $reporteExcel->getActiveSheet()->getStyle('K'.$i)->getFont()->getColor()->setRGB('FFFFFF'); 
                        
                    } else if ( $porcentaje > 75 && $porcentaje < 101 ){
                        $reporteExcel->getActiveSheet()->getStyle('K'.$i)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('0000FF');
                        $reporteExcel->getActiveSheet()->getStyle('K'.$i)->getFont()->getColor()->setRGB('FFFFFF');
                        
                    } else if ( $porcentaje > 50 && $porcentaje <= 75 ){
                        $reporteExcel->getActiveSheet()->getStyle('K'.$i)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('008000');
                        $reporteExcel->getActiveSheet()->getStyle('K'.$i)->getFont()->getColor()->setRGB('FFFFFF');  
                        
                    } else if ( $porcentaje > 25 && $porcentaje <= 50 ){
                        $reporteExcel->getActiveSheet()->getStyle('K'.$i)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('F5FC0A');
                        
                    } else if ( $porcentaje < 26 ){
                        $reporteExcel->getActiveSheet()->getStyle('K'.$i)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('c51022');
                        $reporteExcel->getActiveSheet()->getStyle('K'.$i)->getFont()->getColor()->setRGB('FFFFFF');
                        
                    } 
                    
                    $reporteExcel->getActiveSheet()->SetCellValue('B'.$i, round( $ln1->conteo,2 ) );
                    $reporteExcel->getActiveSheet()->SetCellValue('C'.$i, round( $ln2->conteo,2 ) );
                    $reporteExcel->getActiveSheet()->SetCellValue('D'.$i, round( $ln3->conteo,2 ) );
                    $reporteExcel->getActiveSheet()->SetCellValue('E'.$i, round( $ln4->conteo,2 ) );
                    $reporteExcel->getActiveSheet()->SetCellValue('F'.$i, round( $ln5->conteo,2 ) );
                    $reporteExcel->getActiveSheet()->SetCellValue('G'.$i, round( $ln6->conteo,2 ) );
                    $reporteExcel->getActiveSheet()->SetCellValue('H'.$i, round( $ln7->conteo,2 ) );
                    $reporteExcel->getActiveSheet()->SetCellValue('I'.$i, round( $ln8->conteo,2 ) );
                    $reporteExcel->getActiveSheet()->SetCellValue('J'.$i, round( $ln9->conteo,2 ) );
                    $reporteExcel->getActiveSheet()->SetCellValue('K'.$i, round( $porcentaje,2 ) );
                                        
                    $acumuladorLinea1 = $acumuladorLinea1 + $ln1->conteo;
                    $acumuladorLinea2 = $acumuladorLinea2 + $ln2->conteo;
                    $acumuladorLinea3 = $acumuladorLinea3 + $ln3->conteo;
                    $acumuladorLinea4 = $acumuladorLinea4 + $ln4->conteo;
                    $acumuladorLinea5 = $acumuladorLinea5 + $ln5->conteo;
                    $acumuladorLinea6 = $acumuladorLinea6 + $ln6->conteo;
                    $acumuladorLinea7 = $acumuladorLinea7 + $ln7->conteo;
                    $acumuladorLinea8 = $acumuladorLinea8 + $ln8->conteo;
                    $acumuladorLinea9 = $acumuladorLinea9 + $ln9->conteo;     
                    
                    $border_style= array('borders' => array('bottom' => array('style' =>PHPExcel_Style_Border::BORDER_THICK,'color' => array('argb' => '008000'),)));
                    $reporteExcel->getActiveSheet()->getStyle("A".$i.":K".$i)->applyFromArray($border_style);
            }
             
        }
        
            $i=$i+1;                   
            $numeroPlanesInstitucional=$numeroPlanes-1;
            $acumulado1 = round( $acumuladorLinea1/$numeroPlanesInstitucional,2);
            $acumulado2 = round( $acumuladorLinea2/$numeroPlanes,2 ) ;
            $acumulado3 = round( $acumuladorLinea3/$numeroPlanes,2 ) ;
            $acumulado4 = round( $acumuladorLinea4/$numeroPlanesInstitucional,2 );
            $acumulado5 = round( $acumuladorLinea5/$numeroPlanesInstitucional,2);
            $acumulado6 = round( $acumuladorLinea6/$numeroPlanes,2 ) ;
            $acumulado7 = round(  $acumuladorLinea7/$numeroPlanesInstitucional,2);
            $acumulado8 = round( $acumuladorLinea8/$numeroPlanesInstitucional,2 );
            $acumulado9 = round( $acumuladorLinea9/$numeroPlanesInstitucional,2);                    
            $avanceInstitucional = round(($acumulado1 + $acumulado2 + $acumulado3 +$acumulado4 + $acumulado5 + $acumulado6 + $acumulado7 + $acumulado8 + $acumulado9 )/9,2); 

            if( $avanceInstitucional > 100 ){
                $reporteExcel->getActiveSheet()->getStyle('K'.$i)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('84c3be');
                $reporteExcel->getActiveSheet()->getStyle('K'.$i)->getFont()->getColor()->setRGB('FFFFFF');

            } else if ( $avanceInstitucional > 75 && $avanceInstitucional < 101 ){
                $reporteExcel->getActiveSheet()->getStyle('K'.$i)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('0000FF');
                $reporteExcel->getActiveSheet()->getStyle('K'.$i)->getFont()->getColor()->setRGB('FFFFFF'); 

            } else if ( $avanceInstitucional > 50 && $avanceInstitucional <= 75 ){
                $reporteExcel->getActiveSheet()->getStyle('K'.$i)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('008000');
                $reporteExcel->getActiveSheet()->getStyle('K'.$i)->getFont()->getColor()->setRGB('FFFFFF');

            } else if ( $avanceInstitucional > 25 && $avanceInstitucional <= 50 ){
                $reporteExcel->getActiveSheet()->getStyle('K'.$i)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('F5FC0A');

            } else if ( $avanceInstitucional < 26 ){
                $reporteExcel->getActiveSheet()->getStyle('K'.$i)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('c51022');
                $reporteExcel->getActiveSheet()->getStyle('K'.$i)->getFont()->getColor()->setRGB('FFFFFF');

            } 
            
            $reporteExcel->getActiveSheet()->SetCellValue('A'.$i, "Plan Desarrollo Institucional");
            $reporteExcel->getActiveSheet()->SetCellValue('B'.$i, $acumulado1  );
            $reporteExcel->getActiveSheet()->SetCellValue('C'.$i, $acumulado2 );
            $reporteExcel->getActiveSheet()->SetCellValue('D'.$i, $acumulado3 );
            $reporteExcel->getActiveSheet()->SetCellValue('E'.$i, $acumulado4 );
            $reporteExcel->getActiveSheet()->SetCellValue('F'.$i, $acumulado5 );
            $reporteExcel->getActiveSheet()->SetCellValue('G'.$i, $acumulado6 );
            $reporteExcel->getActiveSheet()->SetCellValue('H'.$i, $acumulado7 );
            $reporteExcel->getActiveSheet()->SetCellValue('I'.$i, $acumulado8 );
            $reporteExcel->getActiveSheet()->SetCellValue('J'.$i, $acumulado9 );
            $reporteExcel->getActiveSheet()->SetCellValue('K'.$i, $avanceInstitucional );                  
                    
    }break;
    
    case '4':{
        
        $reporteExcel->getActiveSheet()->getStyle("A1:F1")->getFont()->setBold(true);        
        $reporteExcel->getActiveSheet()->SetCellValue('A1', 'Línea Estratégica');
        $reporteExcel->getActiveSheet()->SetCellValue('B1', 'Programa');
        $reporteExcel->getActiveSheet()->SetCellValue('C1', 'Proyecto');
        $reporteExcel->getActiveSheet()->SetCellValue('D1', 'Indicador');
        $reporteExcel->getActiveSheet()->SetCellValue('E1', 'Meta');
        $reporteExcel->getActiveSheet()->SetCellValue('F1', 'Alcance de la Meta');
        
        $carrera = mysql_real_escape_string($_REQUEST['carrera']);        
        $linea = $controlViewPlanDiferencia->lineaSinAvances( $carrera );
        $n=1;
        foreach ($linea as $ln){
            $idLinea = $ln->getLineaEstrategicaId();
            $nombreLinea = $ln->getNombreLineaEstrategica();
            $programas = $controlViewPlanDiferencia->programaSinAvances( $carrera , $idLinea );
            
            foreach( $programas as $prg ){
                $idPrograma = $prg->getProgramaPlanDesarrolloId();
                $nombrePrograma = $prg->getNombrePrograma();
                $proyecto = $controlViewPlanDiferencia->proyectoSinAvances( $carrera , $idLinea , $idPrograma );
                
                foreach ($proyecto as $pry ){
                    $idProyecto = $pry->getProyectoPlanDesarrolloId();
                    $nombreProyecto= $pry ->getNombreProyectoPlanDesarrollo();
                    $indicadores = $controlViewPlanDiferencia->indicadorSinAvances($carrera , $idLinea , $idPrograma , $idProyecto);
                    
                    foreach ( $indicadores as $indic ){
                        $indicadorId = $indic->getIndicadorPlanDesarrolloId();
                        $nombreIndicadores = $indic->getIndicador();
                        $indicador = explode("_",$nombreIndicadores);
                        $tipoIndicador = $indicador[0];
                        $nombreIndicador =  $indicador[1];
                        $celdaIndicador=$nombreIndicador."--".$tipoIndicador; 
                        $meta = $controlViewPlanDiferencia->metaSinAvances($carrera , $idLinea , $idPrograma , $idProyecto , $indicadorId);
                        $nm = 1;
                        $numeroMetas = sizeof( $meta );
                        
                        foreach ($meta as $mt){
                           $n++;
                            $reporteExcel->getActiveSheet()->SetCellValue('A'.$n, $ln->getNombreLineaEstrategica( ) );
                            $reporteExcel->getActiveSheet()->SetCellValue('B'.$n, $nombrePrograma );
                            $reporteExcel->getActiveSheet()->SetCellValue('C'.$n, $nombreProyecto );
                            $reporteExcel->getActiveSheet()->SetCellValue('D'.$n, $celdaIndicador ) ;
                            $reporteExcel->getActiveSheet()->SetCellValue('E'.$n, $mt->getMeta( ) );
                            $reporteExcel->getActiveSheet()->SetCellValue('F'.$n, $mt->getAlcanceMeta( ) );
                            
                        }
                    }
                }
            }
            $border_style= array('borders' => array('bottom' => array('style' =>PHPExcel_Style_Border::BORDER_THICK,'color' => array('argb' => '008000'),)));
            $reporteExcel->getActiveSheet()->getStyle("A".$n.":F".$n)->applyFromArray($border_style);
        }      
        
    }break;
    
    case '5':{
      
        $reporteExcel->getActiveSheet()->getStyle("A1:G1")->getFont()->setBold(true);        
        $reporteExcel->getActiveSheet()->SetCellValue('A1', 'Línea Estratégica');
        $reporteExcel->getActiveSheet()->SetCellValue('B1', 'Programa');
        $reporteExcel->getActiveSheet()->SetCellValue('C1', 'Proyecto');
        $reporteExcel->getActiveSheet()->SetCellValue('D1', 'Indicador');
        $reporteExcel->getActiveSheet()->SetCellValue('E1', 'Meta');
        $reporteExcel->getActiveSheet()->SetCellValue('F1', 'Alcance de la Meta');
        $reporteExcel->getActiveSheet()->SetCellValue('G1', 'Alcance de los Avances');
        
        $carrera = mysql_real_escape_string($_REQUEST['carrera']);
        $linea = $controlViewPlanDiferencia->lineaDiferencia( $carrera );
        $n=1;
        $nLinea=2;
         foreach ($linea as $ln ){
        
            $idLinea = $ln->getLineaEstrategicaId();
            $programas = $controlViewPlanDiferencia->programaDiferencia( $carrera , $idLinea );
            $numeroProgramas = sizeof( $programas );
           
            foreach( $programas as $prg ){
                $idPrograma = $prg->getProgramaPlanDesarrolloId();
                $nombrePrograma = $prg->getNombrePrograma();
                $proyecto = $controlViewPlanDiferencia->proyectoDiferencia( $carrera , $idLinea , $idPrograma );
                $numeroProyectos = sizeof( $proyecto );
            
                foreach ($proyecto as $pry ){
                    $idProyecto = $pry->getProyectoPlanDesarrolloId();
                    $nombreProyecto= $pry ->getNombreProyectoPlanDesarrollo();
                    $indicadores = $controlViewPlanDiferencia->indicadorDiferencia($carrera , $idLinea , $idPrograma , $idProyecto);
                    $numeroIndicadores = sizeof( $indicadores );
                    
                    foreach ( $indicadores as $indic ){
                        $contadorMetas=0;
                        $indicadorId = $indic->getIndicadorPlanDesarrolloId();
                        $nombreIndicadores = $indic->getIndicador();
                        $indicador = explode("_",$nombreIndicadores);
                        $tipoIndicador = $indicador[0];
                        $nombreIndicador =  $indicador[1];
                        $celdaIndicador=$nombreIndicador."--".$tipoIndicador; 
                        $meta = $controlViewPlanDiferencia->metaDiferencia($carrera , $idLinea , $idPrograma , $idProyecto , $indicadorId);
                        $numeroMetas = sizeof( $meta );
                      
                        foreach ($meta as $mt){
                            $n++;
                            
                            $reporteExcel->getActiveSheet()->SetCellValue('A'.$n, $ln->getNombreLineaEstrategica( ) );
                            $reporteExcel->getActiveSheet()->SetCellValue('B'.$n, $nombrePrograma );
                            $reporteExcel->getActiveSheet()->SetCellValue('C'.$n, $nombreProyecto );
                            $reporteExcel->getActiveSheet()->SetCellValue('D'.$n, $celdaIndicador ) ;
                            $reporteExcel->getActiveSheet()->SetCellValue('E'.$n, $mt->getMeta( ) );
                            $reporteExcel->getActiveSheet()->SetCellValue('F'.$n, $mt->getAlcanceMeta( ) );
                            $reporteExcel->getActiveSheet()->SetCellValue('G'.$n, $mt->getDiferencia( ) );
                            $conteoLinea=  $conteoLinea+1;
                        }
                    }                           
                }
            }
            $border_style= array('borders' => array('bottom' => array('style' =>PHPExcel_Style_Border::BORDER_THICK,'color' => array('argb' => '008000'),)));
            $reporteExcel->getActiveSheet()->getStyle("A".$n.":G".$n)->applyFromArray($border_style);
    
            $nLinea++;           
         } 
         
    }break;
    
}

$reporteExcel->getActiveSheet()->calculateColumnWidths();
$reporteExcel->getActiveSheet()->setTitle("Reporte");

header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="Reporte.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($reporteExcel, "Excel2007");
$objWriter->save('php://output');            
exit();
?>