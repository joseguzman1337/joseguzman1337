<?php
if (isset($_REQUEST["v2Certificado"])){
    include ("certificadoDiploma.php");
}else{
    require('../../funciones/clases/fpdf/fpdf.php');
    require_once('../../Connections/sala2.php');
    $rutaado = "../../funciones/adodb/";
    require_once('../../Connections/salaado.php');

    setlocale(LC_CTYPE, 'es');
    if ($_REQUEST['iddiploma'] != "37") {
        if ($_REQUEST['iddiploma'] != "15") {
            if ($_REQUEST['iddiploma'] != "98" && $_REQUEST['iddiploma'] != "39" && $_REQUEST['iddiploma'] != "63" ||$_REQUEST['iddiploma'] == "180") {

                if ($_REQUEST['iddiploma'] == "159" || $_REQUEST['iddiploma'] == "166") {

                    $query_datos = "SELECT doc.nombrecortodocumento as tipo, a.documentoasistente as documento, concat(a.nombreasistente,' ', a.apellidoasistente) as nombre, d.encabezadodiploma, d.fechadiploma, d.atributodiploma, d.intensidaddiploma, f.enlacefirmasdiploma, f.nombrefirmadiploma, f.cargofirmadiploma, f.dependenciafirmadiploma, f.atributosfirmadiploma, d.enlaceencabezadodiploma,d.otorgadiploma,f.idfirmadiploma
                                    FROM asistente a, asistentediploma ad, diploma d, documento doc, firmadiploma f
                                    where ad.iddiploma = d.iddiploma
                                    and a.idasistente = ad.idasistente
                                    and a.tipodocumento = doc.tipodocumento
                                    and f.iddiploma = d.iddiploma
                                    and d.iddiploma = '" . $_REQUEST['iddiploma'] . "'
                                    and a.documentoasistente = '" . $_REQUEST['documento'] . "'
                                    and d.codigoestado like '1%'
                                    and ad.codigoestado like '1%'
                                    and f.codigoestado like '1%'
                                    order by f.pesofirmadiploma";

                }else {
                    $query_datos = "SELECT doc.nombrecortodocumento as tipo, a.documentoasistente as documento, concat(a.nombreasistente,' ', a.apellidoasistente) as nombre, d.encabezadodiploma, d.nombrediploma, d.fechadiploma, d.atributodiploma, d.intensidaddiploma, f.enlacefirmasdiploma, f.nombrefirmadiploma, f.cargofirmadiploma, f.dependenciafirmadiploma, f.atributosfirmadiploma, d.enlaceencabezadodiploma,d.otorgadiploma,f.idfirmadiploma
                FROM asistente a, asistentediploma ad, diploma d, documento doc, firmadiploma f
                where ad.iddiploma = d.iddiploma
                and a.idasistente = ad.idasistente
                and a.tipodocumento = doc.tipodocumento
                and f.iddiploma = d.iddiploma
                and d.iddiploma = '" . $_REQUEST['iddiploma'] . "'
                and a.documentoasistente = '" . $_REQUEST['documento'] . "'
                and d.codigoestado like '1%'
                and ad.codigoestado like '1%'
                and f.codigoestado like '1%'
                order by f.pesofirmadiploma";
                }
            }else {
                $query_datos = "SELECT doc.nombrecortodocumento as tipo, a.documentoasistente as documento, concat(a.nombreasistente,' ', a.apellidoasistente) as nombre, d.encabezadodiploma, d.nombrediploma, d.fechadiploma, d.atributodiploma, d.intensidaddiploma, f.enlacefirmasdiploma, f.nombrefirmadiploma, f.cargofirmadiploma, f.dependenciafirmadiploma, f.atributosfirmadiploma, d.enlaceencabezadodiploma,d.otorgadiploma
                FROM asistente a, asistentediploma ad, diploma d, documento doc, firmadiploma f
                where ad.iddiploma = d.iddiploma
                and a.idasistente = ad.idasistente
                and a.tipodocumento = doc.tipodocumento
                and f.iddiploma = d.iddiploma
                and d.iddiploma = '" . $_REQUEST['iddiploma'] . "'
                and a.documentoasistente = '" . $_REQUEST['documento'] . "'
                and d.codigoestado like '1%'
                and ad.codigoestado like '1%'
                and f.codigoestado like '1%'
                order by f.pesofirmadiploma";
            }
        } else {
            $query_datos = "SELECT doc.nombrecortodocumento as tipo, a.documentoasistente as documento, concat(a.nombreasistente,' ', a.apellidoasistente) as nombre, d.encabezadodiploma, d.nombrediploma, d.fechadiploma, d.atributodiploma,  d.enlaceencabezadodiploma
            FROM asistente a, asistentediploma ad, diploma d, documento doc
            where ad.iddiploma = d.iddiploma
            and a.idasistente = ad.idasistente
            and a.tipodocumento = doc.tipodocumento
            and d.iddiploma = '" . $_REQUEST['iddiploma'] . "'
            and a.documentoasistente = '" . $_REQUEST['documento'] . "'
            and d.codigoestado like '1%'
            and ad.codigoestado like '1%'";
        }
    } else {

        $query_datos = "SELECT doc.nombrecortodocumento as tipo, a.documentoasistente as documento, concat(a.nombreasistente,' ', a.apellidoasistente) as nombre, d.encabezadodiploma, d.nombrediploma, d.fechadiploma, d.atributodiploma,  d.enlaceencabezadodiploma
        FROM asistente a, asistentediploma ad, diploma d, documento doc
        where ad.iddiploma = d.iddiploma
        and a.idasistente = ad.idasistente
        and a.tipodocumento = doc.tipodocumento
        and d.iddiploma = '" . $_REQUEST['iddiploma'] . "'
        and a.documentoasistente = '" . $_REQUEST['documento'] . "'
        and d.codigoestado like '1%'
        and ad.codigoestado like '1%'";
    }
    $datos = $db->Execute($query_datos);
    $totalRows_datos = $datos->RecordCount();
    if ($totalRows_datos <= 0) {
        ?>
        <script type="text/javascript">
            alert('El documento digitado no tiene certificado asignado, por favor comuníquese con educación continuada');
            window.loaction.href = 'autenticacion.php';
        </script>
        <?php
        exit();
    }
    $row_datos = $datos->FetchRow();
    $tipoDocumento = $row_datos['tipo'];

    $parametrosd = explode(",", $row_datos['atributodiploma']);
    if ($_REQUEST['iddiploma'] != "37") {
        $orientacion = "L";
        $unidad = "mm";
        $formato = "Letter";
    } else {
        $orientacion = "P";
        $unidad = "mm";
        $formato = "Letter";
    }

    $imagen = $row_datos['enlaceencabezadodiploma'];
    $pdf = new FPDF($orientacion, $unidad, $formato);
    $pdf->AddPage();
    $pdf->AddFont('Hum521Bd', 'B', 'Hum521Bd.php');
    $pdf->AddFont('Hum521It', 'B', 'Hum521It.php');
    $pdf->AddFont('Hum521Rm', 'B', 'Hum521Rm.php');
    $pdf->AddFont('Hum521bi', 'B', 'Hum521bi.php');
    $pdf->AddFont('FrutigerLTStd-BoldCn', '', 'FrutigerLTStd-BoldCn.php');

    setlocale(LC_CTYPE, "es_ES");

    if ($_REQUEST['iddiploma'] != "37") {
        if ($_REQUEST['iddiploma'] != "15") {
            if ($_REQUEST['iddiploma'] == "166") {
                $pdf->SetFont('Arial', 'B', 14);
                $pdf->SetTextColor(250, 145, 4);
            }else if($_REQUEST['iddiploma'] == "185"){
                //pendiente para certificado letra la facultad
                $pdf->SetTextColor(25, 32, 73);
                $pdf->SetFont('Arial','B',12);
            }else {
                $pdf->SetFont('Hum521Rm', 'B', 11);// modifica texto la faculta // encabezado
                $pdf->SetTextColor(74, 83, 55);
            }
            if ($_REQUEST['iddiploma'] != "98" &&
                $_REQUEST['iddiploma'] != "39" &&
                $_REQUEST['iddiploma'] != "63" &&
                $_REQUEST['iddiploma'] != "88") {

                if ($_REQUEST['iddiploma'] == "123" or
                    $_REQUEST['iddiploma'] == "149" or
                    $_REQUEST['iddiploma'] == "159" or
                    $_REQUEST['iddiploma'] == "166") {
                    $pdf->Image($imagen, 0, 0.1, 279.2, 235);
                } else {
                    if (in_array($_REQUEST['iddiploma'],array(180,184,185))){
                        $pdf->Image($imagen, 0, 0, 279.2, 0);
                    }else if($_REQUEST['iddiploma'] == "188"){
                        $pdf->Image($imagen, 0, 0, 295, 0);
                    }else if(in_array($_REQUEST['iddiploma'],array(191,192,199,200,201,202,203,204))){//se parametriza el fondo del diploma
                        $pdf->Image($imagen, 0, 0, 279, 217);
                    }else{
                        $pdf->Image($imagen, 0.1, 0.1, 279.2, 50);
                    }
                }
            } else {
                $pdf->Image($imagen, 18, 10, 245, 0);
            }
            if ($_REQUEST['iddiploma'] == "166") {
                $pdf->SetY(41);
            }else {
                $pdf->SetY(60);// pilas estadar no afectar
            }
            $pdf->SetX($parametrosd[9]);//sub encabezado en x

            if($_REQUEST['iddiploma'] == "201"){
                $pdf->SetY($parametrosd[9]);//sub encabezado en Y
            }
            if (in_array($_REQUEST['iddiploma'],array(98,39,3,88,123,185))){
                $pdf->SetFont('Hum521Bd', 'B', 13);
            }

            if ($_REQUEST['iddiploma'] == "101") {
                $pdf->SetFontSize(14);
                $nomdip = utf8_decode($row_datos['encabezadodiploma']);
                $pdf->MultiCell($parametrosd[7], $parametrosd[8], $nomdip, 0, 'C');
            }else if ($_REQUEST['iddiploma'] == "187") {
                $pdf->SetFont('Hum521Bd', 'B', 13);
                $nomdip = utf8_decode($row_datos['encabezadodiploma']);
                $pdf->MultiCell($parametrosd[7], $parametrosd[8], $nomdip, 0, 'C');
            }else if ($_REQUEST['iddiploma'] == "149") {
                    $pdf->SetY(50);
                    $pdf->SetX(127);
                    $pdf->SetFontSize(16);
                    $nomdip = utf8_decode($row_datos['encabezadodiploma']);
                    $pdf->MultiCell($parametrosd[7], $parametrosd[8], $nomdip, 0, 'C');
            }else if(in_array($_REQUEST['iddiploma'],array(202,203))){
                    //
            }else {
                    $nomdip = utf8_decode($row_datos['encabezadodiploma']);
                    $pdf->MultiCell($parametrosd[7], $parametrosd[8], $nomdip, 0, 'C');
                }
            if ($_REQUEST['iddiploma'] == "83") {
                $pdf->SetY(75);
                $pdf->SetFont('Hum521Rm', 'B', 11);
                $pdf->SetFontSize(14);
                $pdf->Cell(0, 0, $row_datos['otorgadiploma'], 0, 2, 'C');
                $pdf->SetY(89);
                $pdf->SetFontSize(28);
                $pdf->SetTextColor(60, 70, 40);
                if ($_REQUEST['iddiploma'] == "98" || $_REQUEST['iddiploma'] == "39" || $_REQUEST['iddiploma'] == "63" || $_REQUEST['iddiploma'] == "88") {
                    $pdf->SetFont('Hum521Bd', 'B', 24);
                }
                $nomasis = utf8_decode($row_datos['nombre']);
                $pdf->Cell(0, 0, strtr(strtoupper($nomasis), "àèìòùáéíóúçñäëïöü", "ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜÁ"), 0, 2, 'C');
                $pdf->SetY(95);
                $pdf->SetFontSize(12);
                $pdf->SetTextColor(74, 83, 55);
                if ($_REQUEST['iddiploma'] != "98" && $_REQUEST['iddiploma'] != "34" && $_REQUEST['iddiploma'] != "39" && $_REQUEST['iddiploma'] != "63" && $_REQUEST['iddiploma'] != "88") {
                    if ($tipoDocumento != 'TI' && $tipoDocumento != 'PA') {
                        $pdf->Cell(0, 0, $tipoDocumento . " " . ereg_replace(",", ".", number_format($row_datos['documento'])), 0, 2, 'C');
                    } else {
                        $pdf->Cell(0, 0, $tipoDocumento . " " . ereg_replace(",", ".", $row_datos['documento']), 0, 2, 'C');
                    }
                }
                $pdf->SetY(105);
                $pdf->SetFont('Hum521Rm', 'B', 11);
                $pdf->SetFontSize(11);
                $pdf->Cell(0, 0, 'ATTENDED THE', 0, 2, 'C');
            } else {
                if ($_REQUEST['iddiploma'] == "84") {
                    $pdf->SetY(80);
                    $pdf->SetFont('Hum521Rm', 'B', 11);
                    $pdf->SetFontSize(14);
                    $pdf->Cell(0, 0, $row_datos['otorgadiploma'], 0, 2, 'C');
                    $pdf->SetY(90);
                    $pdf->SetFontSize(28);
                    $pdf->SetTextColor(60, 70, 40);
                    $nomasis = utf8_decode($row_datos['nombre']);
                    $pdf->Cell(0, 0, strtr(strtoupper($nomasis), "àèìòùáéíóúçñäëïöü", "ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ"), 0, 2, 'C');
                    $pdf->SetY(108);
                    $pdf->SetFontSize(12);
                    $pdf->SetTextColor(74, 83, 55);
                    $pdf->Cell(0, 0, 'Quien participo como asistente en el', 0, 2, 'C');
                }else{
                    if ($_REQUEST['iddiploma'] == "101") {
                        $pdf->SetY(40);
                        $pdf->SetFont('Hum521Rm', 'B', 13);
                        $pdf->SetFontSize(12);
                        $pdf->SetTextColor(60, 70, 40);
                        $pdf->Cell(0, 0, $row_datos['otorgadiploma'], 0, 2, 'C');

                        $pdf->SetY(90);
                        $pdf->SetFontSize(28);
                        $pdf->SetTextColor(60, 70, 40);
                        $nomasis = utf8_decode($row_datos['nombre']);
                        $pdf->Cell(0, -55, strtr(strtoupper($nomasis), "àèìòùáéíóúçñäëïöü", "ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ"), 0, 2, 'C');

                    }else if ($_REQUEST['iddiploma'] == "123") {
                            $pdf->SetY(70);
                            $pdf->SetX(100);
                            $pdf->SetFont('Hum521Rm', 'B', 11);
                            $pdf->SetFontSize(14);
                            $pdf->SetTextColor(3, 3, 3);
                            $pdf->Cell(0, 0, $row_datos['otorgadiploma'], 0, 2, 'C');

                            $pdf->SetY(80);
                            $pdf->SetX(100);
                            $pdf->SetFontSize(24);
                            $pdf->SetTextColor(3, 3, 3);
                            $pdf->SetFont('Arial', 'B', 20);
                            $nomasis = utf8_decode($row_datos['nombre']);
                            $pdf->Cell(0, 0, strtr(strtoupper($nomasis), "àèìòùáéíóúçñäëïöü", "ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ"), 0, 2, 'C');

                            $pdf->SetY(108);
                            $pdf->SetX(100);
                            $pdf->SetFontSize(12);
                            $pdf->SetTextColor(3, 3, 3);
                        } else if ($_REQUEST['iddiploma'] == "149") {
                                $pdf->SetY(55);
                                $pdf->SetX(124);
                                $pdf->SetFont('Hum521Rm', 'B', 11);
                                $pdf->SetFontSize(14);
                                $pdf->SetTextColor(3, 3, 3);
                                $pdf->Cell(0, 0, $row_datos['otorgadiploma'], 0, 2, 'C');
                                $pdf->SetY(68);
                                $pdf->SetX(130);
                                $pdf->SetFontSize(24);
                                $pdf->SetTextColor(3, 3, 3);
                                $pdf->SetFont('Arial', 'B', 20);
                                $nomasis = utf8_decode($row_datos['nombre']);
                                $pdf->Cell(0, 0, strtr(strtoupper($nomasis), "àèìòùáéíóúçñäëïöü", "ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ"), 0, 2, 'C');
                                $pdf->SetFont('Arial', '', 15);
                                $asistir = utf8_decode('Asistió al:');
                                $pdf->Cell(130, 25, $asistir, 0, 1, 'C');

                                $pdf->SetY(108);
                                $pdf->SetX(100);
                                $pdf->SetFontSize(12);
                                $pdf->SetTextColor(3, 3, 3);
                            } else
                                if ($_REQUEST['iddiploma'] == "159") {
                                    $pdf->SetY(96);
                                    $pdf->SetFont('Hum521Rm', 'B', 11);
                                    $pdf->SetFontSize(14);
                                    $pdf->SetTextColor(3, 3, 3);
                                    $pdf->Cell(0, 0, $row_datos['otorgadiploma'], 0, 2, 'C');
                                    $pdf->SetY(107);
                                    $pdf->SetFontSize(24);
                                    $pdf->SetTextColor(3, 3, 3);
                                    $pdf->SetFont('Arial', '', 20);
                                    $nomasis = utf8_decode($row_datos['nombre']);
                                    $pdf->Cell(0, 0, strtr(strtoupper($nomasis), "àèìòùáéíóúçñäëïöü", "ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ"), 0, 2, 'C');
                                } else if ($_REQUEST['iddiploma'] == "166") {
                                    $pdf->SetY(68);
                                    $pdf->SetTextColor(250, 145, 4);
                                    $pdf->SetFontSize(24);
                                    $pdf->SetFont('Arial', 'B', 20);
                                    $nomasis = utf8_decode($row_datos['nombre']);
                                    $pdf->Cell(0, 0, strtr(strtoupper($nomasis), "àèìòùáéíóúçñäëïöü", "ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ"), 0, 2, 'C');
                                    $pdf->SetY(52);
                                    $pdf->SetFont('Arial', 'B', 11);
                                    $pdf->SetFontSize(14);
                                    $pdf->Cell(0, 0, $row_datos['otorgadiploma'], 0, 2, 'C');
                                    $pdf->SetY(83);
                                    $pdf->SetFontSize(15);
                                    $pdf->SetTextColor(250, 145, 4);
                                    $pdf->Cell(0, 0, utf8_decode('Asistió al'), 0, 2, 'C');
                                }else if ($_REQUEST['iddiploma'] == "180") {
                                        $pdf->SetY(85);
                                        $pdf->SetTextColor(43, 43, 90);
                                        $pdf->SetFontSize(24);
                                        $pdf->SetFont('Arial', 'B', 20);
                                        $nomasis = utf8_decode($row_datos['nombre']);
                                        $pdf->Cell(0, 0, strtr(strtoupper($nomasis), "àèìòùáéíóúçñäëïöü", "ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ"), 0, 2, 'C');
                                    }else if ($_REQUEST['iddiploma'] == "185") {//validacion nombre asistente y Documento
                                        $pdf->SetY(86);
                                        $pdf->SetTextColor(25, 32, 73);
                                        $pdf->SetFontSize(24);
                                        // $pdf->SetFont('Arial', 'B', 20);
                                        $nomasis = utf8_decode($row_datos['nombre']);
                                        $pdf->Cell(0, 0, strtr(strtoupper($nomasis), "àèìòùáéíóúçñäëïöü", "ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ"), 0, 2, 'C');
                                        $pdf->SetY(94);
                                        $pdf->SetTextColor(43, 43, 90);
                                        $pdf->SetFontSize(11);
                                        $pdf->Cell(0, 0, $tipoDocumento." ".ereg_replace(",", ".", number_format($row_datos['documento'])), 0, 2, 'C');

                                    }else if($_REQUEST['iddiploma'] == "184" ){
                                        $pdf->SetY(80);
                                        $pdf->SetX(150);
                                        $pdf->SetTextColor(43, 43, 90);
                                        $pdf->SetFontSize(19);
                                        $pdf->SetFont('Arial', 'B', 20);
                                        $nomasis = utf8_decode($row_datos['nombre']);
                                        $pdf->Cell(0, 0, strtr(strtoupper($nomasis), "àèìòùáéíóúçñäëïöü", "ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ"), 0, 2, 'C');

                                        $pdf->SetY(90);
                                        $pdf->SetX(163);
                                        $pdf->SetTextColor(43, 43, 90);
                                        $pdf->SetFontSize(11);
                                        $pdf->Cell(0, 0, ereg_replace(",", ".", number_format($row_datos['documento'])), 0, 2, 'C');

                                    }else if($_REQUEST['iddiploma'] == "191"){
                                        //nombre asistente
                                        $pdf->SetY(85);
                                        $pdf->SetFontSize(28);
                                        $pdf->SetTextColor(53, 68, 41);
                                        $nomasis = utf8_decode($row_datos['nombre']);
                                        $pdf->Cell(0, 0, strtr(strtoupper($nomasis), "àèìòùáéíóúçñäëïöü", "ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ"), 0, 2, 'C');
                                        //cedula
                                        $pdf->SetY(95);
                                        $pdf->SetFontSize(12);
                                        $pdf->SetTextColor(53, 68, 41);
                                        $pdf->Cell(0, 0, $tipoDocumento . " " . ereg_replace(",", ".", $row_datos['documento']), 0, 2, 'C');

                                    }else if($_REQUEST['iddiploma'] == "192"){
                                        //nombre asistente
                                        $pdf->SetY(85);
                                        $pdf->SetFontSize(28);
                                        $pdf->SetTextColor(0, 0, 0);
                                        $nomasis = utf8_decode($row_datos['nombre']);
                                        $pdf->Cell(0, 0, strtr(strtoupper($nomasis), "àèìòùáéíóúçñäëïöü", "ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ"), 0, 2, 'C');
                                        //cedula
                                        $pdf->SetY(95);
                                        $pdf->SetFontSize(12);
                                        $pdf->SetTextColor(0, 0, 0);
                                        $pdf->Cell(0, 0, $tipoDocumento . " " . ereg_replace(",", ".", $row_datos['documento']), 0, 2, 'C');

                                    }else if($_REQUEST['iddiploma'] == "199"){
                                        //nombre asistente
                                        $pdf->SetY(67);
                                        $pdf->SetFontSize(26);
                                        $pdf->SetTextColor(53, 68, 41);
                                        $nomasis = utf8_decode($row_datos['nombre']);
                                        $pdf->Cell(0, 0, strtr(strtoupper($nomasis), "àèìòùáéíóúçñäëïöü", "ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ"), 0, 2, 'C');
                                        //cedula
                                        $pdf->SetY(75.2);
                                        $pdf->SetFontSize(13);
                                        $pdf->SetTextColor(53, 68, 41);
                                        $pdf->Cell(0, 0, $tipoDocumento . " " . ereg_replace(",", ".", $row_datos['documento']), 0, 2, 'C');
                                    }else if($_REQUEST['iddiploma'] == "200"){
                                        //nombre asistente
                                        $pdf->SetY(69);
                                        $pdf->SetFontSize(26);
                                        $pdf->SetTextColor(53, 68, 41);
                                        $nomasis = utf8_decode($row_datos['nombre']);
                                        $pdf->Cell(0, 0, strtr(strtoupper($nomasis), "àèìòùáéíóúçñäëïöü", "ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ"), 0, 2, 'C');
                                        //cedula
                                        $pdf->SetY(77.2);
                                        $pdf->SetFontSize(12);
                                        $pdf->SetTextColor(53, 68, 41);
                                        $pdf->Cell(0, 0, $tipoDocumento . " " . ereg_replace(",", ".", $row_datos['documento']), 0, 2, 'C');
                                    }else if($_REQUEST['iddiploma'] == "204"){
                                        //nombre asistente
                                        $pdf->SetY(69);
                                        $pdf->SetFontSize(26);
                                        $pdf->SetTextColor(53, 68, 41);
                                        $nomasis = utf8_decode($row_datos['nombre']);
                                        $pdf->Cell(0, 0, strtr(strtoupper($nomasis), "àèìòùáéíóúçñäëïöü", "ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ"), 0, 2, 'C');
                                        //cedula
                                        $pdf->SetY(77.2);
                                        $pdf->SetFontSize(12);
                                        $pdf->SetTextColor(53, 68, 41);
                                        if ($tipoDocumento == 'TI' or $tipoDocumento == 'CC') {
                                            $pdf->Cell(0, 0, $tipoDocumento[0].".".$tipoDocumento[1] . " " . ereg_replace(",", ".", number_format($row_datos['documento'])), 0, 2, 'C');
                                        } else {
                                            $pdf->Cell(0, 0, $tipoDocumento. " " . ereg_replace(",", ".", $row_datos['documento']), 0, 2, 'C');
                                        }
                                    }else if(in_array($_REQUEST['iddiploma'],array(206,207))){
                                    //$pdf->Image($data["fondoImagen"], $positionX, $positionY, $whit, $heigth);
                                        //imagen de fondo
                                        $positionX = $parametrosd[0];
                                        $positionY = $parametrosd[1];
                                        $whit      = $parametrosd[2];
                                        $heigth    = $parametrosd[3];
                                        $pdf->Image($imagen, $positionX, $positionY, $whit, $heigth);
                                        //Fin imagen de fondo
                                        //nombre asistente
                                        $positionYNombre = $parametrosd[4];
                                        $fontSizeNombre  = $parametrosd[5];
                                        $r               = $parametrosd[6];
                                        $g               = $parametrosd[7];
                                        $b               = $parametrosd[8];
                                        $pdf->SetY($positionYNombre);//
                                        $pdf->SetFontSize($fontSizeNombre);
                                        $pdf->SetTextColor($r, $g, $b);//color letra nombre asistente
                                        $nomasis = utf8_decode($row_datos['nombre']);
                                        $whitNombre =  $parametrosd[9];
                                        $heigthNombre =  $parametrosd[10];
                                        $bordeCell = $parametrosd[11];
                                        $align = $parametrosd[12];
                                        $pdf->Cell($whitNombre, $heigthNombre, strtr(strtoupper($nomasis), "àèìòùáéíóúçñäëïöü", "ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ"), $bordeCell, 2, $align);
                                        //Fin nombre asistente
                                        //Documento Asistente
                                        $positionX = $parametrosd[13];
                                        $positionY = $parametrosd[14];
                                        $fontSizeDocumento =  $parametrosd[15];
                                        $r               = $parametrosd[16];
                                        $g               = $parametrosd[17];
                                        $b               = $parametrosd[18];

                                        $whitDocumento =  $parametrosd[19];
                                        $heigthDocumento =  $parametrosd[20];
                                        $bordeCell = $parametrosd[21];
                                        $align = $parametrosd[22];

                                        $pdf->SetXY($positionX,$positionY);
                                        $pdf->SetFontSize($fontSizeDocumento);
                                        $pdf->SetTextColor($r, $g, $b);

                                           //  $pdf->Cell(0, 0,ereg_replace(",", ".", "CC ".number_format($row_datos['documento'])), 0, 2);
                                        if ($tipoDocumento == 'TI' or $tipoDocumento == 'CC') {
                                            $pdf->Cell($whitDocumento, $heigthDocumento, $tipoDocumento[0].".".$tipoDocumento[1] . " " . ereg_replace(",", ".", number_format($row_datos['documento'])), $bordeCell, 2, $align);
                                        } else {
                                            $pdf->Cell($whitDocumento, $heigthDocumento, $tipoDocumento. " " . ereg_replace(",", ".", $row_datos['documento']), $bordeCell, 2, $align);
                                        }

                                    }else if($_REQUEST['iddiploma'] == "201"){
                                    //nombre asistente
                                    $pdf->SetY(85);
                                    $pdf->SetFontSize(26);
                                    $pdf->SetTextColor(114, 144, 0);
                                    $nomasis = utf8_decode($row_datos['nombre']);
                                    $pdf->Cell(0, 0, strtr(strtoupper($nomasis), "àèìòùáéíóúçñäëïöü", "ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ"), 0, 2, 'C');
                                    //cedula
                                    $pdf->SetY(93);
                                    $pdf->SetFontSize(12);
                                    $pdf->SetTextColor(114, 144, 0);
                                    $pdf->Cell(0, 0, $tipoDocumento . " " . ereg_replace(",", ".", $row_datos['documento']), 0, 2, 'C');
                                    }else if($_REQUEST['iddiploma'] == "202"){
                                        $pdf->SetY(56.2);
                                        $pdf->SetFontSize(16);
                                        $pdf->SetTextColor(255, 255, 255);
                                        $nomasis = utf8_decode($row_datos['nombre']);
                                        $pdf->Cell(0, 0, strtr(strtoupper($nomasis), "àèìòùáéíóúçñäëïöü", "ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ"), 0, 2, 'C');
                                        //cedula
                                        $pdf->SetY(63.8);
                                        $pdf->SetX(55);
                                        $pdf->SetFontSize(11);
                                        $pdf->SetTextColor(255, 255, 255);
                                        $pdf->Cell(0, 0, ereg_replace(",", ".", $row_datos['documento']), 0, 2, 'C');
                                    }else if($_REQUEST['iddiploma'] == "203"){
                                            $pdf->SetY(97);

                                           // $pdf->SetFontSize(20);
                                            $pdf->SetFont('Arial', 'I', 19);
                                            $pdf->SetTextColor(0, 0, 0);
                                            $nomasis = utf8_decode($row_datos['nombre']);
                                            $pdf->Cell(0, 0, strtr(strtoupper($nomasis), "àèìòùáéíóúçñäëïöü", "ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ"), 0, 2, 'C');

                                            $pdf->SetY(105);
                                            $pdf->SetFont('Arial', 'I', 12);
                                            $pdf->SetTextColor(0, 0, 0);
                                            if ($tipoDocumento == 'TI' or $tipoDocumento == 'CC') {
                                                $pdf->Cell(0, 0, $tipoDocumento[0].".".$tipoDocumento[1] . " " . ereg_replace(",", ".", number_format($row_datos['documento'])), 0, 2, 'C');
                                            } else {
                                                $pdf->Cell(0, 0, $tipoDocumento. " " . ereg_replace(",", ".", $row_datos['documento']), 0, 2, 'C');
                                            }
                                }else {
                                        $pdf->SetY(80);
                                        $pdf->SetFont('Hum521Rm', 'B', 11);
                                        $pdf->SetFontSize(14);
                                        $pdf->Cell(0, 0, $row_datos['otorgadiploma'], 0, 2, 'C');

                                        $pdf->SetY(95);
                                        $pdf->SetFontSize(28);
                                        $pdf->SetTextColor(60, 70, 40);
                                        if ($_REQUEST['iddiploma'] == "98" || $_REQUEST['iddiploma'] == "39" || $_REQUEST['iddiploma'] == "63") {

                                            $pdf->SetFont('Hum521Bd', 'B', 24);
                                        }

                                        $nomasis = utf8_decode($row_datos['nombre']);
                                        $pdf->Cell(0, 0, strtr(strtoupper($nomasis), "àèìòùáéíóúçñäëïöü", "ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ"), 0, 2, 'C');
                                        $pdf->SetY(108);
                                        $pdf->SetFontSize(12);
                                        $pdf->SetTextColor(74, 83, 55);
                                        if ($_REQUEST['iddiploma'] != "98" and $_REQUEST['iddiploma'] != "34" and $_REQUEST['iddiploma'] != "39" and $_REQUEST['iddiploma'] != "63" and $_REQUEST['iddiploma'] != "88") {

                                            if ($tipoDocumento == 'TI' or $tipoDocumento == 'CC') {
                                                $pdf->Cell(0, 0, $tipoDocumento . " " . ereg_replace(",", ".", number_format($row_datos['documento'])), 0, 2, 'C');
                                            } else {
                                                $pdf->Cell(0, 0, $tipoDocumento . " " . ereg_replace(",", ".", $row_datos['documento']), 0, 2, 'C');
                                            }
                                        }
                                    }
                }
            }

            if ($_REQUEST ['iddiploma'] == "123") {
                $pdf->SetY($parametrosd[0]);
                $pdf->SetX(100);
            }else if($_REQUEST ['iddiploma'] == "201"){
                $pdf->SetFont('Hum521Bd', 'B', 12);
                $pdf->SetY($parametrosd[0]);
                $pdf->SetTextColor(53, 68, 41);
            }
                //Parametro = posicion en Y para "Quien asistio al"
                $pdf->SetY($parametrosd[0]);
                $pdf->SetFont('Hum521Rm', 'B', 13);
            $parametrosd[6] = utf8_decode($parametrosd[6]);
            $pdf->Cell(0, 0, $parametrosd[6], 0, 2, 'C');
            if ($_REQUEST['iddiploma'] != "98" &&
                $_REQUEST['iddiploma'] != "39" &&
                $_REQUEST['iddiploma'] != "63" &&
                $_REQUEST['iddiploma'] != "88" &&
                $_REQUEST['iddiploma'] != "101" &&
                $_REQUEST['iddiploma'] != "123" &&
                $_REQUEST['iddiploma'] != "149") {

                $pdf->SetFont('Hum521Bd', 'B', 15);
                if($_REQUEST['iddiploma'] == "185"){
                    $pdf->SetY(110);
                    $pdf->SetX($parametrosd[2]);
                    $pdf->SetTextColor(25, 32, 73);
                    $nomcert = utf8_decode($row_datos['nombrediploma']);
                    $pdf->MultiCell($parametrosd[3], $parametrosd[4], $nomcert, 0, 'C');
                }else if(in_array($_REQUEST['iddiploma'],array(191,180,192,202,203,203,204,206,207))){// vacio por que no requiere que muestre el nombre del diploma ya que esta en la plantilla como imagen
                    //
                }else if($_REQUEST['iddiploma'] == "199" || $_REQUEST['iddiploma'] == "200"){
                    $pdf->SetFont('Hum521Bd', 'B', 20);
                    $pdf->SetY($parametrosd[1]);
                    $pdf->SetX($parametrosd[2]);
                    $pdf->SetTextColor(53, 68, 41);
                    $nomcert = utf8_decode($row_datos['nombrediploma']);
                   // $pdf->MultiCell($parametrosd[3], $parametrosd[4], $nomcert, 0, 'C');
                    $pdf->Cell($parametrosd[3], $parametrosd[4], $nomcert, 0, 2, 'C');
                }else if($_REQUEST['iddiploma'] == "201"){
                    $pdf->SetFont('Hum521Bd', 'B', 22);
                    $pdf->SetY($parametrosd[1]);

                    $pdf->SetX($parametrosd[2]);
                    $pdf->SetTextColor(53, 68, 41);
                    $nomcert = utf8_decode($row_datos['nombrediploma']);
                     $pdf->MultiCell($parametrosd[3], $parametrosd[4], $nomcert, 0, 'C');
                    //$pdf->Cell($parametrosd[3], $parametrosd[4], $nomcert, 0, 2, 'C');
                }else{
                    $pdf->SetY($parametrosd[1]);
                    $pdf->SetX($parametrosd[2]);
                    $pdf->SetTextColor(60, 70, 40);
                    //parametros 3 y 4 para definir renglones(4) y tamaño de la celda(3)
                    $nomcert = utf8_decode($row_datos['nombrediploma']);
                    $pdf->MultiCell($parametrosd[3], $parametrosd[4], $nomcert, 0, 'C');
                }
            }else {
                if ($_REQUEST['iddiploma'] == "98") {
                    $pdf->Image($row_datos['nombrediploma'], $parametrosd[2], $parametrosd[1], 100, 0);
                } elseif ($_REQUEST['iddiploma'] == "39") {
                    $pdf->Image($row_datos['nombrediploma'], $parametrosd[2], $parametrosd[1], 72, 0);
                } elseif ($_REQUEST['iddiploma'] == "63") {
                    $pdf->Image($row_datos['nombrediploma'], $parametrosd[2], $parametrosd[1], 55, 0);
                } elseif ($_REQUEST['iddiploma'] == "88") {
                    $pdf->Image($row_datos['nombrediploma'], $parametrosd[2], $parametrosd[1], 100, 0);
                } elseif ($_REQUEST['iddiploma'] == "101") {
                    $pdf->Image($row_datos['nombrediploma'], $parametrosd[2], $parametrosd[1], 100, 37);
                    $pdf->Image(trim($row_datos['dependenciafirmadiploma'], "Univerdiad El Bosque,"), 0, 185, 280, 0);
                }
            }
            //Parametro 5 posicion en Y para fecha del diploma
            $pdf->SetY($parametrosd[5]);
            $pdf->SetX($parametrosd[11]);

            $pdf->SetFont('Hum521Rm', 'B', 11);
            if ($_REQUEST['iddiploma'] == "98" ||
                $_REQUEST['iddiploma'] == "39" ||
                $_REQUEST['iddiploma'] == "63" ||
                $_REQUEST['iddiploma'] == "88" ||
                $_REQUEST['iddiploma'] == "123" ||
                $_REQUEST['iddiploma'] == "149" ) {

                $pdf->SetX($parametrosd[10]);
            }

            if ($_REQUEST["iddiploma"] == "185") {

                $pdf->SetFont('Hum521Rm', 'B', 11);
                $fecdip = utf8_decode($row_datos['fechadiploma']);
                $pdf->Cell(0, 0, $fecdip, 0, 2, 'C');
                $pdf->SetY($parametrosd[10]);
                $pdf->SetFont('Hum521Rm', 'B', 11);
                $intencidadDiploma = utf8_decode($row_datos['intensidaddiploma']);
                $r1=substr($intencidadDiploma,0,20);
                $r2=substr($intencidadDiploma,21,18);

                $pdf->cell(0,0, $r1,0,2,'C');
                $pdf->SetXY(12, 135);
                $pdf->cell(0,0, $r2,0,2,'C');
            }else{
                $fecdip = utf8_decode($row_datos['fechadiploma']);
                $pdf->Cell(0, 0, $fecdip, 0, 2, 'C');
                $pdf->SetY($parametrosd[10]);
                $pdf->SetX($parametrosd[12]);
                $pdf->SetFont('Hum521Rm', 'B', 11);
                $pdf->Cell(0, 0, $row_datos['intensidaddiploma'], 0, 2, 'C');
            }
             /* * ****************
             * *  Firma 1      **
             * ***************** */
            do {
                $parametros = explode(",", $row_datos['atributosfirmadiploma']);
                if($_REQUEST["iddiploma"]== '184' || empty($row_datos['enlacefirmasdiploma'])){
                    //
                }else{
                    if (isset($row_datos['enlacefirmasdiploma']) && !empty($row_datos['enlacefirmasdiploma'])) {
                        $pdf->Image($row_datos['enlacefirmasdiploma'], $parametros[0], $parametros[12], $parametros[1], $parametros[11]);
                    }
                }
                //Parametro 0 posicion en X, parametro 12 posicion en Y, parametro 1 porcentaje del tamaño de la imagen, parametro 11 alto de la imagen
                $pdf->SetY($parametros[13]);
                //Parametro 2 inicio del nombre
                $pdf->SetX($parametros[2]);
                if ($_REQUEST['iddiploma'] != "98" &&
                    $_REQUEST['iddiploma'] != "39" &&
                    $_REQUEST['iddiploma'] != "63" &&
                    $_REQUEST['iddiploma'] != "88") {
                    $pdf->SetFont('Hum521Bd', 'B', 14);
                } else {
                    $pdf->SetFont('Hum521Bd', 'B', 11);
                }
                if ($_REQUEST['iddiploma'] == '159') {
                    $pdf->SetTextColor(3, 3, 3);
                    $pdf->SetFont('Arial', 'B', 9);
                    $nomfirmdip = utf8_decode($row_datos['nombrefirmadiploma']);
                    $pdf->Cell(0, 0, $nomfirmdip, 0, 2, 'L');
                } else
                    //Nombre del director del Departamento
                    if ($_REQUEST['iddiploma'] == '166') {

                        $pdf->SetTextColor(250, 145, 4);
                        $pdf->SetFont('Arial', 'B', 11);
                        $nomfirmdip = utf8_decode($row_datos['nombrefirmadiploma']);
                        $pdf->Cell(0, 0, $nomfirmdip, 0, 2, 'L');

                        $pdf->SetY($parametrosd[5]);
                        $pdf->SetFont('Arial', 'B', 11);
                        $pdf->Cell(0, 0, utf8_decode('Bogotá, D.C., 17 y 18 de Agosto 2018'), 0, 2, 'C');

                        $pdf->SetY(109, $parametrosd[1]);
                        $pdf->SetX(10, $parametrosd[2]);
                        $pdf->SetTextColor(250, 145, 4);
                        $pdf->SetFont('Hum521Bd', 'B', 14);
                        //parametros 3 y 4 para definir renglones(4) y tamaño de la celda(3)
                        $pdf->Cell(0, 0, utf8_decode('Seminario Internacional de Bioética'), 0, 2, 'C');
                    } else if($_REQUEST['iddiploma'] == '185'){// cambia el color de la letra
                        $pdf->SetTextColor(25, 32, 73);
                        $pdf->SetFont('Times', 'B', 11);
                        $nomfirmdip = utf8_decode($row_datos['nombrefirmadiploma']);
                        $pdf->Cell(0, 0, $nomfirmdip, 0, 2, 'L');
                    } else if($_REQUEST['iddiploma'] == '203'){

                        $pdf->SetTextColor(0, 0, 0);
                        $pdf->SetFont('Arial', '', 12);
                        $nomfirmdip = utf8_decode($row_datos['nombrefirmadiploma']);
                        $pdf->Cell(0, 0, $nomfirmdip, 0, 2, 'C');
                    }else {
                        $pdf->SetTextColor(60, 70, 40);
                        $nomfirmdip = utf8_decode($row_datos['nombrefirmadiploma']);
                        $pdf->Cell(0, 0, $nomfirmdip, 0, 2, 'L');
                    }

                //Parametro 3 y 4 posicion y tamaño de la linea, parametros 14 posicion en Y de la linea ojo deben ser iguales.
                if ($row_datos['idfirmadiploma'] != '271') {
                    if ($_REQUEST['iddiploma'] == '101') {
                        //$pdf->Line($parametros[3], $parametros[14], $parametros[4], $parametros[14]);
                    } else {
                        if (isset($row_datos['enlacefirmasdiploma']) && !empty($row_datos['enlacefirmasdiploma'])) {
                            $pdf->Line($parametros[3], $parametros[14], $parametros[4], $parametros[14]);
                        }
                    }
                }
                if($_REQUEST['iddiploma'] == "185"){
                    $pdf->SetFont('Hum521Rm', 'B', 11);
                }else if ($_REQUEST['iddiploma'] != "98" &&
                    $_REQUEST['iddiploma'] != "39" &&
                    $_REQUEST['iddiploma'] != "63" &&
                    $_REQUEST['iddiploma'] != "88") {
                    $pdf->SetFont('Hum521Rm', 'B', 14);
                } else {
                    $pdf->SetFont('Hum521Rm', 'B', 10);
                }
                $pdf->SetY($parametros[15]);
                $pdf->SetX($parametros[5]);
                //parametro 5 inicio del cargo, parametro 15 posicion en Y del cargo
                //Parametro 6 y 7 ancho y alto
                if ($_REQUEST['iddiploma'] == "159") {
                    $pdf->SetTextColor(3, 3, 3);
                    $pdf->SetFont('Arial', '', 9);
                    $cargodip = utf8_decode($row_datos['cargofirmadiploma']);
                    $pdf->MultiCell($parametros[6], $parametros[7], $cargodip, 0, $parametros[10]);
                } else
                    if ($_REQUEST['iddiploma'] == "166") {
                        $pdf->SetTextColor(250, 145, 4);
                        $pdf->SetFont('Arial', '', 10);
                        $cargodip = utf8_decode($row_datos['cargofirmadiploma']);
                        $pdf->MultiCell($parametros[6], $parametros[7], $cargodip, 0, $parametros[10]);
                    }else if($_REQUEST['iddiploma'] == "185"){
                        $cargodip = utf8_decode($row_datos['cargofirmadiploma']);
                        $r1=substr($cargodip,0,45);
                        $r2=substr($cargodip,46,8);
                        $pdf->Multicell($parametros[6], $parametros[7], $r1, 0, $parametros[10]);

                        //$pdf->Line(10, 35, 15, 40);
                        $pdf->SetXY(102, 176);

                        $pdf->cell($parametros[6], $parametros[7], $r2, 0, $parametros[10]);

                    } else {
                        $cargodip = utf8_decode($row_datos['cargofirmadiploma']);
                        $pdf->MultiCell($parametros[6], $parametros[7], $cargodip, 0, $parametros[10]);
                    }

                if ($row_datos['dependenciafirmadiploma'] != "") {

                    if ($_REQUEST['iddiploma'] != "7") {
                        $pdf->SetY($parametros[9]);
                        $pdf->SetX($parametros[8]);
                        if ($_REQUEST['iddiploma'] == "101") {
                            $depnede = trim(utf8_decode($row_datos['dependenciafirmadiploma']), ", img-1-logos-01.jpg");
                        } else {
                            $depnede = utf8_decode($row_datos['dependenciafirmadiploma']);
                        }

                        $pdf->Cell(0, 0, $depnede, 0, 1, 'L');
                    } else {
                        //se utiliza para imprimir una imagen con patrocinadores caso especifico el diploma de PIAGET.
                        $pdf->Image($row_datos['dependenciafirmadiploma'], 5, 190, 290, 0);
                    }
                }
            } while ($row_datos = $datos->FetchRow());
        } else if ($_REQUEST['iddiploma'] == "15") {
            $pdf->SetFont('FrutigerLTStd-BoldCn', '', 28);
            //$pdf->SetTextColor(60,70,40);
            $pdf->SetTextColor(55, 55, 55);
            $pdf->Image($imagen, 0, 0, 282, 210);

            $pdf->SetY(77);
            $pdf->Cell(0, 0, $row_datos['nombre'], 0, 2, 'C');
        }
    } elseif ($_REQUEST['iddiploma'] == "37") {
        $pdf->SetFont('Hum521Bd', 'B', 11);
        $pdf->SetFontSize(24);
        $pdf->SetTextColor(60, 70, 40);
        $pdf->Image($imagen, 0, 0, 215);

        $pdf->SetY(80);
        $pdf->SetX(7);
        $nomasis = utf8_decode($row_datos['nombre']);
        $pdf->Cell(0, 0, strtr(strtoupper($nomasis), "àèìòùáéíóúçñäëïöü", "ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ"), 0, 2, 'C');

        $pdf->SetFont('Hum521Rm', 'B', 11);
        $pdf->SetY(87);
        $pdf->SetX(5);
        $pdf->SetFontSize(12);
        if ($tipoDocumento != 'TI' and $tipoDocumento != 'PA')
            $pdf->Cell(0, 0, $tipoDocumento . " " . ereg_replace(",", ".", number_format($row_datos['documento'])), 0, 2, 'C');
        else
            $pdf->Cell(0, 0, $tipoDocumento . " " . ereg_replace(",", ".", $row_datos['documento']), 0, 2, 'C');
    }
    $pdf->Output();
}
?>