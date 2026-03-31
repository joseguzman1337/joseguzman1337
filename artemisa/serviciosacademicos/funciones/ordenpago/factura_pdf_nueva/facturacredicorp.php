<?php

require_once(realpath(dirname(__FILE__) . "/../../../../sala/includes/adaptador.php"));
require_once('../../clases/fpdf/fpdf.php');
require_once("funciones/obtener_datos.php");
require_once("funciones/universidad.php");
require_once("funciones/ean128.php");
require_once("../../../funciones/sala_genericas/FuncionesFecha.php");

setlocale(LC_MONETARY, 'en_US');
$fechahoy=date("Y-m-d H:i:s");

ob_start();
$univeridades = new universidad();
$universidad = $univeridades->consultarUniversidad();

$datos=new datos_ordenpago($db,$_GET['codigoestudiante'],$_GET['numeroordenpago']);
$datos->obtener_datos_estudiante();
$datos->obtener_conceptos();
$fechas=$datos->fechas_pago();

//listar($fechas);
$datos->obtener_materias();
$datos->armar_referencia();
$codigosbarras=$datos->generar_codigobarras_base_credicorp();
$titulosbarras=$datos->generar_titulobarras_base_credicorp();
//////////////////////////////////////////////////
$factura=new FPDF("P","cm","letter");
$factura->SetAutoPageBreak(1);
$factura->AddFont('code128','','code128.php');
$factura->SetFont('Arial','B',10);
$factura->SetMargins(1,1,2);
$factura->AddPage();

/************Imagenes***************/
$factura->Image('../../../../imagenes/estudiante_pdf.jpg',0.6,3,0.25,2.03);
$factura->Image('../../../../imagenes/secretariaacademica_pdf.jpg',0.6,9,0.25,3.5);
$factura->Image('../../../../imagenes/banco_pdf.jpg',0.6,20.5,0.35,1.2);
$factura->Image('../../../../imagenes/tijeras.png',0.5,8.15,0.4);
$factura->Image('../../../../imagenes/tijeras.png',0.5,12.82,0.4);
$factura->Image('../../../../imagenes/logo.jpg',1.05,1,1);
$factura->Image('../../../../imagenes/logo.jpg',1.05,8.75,1);
$factura->Image('../../../../imagenes/logo.jpg',1.05,13.43,1);//logo tercer bloque
/********************************************/
/************rectangulos************/
$factura->Rect(1,0.9,11,2,"");
$factura->Rect(1,2.9,11,5.1,"");
$factura->Rect(1,8.65,19,4,"");
$factura->Rect(1,8.65,11,4,"");
$factura->Rect(1,13.3,19,2.5,"");//tercer bloque
$factura->Rect(1,13.3,11,1.91,"");//tercer bloque
$factura->Rect(1,19,19,7.8,"");//tercer bloque
$factura->Rect(12,0.9,8,7.1,"");
//$factura->Rect(15.8,19,4.2,7,"");
/********************************************/

/************rayitas cortadas************/
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

/*****************************************************************************************************/
// SI LA CONSULTA RETORNA RESULTADOS ES PORQUE LA ORDEN ES POR CONCEPTO DE INSCRIPCION.
$query_ins="select c.codigoconcepto,c.nombreconcepto,dop.valorconcepto ".
" from detalleordenpago dop join concepto c on dop.codigoconcepto=c.codigoconcepto ".
" where numeroordenpago ='".$_GET['numeroordenpago']."' and cuentaoperacionprincipal='153' and cuentaoperacionparcial='0001'";
$rta_query_ins=$datos->conexion->query($query_ins);
$esordeninscripcion=($rta_query_ins->RecordCount()>0)?true:false;
/*****************************************************************************************************/

/********************************************/
//**CUADRITOS**//
$factura->Rect(15.5,1,0.20,0.20,"");
$factura->Rect(15.5,1.3,0.20,0.20,"");
$factura->Rect(15.5,1.61,0.20,0.20,"");
$factura->Rect(19.5,1.0,0.20,0.20,"");
$factura->Rect(19.5,1.3,0.20,0.20,"");

$factura->Rect(15.5,8.77,0.20,0.20,"");
$factura->Rect(15.5,9.07,0.20,0.20,"");
$factura->Rect(15.5,9.38,0.20,0.20,"");
$factura->Rect(19.5,8.77,0.20,0.20,"");
$factura->Rect(19.5,9.07,0.20,0.20,"");

$factura->Rect(15.5,13.42,0.20,0.20,"");
$factura->Rect(15.5,13.72,0.20,0.20,"");
$factura->Rect(15.5,14,0.20,0.20,"");
$factura->Rect(19.5,13.42,0.20,0.20,"");
$factura->Rect(19.5,13.72,0.20,0.20,"");
/********************************************/
$factura->Cell(11,0.3,$universidad['nombreuniversidad'],0,1,'C');
$factura->SetFont('Arial','',5);
$factura->Cell(11,0.2,utf8_decode($universidad['personeriauniversidad']),0,1,'C');
$factura->Cell(11,0.2,$universidad['direccionuniversidad'],0,1,'C');
$factura->Cell(11,0.2,$universidad['nituniversidad'].' '.'-'.' '.utf8_decode('Vigilada Mineducación'),0,1,'C');

$factura->Ln(0.1);
$factura->SetFont('Arial','',6);
$factura->Cell(3,0.3,"ID ".$datos->estudiante['idestudiantegeneral'],1,0,'L');

/*
* Ivan Dario Quintero Rios
* Noviembre 3 del 2017
* Creacion de validaciones para educacion virtual
*/

//semestre del estudiante
$factura->Cell(2,0.3,$datos->obtenerSemestre(),1,0,'L');

if(($datos->conceptos[0]["codigoconcepto"]==159||$datos->conceptos[0]["codigoconcepto"]=='C9076'
        ||$datos->conceptos[0]["codigoconcepto"]=='C9077') && $datos->estudiante['fechaentregaordenpago']!='0000-00-00')
{
    $cadenafecha=fechaatextofecha(formato_fecha_defecto($datos->estudiante['fechaentregaordenpago']));
    $arraycadenafecha=explode("de",$cadenafecha);
    $factura->Cell(3,0.3,"".strtoupper($arraycadenafecha[1]." de ").$arraycadenafecha[2],1,0,'L');
}
else

$factura->Cell(3,0.3,$datos->obtenerPeriodo(),1,0,'L');
$factura->Cell(3,0.3,"IDENT. ".$datos->estudiante['nombrecortodocumento']." ".$datos->estudiante['numerodocumento'],1,1,'L');
$factura->Cell(1.5,0.3,"NOMBRE: ",1,0,'C');
$factura->Cell(9.5,0.3,utf8_decode($datos->estudiante['nombre']),1,1,'C');
$factura->SetFont('Arial','B',6);
$factura->Cell(11,0.3,"DESCRIPCION DEL PAGO",1,1,'C');
$factura->SetY(2.9);//posicion vertical inicial para empezar a colocar los conceptos
$esmatricula = false;

foreach ($datos->conceptos as $llave => $valor){
        
    $signoconcepto = $valor['codigotipoconcepto'] == 01 ? "(+)" : ($valor['codigotipoconcepto'] == 02 ? "(-)" : ""); 
    $nombresignoconcepto = $valor['nombreconcepto']." ".$signoconcepto; 

    $factura->Cell(9,0.3,$nombresignoconcepto,0,0,'L');    
    $factura->Cell(2,0.3,money_format('%(#10n',$valor['valorconcepto']),0,1,'L');
	if($valor['codigoconcepto'] == '151') {
            $esmatricula = true;
	}
}


//temporal info posgrados
$factura->SetFont('Arial','B',6);
$factura->SetY(5.0);

if($esmatricula) {
    $query_mensajeOP= " select m.idmensajecarreraordenpago, observacionmensajecarreraordenpago ".
    " from mensajecarreraordenpago m ".
    " where m.codigocarrera = ".$datos->estudiante['codigocarrera']." and codigoestado like '1%'";
    $rta_mensajeOP=$datos->conexion->query($query_mensajeOP);
    $totalRows_mensajeOP = $rta_mensajeOP->RecordCount();
            
    //if($datos->codigomodalidadacademica==300){
    if($totalRows_mensajeOP != 0){
            $row_mensajeOP=$rta_mensajeOP->fetchRow();
            $factura->ln(0.3);
            //$factura->MultiCell(11,0.3,'SEÑOR RESIDENTE LE RECORDAMOS QUE PARA LEGALIZAR  LA MATRICULA
        //  ES OBLIGATORIO REALIZAR  LA  AFILIACION A LA EPS Y ARP EN  LA  DIVISION DE POSTGRADOS.');
            $mensaje = ucfirst(strtolower($row_mensajeOP['observacionmensajecarreraordenpago']));
            $mensaje = str_replace('Ñ','ñ',$mensaje);
            
            $factura->MultiCell(11,0.3,utf8_decode($mensaje));
    }

    if($datos->estudiante['semestreprematricula']==1)
    {
	   if($datos->codigomodalidadacademica==200)
       {
	       $factura->SetFont('Arial','B',6);
	       $factura->SetY(5.5);	  
	       $factura->MultiCell(11,0.3,utf8_decode('Nuestro estudiante atenderá periódicamente, algunas 
	       actividades propias de su programa académico en las instalaciones ubicadas en el
	        kilómetro 20 de la Autopista Norte.'),0,'C');
	   }
    }	

    $factura->SetY(6.3);
    $factura->SetFont('Arial','B',6);
    $factura->Cell(11,0.2,utf8_decode("Declaro que conozco el Reglamento Estudiantil Vigente, acepto las condiciones y contenidos del"),0,1,'C');
    $factura->Cell(11,0.2,utf8_decode("Programa Académico que elegí y procedo a realizar el pago de mi matrícula para el presente periodo"),0,1,'C');
}

if($esordeninscripcion) {

    if($datos->codigomodalidadacademica==200){

    $factura->SetFont('Arial','B',6);
    $factura->SetY(6.0);
    $factura->MultiCell(11,0.3,utf8_decode('Nuestro estudiante atenderá periódicamente, algunas actividades 
    propias de su programa académico en las instalaciones ubicadas en el kilómetro 20 de la Autopista Norte.'),0,'C');

    }

}

$factura->SetY(6.8);

$factura->SetFont('Arial','B',6);
$factura->Cell(6,0.3,"PAGO TOTAL: ",1,0,'L');
$factura->Cell(5,0.3,money_format('%(#10n',$datos->fechas[0]['valorapagar']),1,1,'L');

foreach ($datos->fechas as $llave => $valor)
{
	$factura->Cell(6,0.3,$valor['nombreplazo']." ".$valor['fechaordenpago'],1,0,'L');
	$factura->Cell(5,0.3,money_format('%(#10n',$valor['valorapagar']),1,1,'L');
}
if($esordeninscripcion) {
	$factura->SetFont('Arial','B',6);
	$factura->Cell(11,0.3,"EL VALOR CANCELADO POR ESTE CONCEPTO NO ES REEMBOLSABLE",1,1,'C');
}
$factura->SetFont('Arial','',4);
$factura->SetY(8.05);
$factura->Cell(20.65,0.2,"PARA SU VALIDEZ DEBE TENER EL TIMBRE DE LA REGISTRADORA Y EL SELLO DE RECIBIDO",0,0,'C');

/*primer bloque*/
$factura->SetY(1);//posicion vertical inicial para empezar a colocar el bloque derecho
$factura->SetLeftMargin(12);
$factura->SetFont('Arial','',7);
$factura->SetFont('Arial','B',7);
$factura->Cell(4,0.3,utf8_decode("BANCO DE BOGOTÁ"),'ltRb',0,'L');
$factura->SetFont('Arial','',7);
$factura->SetFont('Arial','B',7);
$factura->Cell(4,0.3,"  BANCOLOMBIA",0,1,'L');
$factura->SetFont('Arial','',7);
$factura->SetFont('Arial','B',7);
$factura->Cell(4,0.3,"BANCO DE OCCIDENTE",'ltRb',0,'L');
$factura->SetFont('Arial','',7);
$factura->SetFont('Arial','B',7);
$factura->Cell(4,0.3,"  DAVIVIENDA",0,1,'L');
$factura->SetFont('Arial','',7);
$factura->SetFont('Arial','B',7);
$factura->Cell(4,0.3,"SCOTIABANK COLPATRIA",'ltRb',1,'L');
$factura->SetFont('Arial','',7);
$factura->SetFont('Arial','B',7);

$factura->Cell(8,0.4,"RECIBO DE PAGO No.      ".$_GET['numeroordenpago'],1,1,'L');
$factura->SetFont('Arial','',6);
$factura->MultiCell(8,0.3,"PROGRAMA: ".utf8_decode($datos->estudiante['nombrecarrera']),1,1,'L');


$factura->SetY(3.0);//posicion vertical inicial para empezar a colocar las materias
foreach($datos->materias as $llave => $valor)
{
	$factura->Cell(9.65, 0.3,$valor['codigomateria']. " " .utf8_decode(strtoupper($valor['nombremateria'])), 0, 1, 'L');

}
//***********final primer bloque /*************************


//segunda casila

$factura->setxy(1,8.75);
$factura->SetLeftMargin(1);
//2 encabezado
$factura->SetFont('Arial','B',10);
$factura->Cell(11,0.3,$universidad['nombreuniversidad'],0,1,'C');
$factura->SetFont('Arial','',5);
$factura->Cell(11,0.2,utf8_decode($universidad['personeriauniversidad']),0,1,'C');
$factura->Cell(11,0.2,$universidad['direccionuniversidad'],0,1,'C');
$factura->Cell(11,0.2,$universidad['nituniversidad'].' '.'-'.' '.utf8_decode('Vigilada Mineducación'),0,1,'C');

$factura->Ln(0.1);
$factura->SetFont('Arial','',6);
$factura->Cell(3,0.3,"ID ".$datos->estudiante['idestudiantegeneral'],1,0,'L');

//semestre del estudiante
$factura->Cell(2,0.3,$datos->obtenerSemestre(),1,0,'L');

if(($datos->conceptos[0]["codigoconcepto"]==159||$datos->conceptos[0]["codigoconcepto"]=='C9076'
        ||$datos->conceptos[0]["codigoconcepto"]=='C9077') && $datos->estudiante['fechaentregaordenpago']!='0000-00-00')
{
    $cadenafecha=fechaatextofecha(formato_fecha_defecto($datos->estudiante['fechaentregaordenpago']));
    $arraycadenafecha=explode("de",$cadenafecha);
    $factura->Cell(3,0.3,"".strtoupper($arraycadenafecha[1]." de ").$arraycadenafecha[2],1,0,'L');
}
else
$factura->Cell(3,0.3,$datos->obtenerPeriodo(),1,0,'L');
$factura->Cell(3,0.3,"IDENT. ".$datos->estudiante['nombrecortodocumento']." ".$datos->estudiante['numerodocumento'],1,1,'L');
$factura->Cell(1.5,0.3,"NOMBRE: ",1,0,'C');
$factura->Cell(9.5,0.3,utf8_decode($datos->estudiante['nombre']),1,1,'C');
$factura->SetFont('Arial','B',6);
$factura->Cell(11,0.3,"DESCRIPCION DEL PAGO",1,1,'C');
$factura->SetY(10.95);
$factura->SetFont('Arial','B',6);
$factura->Cell(6,0.3,"PAGO TOTAL: ",1,0,'L');
$factura->Cell(5,0.3,money_format('%(#10n',$datos->fechas[0]['valorapagar']),1,1,'L');
foreach ($datos->fechas as $llave => $valor)
{
	$factura->Cell(6,0.3,$valor['nombreplazo']." ".$valor['fechaordenpago'],1,0,'L');
	$factura->Cell(5,0.3,money_format('%(#10n',$valor['valorapagar']),1,1,'L');
}

if($esmatricula) {
	$factura->SetY(12.2);
	$factura->SetFont('Arial','B',6);
	$factura->Cell(11,0.2,utf8_decode("Declaro que conozco el Reglamento Estudiantil Vigente, acepto las condiciones y contenidos del"),0,1,'C');
	$factura->Cell(11,0.2,utf8_decode("Programa Académico que elegí y procedo a realizar el pago de mi matrícula para el presente periodo"),0,1,'C');
}

if($esordeninscripcion) {
	$factura->SetFont('Arial','B',6);
	$factura->Cell(11,0.3,"EL VALOR CANCELADO POR ESTE CONCEPTO NO ES REEMBOLSABLE",1,1,'C');
}
$factura->SetFont('Arial','',4);
$factura->SetY(12.7);
$factura->Cell(20.65,0.2,"ENTREGAR ESTE VOLANTE EN LA SECRETARIA ACADEMICA. EL SOLO PAGO DE LA MATRICULA NO SUPONE COMPROMISO ACADEMICO",0,0,'C');
$factura->SetY(13.45);

$factura->SetY(8.75);
$factura->SetLeftMargin(12);

$factura->SetFont('Arial','B',7);
$factura->Cell(4,0.3,utf8_decode("BANCO DE BOGOTÁ"),'ltRb',0,'L');
$factura->SetFont('Arial','',7);

$factura->SetFont('Arial','B',7);
$factura->Cell(4,0.3,"  BANCOLOMBIA",0,1,'L');
$factura->SetFont('Arial','',7);

$factura->SetFont('Arial','B',7);
$factura->Cell(4,0.3,"BANCO DE OCCIDENTE",'ltRb',0,'L');
$factura->SetFont('Arial','',7);

$factura->SetFont('Arial','B',7);
$factura->Cell(4,0.3,"  DAVIVIENDA",0,1,'L');
$factura->SetFont('Arial','',7);

$factura->SetFont('Arial','B',7);
$factura->Cell(4,0.3,"SCOTIABANK COLPATRIA",'ltRb',1,'L');
$factura->SetFont('Arial','',7);

$factura->Cell(8,0.4,"RECIBO DE PAGO No.      ".$_GET['numeroordenpago'],1,1,'L');
$factura->SetFont('Arial','',6);
$factura->MultiCell(8,0.3,"PROGRAMA: ".(utf8_decode($datos->estudiante['nombrecarrera'])),1,1,'L');

/***************************************************Ultimo Bloque**************************************/
$factura->SetLeftMargin(1);

$factura->SetY(13.42);//pos inicio vertical ultimo bloque

$factura->SetFont('Arial','B',10);
$factura->Cell(11,0.3,$universidad['nombreuniversidad'],0,1,'C');
$factura->SetFont('Arial','',5);
$factura->Cell(11,0.2,utf8_decode($universidad['personeriauniversidad']),0,1,'C');
$factura->Cell(11,0.2,$universidad['direccionuniversidad'],0,1,'C');
$factura->Cell(11,0.2,$universidad['nituniversidad'],0,1,'C');
$factura->Cell(11,0.2,$universidad['nituniversidad'].' '.'-'.' '.utf8_decode('Vigilada Mineducación'),0,1,'C');
$factura->Ln(0.1);
$factura->SetFont('Arial','',6);
$factura->Cell(3,0.3,"ID ".$datos->estudiante['idestudiantegeneral'],1,0,'L');

/*
* Ivan Dario Quintero Rios
* Noviembre 3 del 2017
* Creacion de validaciones para educacion virtual
*/

//semestre del estudiante
$factura->Cell(2,0.3,$datos->obtenerSemestre(),1,0,'L');



if(($datos->conceptos[0]["codigoconcepto"]==159||$datos->conceptos[0]["codigoconcepto"]=='C9076'
        ||$datos->conceptos[0]["codigoconcepto"]=='C9077') && $datos->estudiante['fechaentregaordenpago']!='0000-00-00')
{
    $cadenafecha=fechaatextofecha(formato_fecha_defecto($datos->estudiante['fechaentregaordenpago']));
    $arraycadenafecha=explode("de",$cadenafecha);
    $factura->Cell(3,0.3,"".strtoupper($arraycadenafecha[1]." de ").$arraycadenafecha[2],1,0,'L');
}
else
$factura->Cell(3,0.3,$datos->obtenerPeriodo(),1,0,'L');
$factura->Cell(3,0.3,"IDENT. ".$datos->estudiante['nombrecortodocumento']." ".$datos->estudiante['numerodocumento'],1,1,'L');
$factura->Cell(1.5,0.3,"NOMBRE: ",1,0,'C');
$factura->Cell(9.5,0.3,utf8_decode($datos->estudiante['nombre']),1,1,'C');
$factura->MultiCell(19,0.3,"PROGRAMA: ".utf8_decode($datos->estudiante['nombrecarrera']),1,1,'L');

$factura->SetY(13.42);//pos inicio vertical ultimo bloque
$factura->SetLeftMargin(12);

$factura->SetFont('Arial','B',7);
$factura->Cell(4,0.3,utf8_decode("BANCO DE BOGOTÁ"),'ltRb',0,'L');
$factura->SetFont('Arial','',7);

$factura->SetFont('Arial','B',7);
$factura->Cell(4,0.3,"BANCOLOMBIA",0,1,'L');
$factura->SetFont('Arial','',7);

$factura->SetFont('Arial','B',7);
$factura->Cell(4,0.3,"BANCO DE OCCIDENTE",'ltRb',0,'L');
$factura->SetFont('Arial','',7);

$factura->SetFont('Arial','B',7);
$factura->Cell(4,0.3,"DAVIVIENDA",0,1,'L');
$factura->SetFont('Arial','',7);

$factura->SetFont('Arial','B',7);
$factura->Cell(4,0.3,"SCOTIABANK COLPATRIA",'ltRb',1,'L');
$factura->SetFont('Arial','',7);

$factura->Cell(8,0.3,"RECIBO DE PAGO No.      ".$_GET['numeroordenpago'],1,1,'L');
$factura->SetFont('Arial','B',10);
$factura->Cell(8,0.65,"REFERENCIA ".$datos->referencia,0,1,'L');
$factura->SetFont('Arial','',7);
/*****************************cuadro forma de pago**********************************************/
$factura->SetXY(1,16);
$factura->SetLeftMargin(1);
$factura->Cell(14,0.5,"FORMA DE PAGO",1,0,'C');
$factura->Cell(1,0.5,"FECHA",1,0,'C');
$factura->SetTextColor(192,192,192);
$factura->Cell(4,0.5,"A                  M                  D",1,1,'C');
$factura->SetTextColor(0,0,0);
$factura->SetFont('Arial','B',7);
$factura->Cell(5,1.5,"CHEQUES DE GERENCIA UNICAMENTE",1,1,'C');
$factura->sety(18);
$factura->Cell(8,0.5,"PAGO CON CHEQUE DE GERENCIA",'LTRb',1,'C');
$factura->Cell(8,0.5,"SE DEBE ENDOSAR A NOMBRE DE CREDICORP",'LtRB',1,'C');

$factura->SetXY(6,16.5);
$factura->SetFont('Arial','B',7);
$factura->SetLeftMargin(6);
$factura->Cell(3,0.5,"COD. BANCO",1,1,'C');
$factura->Cell(3,0.5,"",1,1,'C');
$factura->Cell(3,0.5,"",1,1,'C');

$factura->SetXY(9,16.5);
$factura->SetLeftMargin(9);
$factura->Cell(6,0.5,"NO. CUENTA",1,1,'C');
$factura->Cell(6,0.5,"",1,1,'C');
$factura->Cell(6,0.5,"",1,1,'C');
$factura->Cell(6,0.5,"EFECTIVO",1,1,'R');
$factura->Cell(6,0.5,"TOTAL PAGADO",1,1,'R');

$factura->SetXY(15,16.5);
$factura->SetLeftMargin(15);
$factura->Cell(5,0.5,"VALOR",1,1,'C');
$factura->Cell(5,0.5,"",1,1,'C');
$factura->Cell(5,0.5,"",1,1,'C');
$factura->Cell(5,0.5,"",1,1,'C');
$factura->Cell(5,0.5,"",1,1,'C');

//********************************************************************* barras
$factura->SetY(18.9);//posición vertical inicial codigos de barra
$factura->SetLeftMargin(1);
$factura->SetFont('code128','',28);
$factura->SetX(2);
$contador_barras=0;
foreach($codigosbarras as $llave => $valor)
{
    //detalle superior del codigo de barras
	$factura->SetFont('arial','',8);
	$factura->Cell(19,1.0,"               ".$datos->fechas[$contador_barras]['nombreplazo_2']."                           ".$datos->fechas[$contador_barras]['fechaordenpago']."                           ".money_format('%(#10n',$datos->fechas[$contador_barras]['valorfechaordenpago']),0,1,'L');
	//imagen de codigo
	$prueba =  new ean128($valor);
	$ean128=$prueba->codificar();
	$factura->SetFont('code128','',37);// tamaño del codigo de barras
	$factura->Cell(19,1,$ean128,0,1,'L');

	//numero de codigo de barras
	$factura->SetFont('arial','',8);
	$factura->Cell(19,0.4,"            ".$titulosbarras[$contador_barras],0,1,'L');
	$contador_barras++;
}
$factura->sety(17.40);
$factura->SetFont('Arial','B',9);
$factura->sety(26.2);
$factura->Cell(19,0.2,utf8_decode("EL RECAUDO SE RECIBE A TRAVÉS DE CUENTAS DE LA UNIVERSIDAD"),0,0,'C');
$factura->sety(26.5);
$factura->Cell(19,0.2,"ADMINISTRADAS POR CREDICORP CAPITAL COLOMBIA S.A.",0,0,'C');
$factura->Output();
ob_end_flush();
?>
