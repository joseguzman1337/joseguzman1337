<?php

require_once(realpath(dirname(__FILE__) . "/../../../../sala/includes/adaptador.php"));

$pos = strpos($Configuration->getEntorno(), "local");
if ($Configuration->getEntorno() == "local" || $Configuration->getEntorno() == "pruebas" || $pos !== false) {
    require_once (PATH_ROOT . '/kint/Kint.class.php');
}
$rutaado = (PATH_ROOT . "/serviciosacademicos/funciones/adodb/");
require_once(PATH_ROOT . '/serviciosacademicos/funciones/clases/fpdf/fpdf.php');
require_once(PATH_ROOT . '/serviciosacademicos/Connections/salaado-pear.php');
require_once(PATH_ROOT . "/serviciosacademicos/funciones/ordenpago/factura_pdf_nueva/funciones/obtener_datos.php");
require_once(PATH_ROOT . "/serviciosacademicos/funciones/ordenpago/factura_pdf_nueva/funciones/ean128.php");
require_once(PATH_ROOT . "/serviciosacademicos/funciones/sala_genericas/FuncionesFecha.php");

setlocale(LC_MONETARY, 'en_US');
$fechahoy = date("Y-m-d H:i:s");

ob_start();
$universidad = new ADODB_Active_Record('universidad');
$universidad->Load('iduniversidad = 1');
$datos = new datos_ordenpago($sala, $_GET['codigoestudiante'], $_GET['numeroordenpago']);
$datos->obtener_datos_estudiante();
$datos->obtener_conceptos();
$fechas = $datos->fechas_pago();
$datos->obtener_materias();
$datos->armar_referencia();

$referencia = $datos->referencia;

$codigosbarras = $datos->generar_codigobarras_base_credicorp();
$titulosbarras = $datos->generar_titulobarras_base_credicorp();
$aporte = $datos->fechas_pago_aporte($_GET['numeroordenpago'], $db);
$codigosbarrasaportes = $datos->generar_codigobarras_aportes_credicorp($aporte);
$titulosbarrasaportes = $datos->generar_titulobarras_aportes_credicorp($aporte);

//////////////////////////////////////////////////
$factura = new FPDF("P", "cm", "letter");
$factura->SetAutoPageBreak(1);
$factura->AddFont('code128', '', 'code128.php');
$factura->SetFont('Arial', 'B', 10);
$factura->SetMargins(1, 1, 2);
$factura->AddPage();

/* * **********Imagenes************** */
$factura->Image(PATH_ROOT.'/imagenes/estudiante_pdf.jpg', 0.6, 4, 0.25, 2.03);
$factura->Image(PATH_ROOT.'/imagenes/banco_pdf.jpg', 0.6, 18, 0.35, 1.2);
$factura->Image(PATH_ROOT.'/imagenes/tijeras.png', 0.5, 9.24, 0.4);
$factura->Image(PATH_ROOT.'/imagenes/logo.jpg', 1.05, 1, 1);
$factura->Image(PATH_ROOT.'/imagenes/semilla.jpg', 1, 6, 19, 3.1); // imagen proyecto semillas
$factura->Image(PATH_ROOT.'/imagenes/logo.jpg', 1.05, 9.73, 1); //logo tercer bloque
/* * ***************************************** */
/* * **********rectangulos*********** */
$factura->Rect(1, 0.9, 11, 2, ""); // primer rectacgulo superior izquierda
$factura->Rect(1, 2.9, 11, 3.0, ""); // cuadro donde aparece los conceptos "Matriculas" mod "3.0"
$factura->Rect(1, 6, 19, 3.1, ""); //segundo bloque rectangulo para publicidad proyecto semillas.
$factura->Rect(1, 9.6, 19, 2.2, ""); //tercer bloque rectangulo de Universidad , bancos y datos basicos mod "10.3"
$factura->Rect(1, 9.6, 11, 1.9, ""); //tercer bloque rectangulo de Universidad y datos basicos mod "10.3"
$factura->Rect(1, 14.8, 19, 6.1, ""); //tercer bloque el largo es de 14.8 a 6.1 bloque primer grupo de codigos de barras 
$factura->Rect(1, 20.9, 19, 6.1, ""); //tercer bloque el largo es de 14.8 a 6.1 bloque segundo grupo de codigos de barras 
$factura->Rect(12, 0.9, 8, 5, ""); // Primer cuadro de la izquierda donde estan los bancos y las materias mod "5"
$factura->Rect(1, 14.8, 3, 6.1, ""); // cuadro blanco izquierdo al lado de los cod de barras arriba
$factura->Rect(1, 20.9, 3, 6.1, ""); // cuadro blanco izquierdo al lado de los cod de barras abajo
/* * ***************************************** */

/* * **********rayitas punteadas para separar el desprendible para el estudiante y el banco*********** */
$largo = 0.15;
$espaciado = 0.25;
$x1 = 0;
$x2 = $x1 + $largo;
for ($i = 0; $i <= 85; $i++) { //Tamaño horizontal 
    $factura->Line($x1, 9.4, $x2, 9.4); // posicion Y de la rayita punteada mod "6.3"
    $x1 = $x1 + $espaciado;
    $x2 = $x2 + $espaciado;
}
/* * ************************************************************************************************** */
// SI LA CONSULTA RETORNA RESULTADOS ES PORQUE LA ORDEN ES POR CONCEPTO DE INSCRIPCION.
$query_ins = "select c.codigoconcepto,c.nombreconcepto,dop.valorconcepto from detalleordenpago dop join concepto c on dop.codigoconcepto=c.codigoconcepto where numeroordenpago ='" . $_GET['numeroordenpago'] . "' and cuentaoperacionprincipal='153' and cuentaoperacionparcial='0001'";
$rta_query_ins = $datos->conexion->query($query_ins);
$esordeninscripcion = ($rta_query_ins->RecordCount() > 0) ? true : false;
/* * ************************************************************************************************** */

//CUADRITOS PARA SELECCIONAR EL BANCO DESPRENDIBLE ESTUDIANTE
$factura->Rect(15.5, 1, 0.20, 0.20, "");
$factura->Rect(15.5, 1.3, 0.20, 0.20, "");
$factura->Rect(15.5, 1.61, 0.20, 0.20, "");
$factura->Rect(19.5, 1, 0.20, 0.20, "");
$factura->Rect(19.5, 1.3, 0.20, 0.20, "");

$factura->Rect(1.4, 17.58, 0.40, 0.40, ""); //primer check opcion de pago sin aporte
$factura->Rect(1.4, 23.6, 0.40, 0.40, ""); //segundo check opcion de pago con aporte
//CUADRITOS PARA SELECCIONAR EL BANCO DESPRENDIBLE DEL BANCO
$factura->Rect(15.5, 9.72, 0.20, 0.20, "");
$factura->Rect(15.5, 10.02, 0.20, 0.20, "");
$factura->Rect(15.5, 10.3, 0.20, 0.20, "");
$factura->Rect(19.5, 9.72, 0.20, 0.20, "");
$factura->Rect(19.5, 10.02, 0.20, 0.20, "");

$factura->Cell(11, 0.3, $universidad->nombreuniversidad, 0, 1, 'C');
$factura->SetFont('Arial', '', 5);
$factura->Cell(11, 0.2, utf8_decode($universidad->personeriauniversidad), 0, 1, 'C');
$factura->Cell(11, 0.2, $universidad->direccionuniversidad, 0, 1, 'C');
$factura->Cell(11, 0.2, $universidad->nituniversidad . ' ' . '-' . ' ' . utf8_decode('Vigilada Mineducación'), 0, 1, 'C');

$factura->Ln(0.1);
$factura->SetFont('Arial', '', 6);
$factura->Cell(3, 0.3, "ID " . $datos->estudiante['idestudiantegeneral'], 1, 0, 'L');

if ($datos->codigomodalidadacademica == 800) {
    //si es 1 o 2
    if ($datos->estudiante['semestreprematricula'] < 3) {
        $semestre = "1";
        $PeriodoVirtual = $datos->estudiante['semestreprematricula'];
    }
    //si es 3 o 4
    if ($datos->estudiante['semestreprematricula'] < 5 && $datos->estudiante['semestreprematricula'] > 2) {
        $semestre = "2";
        $PeriodoVirtual = $datos->estudiante['semestreprematricula'];
    }
    //si es 5 o 6
    if ($datos->estudiante['semestreprematricula'] < 7 && $datos->estudiante['semestreprematricula'] > 4) {
        $semestre = "3";
        $PeriodoVirtual = $datos->estudiante['semestreprematricula'];
    }
    //si es 7 o 8
    if ($datos->estudiante['semestreprematricula'] < 8 && $datos->estudiante['semestreprematricula'] > 5) {
        $semestre = "4";
        $PeriodoVirtual = $datos->estudiante['semestreprematricula'];
    }
    //si es 9 o 10
    if ($datos->estudiante['semestreprematricula'] < 11 && $datos->estudiante['semestreprematricula'] > 8) {
        $semestre = "5";
        $PeriodoVirtual = $datos->estudiante['semestreprematricula'];
    }
    //si es 11 o 12
    if ($datos->estudiante['semestreprematricula'] < 13 && $datos->estudiante['semestreprematricula'] > 10) {
        $semestre = "6";
        $PeriodoVirtual = $datos->estudiante['semestreprematricula'];
    }
    //si es 13 o 14
    if ($datos->estudiante['semestreprematricula'] < 15 && $datos->estudiante['semestreprematricula'] > 12) {
        $semestre = "7";
        $PeriodoVirtual = $datos->estudiante['semestreprematricula'];
    }
    //si es 15 o 16
    if ($datos->estudiante['semestreprematricula'] > 14 && $datos->estudiante['semestreprematricula'] < 17) {
        $semestre = "8";
        $PeriodoVirtual = $datos->estudiante['semestreprematricula'];
    }
    //si es 17 o 18
    if ($datos->estudiante['semestreprematricula'] > 16 && $datos->estudiante['semestreprematricula'] < 19) {
        $semestre = "9";
        $PeriodoVirtual = $datos->estudiante['semestreprematricula'];
    }
    //si es 19 o 20
    if ($datos->estudiante['semestreprematricula'] > 18 && $datos->estudiante['semestreprematricula'] < 21) {
        $semestre = "9";
        $PeriodoVirtual = $datos->estudiante['semestreprematricula'];
    }

    $factura->Cell(2, 0.3, "SEM. " . $semestre . " PV." . $PeriodoVirtual, 1, 0, 'L');
} else {
    $factura->Cell(2, 0.3, "SEMESTRE: " . $datos->estudiante['semestreprematricula'], 1, 0, 'L');
}

if (($datos->conceptos[0]["codigoconcepto"] == 159 || $datos->conceptos[0]["codigoconcepto"] == 'C9076' || $datos->conceptos[0]["codigoconcepto"] == 'C9077') && $datos->estudiante['fechaentregaordenpago'] != '0000-00-00') {
    $cadenafecha = fechaatextofecha(formato_fecha_defecto($datos->estudiante['fechaentregaordenpago']));
    $arraycadenafecha = explode("de", $cadenafecha);
    $factura->Cell(3, 0.3, "" . strtoupper($arraycadenafecha[1] . " de ") . $arraycadenafecha[2], 1, 0, 'L');
} else{
    $factura->Cell(3, 0.3, "PERIODO:  " . $datos->estudiante['codigoperiodo'], 1, 0, 'L');
}
$factura->Cell(3, 0.3, "IDENT. " . $datos->estudiante['nombrecortodocumento'] . " " . $datos->estudiante['numerodocumento'], 1, 1, 'L');
$factura->Cell(1.5, 0.3, "NOMBRE: ", 1, 0, 'C');
$factura->Cell(9.5, 0.3, utf8_decode($datos->estudiante['nombre']), 1, 1, 'C');
$factura->SetFont('Arial', 'B', 6);
$factura->Cell(11, 0.3, "DESCRIPCION DEL PAGO", 1, 1, 'C');
$factura->SetY(2.9); //posicion vertical inicial para empezar a colocar los conceptos
$esmatricula = false;

foreach ($datos->conceptos as $llave => $valor) {

    $signoconcepto = $valor['codigotipoconcepto'] == 01 ? "(+)" : ($valor['codigotipoconcepto'] == 02 ? "(-)" : "");
    $nombresignoconcepto = $valor['nombreconcepto']." ".$signoconcepto;

    $factura->Cell(9, 0.3, $nombresignoconcepto, 0, 0, 'L');
    $factura->Cell(2, 0.3, money_format('%(#10n', $valor['valorconcepto']), 0, 1, 'L');
    if ($valor['codigoconcepto'] == '151') {
        $esmatricula = true;
    }
}


//temporal info posgrados
$factura->SetFont('Arial', 'B', 6);
$factura->SetY(3.8);

if ($esmatricula) {
    $query_mensajeOP = " select m.idmensajecarreraordenpago, observacionmensajecarreraordenpago
    from mensajecarreraordenpago m
    where m.codigocarrera = " . $datos->estudiante['codigocarrera'] . "
    and codigoestado like '1%'";
    $rta_mensajeOP = $datos->conexion->query($query_mensajeOP);
    $totalRows_mensajeOP = $rta_mensajeOP->RecordCount();

    if ($totalRows_mensajeOP != 0) {
        $row_mensajeOP = $rta_mensajeOP->fetchRow();
        $factura->ln(0.1);
        $mensaje = ucfirst(strtolower($row_mensajeOP['observacionmensajecarreraordenpago']));
        $mensaje = str_replace('Ñ','ñ',$mensaje);
        
        $factura->MultiCell(11, 0.2, utf8_decode($mensaje));
    }

    if ($datos->estudiante['semestreprematricula'] == 1) {

        if ($datos->codigomodalidadacademica == 200) {
            $factura->SetFont('Arial', 'B', 6);
            $factura->SetY(5.36);
            $factura->MultiCell(11, 0.3, utf8_decode('Nuestro estudiante atenderá periódicamente, algunas actividades propias de su programa académico en las instalaciones ubicadas en el kilómetro 20 de la Autopista Norte.'), 0, 'C');
        }
    }

    $factura->SetY(4.3); // posicion Y del texto declaro...
    $factura->SetFont('Arial', 'B', 6);
    $factura->Cell(11, 0.2, utf8_decode("Declaro que conozco el Reglamento Estudiantil Vigente, acepto las condiciones y contenidos del"), 0, 1, 'C');
    $factura->Cell(11, 0.2, utf8_decode("Programa Académico que elegí y procedo a realizar el pago de mi matrícula para el presente periodo"), 0, 1, 'C');
}

if ($esordeninscripcion) {

    if ($datos->codigomodalidadacademica == 200) {

        $factura->SetFont('Arial', 'B', 6);
        $factura->SetY(6.0);
        $factura->MultiCell(11, 0.3, utf8_decode('Nuestro estudiante atenderá periódicamente, algunas actividades propias de su programa académico en las instalaciones ubicadas en el kilómetro 20 de la Autopista Norte.'), 0, 'C');
    }
}

$factura->SetY(4.7); //POSICION Y del primer cuadro de los plazos mod "4.7"

$factura->SetFont('Arial', 'B', 6);
$factura->Cell(6, 0.3, "FECHAS DE PAGOS: ", 1, 0, 'L');
$factura->Cell(2.5, 0.3, "PAGOS SIN APORTE", 1, 0, 'L'); // ancho de columna sin aporte mod "2.5"
$factura->Cell(2.5, 0.3, "PAGOS CON APORTE", 1, 1, 'L'); // encabezado de columna con aporte

foreach ($datos->fechas as $llave => $valor) {
    $factura->Cell(6, 0.3, $valor['nombreplazo'] . " " . $valor['fechaordenpago'], 1, 0, 'L');
    $factura->Cell(2.5, 0.3, money_format('%(#10n', $valor['valorapagar']), 1, 0, 'L');
    $factura->Cell(2.5, 0.3, money_format('%(#10n', $valor['valorapagar'] + $aporte), 1, 1, 'L'); // crea la nueva columna de valores con aporte 
}

if ($esordeninscripcion) {
    $factura->SetFont('Arial', 'B', 6);
    $factura->Cell(11, 0.3, "EL VALOR CANCELADO POR ESTE CONCEPTO NO ES REEMBOLSABLE", 1, 1, 'C');
}
$factura->SetFont('Arial', '', 4);
$factura->SetY(9.12); // Posicion Y de texto para su Validez
$factura->Cell(18.5, 0.2, "PARA SU VALIDEZ DEBE TENER EL TIMBRE DE LA REGISTRADORA Y EL SELLO DE RECIBIDO", 0, 0, 'C');


/* primer bloque de los nombres de los bancos donde puede realizar el pago */
$factura->SetY(1); //posicion vertical inicial para empezar a colocar el bloque derecho
$factura->SetLeftMargin(12);
$factura->SetFont('Arial', 'B', 7);
$factura->Cell(4, 0.3, utf8_decode("BANCO DE BOGOTÁ"), 'ltRb', 0, 'L');
$factura->SetFont('Arial', '', 7);
$factura->SetFont('Arial', 'B', 7);
$factura->Cell(4, 0.3, "  BANCOLOMBIA", 0, 1, 'L');
$factura->SetFont('Arial', '', 7);
$factura->SetFont('Arial', 'B', 7);
$factura->Cell(4, 0.3, "BANCO DE OCCIDENTE", 'ltRb', 0, 'L');
$factura->SetFont('Arial', '', 7);
$factura->SetFont('Arial', 'B', 7);
$factura->Cell(4, 0.3, "  DAVIVIENDA", 0, 1, 'L');
$factura->SetFont('Arial', '', 7);
$factura->SetFont('Arial', 'B', 7);
$factura->Cell(4, 0.3, "SCOTIABANK COLPATRIA", 'ltRb', 1, 'L');
$factura->SetFont('Arial', '', 7);
$factura->SetFont('Arial', 'B', 7);

$factura->Cell(8, 0.4, "RECIBO DE PAGO No.      " . $_GET['numeroordenpago'], 1, 1, 'L');
$factura->SetFont('Arial', '', 6);
$factura->MultiCell(8, 0.3, "PROGRAMA: " . utf8_decode($datos->estudiante['nombrecarrera']), 1, 1, 'L');


$factura->SetY(3.0); //posicion vertical inicial para empezar a colocar las materias
foreach ($datos->materias as $llave => $valor) {
    $factura->Cell(9.65, 0.3, $valor['codigomateria'] . " " . utf8_decode(strtoupper($valor['nombremateria'])), 0, 1, 'L');
}

if ($esordeninscripcion) {
    $factura->SetFont('Arial', 'B', 6);
    $factura->Cell(11, 0.3, "EL VALOR CANCELADO POR ESTE CONCEPTO NO ES REEMBOLSABLE", 1, 1, 'C');
}

/* * *************************************************Ultimo Bloque************************************* */
$factura->SetLeftMargin(1);

$factura->SetY(9.72); //posición Y texto Universidad el Bosque mod "9.72"

$factura->SetFont('Arial', 'B', 10);
$factura->Cell(11, 0.3, $universidad->nombreuniversidad, 0, 1, 'C');
$factura->SetFont('Arial', '', 5);
$factura->Cell(11, 0.2, utf8_decode($universidad->personeriauniversidad), 0, 1, 'C');
$factura->Cell(11, 0.2, $universidad->direccionuniversidad, 0, 1, 'C');
$factura->Cell(11, 0.2, $universidad->nituniversidad, 0, 1, 'C');
$factura->Cell(11, 0.2, $universidad->nituniversidad . ' ' . '-' . ' ' . utf8_decode('Vigilada Mineducación'), 0, 1, 'C');
$factura->Ln(0.1);
$factura->SetFont('Arial', '', 6);
$factura->Cell(3, 0.3, "ID " . $datos->estudiante['idestudiantegeneral'], 1, 0, 'L');

/*
 * Ivan Dario Quintero Rios
 * Noviembre 3 del 2017
 * Creacion de validaciones para educacion virtual
 */

if ($datos->codigomodalidadacademica == 800) {
    $factura->Cell(2, 0.3, "SEM. " . $semestre . " PV." . $PeriodoVirtual, 1, 0, 'L');
} else {
    $factura->Cell(2, 0.3, "SEMESTRE:  " . $datos->estudiante['semestreprematricula'], 1, 0, 'L');
}
/* END */


if (($datos->conceptos[0]["codigoconcepto"] == 159 || $datos->conceptos[0]["codigoconcepto"] == 'C9076' || $datos->conceptos[0]["codigoconcepto"] == 'C9077') && $datos->estudiante['fechaentregaordenpago'] != '0000-00-00') {
    $cadenafecha = fechaatextofecha(formato_fecha_defecto($datos->estudiante['fechaentregaordenpago']));
    $arraycadenafecha = explode("de", $cadenafecha);
    $factura->Cell(3, 0.3, "" . strtoupper($arraycadenafecha[1] . " de ") . $arraycadenafecha[2], 1, 0, 'L');
} else{
    $factura->Cell(3, 0.3, "PERIODO:  " . $datos->estudiante['codigoperiodo'], 1, 0, 'L');
}
$factura->Cell(3, 0.3, "IDENT. " . $datos->estudiante['nombrecortodocumento'] . " " . $datos->estudiante['numerodocumento'], 1, 1, 'L');
$factura->Cell(1.5, 0.3, "NOMBRE: ", 1, 0, 'C');
$factura->Cell(9.5, 0.3, utf8_decode($datos->estudiante['nombre']), 1, 1, 'C');
$factura->SetFont('Arial', '', 6);
$factura->Cell(19, 0.3, "PROGRAMA: ".utf8_decode($datos->estudiante['nombrecarrera']), 1, 1, 'L');

$factura->SetY(9.72); //posición Y inicio vertical ultimo bloque mod "9.72"
$factura->SetLeftMargin(12);

$factura->SetFont('Arial', 'B', 7);
$factura->Cell(4, 0.3, utf8_decode("BANCO DE BOGOTÁ"), 'ltRb', 0, 'L');
$factura->SetFont('Arial', '', 7);

$factura->SetFont('Arial', 'B', 7);
$factura->Cell(4, 0.3, "  BANCOLOMBIA", 0, 1, 'L');
$factura->SetFont('Arial', '', 7);

$factura->SetFont('Arial', 'B', 7);
$factura->Cell(4, 0.3, "BANCO DE OCCIDENTE", 'ltRb', 0, 'L');
$factura->SetFont('Arial', '', 7);

$factura->SetFont('Arial', 'B', 7);
$factura->Cell(4, 0.3, "  DAVIVIENDA", 0, 1, 'L');
$factura->SetFont('Arial', '', 7);

$factura->SetFont('Arial', 'B', 7);
$factura->Cell(4, 0.3, "SCOTIABANK COLPATRIA", 'ltRb', 1, 'L');
$factura->SetFont('Arial', '', 7);

$factura->Cell(8, 0.35, "RECIBO DE PAGO No.      " . $_GET['numeroordenpago'], 1, 1, 'L');
$factura->SetFont('Arial', 'B', 8);
$factura->SetXY(12, 10.93);
$factura->Cell(8, 0.58, "REFERENCIA " . $referencia, 0, 1, 'L');
$factura->SetFont('Arial', '', 7);
/* * ***************************cuadro forma de pago********************************************* */
$factura->SetXY(1, 11.8); // posicion Y del cuadro forma de pago mod "11.8"
$factura->SetLeftMargin(1);
$factura->Cell(14, 0.5, "FORMA DE PAGO", 1, 0, 'C');
$factura->Cell(1, 0.5, "FECHA", 1, 0, 'C');
$factura->SetTextColor(192, 192, 192);
$factura->Cell(4, 0.5, "A                  M                  D", 1, 1, 'C');
$factura->SetTextColor(0, 0, 0);
$factura->SetFont('Arial', 'B', 7);
$factura->Cell(5, 1.5, "CHEQUES DE GERENCIA UNICAMENTE", 1, 1, 'C');
$factura->sety(13.8);
$factura->Cell(8,0.5,"PAGO CON CHEQUE DE GERENCIA",'LTRb',1,'C');
$factura->Cell(8,0.5,"SE DEBE ENDOSAR A NOMBRE DE CREDICORP",'LtRB',1,'C');

$factura->SetXY(6, 12.3); // posicion Y del cuadro COD.BANCO mod "12.3"
$factura->SetLeftMargin(6);
$factura->Cell(3, 0.5, "COD. BANCO", 1, 1, 'C');
$factura->Cell(3, 0.5, "", 1, 1, 'C');
$factura->Cell(3, 0.5, "", 1, 1, 'C');


$factura->SetXY(9, 12.3);  // posicion Y del cuadro NUMERO DE CUENTA mod "12.3"
$factura->SetLeftMargin(9);
$factura->Cell(6, 0.5, "NO. CUENTA", 1, 1, 'C');
$factura->Cell(6, 0.5, "", 1, 1, 'C');
$factura->Cell(6, 0.5, "", 1, 1, 'C');
$factura->Cell(6, 0.5, "EFECTIVO", 1, 1, 'R');
$factura->Cell(6, 0.5, "TOTAL PAGADO", 1, 1, 'R');

$factura->SetXY(15, 12.3); // posicion Y del cuadro VALOR mod "12.3"
$factura->SetLeftMargin(15);
$factura->Cell(5, 0.5, "VALOR", 1, 1, 'C');
$factura->Cell(5, 0.5, "", 1, 1, 'C');
$factura->Cell(5, 0.5, "", 1, 1, 'C');
$factura->Cell(5, 0.5, "", 1, 1, 'C');
$factura->Cell(5, 0.5, "", 1, 1, 'C');


//bloque primer bloque codigos de barras con aporte.
$factura->SetY(14.6); //posición Y inicial codigos de barras
$factura->SetLeftMargin(3.8); // posicion X de los codigos de barras mod "7.4"
$factura->SetFont('code128', '', 28);
$contador_barras = 0;

foreach ($codigosbarrasaportes as $llave => $valor) {
    $factura->SetX(4.2); // posicion X de la fecha de los plazos
    $factura->SetFont('arial', '', 8);
    $factura->Cell(17, 1.0, "               " . $datos->fechas[$contador_barras]['nombreplazo_3'] . "                           " .
        $datos->fechas[$contador_barras]['fechaordenpago'] . "                           " .
        money_format('%(#10n', $datos->fechas[$contador_barras]['valorfechaordenpago'] + $aporte), 0, 1, 'L'); //EN ESTA LINEA SE SUMA EL VALOR DEL APORTE A LA MATRICULA
    $prueba = new ean128($valor);
    $ean128 = $prueba->codificar();
    $factura->SetFont('code128', '', 37);// tamaño del codigo de barras
    $factura->Cell(17, 0.7, $ean128, 0, 1, 'L');
    $factura->SetFont('arial', '', 8);
    $factura->Cell(19, 0.4, "            " . $titulosbarrasaportes[$contador_barras], 0, 1, 'L');
    $contador_barras++;
}

//bloque de codigo de barras sin aporte
$factura->SetY(20.69); //posición Y inicial codigos de barras del bloque con aporte.
$factura->SetLeftMargin(3.8); // posicion X de los codigos de barras mod "7.4"
$factura->SetFont('code128', '', 28);
$contador_barras = 0;

foreach ($codigosbarras as $llave => $valor) {
    $factura->SetX(4.2); // posicion X
    $factura->SetFont('arial', '', 8);
    $factura->Cell(19, 1.0, "               " . $datos->fechas[$contador_barras]['nombreplazo_2'] . "                           " .
        $datos->fechas[$contador_barras]['fechaordenpago'] . "                           " .
        money_format('%(#10n', $datos->fechas[$contador_barras]['valorfechaordenpago']), 0, 1, 'L');
    $prueba = new ean128($valor);
    $ean128 = $prueba->codificar();
    $factura->SetFont('code128', '', 37);// tamaño del codigo de barras
    $factura->Cell(19, 0.7, $ean128, 0, 1, 'L');
    $factura->SetFont('arial', '', 8);
    $factura->Cell(19, 0.4, "            " . $titulosbarras[$contador_barras], 0, 1, 'L');
    $contador_barras++;
}
$factura->sety(17.40);
$factura->SetFont('Arial', 'B', 8);
$factura->sety(27.1); // posicion Y del texto Paguese...
$factura->SetX(1);
$factura->Cell(19, 0.2, utf8_decode("EL RECAUDO SE RECIBE A TRAVÉS DE CUENTAS DE LA UNIVERSIDAD ADMINISTRADAS POR CREDICORP CAPITAL COLOMBIA S.A."), 0, 0, 'C');

$factura->sety(17.40);
$factura->SetFont('Arial', '', 6);
$factura->sety(16.1);
$factura->SetX(1.1);
$factura->Cell(21.65, 0.2, "MARQUE ESTA CASILLA", 0, 0, 'L');
$factura->sety(16.5);
$factura->SetX(1.1);
$factura->Cell(20.65, 0.2, "SI DESEA REALIZAR SU", 0, 0, 'L');
$factura->sety(16.9);
$factura->SetX(1.1);
$factura->Cell(20.65, 0.2, "PAGO CON APORTE AL", 0, 0, 'L');
$factura->sety(17.3);
$factura->SetX(1.1);
$factura->Cell(20.65, 0.2, "PROGRAMA SEMILLAS.", 0, 0, 'L');

$factura->sety(22.3);
$factura->SetX(1.1);
$factura->Cell(21.65, 0.2, "MARQUE ESTA CASILLA", 0, 0, 'L');
$factura->sety(22.7);
$factura->SetX(1.1);
$factura->Cell(21.65, 0.2, "SI DESEA REALIZAR SU", 0, 0, 'L');
$factura->sety(23.1);
$factura->SetX(1.1);
$factura->Cell(21.65, 0.2, "PAGO SIN APORTE.", 0, 0, 'L');

$factura->SetFont('Arial', '', 8);
$factura->SetTextColor(192, 192, 192);
$factura->Output();
ob_end_flush();
?>
