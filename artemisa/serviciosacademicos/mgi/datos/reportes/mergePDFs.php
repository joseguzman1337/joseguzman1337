<?php

    // this starts the session 
    session_start();
    ini_set ("memory_limit","300M");    
    include_once('../../SQI_Documento/fpdf17/fpdf.php');  
    include_once('../../SQI_Documento/FPDI-1.4.2/fpdi.php');  
    
    $_SESSION['MM_Username'] = $_REQUEST["usuario"];
  
    ob_start(  );  
  
       // creo la clase para concatenación de PDFS  
    class concat_pdf extends FPDI {  
  
        var $files = array();  
  
        function setFiles($files) {  
            $this->files = $files;  
        }  
  
        function concat() {  
            foreach($this->files AS $file) {  
                $pagecount = $this->setSourceFile($file);  
                for ($i = 1; $i <= $pagecount; $i++) { 
				
				     $tplidx = $this->ImportPage($i);  
                     $s = $this->getTemplatesize($tplidx);  
                     //P es portrait y L es landscape --> orientación de la pagina
                     $this->AddPage('L', array($s['w'], $s['h']));  
                     $this->useTemplate($tplidx);  
                }  
            }  
        }  
    }  
  
    $pdf =& new concat_pdf();  
        // Simplemente basta con enviar como parametros las rutas de los archivos a fusionar  
    $pdf->setFiles(array("./reportesPDF/reporteIndicesEstudiantes_2013-04-01_08-37-56.pdf", "./reportesPDF/reporteIndicesEstudiantes_2013-04-01_08-38-25.pdf"));  
       // ejecuto la concatenacion de mis archivos origen  
    $pdf->concat();  
 
        // Escribir el archivo PDF resultado el directorio de salida debera tener permisos de escritura.  
    //$pdf->Output();  
    //$result = file_put_contents("./reportesPDF/prueba.pdf",$pdf->Output(),FILE_USE_INCLUDE_PATH);
    $pdf->Output("./reportesPDF/prueba.pdf", "F");
  
    ob_end_flush(); 
    
            if($result){
                $data["success"] = true;
                $data["archivo"] = 'prueba.pdf';
                //header('Location: ./reportesPDF/'.$path);
                //$dompdf->stream($path);
            } else {
                $data["success"] = false;
                $data["mensaje"] = 'ocurrio un error generando el archivo PDF';
            }
            echo json_encode($data);
?>
