<?php
require('fpdf.php');
require ('ean128.php');
?>
<?php
$prueba =  new ean128("41577099980017018020171100017106810093933900013800009620050624");
$prueba2 = new ean128("41577099980017018020171100017106810093933900014490009620050701");
$prueba3 = new ean128("41577099980017018020171100017106810093933900015180009620050711");
$ean1=$prueba->codificar();
$ean2=$prueba2->codificar();
$ean3=$prueba3->codificar();
?>
<?php
$pdf=new FPDF("P","mm","letter");
$pdf->AddFont('code128','','code128.php');
$pdf->AddPage();
$pdf->SetFont('code128','',28);
$pdf->Cell(0,30,$ean1,0,1);
$pdf->Cell(0,30,$ean2,0,1);
$pdf->Cell(0,30,$ean3,0,1);
$pdf->Output();
?>