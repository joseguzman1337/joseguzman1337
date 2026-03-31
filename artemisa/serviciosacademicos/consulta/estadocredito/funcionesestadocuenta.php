<?php
/*
 * Este archivo contiene las funciones del modulo de estadocuenta
 *
 * funcion de histrocico de documentos
 * funcion de salgo afavo o contra
 * funcion de convertir positivos valores
 * funcion de datos del estudiante
 *
*/

function historicoDocumentos($db, $codigoestudiante){
    //consulta el historico de documentos que ha regristrado el estudiante
    $sqldocumentos = "select ed.numerodocumento, ed.tipodocumento, d.nombrecortodocumento, ".
        " eg.idestudiantegeneral, d2.codigodocumentopeople ".
        " from estudiantegeneral eg ".
        " inner join estudiantedocumento ed on ed.idestudiantegeneral = eg.idestudiantegeneral ".
        " inner join estudiante e on e.idestudiantegeneral = eg.idestudiantegeneral ".
        " inner join documento d on d.tipodocumento = ed.tipodocumento ".
        " inner join documentopeople d2 on d.tipodocumento = d2.tipodocumentosala ".
        " where e.codigoestudiante = $codigoestudiante";
    $documentos = $db->GetAll($sqldocumentos);
    return $documentos;
}

function saldoaFavorContra($db,$documento){
    $resultados = array('error'=> '', 'saldoafavor'=>'', 'saldoencontra'=>'');
    //VERIFICAMOS SI PEOPLESOFT ESTA EN LINEA
    $results = array();
    require_once(dirname(__FILE__) . '/../interfacespeople/reporteCaidaPeople.php');
    require_once(dirname(__FILE__) . '/../../../nusoap/lib/nusoap.php');
    require_once(realpath(dirname(__FILE__)) . '/../interfacespeople/conexionpeople.php');
    $envio = 0;

    $servicioPS = verificarPSEnLinea();

    if ($servicioPS) {
        $client = new nusoap_client(WEBESTADOCUENTA, true, false, false, false, false, 0, 100);
        $err = $client->getError();
        if ($err) {
            echo '<h2>ERROR EN EL CONSTRUCTOR</h2><pre>' . $err . '</pre>';
        }
    }

    if (isset($documento['numerodocumento']) && !empty($documento['numerodocumento'])) {
        //asignacion de la extructura del xml de consulta,
        // el parametro deptid se envia vacio para obtener los detalles de deudas o saldos a favor
        $param2 = "<UB_DATOSCONS_WK><NATIONAL_ID_TYPE>".$documento['codigodocumentopeople']."</NATIONAL_ID_TYPE>" .
            "<NATIONAL_ID>".$documento['numerodocumento']."</NATIONAL_ID><DEPTID></DEPTID></UB_DATOSCONS_WK>";

        if ($servicioPS) {
            $hayResultado = false;

            for ($i = 0; $i <= 5 && !$hayResultado; $i++) {
                $start = time();
                //llamado al servicio de cuenta cliente
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
                    }else{
                        if($resultado['ERRNUM'] > 0) {
                            $resultados['error'] = array('numero' => $resultado['ERRNUM'], 'descripcion' => $resultado['DESCRLONG']);
                        }
                    }
                }
                sleep(3); // this should halt for 3 seconds for every loop
            }//for
        }
        //valida si en la variable descrlong existe la siguien cadena de string
        preg_match('/No existe un registro de persona para el tipo/', $resultado['DESCRLONG'], $matches);

        //consulta de registros de existentes de la tabla de logs
        $sqlconsultalogtrace = "select idlogtraceintegracionps from logtraceintegracionps " .
            " where documentologtraceintegracionps= '" . $documento['numerodocumento'] . "' " .
            " and transaccionlogtraceintegracionps = 'Consulta Estado de Cuenta' " .
            " and respuestalogtraceintegracionps= 'id:".$resultado['ERRNUM']." descripcion: ".$resultado['DESCRLONG']."'".
            " and estadoenvio = '".$envio."'";
        $idlogtrace = $db->GetRow($sqlconsultalogtrace);
        $totalidlogtrace = count($idlogtrace);

        if($totalidlogtrace == 0) {
            //si en la primera posicion del array existe la cadena buscada
            if (!isset($matches[0]) || empty($matches[0])) {
                //Crea un registro en logtra de la consulta de estado cuenta del estudiante
                $query = "INSERT INTO logtraceintegracionps (transaccionlogtraceintegracionps,enviologtraceintegracionps, " .
                    " respuestalogtraceintegracionps,documentologtraceintegracionps,estadoenvio) " .
                    " VALUES ('Consulta Estado de Cuenta', '" . $param2 . "','id:" . $resultado['ERRNUM'] . " descripcion: " .
                    $resultado['DESCRLONG'] . "','" . $documento['numerodocumento'] . "'," . $envio . ")";
                $db->Execute($query);
            }
        }
        if (!is_array($results)) {
            $resultstmp = $results;
            unset($results);
            $results[0] = $resultstmp;
        }

        if ($results <> "") {
            $list = "";
            //asigna el valor del campo del array
            foreach ($results as $detalle) {
                //valida si es array es una dimension
                if(isset($detalle['BUSINESS_UNIT'])) {
                    //se crea un array superior para asignar el resultado
                    $list[] = $detalle;
                }else{
                    $list = $detalle;
                }
            }
            foreach($list as $valores) {
                if (isset($valores['ITEM_TYPE']) && !empty($valores['ITEM_TYPE'])) {
                    $itemconcepto = $valores['ITEM_TYPE'];
                    $fechavence = $valores['DUE_DT'];
                    $valor = $valores['ITEM_AMT'] - $valores['APPLIED_AMT'];

                    if (isset($valores['INVOICE_ID']) && !empty($valores['INVOICE_ID'])) {
                        $numerodeorden = $valores['INVOICE_ID'];
                    } else {
                        if (isset($_POST['orden']) && !empty($_POST['orden'])) {
                            $numerodeorden = $_POST['orden'];
                        } else {
                            $numerodeorden = "";
                        }
                    }
                    //asignacion de variables
                    $cuenta = $valores['ACCOUNT_NBR'];
                    $nombreconcepto = $valores['DESCR'];
                    $fechasaldoafavor = $valores['ITEM_EFFECTIVE_DT'];

                    //consulta de los conceptos
                    $query_concepto = "SELECT c.codigoconcepto, c.codigotipoconcepto ".
                        " FROM carreraconceptopeople ccp, concepto c " .
                        " WHERE c.codigoconcepto=ccp.codigoconcepto " .
                        " and itemcarreraconceptopeople='".$itemconcepto."'";
                    $row_concepto = $db->GetRow($query_concepto);

                    //consulta de estudiante y carrera
                    $query_codigoestudiantecarrera = "SELECT e.codigoestudiante, e.codigocarrera ".
                        " FROM estudiante e, prematricula p " .
                        " WHERE e.idestudiantegeneral = '" . $documento['idestudiantegeneral'] . "' " .
                        " and p.codigoestudiante = e.codigoestudiante group by codigocarrera";
                    $row_codigoestudiantecarrera = $db->GetRow($query_codigoestudiantecarrera);

                    $codigoestudiante = $row_codigoestudiantecarrera['codigoestudiante'];
                    $codigocarrera = $row_codigoestudiantecarrera['codigocarrera'];

                    if (isset($row_concepto['codigoconcepto']) && !empty($row_concepto['codigoconcepto'])) {
                        if ($row_concepto['codigoconcepto'] == '149' and $codigocarrera <> '98') {
                            $row_concepto['codigoconcepto'] = '154';
                        }

                        if ($row_concepto['codigotipoconcepto'] == '02') {
                            $resultados['saldoafavor'][] = array($codigocarrera, $row_concepto['codigoconcepto'],
                                $row_concepto['nombreconcepto'], $fechasaldoafavor, $valor,
                                $numerodeorden, $codigoestudiante, $cuenta);
                        } else if ($row_concepto['codigotipoconcepto'] == '01') {
                            $resultados['saldoencontra'][] = array($codigocarrera, $itemconcepto, $row_concepto['codigoconcepto'],
                                $nombreconcepto, $fechavence, $fechasaldoafavor, $valor, $numerodeorden,
                                $codigoestudiante, $cuenta, $documento['numerodocumento'],
                                $documento['nombrecortodocumento']);
                        }
                    }
                }//if
            }//foreach
        }//if
    }//fin if
    return $resultados;
}//function

function convertirPositivo($valortotal){
    $valortotal = $valortotal * (-1);
    return $valortotal;
}

function datosEstudianteEstadoCuenta($db, $codigoestudiante, $link){
    $sinprematricula = false;
    $query_seldocumentos = "select ed.numerodocumento, ed.fechainicioestudiantedocumento, ".
        " ed.fechavencimientoestudiantedocumento, u.linkidubicacionimagen ".
        " from estudiantedocumento ed ".
        " inner join estudiante e on ed.idestudiantegeneral = e.idestudiantegeneral ".
        " inner join ubicacionimagen u ".
        " where e.codigoestudiante = '$codigoestudiante' ".
        " and u.idubicacionimagen like '1%' and u.codigoestado like '1%' order by 2 desc";
    $row_seldocumentos = $db->GetRow($query_seldocumentos);

    if(isset($row_seldocumentos['numerodocumento'])){
        $imagenjpg = $row_seldocumentos['numerodocumento'].".jpg";
        $imagenJPG = $row_seldocumentos['numerodocumento'].".JPG";
        if(is_file($link.$imagenjpg)){
            $linkimagen = $link.$imagenjpg;
        }
        else if(is_file($link.$imagenJPG)){
            $linkimagen = $link.$imagenJPG;
        }
        else{
            $linkimagen = HTTP_SITE."/assets/images/icons/no_foto2.png";
        }
    }//if

    $cuentaconplandeestudio = true;
    $query_selplan = "select p.idplanestudio, p.nombreplanestudio from planestudioestudiante pe, planestudio p ".
        " where pe.idplanestudio = p.idplanestudio and pe.codigoestudiante = '".$codigoestudiante."' ".
        " and pe.codigoestadoplanestudioestudiante like '1%' and p.codigoestadoplanestudio like '1%'";
    $row_selplan = $db->GetRow($query_selplan);

    if(isset($row_selplan['idplanestudio'])){
        $idplan = $row_selplan['idplanestudio'];
        $nombreplan = $row_selplan['nombreplanestudio'];
    }
    else{
        $cuentaconplandeestudio = false;
        $idplan = "0";
        $nombreplan = "Sin Asignar";
        // Verifica si la carrera necesita plan de estudio
        $query_datocarreraplan = "select c.codigoindicadorplanestudio from carrera c, estudiante e ".
            " where e.codigocarrera = c.codigocarrera and e.codigoestudiante = '$codigoestudiante'";
        $row_datocarreraplan = $db->GetAll($query_datocarreraplan);
        // Mira si la carrera requiere o no requiere plan de estudio
    }
    $sinprematricula = true;
    $query_dataestudiante = "select c.codigocarrera, c.nombrecarrera, ".
        " concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) as nombre, c.codigocarrera, ".
        " eg.numerodocumento, eg.fechanacimientoestudiantegeneral, eg.expedidodocumento, e.codigojornada, e.semestre, ".
        " e.numerocohorte, e.codigotipoestudiante, t.nombretipoestudiante, e.codigosituacioncarreraestudiante, ".
        " s.nombresituacioncarreraestudiante, eg.celularestudiantegeneral, eg.emailestudiantegeneral, eg.codigogenero, ".
        " eg.direccionresidenciaestudiantegeneral, eg.telefonoresidenciaestudiantegeneral, eg.ciudadresidenciaestudiantegeneral, ".
        " eg.direccioncorrespondenciaestudiantegeneral, eg.telefonocorrespondenciaestudiantegeneral, eg.ciudadcorrespondenciaestudiantegeneral ".
        " from estudiante e, carrera c, tipoestudiante t, situacioncarreraestudiante s, estudiantegeneral eg ".
        " where e.codigocarrera = c.codigocarrera ".
        " and e.codigotipoestudiante = t.codigotipoestudiante ".
        " and e.codigosituacioncarreraestudiante = s.codigosituacioncarreraestudiante ".
        " and e.codigoestudiante = '$codigoestudiante' and e.idestudiantegeneral = eg.idestudiantegeneral";
    $row_dataestudiante = $db->GetRow($query_dataestudiante);

    $row_dataestudiante['idplan'] = $idplan;
    $row_dataestudiante['nombreplan'] = $nombreplan;
    $row_dataestudiante['linkimagen'] = $linkimagen;

    return $row_dataestudiante;
} //fin funcion

function cuotasplanpagos($db, $datos){
    //VERIFICAMOS SI PEOPLESOFT ESTA EN LINEA
    $results = array();
    require_once(dirname(__FILE__) . '/../interfacespeople/reporteCaidaPeople.php');
    require_once(dirname(__FILE__) . '/../../../nusoap/lib/nusoap.php');
    require_once(realpath(dirname(__FILE__)) . '/../interfacespeople/conexionpeople.php');
    $envio = 0;

    $servicioPS = verificarPSEnLinea();
    if ($servicioPS) {
        $client = new nusoap_client(WEBPLANDEPAGO, true, false, false, false, false, 0, 90);
        $err = $client->getError();
        if ($err) {
            echo '<h2>ERROR EN EL CONSTRUCTOR</h2><pre>' . $err . '</pre>';
        }

        $param2 = "	<UB_DATOSCONS_WK><NATIONAL_ID_TYPE>" . $datos['codigodocumentopeople'] . "</NATIONAL_ID_TYPE> " .
            "<NATIONAL_ID>" . $datos['numerodocumento'] . "</NATIONAL_ID></UB_DATOSCONS_WK>";

        $start = time();
        $resultado = $client->call('UBI_CONS_PLANPAGO_OPR_SRV', $param2);
        $time = time() - $start;
        $envio = 1;
        if ($time >= 100 || $resultado === false) {
            $envio = 0;
            reportarCaida(1, 'Consulta Plan de Pago');
        } else {
            if (isset($resultado['UBI_ITEMS_WRK']['UBI_ITEM_WRK']) && !empty($resultado['UBI_ITEMS_WRK']['UBI_ITEM_WRK'])) {
                $results = $resultado['UBI_ITEMS_WRK'];
            } else {
                if ($resultado['ERRNUM'] > 0) {
                    $resultados['error'] = array('numero' => $resultado['ERRNUM'], 'descripcion' => $resultado['DESCRLONG']);
                }
            }
        }

        //consulta de registros de existentes de la tabla de logs
        $sqlconsultalogtrace = "select idlogtraceintegracionps from logtraceintegracionps " .
            " where documentologtraceintegracionps= '" . $datos['numerodocumento'] . "' " .
            " and transaccionlogtraceintegracionps = 'Consulta Plan de Pago' " .
            " and respuestalogtraceintegracionps= 'id:".$resultado['ERRNUM']." descripcion: ".$resultado['DESCRLONG']."'";
        $idlogtrace = $db->GetRow($sqlconsultalogtrace);
        $totalidlogtrace = count($idlogtrace);

        if($totalidlogtrace == 0) {
            $query = "INSERT INTO logtraceintegracionps (transaccionlogtraceintegracionps ,enviologtraceintegracionps " .
                ",respuestalogtraceintegracionps ,documentologtraceintegracionps,estadoenvio) " .
                " VALUES ('Consulta Plan de Pago' ,'" . $param2 . "' ,'id:" . $resultado['ERRNUM'] . " descripcion: " .
                $resultado['DESCRLONG'] . "' ,'" . $datos['numerodocumento'] . "'," . $envio . ")";
            $db->Execute($query);
        }


        if (!is_array($results)) {
            $resultstmp = $results;
            unset($results);
            $results[0] = $resultstmp;
        }

        if ($results <> "") {
            $list = "";
            //asigna el valor del campo del array
            foreach ($results as $detalle) {
                //valida si es array es una dimension
                if(isset($detalle['BUSINESS_UNIT'])) {
                    //se crea un array superior para asignar el resultado
                    $list[] = $detalle;
                }else{
                    $list = $detalle;
                }
                return $list;
            }
        }else{
            return $resultados;
        }
    }
}//function

function limpiarInvoice($invoice){
    //primero se retiran los espacios del invoice
    $invoice = trim($invoice);

    //se separa el invoice en secciones acorde con los guiones
    $invoiceArray = explode("-", $invoice);

    //ahora buscamos la orden que sea un numero
    $auxResponse = false;

    foreach ($invoiceArray as $key => $subString) {
        $floatSubString = (float)$subString;

        if ($floatSubString > 0) {
            echo "<script type='text/javascript'>console.log('Numero de orden padre " . $invoice . " cambiado por " . $floatSubString . "')</script>";
            return $floatSubString;
            break;
        }
    }
    if (!$auxResponse) {
        echo "<script type='text/javascript'>console.log('Invoice id inconveniente: " . $invoice . "')</script>";
        echo "<script type='text/javascript'>alert('Existe un inconveniente con la generación de cuotas de plan de pagos. ' +
        ' Por favor pongase en contacto con Mesa de Servicio')</script>";
        die();
        return 0;
    }
}