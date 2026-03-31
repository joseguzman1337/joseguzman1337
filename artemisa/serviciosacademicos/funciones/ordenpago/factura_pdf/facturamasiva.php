<?php
$universidad = new ADODB_Active_Record('universidad');
$universidad->Load('iduniversidad=1');

$datos=new datos_ordenpago($sala,$codigoestudiante,$numeroordenpago);
$datos->obtener_datos_estudiante();
$datos->obtener_conceptos();
$fechas=$datos->fechas_pago();
//listar($fechas);
$datos->obtener_materias();
$datos->armar_referencia();
$codigosbarras=$datos->generar_codigobarras_base();
$titulosbarras=$datos->generar_titulobarras_base();
//////////////////////////////////////////////////

$factura->SetAutoPageBreak(1);
$factura->AddFont('code128','','code128.php');
$factura->SetFont('Arial','B',10);
$factura->SetMargins(1,0.5,1);
$factura->AddPage();
$factura->Rect(1,0.4,11,2,"");
$factura->Cell(11,0.3,$universidad->nombreuniversidad,0,1,'C');
$factura->SetFont('Arial','',5);
$factura->Cell(11,0.2,$universidad->personeriauniversidad,0,1,'C');
$factura->Cell(11,0.2,$universidad->direccionuniversidad,0,1,'C');
$factura->Cell(11,0.2,$universidad->nituniversidad,0,1,'C');
$factura->Image('../../../../imagenes/logo.jpg',1.05,0.5,1);
$factura->Ln(0.1);
$factura->SetFont('Arial','',6);
$factura->Cell(3,0.3,"ID ".$datos->estudiante['idestudiantegeneral'],1,0,'L');
$factura->Cell(2,0.3,"SEM. ".$datos->estudiante['semestreprematricula'],1,0,'L');
$factura->Cell(3,0.3,"PERIODO ".$datos->estudiante['codigoperiodo'],1,0,'L');
$factura->Cell(3,0.3,"IDENT. ".$datos->estudiante['nombrecortodocumento']." ".$datos->estudiante['numerodocumento'],1,1,'L');
$factura->Cell(1.5,0.3,"NOMBRE: ",1,0,'C');
$factura->Cell(9.5,0.3,$datos->estudiante['nombre'],1,1,'C');
$factura->SetFont('Arial','B',6);
$factura->Cell(11,0.3,"DESCRIPCION DEL PAGO",1,1,'C');
//*********************************************************************rectangulo
$factura->Rect(1,2.4,11,5.6,"");
$factura->SetY(2.4);
foreach ($datos->conceptos as $llave => $valor)
{
	$factura->Cell(9,0.3,$valor['nombreconcepto'],0,0,'L');
	$factura->Cell(2,0.3,money_format('%(#10n',$valor['valorconcepto']),0,1,'L');
}
$factura->SetY(6.8);
$factura->SetFont('Arial','',6);
$factura->Cell(6,0.3,"PAGO TOTAL: ",1,0,'L');
$factura->Cell(5,0.3,money_format('%(#10n',$datos->fechas[0]['valorapagar']),1,1,'L');
foreach ($datos->fechas as $llave => $valor)
{
	$factura->Cell(6,0.3,$valor['nombreplazo']." ".$valor['fechaordenpago'],1,0,'L');
	$factura->Cell(5,0.3,money_format('%(#10n',$valor['valorapagar']),1,1,'L');
}

$factura->SetFont('Arial','',4);
$factura->SetY(8.05);
$factura->Cell(20.65,0.2,"PARA SU VALIDEZ DEBE TENER EL TIMBRE DE LA REGISTRADORA Y EL SELLO DE RECIBIDO",0,0,'C');
$largo=0.15;
$espaciado=0.25;
$x1=0;
$x2=$x1+$largo;
for($i = 0; $i <= 86; $i++)
{
	$factura->Line($x1, 8.3, $x2, 8.3);
	//echo $x1," ",$x2,"<br>";
	$x1=$x1+$espaciado;
	$x2=$x2+$espaciado;
}
$factura->Image('../../../../imagenes/tijeras.png',0.5,8.15,0.4);
$factura->SetY(0.5);
$factura->SetLeftMargin(12);
//*********************************************************************rectangulo
$factura->Rect(12,0.4,8.6,1.4,"");
$factura->SetFont('Arial','B',9);
$factura->Cell(4,0.4,"BANCO DE CREDITO",0,0,'L');
$factura->SetFont('Arial','',7);
$factura->Cell(4,0.4,"CONVENIO No. 8032",0,1,'L');
$factura->SetFont('Arial','B',9);
$factura->Cell(4,0.4,"BANCO DE BOGOTA",0,0,'L');
$factura->SetFont('Arial','',7);
$factura->Cell(4,0.4,"CODIGO No. 2121",0,1,'L');
$factura->SetFont('Arial','B',9);
$factura->Cell(4,0.4,"BANCOLOMBIA",0,0,'L');
$factura->SetFont('Arial','',7);
$factura->Cell(4,0.34,"CONVENIO No. 4261",0,1,'L');
//**CUADRITOS
$factura->Rect(20.1,0.5,0.32,0.32,"");
$factura->Rect(20.1,0.9,0.32,0.32,"");
$factura->Rect(20.1,1.32,0.32,0.32,"");
$factura->SetFont('Arial','B',6);
$factura->SetY(1.8);
$factura->Cell(8.6,0.3,"RECIBO DE PAGO No.      ".$_GET['numeroordenpago'],1,1,'L');
$factura->SetFont('Arial','',6);
$factura->Cell(8.6,0.3,"PROGRAMA: ".$datos->estudiante['codigosucursal']."-".$datos->estudiante['centrocosto']." ".$datos->estudiante['nombrecarrera'],1,1,'L');
//*********************************************************************rectangulo
$factura->Rect(12,1.8,8.6,6.2,"");
$factura->SetY(2.4);
foreach($datos->materias as $llave => $valor)
{
	$factura->Cell(9.65,0.3,$valor['codigomateria']." ".strtoupper($valor['nombremateria']),0,1,'L');

}
//*********************************************************************final primer pedazo
$factura->Rect(1,8.65,19.6,4,"");
$factura->Rect(1,8.65,11,4,"");
//*****rayita
$largo=0.15;
$espaciado=0.25;
$x1=0;
$x2=$x1+$largo;
for($i = 0; $i <= 86; $i++)
{
	$factura->Line($x1, 13, $x2, 13);
	$x1=$x1+$espaciado;
	$x2=$x2+$espaciado;
}
$factura->Image('../../../../imagenes/tijeras.png',0.5,12.8,0.4);
$factura->Rect(1,13.35,19.6,4,"");
$factura->Rect(1,13.35,11,4,"");
$largo=0.15;
$espaciado=0.25;
$x1=0;
$x2=$x1+$largo;
for($i = 0; $i <= 86; $i++)
{
	$factura->Line($x1, 17.65, $x2, 17.65);
	$x1=$x1+$espaciado;
	$x2=$x2+$espaciado;
}
//ultimo cuadro
$factura->Image('../../../../imagenes/tijeras.png',0.5,17.5,0.4);
$factura->Rect(1,18,19.6,7.7,"");
$factura->Rect(1,18,11,7.7,"");
//segunda casila
$factura->Image('../../../../imagenes/logo.jpg',1.05,8.75,1);
$factura->Image('../../../../imagenes/logo.jpg',1.05,13.45,1);
//$factura->Image('../../../../imagenes/logo.jpg',1.05,19.7,1);
$factura->setxy(1,8.75);
$factura->SetLeftMargin(1);
//2 encabezado
$factura->SetFont('Arial','B',10);
$factura->Cell(11,0.3,$universidad->nombreuniversidad,0,1,'C');
$factura->SetFont('Arial','',5);
$factura->Cell(11,0.2,$universidad->personeriauniversidad,0,1,'C');
$factura->Cell(11,0.2,$universidad->direccionuniversidad,0,1,'C');
$factura->Cell(11,0.2,$universidad->nituniversidad,0,1,'C');
$factura->Ln(0.1);
$factura->SetFont('Arial','',6);
$factura->Cell(3,0.3,"ID ".$datos->estudiante['idestudiantegeneral'],1,0,'L');
$factura->Cell(2,0.3,"SEM. ".$datos->estudiante['semestreprematricula'],1,0,'L');
$factura->Cell(3,0.3,"PERIODO ".$datos->estudiante['codigoperiodo'],1,0,'L');
$factura->Cell(3,0.3,"IDENT. ".$datos->estudiante['nombrecortodocumento']." ".$datos->estudiante['numerodocumento'],1,1,'L');
$factura->Cell(1.5,0.3,"NOMBRE: ",1,0,'C');
$factura->Cell(9.5,0.3,$datos->estudiante['nombre'],1,1,'C');
$factura->SetFont('Arial','B',6);
$factura->Cell(11,0.3,"DESCRIPCION DEL PAGO",1,1,'C');
$factura->SetY(10.95);
$factura->SetFont('Arial','',6);
$factura->Cell(6,0.3,"PAGO TOTAL: ",1,0,'L');
$factura->Cell(5,0.3,money_format('%(#10n',$datos->fechas[0]['valorapagar']),1,1,'L');
foreach ($datos->fechas as $llave => $valor)
{
	$factura->Cell(6,0.3,$valor['nombreplazo']." ".$valor['fechaordenpago'],1,0,'L');
	$factura->Cell(5,0.3,money_format('%(#10n',$valor['valorapagar']),1,1,'L');
}
$factura->SetFont('Arial','',4);
$factura->SetY(12.7);
$factura->Cell(20.65,0.2,"ENTREGAR ESTE VOLANTE EN LA SECRETARIA ACADEMICA. EL SOLO PAGO DE LA MATRICULA NO SUPONE COMPROMISO ACADEMICO",0,0,'C');
$factura->SetY(13.45);
$factura->SetFont('Arial','B',10);
$factura->Cell(11,0.3,$universidad->nombreuniversidad,0,1,'C');
$factura->SetFont('Arial','',5);
$factura->Cell(11,0.2,$universidad->personeriauniversidad,0,1,'C');
$factura->Cell(11,0.2,$universidad->direccionuniversidad,0,1,'C');
$factura->Cell(11,0.2,$universidad->nituniversidad,0,1,'C');
$factura->Ln(0.1);
$factura->SetFont('Arial','',6);
$factura->Cell(3,0.3,"ID ".$datos->estudiante['idestudiantegeneral'],1,0,'L');
$factura->Cell(2,0.3,"SEM. ".$datos->estudiante['semestreprematricula'],1,0,'L');
$factura->Cell(3,0.3,"PERIODO ".$datos->estudiante['codigoperiodo'],1,0,'L');
$factura->Cell(3,0.3,"IDENT. ".$datos->estudiante['nombrecortodocumento']." ".$datos->estudiante['numerodocumento'],1,1,'L');
$factura->Cell(1.5,0.3,"NOMBRE: ",1,0,'C');
$factura->Cell(9.5,0.3,$datos->estudiante['nombre'],1,1,'C');
$factura->SetFont('Arial','B',6);
$factura->Cell(11,0.3,"DESCRIPCION DEL PAGO",1,1,'C');
$factura->SetY(15.65);
$factura->SetFont('Arial','',6);
$factura->Cell(6,0.3,"PAGO TOTAL: ",1,0,'L');
$factura->Cell(5,0.3,money_format('%(#10n',$datos->fechas[0]['valorapagar']),1,1,'L');
foreach ($datos->fechas as $llave => $valor)
{
	$factura->Cell(6,0.3,$valor['nombreplazo']." ".$valor['fechaordenpago'],1,0,'L');
	$factura->Cell(5,0.3,money_format('%(#10n',$valor['valorapagar']),1,1,'L');
}

//*********************************************************************rectangulo
$factura->SetY(8.75);
$factura->SetLeftMargin(12);
$factura->Rect(12,0.4,8.6,1.4,"");
$factura->SetFont('Arial','B',9);
$factura->Cell(4,0.4,"BANCO DE CREDITO",0,0,'L');
$factura->SetFont('Arial','',7);
$factura->Cell(4,0.4,"CONVENIO No. 8032",0,1,'L');
$factura->SetFont('Arial','B',9);
$factura->Cell(4,0.4,"BANCO DE BOGOTA",0,0,'L');
$factura->SetFont('Arial','',7);
$factura->Cell(4,0.4,"CODIGO No. 2121",0,1,'L');
$factura->SetFont('Arial','B',9);
$factura->Cell(4,0.4,"BANCOLOMBIA",0,0,'L');
$factura->SetFont('Arial','',7);
$factura->Cell(4,0.34,"CONVENIO No. 4261",0,1,'L');
//**CUADRITOS
$factura->Rect(20.1,8.75,0.32,0.32,"");
$factura->Rect(20.1,9.15,0.32,0.32,"");
$factura->Rect(20.1,9.57,0.32,0.32,"");
$factura->SetFont('Arial','B',6);
$factura->SetY(10.05);
$factura->Cell(8.6,0.3,"RECIBO DE PAGO No.      ".$_GET['numeroordenpago'],1,1,'L');
$factura->SetFont('Arial','',6);
$factura->Cell(8.6,0.3,"PROGRAMA: ".$datos->estudiante['codigosucursal']."-".$datos->estudiante['centrocosto']." ".$datos->estudiante['nombrecarrera'],1,1,'L');
//*********************************************************************rectangulo

//*********************************************************************rectangulo
$factura->SetY(13.45);
$factura->SetLeftMargin(12);
$factura->Rect(12,0.4,8.6,1.4,"");
$factura->SetFont('Arial','B',9);
$factura->Cell(4,0.4,"BANCO DE CREDITO",0,0,'L');
$factura->SetFont('Arial','',7);
$factura->Cell(4,0.4,"CONVENIO No. 8032",0,1,'L');
$factura->SetFont('Arial','B',9);
$factura->Cell(4,0.4,"BANCO DE BOGOTA",0,0,'L');
$factura->SetFont('Arial','',7);
$factura->Cell(4,0.4,"CODIGO No. 2121",0,1,'L');
$factura->SetFont('Arial','B',9);
$factura->Cell(4,0.4,"BANCOLOMBIA",0,0,'L');
$factura->SetFont('Arial','',7);
$factura->Cell(4,0.34,"CONVENIO No. 4261",0,1,'L');
//**CUADRITOS
$factura->Rect(20.1,13.45,0.32,0.32,"");
$factura->Rect(20.1,13.87,0.32,0.32,"");
$factura->Rect(20.1,14.3,0.32,0.32,"");
$factura->SetFont('Arial','B',6);
$factura->SetY(14.75);
$factura->Cell(8.6,0.3,"RECIBO DE PAGO No.      ".$_GET['numeroordenpago'],1,1,'L');
$factura->SetFont('Arial','',6);
$factura->Cell(8.6,0.3,"PROGRAMA: ".$datos->estudiante['codigosucursal']."-".$datos->estudiante['centrocosto']." ".$datos->estudiante['nombrecarrera'],1,1,'L');

/**************************/
$factura->SetLeftMargin(1);
$factura->Image('../../../../imagenes/logo.jpg',1.05,18.1,1);
$factura->SetY(18.1);
$factura->SetFont('Arial','B',10);
$factura->Cell(11,0.3,$universidad->nombreuniversidad,0,1,'C');
$factura->SetFont('Arial','',5);
$factura->Cell(11,0.2,$universidad->personeriauniversidad,0,1,'C');
$factura->Cell(11,0.2,$universidad->direccionuniversidad,0,1,'C');
$factura->Cell(11,0.2,$universidad->nituniversidad,0,1,'C');
$factura->Ln(0.1);
$factura->SetFont('Arial','',6);
$factura->Cell(3,0.3,"ID ".$datos->estudiante['idestudiantegeneral'],1,0,'L');
$factura->Cell(2,0.3,"SEM. ".$datos->estudiante['semestreprematricula'],1,0,'L');
$factura->Cell(3,0.3,"PERIODO ".$datos->estudiante['codigoperiodo'],1,0,'L');
$factura->Cell(3,0.3,"IDENT. ".$datos->estudiante['nombrecortodocumento']." ".$datos->estudiante['numerodocumento'],1,1,'L');
$factura->Cell(1.5,0.3,"NOMBRE: ",1,0,'C');
$factura->Cell(9.5,0.3,$datos->estudiante['nombre'],1,1,'C');
$factura->Cell(11,0.3,"PROGRAMA:             ".$datos->estudiante['codigosucursal']."-".$datos->estudiante['centrocosto']." ".$datos->estudiante['nombrecarrera'],1,0,'L');


$factura->SetY(18.12);
$factura->SetLeftMargin(12);
$factura->Rect(12,0.4,8.6,1.4,"");
$factura->SetFont('Arial','B',9);
$factura->Cell(4,0.4,"BANCO DE CREDITO",0,0,'L');
$factura->SetFont('Arial','',7);
$factura->Cell(4,0.4,"CONVENIO No. 8032",0,1,'L');
$factura->SetFont('Arial','B',9);
$factura->Cell(4,0.4,"BANCO DE BOGOTA",0,0,'L');
$factura->SetFont('Arial','',7);
$factura->Cell(4,0.4,"CODIGO No. 2121",0,1,'L');
$factura->SetFont('Arial','B',9);
$factura->Cell(4,0.4,"BANCOLOMBIA",0,0,'L');
$factura->SetFont('Arial','',7);
$factura->Cell(4,0.34,"CONVENIO No. 4261",0,1,'L');
$factura->SetFont('Arial','B',6);
$factura->ln(0.14);
$factura->Cell(8.6,0.3,"RECIBO DE PAGO No.      ".$_GET['numeroordenpago'],1,1,'L');
$factura->SetFont('Arial','B',10);
$factura->Cell(8.6,0.65,"REFERENCIA ".$datos->referencia,1,1,'L');
//**CUADRITOS
$factura->Rect(20.1,18.10,0.32,0.32,"");
$factura->Rect(20.1,18.5,0.32,0.32,"");
$factura->Rect(20.1,18.92,0.32,0.32,"");
//*********************************************************************barras
$factura->SetY(20.05);
$factura->SetLeftMargin(1);
$factura->SetFont('code128','',28);
$factura->SetX(1);
$contador_barras=0;
foreach($codigosbarras as $llave => $valor)
{
	$factura->SetFont('arial','',6);
	$factura->Cell(11,0.3,"                           ".$datos->fechas[$contador_barras]['nombreplazo_2']."                           ".$datos->fechas[$contador_barras]['fechaordenpago']."                           ".money_format('%(#10n',$datos->fechas[$contador_barras]['valorfechaordenpago']),0,1,'L');
	$prueba =  new ean128($valor);
	$ean128=$prueba->codificar();
	$factura->SetFont('code128','',26);
	$factura->Cell(11,1.5,$ean128,1,1,'C');
	$contador_barras++;
}
$factura->SetY(20.65);
foreach($titulosbarras as $llave => $valor)
{
	$factura->SetFont('arial','',6);
	$factura->Cell(11,1.8,$valor,0,1,'C');
}
$factura->sety(17.40);
$factura->SetFont('Arial','',4);
$factura->Cell(20.65,0.2,"PARA SU VALIDEZ DEBE TENER EL TIMBRE DE LA REGISTRADORA Y EL SELLO DE RECIBIDO",0,0,'C');
$factura->sety(25.75);
$factura->Cell(20.65,0.2,"PAGUESE UNICAMENTE EN CHEQUE DE GERENCIA O EFECTIVO - NO SE ACEPTAN PAGOS PARCIALES",0,0,'C');
//$factura->Rect(11,18,19.6,4,"");
$factura->setLeftMargin(12);
$factura->setY(20.35);
$factura->Cell(2,0.3,"COD. BANCO",1,0,'C');
$factura->Cell(3,0.3,"CHEQUE DE GERENCIA NUMERO",1,0,'C');
$factura->Cell(3.6,0.3,"VALOR",1,1,'C');

$factura->Cell(2,1.2,"",1,0,'C');
$factura->Cell(3,1.2,"",1,0,'C');
$factura->Cell(3.6,1.2,"",1,1,'C');

$factura->SetFont('Arial','',8);
$factura->Cell(5,1.2,"EFECTIVO ",1,0,'L');
$factura->Cell(3.6,1.2,"",1,1,'C');

$factura->Cell(5,1.2,"VALOR A PAGAR ",1,1,'L');
$factura->SetTextColor(192,192,192);

$factura->Cell(8.6,1.2,"ESPACIO TIMBRE DE CAJA",1,0,'C');
$factura->setY(15.7);
$factura->Cell(8.6,1.2,"ESPACIO TIMBRE DE CAJA",0,0,'C');
$factura->setY(11);
$factura->Cell(8.6,1.2,"ESPACIO TIMBRE DE CAJA",0,0,'C');
$factura->Image('../../../../imagenes/estudiante_pdf.jpg',0.6,3,0.25,2.03);
$factura->Image('../../../../imagenes/secretariaacademica_pdf.jpg',0.6,9,0.25,3.5);
$factura->Image('../../../../imagenes/bancotesoreria_pdf.jpg',0.6,13.7,0.3,3.2);
$factura->Image('../../../../imagenes/banco_pdf.jpg',0.6,21,0.35,1.2);
?>