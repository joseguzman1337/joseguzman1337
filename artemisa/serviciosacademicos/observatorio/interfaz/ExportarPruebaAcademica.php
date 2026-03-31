<?php
session_start();

require_once 'functions/excel2.php';

activeErrorReporting();
noCli();

require 'Classes/PHPExcel.php';

include 'PlantillaPdf.php';

require_once(realpath(dirname(__FILE__)).'/../../Connections/sala2.php' );
mysql_select_db($database_sala, $sala);


$modalidadacademica = $_SESSION['codigomodalidadacademica'];
$programa = $_SESSION['programa'];


$objPHPExcel = new PHPExcel();

if(isset($_POST['excel'])){

    $objPHPExcel->getProperties()->setCreator("HernanCortes")
    ->setLastModifiedBy("Maarten Balliauw")
    ->setTitle("Office 2007 XLSX Test Document")
    ->setSubject("Office 2007 XLSX Test Document")
    ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
    ->setKeywords("office 2007 openxml php")
    ->setCategory("Test result file");

    $objPHPExcel->getDefaultStyle()->getFont()->setName('Arial')
    ->setSize(10);


    $objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('A1',"NÚMERO DE IDENTIFICACIÓN")
    ->setCellValue('B1',"NOMBRES")
    ->setCellValue('C1',"APELLIDOS")
    ->setCellValue('D1',"SEMESTRE")
    ->setCellValue('E1',"CARRERA");

    $fila=2;

    if($programa!=""){

        $query_solicitud = "SELECT DISTINCT eg.apellidosestudiantegeneral, eg.nombresestudiantegeneral, eg.numerodocumento, est.codigoestudiante, ca.nombrecarrera
              FROM estudiante est, estudiantegeneral eg,carrera ca
              WHERE ca.codigocarrera = '".$programa."'
              and eg.idestudiantegeneral = est.idestudiantegeneral
              and ca.codigocarrera = est.codigocarrera
              and est.codigosituacioncarreraestudiante in (200)
              order by eg.nombresestudiantegeneral";
              //and est.codigosituacioncarreraestudiante not like '1%'
              //and est.codigosituacioncarreraestudiante not like '5%'
          
        $res_solicitud = mysql_query($query_solicitud, $sala) or die("$query_solicitud".mysql_error());

        while($estudiantesDatos = mysql_fetch_assoc($res_solicitud)){

            $SQL_semestre_Actual = "SELECT MAX(pr.semestreprematricula) AS 'SemestreActual'
                    FROM estudiantegeneral eg
                    INNER JOIN estudiante e ON e.idestudiantegeneral = eg.idestudiantegeneral
                    INNER JOIN prematricula pr ON pr.codigoestudiante = e.codigoestudiante
                    WHERE eg.numerodocumento = '".$estudiantesDatos['numerodocumento']."'";

                    
            $Sem_Actual = mysql_query($SQL_semestre_Actual, $sala) or die("$query_solicitud".mysql_error());
            $semestre_Actual = mysql_fetch_assoc($Sem_Actual);

            $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$fila,$estudiantesDatos['numerodocumento'])
            ->setCellValue('B'.$fila,$estudiantesDatos['nombresestudiantegeneral'])
            ->setCellValue('C'.$fila,$estudiantesDatos['apellidosestudiantegeneral'])
            ->setCellValue('D'.$fila,$semestre_Actual['SemestreActual'])
            ->setCellValue('E'.$fila,$estudiantesDatos['nombrecarrera']);

            $fila++;

        }
        
    }else{


          $departamento="departamento";

                  $cad= 'SELECT 
                      codigocarrera, 
                      nombrecarrera 
                      from carrera   
                      WHERE codigomodalidadacademica = '.$modalidadacademica.' 
                      and nombrecarrera NOT LIKE "%'.$departamento.'%"
                      and codigocarrera not in (30, 39, 74, 138) 
                      ORDER BY nombrecarrera';


          $Programa = mysql_query($cad, $sala) or die("$query".mysql_error());
          
          while($ListProgramas = mysql_fetch_assoc($Programa)){

            $query_solicitud = "SELECT DISTINCT eg.apellidosestudiantegeneral, eg.nombresestudiantegeneral, eg.numerodocumento, est.codigoestudiante, ca.nombrecarrera
                FROM estudiante est, estudiantegeneral eg,carrera ca
                WHERE ca.codigocarrera = '".$ListProgramas['codigocarrera']."'
                and eg.idestudiantegeneral = est.idestudiantegeneral
                and ca.codigocarrera = est.codigocarrera
                and est.codigosituacioncarreraestudiante in (200)
                order by eg.nombresestudiantegeneral";
                //and est.codigosituacioncarreraestudiante not like '1%'
                //and est.codigosituacioncarreraestudiante not like '5%'
            
            $res_solicitud = mysql_query($query_solicitud, $sala) or die("$query_solicitud".mysql_error());

            $_SESSION['res_solicitud'] = $res_solicitud;

              while($estudiantesDatos = mysql_fetch_assoc($res_solicitud)){

                $SQL_semestre_Actual = "SELECT MAX(pr.semestreprematricula) AS 'SemestreActual'
                    FROM estudiantegeneral eg
                    INNER JOIN estudiante e ON e.idestudiantegeneral = eg.idestudiantegeneral
                    INNER JOIN prematricula pr ON pr.codigoestudiante = e.codigoestudiante
                    WHERE eg.numerodocumento = '".$estudiantesDatos['numerodocumento']."'";
                        //and est.codigosituacioncarreraestudiante not like '1%'
                        //and est.codigosituacioncarreraestudiante not like '5%'
                    
                $Sem_Actual = mysql_query($SQL_semestre_Actual, $sala) or die("$query_solicitud".mysql_error());
                $semestre_Actual = mysql_fetch_assoc($Sem_Actual);


            $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$fila,$estudiantesDatos['numerodocumento'])
            ->setCellValue('B'.$fila,$estudiantesDatos['nombresestudiantegeneral'])
            ->setCellValue('C'.$fila,$estudiantesDatos['apellidosestudiantegeneral'])
            ->setCellValue('D'.$fila,$semestre_Actual['SemestreActual'])
            ->setCellValue('E'.$fila,$estudiantesDatos['nombrecarrera']);

            $fila++;


            }

        }

        
    }

    $objPHPExcel->getActiveSheet()->getColumnDimension("A")->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension("B")->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension("C")->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension("D")->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension("E")->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->setTitle('Prueba Academica Estudiantes');

    $objPHPExcel->setActiveSheetIndex(0);

    getHeaders();

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    $objWriter->save('php://output');





}else{



    $pdf = new PDF('L','mm','legal');

    $pdf->AddPage();

    $pdf->SetFillColor(232,232,232);
    $pdf->SetFont('Arial','B',12);

    $pdf->Cell(70,6,utf8_decode('NÚMERO DE IDENTIFICACIÓN'),1,0,'C',1);
    $pdf->Cell(60,6,'NOMBRE',1,0,'C',1);
    $pdf->Cell(60,6,'APELLIDOS',1,0,'C',1);
    $pdf->Cell(30,6,'SEMESTRE',1,0,'C',1);
    $pdf->Cell(70,6,'CARRERA',1,1,'C',1);


    $pdf->SetFont('Arial','',10);
    if($programa!=""){

        $query_solicitud = "SELECT DISTINCT eg.apellidosestudiantegeneral, eg.nombresestudiantegeneral, eg.numerodocumento, est.codigoestudiante, ca.nombrecarrera
              FROM estudiante est, estudiantegeneral eg,carrera ca
              WHERE ca.codigocarrera = '".$programa."'
              and eg.idestudiantegeneral = est.idestudiantegeneral
              and ca.codigocarrera = est.codigocarrera
              and est.codigosituacioncarreraestudiante in (200)
              order by eg.nombresestudiantegeneral";
              //and est.codigosituacioncarreraestudiante not like '1%'
              //and est.codigosituacioncarreraestudiante not like '5%'
          
        $res_solicitud = mysql_query($query_solicitud, $sala) or die("$query_solicitud".mysql_error());

        while($estudiantesDatos = mysql_fetch_assoc($res_solicitud)){

            $SQL_semestre_Actual = "SELECT MAX(pr.semestreprematricula) AS 'SemestreActual'
                    FROM estudiantegeneral eg
                    INNER JOIN estudiante e ON e.idestudiantegeneral = eg.idestudiantegeneral
                    INNER JOIN prematricula pr ON pr.codigoestudiante = e.codigoestudiante
                    WHERE eg.numerodocumento = '".$estudiantesDatos['numerodocumento']."'";

                    
            $Sem_Actual = mysql_query($SQL_semestre_Actual, $sala) or die("$query_solicitud".mysql_error());
            $semestre_Actual = mysql_fetch_assoc($Sem_Actual);

            $pdf->Cell(70,6,$estudiantesDatos['numerodocumento'],1,0,'C',1);
            $pdf->Cell(60,6,utf8_decode($estudiantesDatos['nombresestudiantegeneral']),1,0,'C',1);
            $pdf->Cell(60,6,utf8_decode($estudiantesDatos['apellidosestudiantegeneral']),1,0,'C',1);
            $pdf->Cell(30,6,utf8_decode($semestre_Actual['SemestreActual']),1,0,'C',1);
            $pdf->Cell(70,6,utf8_decode($estudiantesDatos['nombrecarrera']),1,1,'C',1);


        }
        
    }else{


          $departamento="departamento";

                  $cad= 'SELECT 
                      codigocarrera, 
                      nombrecarrera 
                      from carrera   
                      WHERE codigomodalidadacademica = '.$modalidadacademica.' 
                      and nombrecarrera NOT LIKE "%'.$departamento.'%"
                      and codigocarrera not in (30, 39, 74, 138) 
                      ORDER BY nombrecarrera';


          $Programa = mysql_query($cad, $sala) or die("$query".mysql_error());
          
          while($ListProgramas = mysql_fetch_assoc($Programa)){

            $query_solicitud = "SELECT DISTINCT eg.apellidosestudiantegeneral, eg.nombresestudiantegeneral, eg.numerodocumento, est.codigoestudiante, ca.nombrecarrera
                FROM estudiante est, estudiantegeneral eg,carrera ca
                WHERE ca.codigocarrera = '".$ListProgramas['codigocarrera']."'
                and eg.idestudiantegeneral = est.idestudiantegeneral
                and ca.codigocarrera = est.codigocarrera
                and est.codigosituacioncarreraestudiante in (200)
                order by eg.nombresestudiantegeneral";
                //and est.codigosituacioncarreraestudiante not like '1%'
                //and est.codigosituacioncarreraestudiante not like '5%'
            
            $res_solicitud = mysql_query($query_solicitud, $sala) or die("$query_solicitud".mysql_error());

            $_SESSION['res_solicitud'] = $res_solicitud;

              while($estudiantesDatos = mysql_fetch_assoc($res_solicitud)){

                $SQL_semestre_Actual = "SELECT MAX(pr.semestreprematricula) AS 'SemestreActual'
                    FROM estudiantegeneral eg
                    INNER JOIN estudiante e ON e.idestudiantegeneral = eg.idestudiantegeneral
                    INNER JOIN prematricula pr ON pr.codigoestudiante = e.codigoestudiante
                    WHERE eg.numerodocumento = '".$estudiantesDatos['numerodocumento']."'";
                        //and est.codigosituacioncarreraestudiante not like '1%'
                        //and est.codigosituacioncarreraestudiante not like '5%'
                    
                $Sem_Actual = mysql_query($SQL_semestre_Actual, $sala) or die("$query_solicitud".mysql_error());
                $semestre_Actual = mysql_fetch_assoc($Sem_Actual);


            $pdf->Cell(70,6,$estudiantesDatos['numerodocumento'],1,0,'C',1);
            $pdf->Cell(60,6,utf8_decode($estudiantesDatos['nombresestudiantegeneral']),1,0,'C',1);
            $pdf->Cell(60,6,utf8_decode($estudiantesDatos['apellidosestudiantegeneral']),1,0,'C',1);
            $pdf->Cell(30,6,utf8_decode($semestre_Actual['SemestreActual']),1,0,'C',1);
            $pdf->Cell(70,6,utf8_decode($estudiantesDatos['nombrecarrera']),1,1,'C',1);

            


            }

        }
    }


    $pdf->Output('D','Reporte Estudiantes Prueba Academica.pdf');  

}


?>