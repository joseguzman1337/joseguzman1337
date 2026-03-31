<?php
require_once('../../../clases/fpdf/fpdf.php');
require_once('barcode/barcode.php');
require_once("../../conexion/conexionpear.php");
define('FPDF_FONTPATH','../../../clases/fpdf/font/');
?>
<?php
$universidad=DB_DataObject::factory('universidad');
$universidad->get('iduniversidad','1');
$factura=new FPDF("P","cm","letter");
$factura->SetFont('Arial','B',10);
$factura->SetMargins(0.5,0.5,0.5);
$factura->AddPage();
$factura->Cell(11,0.3,$universidad->nombreuniversidad,0,1,'C');
$factura->SetFont('Arial','',5);
$factura->Cell(11,0.2,$universidad->personeriauniversidad,0,1,'C');
$factura->Cell(11,0.2,$universidad->direccionuniversidad,0,1,'C');
$factura->Cell(11,0.2,$universidad->nituniversidad,0,1,'C');
$factura->Image('../../../imagenes/logo.jpg',0.5,0.5,1);
$factura->Ln(0.1);
$factura->SetFont('Arial','',6);
$factura->Cell(3,0.3,"CODIGO ".$codigoestudiante,1,0,'L');
$factura->Cell(2,0.3,"SEM. ".$semestre,1,0,'L');
$factura->Cell(3,0.3,"PER.ACA ".$codigoperiodo,1,0,'L');
$factura->Cell(3,0.3,"IDENT. ".$numerodocumento,1,1,'L');
$factura->Cell(1.5,0.3,"NOMBRE: ".$nombre,1,0,'C');
$factura->Cell(9.5,0.3,$nombre,1,1,'C');
$factura->SetFont('Arial','B',6);
$factura->Cell(11,0.3,"DESCRIPCION DEL PAGO",1,1,'C');
$factura->Cell(11,4.5,"",1,1,'L');
$factura->SetFont('Arial','',6);
$factura->Cell(6,0.3,"PAGO OPORTUNO HASTA: ".$fecha_pago_oportuno,1,0,'L');
$factura->Cell(5,0.3,"LA SUMA DE: ".$suma_pago_oportuno,1,1,'L');
$factura->Cell(6,0.3,"2DO VENCIMIENTO HASTA: ".$fecha_2do_vencimiento,1,0,'L');
$factura->Cell(5,0.3,"LA SUMA DE: ".$suma_pago_2do_vencimiento,1,1,'L');
$factura->Cell(6,0.3,"3ER VENCIMIENTO HASTA: ".$fecha_3er_vencimiento,1,0,'L');
$factura->Cell(5,0.3,"LA SUMA DE: ".$suma_pago_3er_vencimiento,1,1,'L');
$factura->Output();
?>