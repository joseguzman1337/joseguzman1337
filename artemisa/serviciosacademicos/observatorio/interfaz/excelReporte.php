<?php

//session_start();
require_once 'excelInfo.php';

activeErrorReporting();
noCli();

require 'Classes/PHPExcel.php';

include 'PlantillaPdf.php';


   // include('../templates/templateObservatorio.php');
    //include_once ('funciones_datos.php');
    //   $db=writeHeaderBD();
   // $db=writeHeader('Observatorio',true,'');


require_once(realpath(dirname(__FILE__)).'/../../Connections/sala2.php' );
mysql_select_db($database_sala, $sala);



    $codigoperiodo=$_REQUEST['periodo'];//
     $modalidad=$_REQUEST['modalidad'];//
   //  $facultad=$_REQUEST['facultad'];//
     //$nestudiante=$_POST['nestudiante'];//
      $carrera=$_REQUEST['carrera'];//
    /* $tipo=$_REQUEST['tipo'];//
    $tipo2=$_REQUEST['tipo2'];//
    $vtipo=$_REQUEST['vtipo'];//vacio
    $Utipo=$_REQUEST['Utipo'];//vacio*/


    $objPHPExcel = new PHPExcel();



    $objPHPExcel->getProperties()->setCreator("Andres Tarapues")
    ->setLastModifiedBy("Maarten Balliauw")
    ->setTitle("Office 2007 XLSX Test Document")
    ->setSubject("Office 2007 XLSX Test Document")
    ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
    ->setKeywords("office 2007 openxml php")
    ->setCategory("Test result file");

    $objPHPExcel->getDefaultStyle()->getFont()->setName('Arial')
    ->setSize(10);

    





    $wc=''; $wp=''; $wm=''; $wi='';
    /*foreach($data_in as $dt){    
    }*/
    if(!empty($carrera)){
     $wc=" AND e.codigocarrera='".$carrera."' ";
   }

   if(!empty($codigoperiodo)){
     $wp="and ee.codigoperiodo = '".$codigoperiodo."' ";
   }

   if(!empty($modalidad)){
     $wm=" AND c.codigomodalidadacademicasic='".$modalidad."' ";
   }

   if(!empty($nestudiante)){
     $wi=" and  eg.numerodocumento='".$nestudiante."' ";
   }
   $objPHPExcel->setActiveSheetIndex(0)
   ->setCellValue('A1',"TIPO IDENTIFICACION")
   ->setCellValue('B1',"NÚMERO DE IDENTIFICACIÓN")
   ->setCellValue('C1',"NOMBRES")
   ->setCellValue('D1',"APELLIDOS")
   ->setCellValue('E1',"PROGRAMA")
   ->setCellValue('F1',"FACULTAD")
   ->setCellValue('G1',"PUNTAJE")

   ->setCellValue('H1',"¿SOLICITUD SEGUIMIENTO PAE?")
   ->setCellValue('I1',"POSIBLES RIESGOS");

   $fila=3;

   $query_datos ="SELECT ee.codigoestudiante, ee.codigoperiodo, e.codigocarrera,  eg.idestudiantegeneral,
   eg.nombresestudiantegeneral,  eg.apellidosestudiantegeneral,
   (SELECT nombredocumento FROM documento where documento.tipodocumento=eg.tipodocumento) as tipodocumento,
   eg.numerodocumento, c.nombrecarrera, m.nombremodalidadacademica, 
   fa.nombrefacultad, ee.puntaje, ee.seguimiento
   FROM obs_admitidos_cab_entrevista ee
   INNER JOIN estudiante e ON e.codigoestudiante=ee.codigoestudiante
   INNER JOIN estudiantegeneral eg ON e.idestudiantegeneral=eg.idestudiantegeneral 
   INNER JOIN carrera c ON c.codigocarrera=e.codigocarrera 
   INNER JOIN facultad as fa on (c.codigofacultad=fa.codigofacultad) 
   INNER JOIN modalidadacademica as m on (c.codigomodalidadacademica=m.codigomodalidadacademica and m.codigoestado=100)
   where ee.codigoestado like '1%'
   ".$wc." ".$wp." ".$wm." ".$wi." ";


    //echo $query_carrera;
   //$data_in= $db->Execute($query_datos);
   $data_in = mysql_query($query_datos, $sala);
   while($dt = mysql_fetch_assoc($data_in)){





    $codigoEstudiante = $dt['codigoestudiante'];
    $seguimiento = $dt['seguimiento'];
    $queri_PAE="SELECT count(idobs_tiporiesgo) as riesgo FROM  obs_admitidos_entrevista_conte where (idobs_tiporiesgo = 1 or idobs_tiporiesgo=2) 
    and (idobs_admitidos_contextoP=3 or idobs_admitidos_contextoP=5 or idobs_admitidos_contextoP=6)
    and (codigoestudiante = $codigoEstudiante)";

    $data_in2 = mysql_query($queri_PAE, $sala); 
    while($solicitud = mysql_fetch_assoc($data_in2)){ 
      $nivel = $solicitud['riesgo'];
    }



    $queri_PAE2="SELECT  count(puntaje) as riesgo1 FROM obs_admitidos_entrevista  where(puntaje = 0 or puntaje = 1) 
    and (idobs_admitidos_campos_evaluar = 2 or idobs_admitidos_campos_evaluar = 6 or idobs_admitidos_campos_evaluar = 10)
    and (codigoestudiante= $codigoEstudiante)";
    $data_in3 = mysql_query($queri_PAE2, $sala); 
    while($solicitud1 = mysql_fetch_assoc($data_in3)){ 
      $nivel2 = $solicitud1['riesgo1'];
    }


    $queri_PAE3="SELECT count(idobs_tiporiesgo) as riesgo2 FROM  obs_admitidos_entrevista_conte  where (idobs_tiporiesgo = 1 or idobs_tiporiesgo=2) 
    and (idobs_admitidos_contextoP=7 or idobs_admitidos_contextoP=14) and (codigoestudiante = $codigoEstudiante)";
    $data_in4 = mysql_query($queri_PAE3, $sala); 
    while($solicitud2 = mysql_fetch_assoc($data_in4)){ 
      $nivel3 = $solicitud2['riesgo2'];
    }
    $queri_PAE4="SELECT count(puntaje)  as riesgo3 FROM salaoees.obs_admitidos_entrevista where (puntaje = 0 or puntaje = 1) 
    and (obs_admitidos_entrevista.idobs_admitidos_campos_evaluar = 5) and (codigoestudiante = $codigoEstudiante)";
    $data_in5 = mysql_query($queri_PAE4, $sala);
    while($solicitud3 = mysql_fetch_assoc($data_in5)){ 
      $nivel4 = $solicitud3['riesgo3'];
    }
    $queri_PAE5="SELECT count(idobs_tiporiesgo) as riesgo4 FROM  obs_admitidos_entrevista_conte where (idobs_tiporiesgo = 1 or idobs_tiporiesgo=2) 
    and (idobs_admitidos_contextoP=1 or idobs_admitidos_contextoP=2 or idobs_admitidos_contextoP=4)
    and (codigoestudiante = $codigoEstudiante)";
    $data_in6 = mysql_query($queri_PAE5, $sala);
    while($solicitud4 = mysql_fetch_assoc($data_in6)){ 
      $nivel5 = $solicitud4['riesgo4'];
    }

    if( ($nivel!=0) || ($nivel2!=0)  || ($nivel3!=0) || ($nivel4!=0) || ($nivel5!=0)|| $seguimiento !=0){     


     if ($seguimiento!=0){ $res= 'Si';} else { $res= 'No';}
     if ( (($nivel !=0) || ($nivel2!=0) ) && (($nivel3!=0) || ($nivel4!=0)) && ($nivel5!=0) ){ $puntaj= 'Académico - Financiero - Psicosocial';}
      else if ((($nivel3!=0) || ($nivel4!=0)) && ($nivel5!=0)) { $puntaj= 'Financiero - Psicosocial';}	
      else  if ((($nivel!=0) || ($nivel2!=0)) && ($nivel5!=0)) { $puntaj= 'Académico - Psicosocial';}	
      else  if ((($nivel!=0) || ($nivel2!=0)) && (($nivel3!=0) || ($nivel4==1))) { $puntaj= 'Académico - Financiero';}
      else  if ($nivel5!=0){ $puntaj ='Psicosocial';}
      else  if (($nivel3!=0) || ($nivel4==1)){ $puntaj= 'Financiero';}
      else if (($nivel!=0) || ($nivel2==1) ) { $puntaj= 'Académico';}
      else {$puntaj= '-';}

      $objPHPExcel->setActiveSheetIndex(0)
      ->setCellValue('A'.$fila,$dt['tipodocumento'])
      ->setCellValue('B'.$fila,$dt['numerodocumento'])
      ->setCellValue('C'.$fila,$dt['nombresestudiantegeneral'])
      ->setCellValue('D'.$fila,$dt['apellidosestudiantegeneral'])
      ->setCellValue('E'.$fila,$dt['nombrecarrera'])
      ->setCellValue('F'.$fila,$dt['nombrefacultad'])
      ->setCellValue('G'.$fila,$dt['puntaje'])

      ->setCellValue('H'.$fila,$res)
      ->setCellValue('I'.$fila,$puntaj);
      $fila++;



    }//if

  }//while
  	//mysql_close($sala);	

  $objPHPExcel->getActiveSheet()->getColumnDimension("A")->setAutoSize(true);
  $objPHPExcel->getActiveSheet()->getColumnDimension("B")->setAutoSize(true);
  $objPHPExcel->getActiveSheet()->getColumnDimension("C")->setAutoSize(true);
  $objPHPExcel->getActiveSheet()->getColumnDimension("D")->setAutoSize(true);
  $objPHPExcel->getActiveSheet()->getColumnDimension("E")->setAutoSize(true);
  $objPHPExcel->getActiveSheet()->getColumnDimension("F")->setAutoSize(true);
  $objPHPExcel->getActiveSheet()->getColumnDimension("G")->setAutoSize(true);
  $objPHPExcel->getActiveSheet()->getColumnDimension("H")->setAutoSize(true);
  $objPHPExcel->getActiveSheet()->getColumnDimension("I")->setAutoSize(true);
  $objPHPExcel->getActiveSheet()->setTitle('Alertas Tempranas');

  $objPHPExcel->setActiveSheetIndex(0);

  getHeaders('Alertas_Tempranas');

  $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
  $objWriter->save('php://output');

  ?>


