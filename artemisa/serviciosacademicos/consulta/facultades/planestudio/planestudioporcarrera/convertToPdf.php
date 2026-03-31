<?php
    session_start();
    include_once('../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
    // this starts the session 
    session_start();
    ini_set ("memory_limit","300M");
    //set_time_limit(216000);
    //require_once "../../dompdf/dompdf_config.inc.php"; 
    //require_once('../../../../mgi/html2pdf/html2pdf.class.php');
    //se me ocurre meter un css con columna oculta que tenga display:none con eso puedo esconderlas solo pa imprimir el pdf
     
    //$_SESSION['MM_Username'] = $_REQUEST["usuario"];
    
    $content = str_replace('\"', "", $_REQUEST["html"]);
    $dom = new DOMDocument();

    $dom->loadHTML(utf8_decode($content));
    $element = $dom->createElement('head', '');
    // We insert the new element as root (child of the document)
    $dom->appendChild($element);

    $element = $dom->createElement('style', 'table
            {
            border-collapse: collapse;
                border-spacing: 0;
            }
            th, td {
                padding: 0;
            }
            table th{
                font-size: 10px;
                text-align:center;
                font-weight: bold;
            }
            td.estilostd{
                border-bottom: 1px solid #000000;
            }
            
            td.bordes{
                border: 1px solid #000000;
            }
            
            table table div{
                font-size:8px;
                text-align:center;      
    width:100%;font-weight: bold;
            }
            table table td{
                font-size:8px;
                text-align:center; 
            }
            h3{
                margin:5px;
                padding:0;
                font-size:14px;
            }
            
table.separar{
    margin-top:10px;
}
            
table tr table table{
    font-size:10px;
}
            ');
    $element->setAttribute("type", "text/css");

    $head = $dom->getElementsByTagName('head');

    $head = $dom->getElementsByTagName('head')->item(0);
    $head->appendChild($element);
    $tables = $dom->getElementsByTagName('table'); 
    if($tables!=null)
    {
        $i = 1;
        $total = $tables->length;
        foreach ($tables as $row) 
        {
            //$row->setAttribute("width", "600px");
            if($i<2){
                $row->setAttribute("width", "1050");
                $row->setAttribute("border", "0");
                $row->setAttribute("style", "text-align:center;clear:both;margin: 0px 0px;width:1050px;");
            } else if($i<3){
                $row->setAttribute("width", "1050");
                $row->setAttribute("align", "center");
                $row->setAttribute("style", "text-align:center;clear:both;margin: 10px 0px;width:1050px;");
            } else if($i<($total-3)) {
                $row->setAttribute("width", "100%");
                $row->setAttribute("height", "100%");
                $row->setAttribute("border", "0");
                $row->setAttribute("style", "clear:both;margin: 0px 0px;width:100%;height:100%;");
            } else {
                $row->setAttribute("width", "100%");
                $row->setAttribute("height", "100%");
                $row->setAttribute("style", "clear:both;margin: 0px 0px;width:100%;height:100%;font-size:10px;");
            }
            $i++;
        }
    }
    $content = $dom->saveHTML();
    //echo $content; die;
    /*ob_start();
    
    echo $content; //die;
    
    $content = ob_get_clean();
    $content=  str_replace('\"', "", $content);
    
    try
    {
        //$html2pdf = new HTML2PDF('P','A4','es');
	$html2pdf = new HTML2PDF('L','A4','es');
        $html2pdf->WriteHTML($content, false);
        $html2pdf->Output('planEstudio.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }*/
    require_once('./tcpdf/config/tcpdf_config.php');
require_once('./tcpdf/tcpdf.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION_LANDSCAPE, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('SALA');
$pdf->SetTitle('Reporte Plan de Estudio');
$pdf->SetSubject('Reporte Plan de Estudio');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
//// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// add a page
$pdf->AddPage();

$pdf->SetFont('helvetica', '', 6);

$pdf->writeHTML($content, true, false, false, false, '');

//Close and output PDF document
$pdf->Output('planEstudio.pdf', 'I');
    
?>
