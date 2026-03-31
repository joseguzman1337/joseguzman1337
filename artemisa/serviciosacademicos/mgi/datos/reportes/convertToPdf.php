<?php
    // this starts the session 
    session_start();
    ini_set ("memory_limit","300M");
    //set_time_limit(216000);
    //require_once "../../dompdf/dompdf_config.inc.php"; 
    require_once('../../html2pdf/html2pdf.class.php');
    require_once("../templates/template.php");  
    //se me ocurre meter un css con columna oculta que tenga display:none con eso puedo esconderlas solo pa imprimir el pdf
     
    $_SESSION['MM_Username'] = $_REQUEST["usuario"];
    
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
            border: 1px solid #000000;
                padding: 0.5em;
            }');
    $element->setAttribute("type", "text/css");

    $head = $dom->getElementsByTagName('head');

    $head = $dom->getElementsByTagName('head')->item(0);
    $head->appendChild($element);
    $tables = $dom->getElementsByTagName('table'); 
    if($tables!=null)
    {
        foreach ($tables as $row) 
        {
            //$row->setAttribute("width", "600px");
            $row->setAttribute("style", "text-align:left;clear:both;margin: 10px 0px;width:760px;");
        }
    }
    $content = $dom->saveHTML();
    //echo $content; die;
    ob_start();
    
    echo $content; //die;
    
    $content = ob_get_clean();
    $content=  str_replace('\"', "", $content);
    
    try
    {
        $html2pdf = new HTML2PDF('P','A4','es');
	//$html2pdf = new HTML2PDF('L','A4','es');
        $html2pdf->WriteHTML($content, false);
        $html2pdf->Output('certificado.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
    
    /*$dompdf = new DOMPDF();
    $dompdf->load_html($_REQUEST["html"]);
    $dompdf->set_paper("a4", "portrait");
    $dompdf->render();

    $dompdf->stream("reporte.pdf", array("Attachment" => false));*/
    
    /*$content = "";
    $path = "";
    if(isset($_REQUEST["codigoperiodo"])&&$_REQUEST["codigoperiodo"]!=""){
        doPDF($path,$content,false,true,"a4","landscape",$_REQUEST["codigoperiodo"],$_REQUEST["html"]);
    } else {
        doPDF($path,$content,false,true,"a4","landscape", null, $_REQUEST["html"]);
    }
    //doPDF($path,$content,false,true);
    //doPDF();
    function doPDF($path='',$content='',$body=false,$mode=false,$paper_1='a4',$paper_2='portrait',$codigoperiodo=null,$htmlC=null)
{    
    //if( $body!=true and $body!=false ) $body=false;
    //if( $mode!=true and $mode!=false ) $mode=false;
    
    $db = getBD();
    $utils = new Utils_datos();
    $reporte = $utils->getDataEntity("reporte",$_REQUEST["reporte"]);
    
    /*if( $body == true )
    {
        $content='
        <!doctype html>
        <html>
        <head>
            <link rel="stylesheet" href="'.$style.'" type="text/css" />
        </head>
        <body>'
            .$content.
        '</body>
        </html>';
    }*/
    /*ob_start(); 
    $content = ob_get_contents();
    ob_end_clean();*/
    //$content = file_get_contents('http://'. $_SERVER['HTTP_HOST'] .'/serviciosacademicos/mgi/datos/reportes/detalle.php?idIndicador=90038');
    //$content = file_get_contents('http://'. $_SERVER['HTTP_HOST'] .'/serviciosacademicos/mgi/datos/reportes/detalle.php?id=row_1&usuario='.$_SESSION['MM_Username']);
    //$content = file_get_contents('http://172.16.3.227/serviciosacademicos/mgi/datos/reportes/detalle.php?idIndicador=90534&usuario='.$_SESSION['MM_Username']);
    //var_dump($content);
    
    //if($reporte["pdfPersonalizado"]==0){
        //$content = file_get_contents('http://'. $_SERVER['HTTP_HOST'] .'/serviciosacademicos/mgi/datos/reportes/detalle.php?id=row_'.$reporte["idsiq_reporte"].'&usuario='.$_SESSION['MM_Username']);
        
       /* if($htmlC!=null){
            $content = $htmlC;
        }
        //var_dump($content);
        $dom = new DOMDocument();
        $dom->loadHTML($content);
        $element = $dom->getElementById('menuPrincipal');
        if($element!=null)
        $element->parentNode->removeChild($element);
        
        $element = $dom->getElementById('nav');
        if($element!=null)
        $element->parentNode->removeChild($element);
        
        $element = $dom->getElementById('dialog-indicadores');
        if($element!=null)
        $element->parentNode->removeChild($element);
        
        $content = $dom->saveHTML();
    /*} else {
        /*if($reporte["imprimirPDF_por_periodo"]==0){
        if($codigoperiodo!=null){
            $content = file_get_contents('http://'. $_SERVER['HTTP_HOST'] .'/serviciosacademicos/mgi/datos/reportes/detallePDF.php?id=row_'.$reporte["idsiq_reporte"].'&usuario='.$_SESSION['MM_Username'].'&codigoperiodo='.$codigoperiodo);
        } else {
            $content = file_get_contents('http://'. $_SERVER['HTTP_HOST'] .'/serviciosacademicos/mgi/datos/reportes/detallePDF.php?id=row_'.$reporte["idsiq_reporte"].'&usuario='.$_SESSION['MM_Username']);
        }
        /*} else {
            crearPDFPorPeriodo($path,$content,$body,$mode,$paper_1,$paper_2,$db,$reporte,$utils);
        } 
    }*/
    /*if( $content!='' )
    {        
        //Añadimos la extensión del archivo. Si está vacío el nombre lo creamos
        $path!='' ? $path .='.pdf' : $path = crearNombre(10,$reporte);  

        //Las opciones del papel del PDF. Si no existen se asignan las siguientes:[*]
        if( $paper_1=='' ) $paper_1='a4';
        if( $paper_2=='' ) $paper_2='portrait';
            
        $dompdf =  new DOMPDF();
        $dompdf->set_paper($paper_1,$paper_2);
        $dompdf->load_html(utf8_decode($content));
        //ini_set("memory_limit","32M"); //opcional 
        $dompdf->render();
        var_dump($mode); die;   
        //Creamos el pdf
        if($mode==false)
            $dompdf->stream($path);
            
        //Lo guardamos en un directorio y lo mostramos
        if($mode==true)
        {            
        var_dump($dompdf); die;   
            $result = file_put_contents("./reportesPDF/".$path,$dompdf->output(),FILE_USE_INCLUDE_PATH);
            if($result){
                $data["success"] = true;
                $data["archivo"] = $path;
                //header('Location: ./reportesPDF/'.$path);
                //$dompdf->stream($path);
            } else {
                $data["success"] = false;
                $data["mensaje"] = 'ocurrio un error generando el archivo PDF';
            }
            echo json_encode($data);
        }
    }
}

function crearNombre($length,$reporte)
{
    if( ! isset($length) or ! is_numeric($length) ) $length=6;
    
    $str  = "0123456789abcdefghijklmnopqrstuvwxyz";
    $path = '';
    
    if($reporte["archivoReporte"]!=null){
        $path = $reporte["archivoReporte"];
    } else {
        for($i=1 ; $i<$length ; $i++)
            $path .= $str{rand(0,strlen($str)-1)};
    }

    return $path.'_'.date("Y-m-d_H-i-s").'.pdf';    
} 

/*function crearNombreTemp($length,$reporte)
{
    if( ! isset($length) or ! is_numeric($length) ) $length=6;
    
    $str  = "0123456789abcdefghijklmnopqrstuvwxyz";
    $path = '';
    
    if($reporte["archivoReporte"]!=null){
        $path = "temp_".$reporte["archivoReporte"];
    } else {
        for($i=1 ; $i<$length ; $i++)
            $path .= $str{rand(0,strlen($str)-1)};
    }

    return $path.'_'.date("Y-m-d_H-i-s");    
} 

function getPeriodos($db,$dates){
    $query="select codigoperiodo from periodo where fechainicioperiodo>='".$dates["fecha_inicial"]."' AND fechavencimientoperiodo<='".$dates["fecha_final"]."' ORDER BY codigoperiodo ASC";
    return $db->Execute($query);
}


function crearPDFPorPeriodo($path='',$content='',$body=false,$mode=false,$paper_1='a4',$paper_2='portrait',$db,$reporte,$utils){    
       
    $dates = $utils->getDatesReport($db, $reporte["idsiq_reporte"]);
    $periodos = getPeriodos($db,$dates);
    $i = 0;
    
    //Añadimos la extensión del archivo. Si está vacío el nombre lo creamos
    $path!='' ? $path .='.pdf' : $path = crearNombreTemp(10,$reporte); 
    $archivos = array();
    while($row_periodo = $periodos->FetchRow()){ 
        $content = file_get_contents('http://'. $_SERVER['HTTP_HOST'] .'/serviciosacademicos/mgi/datos/reportes/detallePDF.php?id=row_'.$reporte["idsiq_reporte"].'&usuario='.$_SESSION['MM_Username'].'&codigoperiodo='.$row_periodo["codigoperiodo"]);
        if( $content!='' )
            {         
                $pathTemp = $path."_".$row_periodo["codigoperiodo"].'.pdf';
                //Las opciones del papel del PDF. Si no existen se asignan las siguientes:[*]
                if( $paper_1=='' ) $paper_1='a4';
                if( $paper_2=='' ) $paper_2='portrait';

                $dompdf =  new DOMPDF();
                $dompdf -> set_paper($paper_1,$paper_2);
                $dompdf -> load_html(utf8_decode($content));
                //ini_set("memory_limit","32M"); //opcional 
                $dompdf -> render();

                //Creamos el pdf
                if($mode==false)
                    $dompdf->stream($pathTemp);

                //Lo guardamos en un directorio y lo mostramos
                if($mode==true)
                {               
                    $result = file_put_contents("./reportesPDF/".$pathTemp,$dompdf->output(),FILE_USE_INCLUDE_PATH);  
                    if($result){
                        $archivos[$i] = $pathTemp;
                    }
                }
            }
        $i = $i + 1;
    }
    
    if($result){
         $data["success"] = true;
         $data["archivo"] = false;
         $data["archivos"] = $archivos;
                        //header('Location: ./reportesPDF/'.$path);
                        //$dompdf->stream($path);
          } else {
              $data["success"] = false;
              $data["mensaje"] = 'ocurrio un error generando el archivo PDF';
     }
     echo json_encode($data);
     exit();
    
}*/


    
?>
