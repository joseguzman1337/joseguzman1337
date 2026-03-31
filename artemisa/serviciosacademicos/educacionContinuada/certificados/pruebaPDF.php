<?php

ob_start();
    //$content='<page><style type="text/css">table{border-collapse: collapse;border-spacing: 0;border: none;}tr{border: none;} </style>'.$_POST['datos_a_enviar']."</page>";

echo "<img src='../parametrizacion/images/bosque_2013-07-09.jpg' alt='logo' style='width: 1090px'><br/><br/>";
    echo $_POST['datos_a_enviar'];
    
    $content = ob_get_clean();
        $content=  str_replace('\"', "", $content);
    require_once('../html2pdf/html2pdf.class.php');
    try
    {
        //$html2pdf = new HTML2PDF('P','A4','es');
		$html2pdf = new HTML2PDF('L','A4','es');
        $html2pdf->WriteHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output('exemple.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
    //var_dump($content);
    //echo $content;
?>
