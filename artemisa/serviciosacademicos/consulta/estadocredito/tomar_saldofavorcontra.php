<?php
 
$path = getcwd();
$index = stripos($path, "serviciosacademicos");
$pathFinal = substr($path, 0, $index + 20);

require_once(dirname(__FILE__) . '/../../../nusoap/lib/nusoap.php');
require_once(realpath(dirname(__FILE__)) . '/../interfacespeople/conexionpeople.php');
unset($saldoafavor);
unset($saldoencontra);

if (isset($_POST['orden']) && !empty($_POST['orden'])) {
    $query_codigoestudiante = "SELECT d.nombrecortodocumento,eg.numerodocumento 
        FROM ordenpago o, estudiante e, estudiantegeneral eg,documento d,documentopeople dp 
        WHERE o.codigoestudiante=e.codigoestudiante 
        and eg.idestudiantegeneral=e.idestudiantegeneral and d.tipodocumento=dp.tipodocumentosala
        and eg.tipodocumento=d.tipodocumento and numeroordenpago= '" . $_POST['orden'] . "'";
    if (isset($sala) && !empty($sala)) {
        $codigoestudiante = mysql_query($query_codigoestudiante, $sala) or die("$query_dataestudiante" . mysql_error());
        $row_codigoestudiante = mysql_fetch_assoc($codigoestudiante);
        $totalRows_codigoestudiante = mysql_num_rows($codigoestudiante);
    } else {
        $row_codigoestudiante = $db->GetRow($query_codigoestudiante);
    }

    if (isset($row_codigoestudiante['numerodocumento'])
        && !empty($row_codigoestudiante['numerodocumento'])) {
        $numerodocumento = $row_codigoestudiante['numerodocumento'];
        $nombredocumento = $row_codigoestudiante['nombrecortodocumento'];
    } else {
        echo "<br>error de consulta de datos post $query_codigoestudiante<br>" .
            exit();
    }
} elseif (isset($banderaestadocuenta)) {
    $numerodocumentose = $_SESSION['codigo'];
    $query_codigoestudiante = "SELECT dp.codigodocumentopeople,eg.numerodocumento,eg.idestudiantegeneral  
        FROM estudiantegeneral eg,documento d,documentopeople dp, estudiantedocumento ed  WHERE 
        d.tipodocumento=dp.tipodocumentosala
        and eg.tipodocumento=d.tipodocumento 
        and eg.idestudiantegeneral=ed.idestudiantegeneral 
        and ed.numerodocumento = '" . $numerodocumentose . "'";

    if (isset($sala) && !empty($sala)) {
        $codigoestudiante = mysql_query($query_codigoestudiante, $sala) or die("$query_dataestudiante" . mysql_error());
        $row_codigoestudiante = mysql_fetch_assoc($codigoestudiante);
        $totalRows_codigoestudiante = mysql_num_rows($codigoestudiante);
    } else {
        $row_codigoestudiante = $db->GetRow($query_codigoestudiante);
    }
    $numerodocumento = $row_codigoestudiante['numerodocumento'];
    $nombredocumento = $row_codigoestudiante['codigodocumentopeople'];

    if (isset($row_codigoestudiante['numerodocumento'])
        && !empty($row_codigoestudiante['numerodocumento'])) {
        $numerodocumento = $row_codigoestudiante['numerodocumento'];
        $nombredocumento = $row_codigoestudiante['nombrecortodocumento'];
    } else {
        echo "<br>error de consulta de datos post " . $_SESSION['codigo'] . "<br>" .
            exit();
    }
} else {
    require($pathFinal . 'Connections/sala2.php');
    mysql_select_db($database_sala, $sala);

    if (isset($_SESSION['codigo']) && $_SESSION['codigo'] != '') {
        $codigoestudiante = $_SESSION['codigo'];
    } else {
        $codigoestudiante = $this->codigoestudiante;
    }

    $query_dataestudiante = "SELECT dp.codigodocumentopeople,eg.numerodocumento,eg.idestudiantegeneral  " .
        " FROM estudiante e,estudiantegeneral eg,documento d,documentopeople dp " .
        " WHERE e.idestudiantegeneral = eg.idestudiantegeneral and d.tipodocumento=dp.tipodocumentosala " .
        " and eg.tipodocumento=d.tipodocumento and e.codigoestudiante = '" . $codigoestudiante . "'";
    $dataestudiante = mysql_query($query_dataestudiante, $sala) or die("$query_dataestudiante" . mysql_error());
    $row_dataestudiante = mysql_fetch_assoc($dataestudiante);
    $totalRows_dataestudiante = mysql_num_rows($dataestudiante);

    if (isset($row_dataestudiante['numerodocumento']) && !empty($row_dataestudiante['numerodocumento'])) {
        $numerodocumento = $row_dataestudiante['numerodocumento'];
        $nombredocumento = $row_dataestudiante['codigodocumentopeople'];
    } else {
        echo "error de datos del estudianate sala 2 $query_dataestudiante";
        exit();
    }

}
//VERIFICAMOS SI PEOPLESOFT ESTA EN LINEA
$results = array();
require_once(dirname(__FILE__) . '/../interfacespeople/reporteCaidaPeople.php');
$envio = 0;

$servicioPS = verificarPSEnLinea();

if ($servicioPS) {
    $proxyhost = isset($_POST['proxyhost']) ? $_POST['proxyhost'] : '';
    $proxyport = isset($_POST['proxyport']) ? $_POST['proxyport'] : '';
    $proxyusername = isset($_POST['proxyusername']) ? $_POST['proxyusername'] : '';
    $proxypassword = isset($_POST['proxypassword']) ? $_POST['proxypassword'] : '';

    $client = new nusoap_client(WEBESTADOCUENTA, true, false, false, false, false, 0, 100);
    $err = $client->getError();
    if ($err) {
        echo '<h2>ERROR EN EL CONSTRUCTOR</h2><pre>' . $err . '</pre>';
    }
    $proxy = $client->getProxy();
}

/* Consultamos todos los numeros de documento asociados al estudiante en cuestión */
$consultaDocumentos = "SELECT ed.numerodocumento, d.nombrecortodocumento " .
    " FROM estudiantegeneral eg " .
    " INNER JOIN estudiantedocumento ed ON ed.idestudiantegeneral = eg.idestudiantegeneral " .
    " INNER JOIN documento d ON d.tipodocumento = ed.tipodocumento " .
    " WHERE eg.numerodocumento = '" . $numerodocumento . "'";
if (isset($sala) && !empty($sala)) {
    $dataConsultaDocumentos = mysql_query($consultaDocumentos, $sala) or die("$consultaDocumentos" . mysql_error());
    $row_dataConsultaDocumentos = mysql_fetch_assoc($dataConsultaDocumentos);
} else {
    $row_dataConsultaDocumentos = $db->GetRow($consultaDocumentos);
}

if (isset($row_dataConsultaDocumentos['numerodocumento']) && !empty($row_dataConsultaDocumentos['numerodocumento'])) {
    $param2 = "<UB_DATOSCONS_WK><NATIONAL_ID_TYPE>" . $row_dataConsultaDocumentos['nombrecortodocumento'] . "</NATIONAL_ID_TYPE>" .
        "<NATIONAL_ID>" . $row_dataConsultaDocumentos['numerodocumento'] . "</NATIONAL_ID><DEPTID></DEPTID></UB_DATOSCONS_WK>";
    if ($servicioPS) {
        $hayResultado = false;

        for ($i = 0; $i <= 5 && !$hayResultado; $i++) {
            $start = time();
            $resultado = $client->call('UBI_CUENTA_CLIENTE_OPR_SRV', $param2);
            $time = time() - $start;
            $envio = 1;

            if (($time >= 100 || $resultado === false)) {
                $envio = 0;
                if ($i >= 5) {
                    reportarCaida(1, 'Consulta Estado de Cuenta');
                }
            } else {
                $hayResultado = true;
                if (isset($resultado['UBI_ITEMS_WRK']) && !empty($resultado['UBI_ITEMS_WRK'])) {
                    $results = $resultado['UBI_ITEMS_WRK'];
                }
            }
            sleep(3); // this should halt for 3 seconds for every loop
        }//for
    }

    $sqlconsultalogtrace = "select idlogtraceintegracionps from logtraceintegracionps " .
        " where documentologtraceintegracionps= '" . $row_dataConsultaDocumentos['numerodocumento'] . "' " .
        " and transaccionlogtraceintegracionps = 'Consulta Estado de Cuenta' " .
        " and respuestalogtraceintegracionps= 'id:" . $resultado['ERRNUM'] . " descripcion: " . $resultado['DESCRLONG'] . "'" .
        " and estadoenvio = '" . $envio . "'";
    if (isset($sala) && !empty($sala)) {
        $dataConsultalog = mysql_query($sqlconsultalogtrace, $sala) or die("$consultaDocumentos" . mysql_error());
        $idlogtrace = mysql_fetch_assoc($dataConsultalog);
    } else {
        $idlogtrace = $db->GetRow($sqlconsultalogtrace);
    }

    if (isset($idlogtrace['idlogtraceintegracionps']) && !empty($idlogtrace['idlogtraceintegracionps'])) {
        $sqlupdate = "update logtraceintegracionps set fecharegistrologtraceintegracionps = now() " .
            " where idlogtraceintegracionps = '" . $idlogtrace['idlogtraceintegracionps'] . "'";
        if (isset($sala) && !empty($sala)) {
            $plandepago = mysql_query($sqlupdate, $sala) or die("$sqlupdate" . mysql_error());
        } else {
            $db->Execute($sqlupdate);
        }
    } else {
        $query = "INSERT INTO logtraceintegracionps (transaccionlogtraceintegracionps,enviologtraceintegracionps, " .
            " respuestalogtraceintegracionps,documentologtraceintegracionps,estadoenvio) " .
            " VALUES ('Consulta Estado de Cuenta', '" . $param2 . "','id:" . $resultado['ERRNUM'] . " descripcion: " .
            $resultado['DESCRLONG'] . "','" . $row_dataConsultaDocumentos['numerodocumento'] . "'," . $envio . ")";
        if (isset($sala) && !empty($sala)) {
            $plandepago = mysql_query($query, $sala) or die("$query" . mysql_error());
        } else {
            $db->Execute($query);
        }
    }

    if (!is_array($results)) {
        $resultstmp = $results;
        unset($results);
        $results[0] = $resultstmp;
    }

    /* si el array obtenido esta contenido en un array llamado "UBI_ITEM_WRK" y la consulta proviene del modulo de
    matriculaautomatica.php */

    if (isset($results["UBI_ITEM_WRK"]) and isset($_GET['matriculaautomatica'])) {
        $results = $results["UBI_ITEM_WRK"];
    }

    if ($results <> "") {
        foreach ($results as $valor => $total) {
            if (isset($total['ITEM_TYPE']) && !empty($total['ITEM_TYPE'])) {
                $itemconcepto = $total['ITEM_TYPE'];
                $query_carrera = "SELECT * FROM carrera c, carreraconceptopeople  ccp " .
                    " WHERE  c.codigocarrera=ccp.codigocarrera AND ccp.itemcarreraconceptopeople = '$itemconcepto' " .
                    " AND c.codigotipocosto = '100'";
                if (isset($sala) && !empty($sala)) {
                    $carrera1 = mysql_query($query_carrera, $sala) or die("$query_carrera" . mysql_error());
                    $row_carrera = mysql_fetch_assoc($carrera1);
                    $totalRows_carrera = mysql_num_rows($carrera1);
                } else {
                    $row_carrera = $db->GetRow($query_carrera);
                }

                $fechavence = $total['DUE_DT'];
                $valor = $total['ITEM_AMT'] - $total['APPLIED_AMT'];

                if (isset($total['INVOICE_ID']) && !empty($total['INVOICE_ID'])) {
                    $numerodeorden = $total['INVOICE_ID'];
                } else {
                    if (isset($_POST['orden']) && !empty($_POST['orden'])) {
                        $numerodeorden = $_POST['orden'];
                    } else {
                        $numerodeorden = "";
                    }
                }

                $cuenta = $total['ACCOUNT_NBR'];
                $nombreconcepto = $total['DESCR'];
                $fechasaldoafavor = $total['ITEM_EFFECTIVE_DT'];

                $query_concepto = "SELECT * FROM carreraconceptopeople ccp, concepto c " .
                    " WHERE c.codigoconcepto=ccp.codigoconcepto " .
                    " and itemcarreraconceptopeople='$itemconcepto'";
                if (isset($sala) && !empty($sala)) {
                    $concepto = mysql_query($query_concepto, $sala) or die("$query_concepto" . mysql_error());
                    $row_concepto = mysql_fetch_assoc($concepto);
                    $totalRows_concepto = mysql_num_rows($concepto);
                } else {
                    $row_concepto = $db->GetRow($query_concepto);
                }
                $query_codigoestudiantecarrera = "SELECT * FROM estudiante e, prematricula p " .
                    " WHERE e.idestudiantegeneral = '" . $row_dataestudiante['idestudiantegeneral'] . "' " .
                    " and p.codigoestudiante = e.codigoestudiante group by codigocarrera";
                if (isset($sala) && !empty($sala)) {
                    $codigoestudiantecarrera = mysql_query($query_codigoestudiantecarrera, $sala) or die("$query_codigoestudiantecarrera" . mysql_error());
                    $row_codigoestudiantecarrera = mysql_fetch_assoc($codigoestudiantecarrera);
                    $totalRows_codigoestudiantecarrera = mysql_num_rows($codigoestudiantecarrera);
                } else {
                    $row_codigoestudiantecarrera = $db->GetRow($query_codigoestudiantecarrera);
                }
                $codigoestudiante = $row_codigoestudiantecarrera['codigoestudiante'];
                $codigocarrera = $row_codigoestudiantecarrera['codigocarrera'];

                if (isset($row_concepto['codigoconcepto']) && !empty($row_concepto['codigoconcepto'])) {
                    if ($row_concepto['codigoconcepto'] == '149' and $codigocarrera <> '98') {
                        $row_concepto['codigoconcepto'] = '154';
                    }

                    if ($row_concepto['codigotipoconcepto'] == '02') {
                        $saldoafavor[] = array($codigocarrera, $row_concepto['codigoconcepto'],
                            $row_concepto['nombreconcepto'], $fechasaldoafavor, $valor,
                            $numerodeorden, $codigoestudiante, $cuenta);
                    } else if ($row_concepto['codigotipoconcepto'] == '01') {
                        $saldoencontra[] = array($codigocarrera, $itemconcepto, $row_concepto['codigoconcepto'],
                            $nombreconcepto, $fechavence, $fechasaldoafavor, $valor, $numerodeorden,
                            $codigoestudiante, $cuenta, $row_dataConsultaDocumentos['numerodocumento'],
                            $row_dataConsultaDocumentos['nombrecortodocumento']);
                    }
                }
            }
        }//foreach
    }
}//fin while