<?php

require('html2fpdf.php');
$pdf=new HTML2FPDF();
$pdf->AddPage();
$fp = fopen("sample.html","r");
$strContent = fread($fp, filesize("sample.html"));
fclose($fp);
$pdf->WriteHTML($strContent);
echo $strContent;
$pdf->Output("sample.pdf");
echo "PDF file is generated successfully!";

?>
