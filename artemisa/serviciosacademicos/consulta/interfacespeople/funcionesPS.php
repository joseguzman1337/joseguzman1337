<?php

require_once(realpath(dirname(__FILE__) . "/../../../sala/includes/adaptador.php"));
require_once(PATH_ROOT . "/serviciosacademicos/consulta/interfacespeople/conexionpeople.php");
require_once(PATH_ROOT . '/serviciosacademicos/consulta/interfacespeople/reporteCaidaPeople.php');
require_once(PATH_ROOT . '/serviciosacademicos/consulta/prematricula/descuentos/descuento.php');
require_once(PATH_ROOT . '/serviciosacademicos/consulta/interfacespeople/cambia_fecha_people.php');
require_once(PATH_ROOT . '/sala/entidadDAO/LogTraceIntegracionPsDAO.php');
require_once(PATH_ROOT . '/sala/entidadDAO/OrdenPagoDAO.php');
require_once(PATH_ROOT . '/sala/entidadDAO/PrematriculaDAO.php');
require_once(PATH_ROOT . '/sala/entidadDAO/DetallePrematriculaDAO.php');
require_once(PATH_ROOT . '/nusoap/lib/nusoap.php');
require_once(PATH_ROOT . '/sala/entidadDAO/ColaNotificacionPagoPsDAO.php');
require_once(PATH_ROOT . '/sala/entidad/ColaNotificacionPagoPs.php');

$pos = strpos($Configuration->getEntorno(), "local");
if($Configuration->getEntorno()=="local" || $pos!==false){
    require_once(PATH_ROOT.'/kint/Kint.class.php');
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

//estado de integracion
function getLogCaida($db = null, $tipo = 1){
    if(empty($db)){
        $db = Factory::createDbo();
    }
    $SQL = "SELECT LogCaidaSistemaInformacionId AS id, Tipo, DATE(HoraEvento) AS fecha, ".
        " TIME(HoraEvento) AS tiempo, TipoSistemaInformacionLogId AS Sis ".
        " FROM LogsCaidasSistemaInformacion ".
        " WHERE TipoSistemaInformacionLogId = ".$tipo." ORDER BY LogCaidaSistemaInformacionId DESC LIMIT 1";
    $Funciona = $db->GetRow($SQL);
    return $Funciona;
}
function llamarPeople() {
    $Respuesta = array();
    $client = new nusoap_client(WEBESTADOCUENTA, true, false, false, false, false, 0, 200);

    $param2 = getXML('EstadoCuenta');

    $start = time(); // starting the timer
    $resultado = $client->call('UBI_CUENTA_CLIENTE_OPR_SRV', $param2);
    $timing = time() - $start;

    // Calcula el tiempo de la transaccion
    if ($timing >= 300 || !$resultado) {
        $Respuesta = false;
    } else {
        $Respuesta = true;
        InsertEstadoNew();
    }

    return $Respuesta;
}
function InsertEstadoNew($tipo = 1) {
    $db = Factory::createDbo();
    $SQL = "INSERT INTO LogsCaidasSistemaInformacion(Tipo,HoraEvento,TipoSistemaInformacionLogId)".
        " VALUES('1',NOW(),''".$tipo."')";
    $db->Execute($SQL);
}

function reportarPagoPSE($db, $numeroordenpago, $tiketid, $respuesta = null) {
    $fechahoy = date("m/d/y");
    $fechapagoorden = date("Y-m-d");

    $query_logpagos = "select  l.FIName, l.PaymentSystem, l.TransValue, l.BankProcessDate from LogPagos l ".
        " where l.Reference1 = '" . $numeroordenpago . "' and StaCode = 'OK'";
    $row_logpagos = $db->GetRow($query_logpagos);

    if (!isset($row_logpagos['FIName']) && empty($row_logpagos['FIName'])) {
        exit();
    }

    if ($row_logpagos['FIName'] == 'MASTERCARD' || $row_logpagos['FIName'] == 'VISA') {
        $numerocuenta = "071000080001";
        $tipocuentapeople = "TC";
    } else if ($row_logpagos['FIName'] == 'CODENSA') {
        $numerocuenta = "071000080007";
        $tipocuentapeople = "TC";
    } else if ($row_logpagos['FIName'] == 'BANCOLOMBIA' && $row_logpagos['PaymentSystem'] == 100) {
        $numerocuenta = "071000170001";
        $tipocuentapeople = "TD";
    } else if ($row_logpagos['FIName'] == 'BANCO DE BOGOTA' && $row_logpagos['PaymentSystem'] == 100) {
        $numerocuenta = "071000171001";
        $tipocuentapeople = "TD";
    } else if ($row_logpagos['PaymentSystem'] == 100) {
        $numerocuenta = "071000174003";
        $tipocuentapeople = "TD";
    } else {
        //Pago PSE Credicorp Fonval
        $numerocuenta = "071000080009";
        $tipocuentapeople = "TD";
    }

    $query_variables = "select dp.codigodocumentopeople ,eg.numerodocumento ,op.numeroordenpago, op.fechaordenpago ".
        " ,coalesce(ccp.tipocuenta,ccp2.tipocuenta) as tipocuenta ,cp.cuentaoperacionprincipal, ".
        " eg.idestudiantegeneral ".
        " from carrera c ".
        " join estudiante e on c.codigocarrera=e.codigocarrera ".
        " join estudiantegeneral eg on e.idestudiantegeneral=eg.idestudiantegeneral ".
        " join documentopeople dp on eg.tipodocumento=dp.tipodocumentosala ".
        " join ordenpago op on e.codigoestudiante=op.codigoestudiante ".
        " join detalleordenpago dop on op.numeroordenpago=dop.numeroordenpago ".
        " join concepto cp on dop.codigoconcepto=cp.codigoconcepto ".
        " left join carreraconceptopeople ccp on e.codigocarrera=ccp.codigocarrera and ".
        " dop.codigoconcepto=ccp.codigoconcepto ".
        " left join carreraconceptopeople ccp2 on 1=ccp2.codigocarrera and dop.codigoconcepto=ccp2.codigoconcepto ".
        " where op.numeroordenpago='" . $numeroordenpago . "' ".
        " group by dp.codigodocumentopeople,eg.numerodocumento,op.numeroordenpago, ccp.tipocuenta";
    $row_variables = $db->GetRow($query_variables);

    if (isset($respuesta) && !empty($respuesta)) {
        $sql = "select dp.codigodocumentopeople, ed.numerodocumento ".
            " from estudiantedocumento ed ".
            " inner join documentopeople dp on ed.tipodocumento=dp.tipodocumentosala ".
            " where idestudiantegeneral=" . $row_variables['idestudiantegeneral'] . " ".
            " and fechavencimientoestudiantedocumento<NOW() ".
            " ORDER BY fechavencimientoestudiantedocumento DESC";
        $row_variables2 = $db->GetRow($sql);
        if (isset($row_variables2['numerodocumento']) && !empty($row_variables2['numerodocumento'])){
            $row_variables['codigodocumentopeople'] = $row_variables2['codigodocumentopeople'];
            $row_variables['numerodocumento'] = $row_variables2['numerodocumento'];
        }
    }//if

    if(isset($row_variables['numerodocumento'])&& !empty($row_variables['numerodocumento'])){
        if ($row_variables['cuentaoperacionprincipal'] != 153) {
            $national_id_type = $row_variables['codigodocumentopeople'];
            $national_id = $row_variables['numerodocumento'];
            $invoice_id = $numeroordenpago;
        } else {
            // Validar si fue creada la inscipcion como DUMMY o  no
            if($row_variables['fechaordenpago'] <= '2020-09-17'){

                $national_id_type = 'CC';
                $rowDumy = getDummy($db, $numeroordenpago);
                $national_id = $rowDumy['dummy'];
                $invoice_id = $numeroordenpago."-".$row_variables['codigodocumentopeople'].$row_variables['numerodocumento'];
            }else{
                $national_id_type = $row_variables['codigodocumentopeople'];
                $national_id = $row_variables['numerodocumento'];
                $invoice_id = $numeroordenpago;
            }
        }
        $account_type_sf = $row_variables['tipocuenta'];

        $item_type = $numerocuenta;
        $payment_method = $tipocuentapeople;
        $item_effective_dt = cambiafechaapeoplePse($row_logpagos['BankProcessDate']);
        $item_amt = $row_logpagos['TransValue'];

        $result = array();
        $envio = 0;
        $servicioPS = verificarPSEnLinea();

        $param = array('NATIONAL_ID_TYPE' => $national_id_type,
            'NATIONAL_ID' => $national_id,
            'INVOICE_ID' => $invoice_id,
            'ACCOUNT_TYPE_SF' => $account_type_sf,
            'ITEM_TYPE' => $item_type,
            'PAYMENT_METHOD' => $payment_method,
            'ITEM_AMT' => $item_amt,
            'ITEM_EFFECTIVE_DT' => $item_effective_dt);
        $param2 = getXML('PagoPse', $param);

        if ($servicioPS) {
            //Se Valida la orden para el envio a People
            $resultadoEstadoEnvioCola= EnvioColaPagoPeople($invoice_id, $tiketid);
            
            if(!empty($resultadoEstadoEnvioCola)){
            // SE PONE UN TIEMPO DE RESPUESTA DE 200 SEGUNDOS
            $client = new nusoap_client(WEBREPORTAPAGOPSE, true, false, false, false, false, 0, 200);
            $err = $client->getError();
            if ($err) {
                echo '<h2>ERROR EN EL CONSTRUCTOR</h2><pre>' . $err . '</pre>';
                $transaccion = "Informa Pago PSE";
                $param = "No hay respuesta del WSDL, error de conexión con el servidor ".$err;
                $log = new \Sala\entidadDAO\LogTraceIntegracionPsDAO();
                $log->setLog($numeroordenpago, $param2, $transaccion, $param, $envio);
                ActualizacionEnvioColaPagoPeople($invoice_id,0,3,$resultadoEstadoEnvioCola);
            }
            $proxy = $client->getProxy();
            ActualizacionEnvioColaPagoPeople($invoice_id,0,3,$resultadoEstadoEnvioCola);
         }
        }//if

        if ($servicioPS) {
            //Se Valida la orden para el envio a People
            $resultadoEstadoEnvioCola= EnvioColaPagoPeople($invoice_id, $tiketid);
            if(!empty($resultadoEstadoEnvioCola)){
            $start = time();
            $result = $client->call('UBI_PAGO_PSE_OPR_SRV', $param2);
            $time = time() - $start;
            $envio = 1;
            if ($time >= 200 || $result === false) {
                $envio = 0;
                reportarCaida(1, 'Informa Pago PSE');
            }

            if ($client->fault) {
                $resultado = $result['detail']['IBResponse']['DefaultMessage'];
                $transaccion = "Informa Pago PSE";
                $log = new \Sala\entidadDAO\LogTraceIntegracionPsDAO();
                $log->setLog($invoice_id, $param2, $transaccion, $resultado, $envio);
                ActualizacionEnvioColaPagoPeople($invoice_id,0,3,$resultadoEstadoEnvioCola);
            }
            else{
                // Revision de errores
                $err = $client->getError();
                if ($err) {
                    // Display the error
                    $resultado = $err;
                    $transaccion = "Informa Pago PSE";
                    $log = new \Sala\entidadDAO\LogTraceIntegracionPsDAO();
                    $log->setLog($invoice_id, $param2, $transaccion, $resultado, $envio);
                    ActualizacionEnvioColaPagoPeople($invoice_id,0,3,$resultadoEstadoEnvioCola);
                } else {
                    $parametro = "id:".$result['ERRNUM']." descripcion: ".$result['DESCRLONG'];
                    $transaccion = "Informa Pago PSE";
                    $log = new \Sala\entidadDAO\LogTraceIntegracionPsDAO();
                    $log->setLog($invoice_id, $param2, $transaccion, $parametro, $envio);
                    ActualizacionEnvioColaPagoPeople($invoice_id,0,3,$resultadoEstadoEnvioCola);
                }
            }
         }
        } else {
            $resultadoEstadoEnvioCola= EnvioColaPagoPeople($invoice_id, $tiketid);
            if(!empty($resultadoEstadoEnvioCola)){
            $resultado = "id: " . $result['ERRNUM'] . " descripcion: " . $result['DESCRLONG'];
            $transaccion = "Informa Pago PSE";
            $log = new \Sala\entidadDAO\LogTraceIntegracionPsDAO();
            $log->setLog($invoice_id, $param2, $transaccion, $resultado, $envio);
            ActualizacionEnvioColaPagoPeople($invoice_id,0,3,$resultadoEstadoEnvioCola);
            if ($result['ERRNUM'] <> 0) {
                $result['val'] = false;
            }
         }
        }
    }else{
        $result['DESCRLONG'] = "Sin datos en resultado";
        $result['val'] = false;
    }
    return $result;
}

//Funcion Encargada de Enviar pagos a People desde el comprobante
function reportarPagoPeople($db, $orden, $pago, $respuesta = null) {
    $query_logpagos = "select o.*,l.*,b.itempeoplesoft FROM LogPagos l ".
        " INNER JOIN ordenpago o ON o.numeroordenpago=l.Reference1 ".
        " LEFT JOIN bancopse b on l.FIName LIKE CONCAT('%', b.nombrebancopse, '%') AND codigoestado=100 ".
        " WHERE l.TicketID = '" . $pago . "' AND StaCode = 'OK' AND o.numeroordenpago='" . $orden . "' ";
    $logpagos = $db->Execute($query_logpagos);

    $ValidacionLogTrace = ValidacionTrace($db, $orden);
    $totalRows_logpagos = $logpagos->RecordCount();
    $row_logpagos = $logpagos->FetchRow();

    if ($ValidacionLogTrace) {
        if ($totalRows_logpagos == '' || $totalRows_logpagos == 0) {
            updateColaNotificacion($db, $orden, 1);
            exit();
        } else {
            $fechapagoorden = date("Y-m-d");

            if ($row_logpagos['FIName'] == 'MASTERCARD' || $row_logpagos['FIName'] == 'VISA') {
                $numerocuenta = "071000080001";
                $tipocuentapeople = "TC";
            } else if ($row_logpagos['FIName'] == 'CODENSA') {
                $numerocuenta = "071000080007";
                $tipocuentapeople = "TC";
            } else if ($row_logpagos['FIName'] == 'BANCOLOMBIA' && $row_logpagos['PaymentSystem'] == 100) {
                $numerocuenta = "071000170001";
                $tipocuentapeople = "TD";
            } else if ($row_logpagos['FIName'] == 'BANCO DE BOGOTA' && $row_logpagos['PaymentSystem'] == 100) {
                $numerocuenta = "071000171001";
                $tipocuentapeople = "TD";
            } else if ($row_logpagos['PaymentSystem'] == 100) {
                $numerocuenta = "071000174003";
                $tipocuentapeople = "TD";
            } else {
                //Pago PSE Credicorp Fonval
                $numerocuenta = "071000080009";
                $tipocuentapeople = "TD";
            }

            $query_variables = "select dp.codigodocumentopeople ,eg.numerodocumento ,op.numeroordenpago ".
                ",coalesce(ccp.tipocuenta,ccp2.tipocuenta) as tipocuenta ,cp.cuentaoperacionprincipal, eg.idestudiantegeneral, op.fechaordenpago".
                " from carrera c ".
                " join estudiante e on c.codigocarrera=e.codigocarrera ".
                " join estudiantegeneral eg on e.idestudiantegeneral=eg.idestudiantegeneral ".
                " join documentopeople dp on eg.tipodocumento=dp.tipodocumentosala ".
                " join ordenpago op on e.codigoestudiante=op.codigoestudiante ".
                " join detalleordenpago dop on op.numeroordenpago=dop.numeroordenpago ".
                " join concepto cp on dop.codigoconcepto=cp.codigoconcepto ".
                " left join carreraconceptopeople ccp on e.codigocarrera=ccp.codigocarrera and dop.codigoconcepto=ccp.codigoconcepto ".
                " left join carreraconceptopeople ccp2 on 1=ccp2.codigocarrera and dop.codigoconcepto=ccp2.codigoconcepto ".
                " where op.numeroordenpago='" . $orden . "' ".
                " group by dp.codigodocumentopeople,eg.numerodocumento,op.numeroordenpago,tipocuenta";
            $variables = $db->Execute($query_variables);
            $totalRows_variables = $variables->RecordCount();
            $row_variables = $variables->FetchRow();

            if ($respuesta != null) {
                $sql = "select dp.codigodocumentopeople,ed.numerodocumento from estudiantedocumento ed ".
                    " inner join documentopeople dp on ed.tipodocumento=dp.tipodocumentosala ".
                    " where idestudiantegeneral=" . $row_variables['idestudiantegeneral'] . " ".
                    " and fechavencimientoestudiantedocumento<NOW() ORDER BY fechavencimientoestudiantedocumento DESC";
                $variables2 = $db->Execute($sql);
                $totalRows_variables2 = $variables2->RecordCount();
                $row_variables2 = $variables2->FetchRow();

                if ($totalRows_variables2 > 1) {
                    $row_variables['codigodocumentopeople'] = $row_variables2['codigodocumentopeople'];
                    $row_variables['numerodocumento'] = $row_variables2['numerodocumento'];
                }
            }//if

            if ($totalRows_variables > 1) {
                $account_type_sf = "PPA";
                $national_id_type = $row_variables['codigodocumentopeople'];
                $national_id = $row_variables['numerodocumento'];
                $invoice_id = $orden;
            } else {
                if ($row_variables['cuentaoperacionprincipal'] != 153) {
                    $national_id_type = $row_variables['codigodocumentopeople'];
                    $national_id = $row_variables['numerodocumento'];
                    $invoice_id = $orden;
                } else {
                    // Validar si fue creada la inscipcion como DUMMY o  no

                    if($row_variables['fechaordenpago'] <= '2020-09-17'){

                        $national_id_type = 'CC';
                        $rowDumy = getDummy($db, $orden);
                        $national_id = $rowDumy['dummy'];
                        $invoice_id = $orden . "-" . $row_variables['codigodocumentopeople'] . $row_variables['numerodocumento'];

                    }else{
                        $national_id_type = 'CC';
                        $national_id = $row_variables['numerodocumento'];
                        $invoice_id = $orden;
                    }
                }
                $account_type_sf = $row_variables['tipocuenta'];
            }//else

            $item_type = $numerocuenta;
            $payment_method = $tipocuentapeople;
            $item_effective_dt = cambiafechaapeoplePse($row_logpagos['BankProcessDate']);
            $item_amt = $row_logpagos["TransValue"];

            $result = array();
            $envio = 0;
            $servicioPS = verificarPSEnLinea();
            $servicioInformaPS = verificarInformaPSE();

            $param = array('NATIONAL_ID_TYPE' => $national_id_type,
                'NATIONAL_ID' => $national_id,
                'INVOICE_ID' => $invoice_id,
                'ACCOUNT_TYPE_SF' => $account_type_sf,
                'ITEM_TYPE' => $item_type,
                'PAYMENT_METHOD' => $payment_method,
                'ITEM_AMT' => $item_amt,
                'ITEM_EFFECTIVE_DT' => $item_effective_dt);
            $param2 = getXML('PagoPse', $param);
            if ($servicioPS && $servicioInformaPS) {

               $resultadoEstadoEnvioCola= EnvioColaPagoPeople($invoice_id,$row_logpagos['TicketId']);
                
               if(!empty($resultadoEstadoEnvioCola)){
                // SE DEFINE TIEMPO DE RESPUESTA DE 200 SEGUNDOS
                $client = new nusoap_client(WEBREPORTAPAGOPSE, true, false, false, false, false, 0, 200);

                $err = $client->getError();
                if ($err) {
                    echo '<h2>ERROR EN EL CONSTRUCTOR</h2><pre>' . $err . '</pre>';
                    $resultado = "No hay respuesta del WSDL, error de conexión con el servidor $err";
                    $transaccion = "Informa Pago PSE";
                    $log = new \Sala\entidadDAO\LogTraceIntegracionPsDAO();
                    $log->setLog($invoice_id, $param2, $transaccion, $resultado, $envio);
                    ActualizacionEnvioColaPagoPeople($invoice_id,0,2,$resultadoEstadoEnvioCola);
                }
                ActualizacionEnvioColaPagoPeople($invoice_id,0,2,$resultadoEstadoEnvioCola);
             }
            }//if

            if ($servicioPS && $servicioInformaPS) {
                $resultadoEstadoEnvioCola= EnvioColaPagoPeople($invoice_id,$row_logpagos['TicketId']);
                
                if(!empty($resultadoEstadoEnvioCola)) {  
                $start = time();
                $result = $client->call('UBI_PAGO_PSE_OPR_SRV', $param2);
                $time = time() - $start;
                $envio = 1;

                if ($client->fault) {
                    $parametro = $result['detail']['IBResponse']['DefaultMessage'];
                    $transaccion = "Informa Pago PSE";
                    $log = new \Sala\entidadDAO\LogTraceIntegracionPsDAO();
                    $log->setLog($invoice_id, $param2, $transaccion, $parametro, $envio);
                    ActualizacionEnvioColaPagoPeople($invoice_id,0,2,$resultadoEstadoEnvioCola);
                } else {
                    // Revision de errores
                    $err = $client->getError();
                    if ($err) {
                        // Display the error
                        $resultado = $err;
                        $transaccion = "Informa Pago PSE";
                        $log = new \Sala\entidadDAO\LogTraceIntegracionPsDAO();
                        $log->setLog($invoice_id, $param2, $transaccion, $resultado, $envio);
                        ActualizacionEnvioColaPagoPeople($invoice_id,0,2,$resultadoEstadoEnvioCola);
                    } else {
                        // Display the result
                        if ($result['ERRNUM'] == 0) {
                            //La respuesta ok
                            $parametro = "id:".$result['ERRNUM']." descripcion: ".$result['DESCRLONG'];
                            $transaccion = "Informa Pago PSE";
                            $log = new \Sala\entidadDAO\LogTraceIntegracionPsDAO();
                            $log->setLog($invoice_id, $param2, $transaccion, $parametro, $envio);
                            ActualizacionEnvioColaPagoPeople($invoice_id,0,2,$resultadoEstadoEnvioCola);

                            $query_ordenpago = "UPDATE ordenpago set fechapagosapordenpago = '$fechapagoorden' ".
                                " where numeroordenpago = '" . $orden . "'";
                            $ordenpago = $db->Execute($query_ordenpago);
                        } else if ($result['ERRNUM'] != 0) {
                            $parametro = "id:".$result['ERRNUM']." descripcion: ".$result['DESCRLONG'];
                            $transaccion = "Informa Pago PSE";
                            $log = new \Sala\entidadDAO\LogTraceIntegracionPsDAO();
                            $log->setLog($invoice_id, $param2, $transaccion, $parametro, $envio);
                            ActualizacionEnvioColaPagoPeople($invoice_id,0,2,$resultadoEstadoEnvioCola);
                        }
                    }//else
                }//else
             } 
            } else {
               $resultadoEstadoEnvioCola= EnvioColaPagoPeople($invoice_id,$row_logpagos['TicketId']);
                
              if(!empty($resultadoEstadoEnvioCola)) {
                $parametro = "id:".$result['ERRNUM']." descripcion: ".$result['DESCRLONG'];
                $transaccion = "Informa Pago PSE";
                $log = new \Sala\entidadDAO\LogTraceIntegracionPsDAO();
                $log->setLog($invoice_id, $param2, $transaccion, $parametro, $envio);
                ActualizacionEnvioColaPagoPeople($invoice_id,0,2,$resultadoEstadoEnvioCola);
               }
               ActualizacionEnvioColaPagoPeople($invoice_id,0,2,$resultadoEstadoEnvioCola);
            }
            updateColaNotificacion($db, $orden, $result['ERRNUM']);
        } // else
    }//validacion nueva
}
function reportarCreacionPeople($db, $datos, $modulo = null, $idgrupo=null){
    $servicioPS = llamarPeople();
    if (isset($datos['idestudiantegeneral']) && !empty($datos['idestudiantegeneral'])) {
        //definicion de variables
        if (!isset($datos['paisnacionalidad']) || empty($datos['paisnacionalidad']) || $datos['paisnacionalidad'] == 0) {
            //bogota colombia
            $datos['paisnacionalidad'] = "CO";
            $datos['departamentonacionalidad'] = 11;
            $datos['ciudadnacionalidad'] = 11001;
        }

        //definicion de parametros de envio
        $parametros['UBI_OPERACION_ORD'] = 'C';
        $parametros['NATIONAL_ID_TYPE'] = $datos['tipodocumento'];
        $parametros['NATIONAL_ID'] = $datos['documento'];
        $parametros['NATIONAL_ID_TYPE_OLD'] = "";
        $parametros['NATIONAL_ID_OLD'] = "";
        $parametros['FIRST_NAME'] = limpiar_string($datos['primernombre'], false);
        $parametros['MIDDLE_NAME'] = limpiar_string($datos['segundonombre'], false);
        $parametros['LAST_NAME'] = limpiar_string($datos['primerapellido'], false);
        $parametros['SECOND_LAST_NAME'] = limpiar_string($datos['segundoapellido'], false);
        $parametros['BIRTHDATE'] = $datos['fechanacimiento'];
        $parametros['BIRTHCOUNTRY'] = $datos['paisnacionalidad'];
        $parametros['BIRTHSTATE'] = $datos['departamentonacionalidad'];
        $parametros['BIRTHPLACE'] = $datos['ciudadnacionalidad'];
        $parametros['SEX'] = $datos['genero'];
        $parametros['MAR_STATUS'] = $datos['estadocivil'];
        $parametros['ADDRESS1'] = $datos['direccion'];

        if ($datos['direccion'] == null || trim($parametros['ADDRESS1']) == "") {
            $parametros['ADDRESS1'] = 'KR 7B BIS No. 132-11';
        }
        $parametros['PHONE'] = $datos['telefono'];
        $parametros['EMAIL_ADDR'] = $datos['email'];
        $parametros['BUSINESS_UNIT'] = 'UBSF0';
        $parametros['INVOICE_ID'] = $datos['numeroordenpago'];
        $parametros['INVOICE_DT'] = $datos['fechacreacion'];
        //$parametros['DUE_DT'] = $datos['fechavencimiento'];
        $parametros['DUE_DT'] = cambiafechaapeople($datos['fechavencimiento']);
        $parametros['TOTAL_BILL'] = $datos['totalordenpago'];
        $anio = substr($datos['periodo'], 2, 2);
        $mes = str_pad(substr($datos['periodo'], 4, strlen($datos['periodo'])), 2, 0, STR_PAD_LEFT);
        $parametros['STRM'] = $anio . $mes;

        if(isset($parametros['INVOICE_DT']) && !empty($parametros['INVOICE_DT'])) {
            $item_effective_dt = cambiafechaapeople($parametros['INVOICE_DT']);
        }else{
            $result['DESCRLONG'] = "Error de fecha de creacion - INVOICE_DT";
            $result['val'] = false;
            return $result;
        }

        //consulta tipo de cuenta de la orden para la carrera
        $query = "select tipocuenta from detalleordenpago dop "
            ." join carreraconceptopeople ccp on dop.codigoconcepto=ccp.codigoconcepto "
            ." where numeroordenpago='".$datos['numeroordenpago']."' "
            ." and ccp.codigocarrera in ('".$datos['codigocarrera']."', 1) group by tipocuenta";
        $exec = $db->GetAll($query);
        foreach ($exec as $row) {
            $arrTiposCuenta[] = $row['tipocuenta'];
        }

        $xml_det = "";
        $auxCreacionAporte = false;

        //si la orden tiene concepto de matricula
        if (in_array("MAT", $arrTiposCuenta)) {
            if(!isset($modulo) || empty($modulo)) {
                //Descuentos - valida concepto, agrega detalleordenpago y ajuste valores de xml
                $descuento = new Descuento($datos['numeroordenpago'], $datos['periodo'], $db);
                $descuento->descuentoMatricula();
                $parametros['TOTAL_BILL'] = $descuento->modificarTotalBill($parametros['TOTAL_BILL']);
                $itemConceptoPeople = $descuento->conceptoPeople('itemcarreraconceptopeople');
            }

            // VERIFICA SI LA ORDEN GENERADA TIENE CONCEPTOS ADICIONALES AL DE MATRICULA, DESCUENTOS O INCREMENTOS COMO
            // POR EJEMPLO (TEXTOS, CARNET, SALDO A FAVOR)
            $query = "SELECT COALESCE(ccp.itemcarreraconceptopeople,ccp2.itemcarreraconceptopeople) as itemcarreraconceptopeople ".
                " ,COALESCE(ccp.tipocuenta,ccp2.tipocuenta) as tipocuenta ,dop.valorconcepto ".
                " FROM detalleordenpago dop ".
                " LEFT JOIN carreraconceptopeople ccp ON (dop.codigoconcepto=ccp.codigoconcepto AND " .
                $datos['codigocarrera'] . "=ccp.codigocarrera )".
                " LEFT JOIN carreraconceptopeople ccp2 ON (dop.codigoconcepto=ccp2.codigoconcepto AND 1=ccp2.codigocarrera)".
                " JOIN concepto c ON dop.codigoconcepto=c.codigoconcepto ".
                " WHERE numeroordenpago='" . $datos['numeroordenpago'] . "' AND concat(trim(cuentaoperacionprincipal),".
                " trim(cuentaoperacionparcial)) not in ('1510001', '0590005', '1050002')";
            $exec = $db->GetAll($query);

            if (count($exec) == 0) {
                $query2 = "SELECT COALESCE(ccp.itemcarreraconceptopeople,ccp2.itemcarreraconceptopeople) as item_ccp " .
                    " ,COALESCE(ccp.tipocuenta,ccp2.tipocuenta) as tipocuenta, dop.valorconcepto AS vlr_dop " .
                    " ,sub.fechaordenpago,sub.valorfechaordenpago AS vlr_sub ,sub.itempagoextraordinario as item_sub, " .
                    " a.numeroordenpago as numeroaporte, dop.codigoconcepto, cp.cuentaoperacionprincipal" .
                    " FROM detalleordenpago dop " .
                    " left join concepto cp on cp.codigoconcepto = dop.codigoconcepto" .
                    " LEFT JOIN carreraconceptopeople ccp ON (dop.codigoconcepto=ccp.codigoconcepto and "
                    . $datos['codigocarrera'] . "=ccp.codigocarrera) " .
                    " LEFT JOIN carreraconceptopeople ccp2 ON (dop.codigoconcepto=ccp2.codigoconcepto AND 1=ccp2.codigocarrera) " .
                    " LEFT JOIN ( " .
                    " select distinct f.numeroordenpago, f.fechaordenpago, f.porcentajefechaordenpago, " .
                    " f.valorfechaordenpago, '010210020002' as itempagoextraordinario " .
                    " from fechaordenpago f where f.numeroordenpago='" . $datos['numeroordenpago'] . "' " .
                    " ) AS sub ON dop.numeroordenpago=sub.numeroordenpago " .
                    " LEFT JOIN AportesBecas a on a.numeroordenpago = dop.numeroordenpago " .
                    " WHERE dop.numeroordenpago='" . $datos['numeroordenpago'] . "' " .
                    " ORDER BY sub.fechaordenpago, 8 asc";
                $exec2 = $db->GetAll($query2);
                $valorCargoAdd = 0;

                $valor = 0;
                $valores = array();
                foreach ($exec2 as $row2) {
                    $extraordinario = false;
                    $account_type_sf = $row2['tipocuenta'];
                    //valida la fecha del concepto a pagar
                    if (isset($row2['fechaordenpago']) && !empty($row2['fechaordenpago'])) {
                        $due_dt2 = cambiafechaapeople($row2['fechaordenpago']);
                    } else {
                        $result['DESCRLONG'] = "Error de fecha de tipo cuenta - " . $row2['fechaordenpago'];
                        $result['val'] = false;
                        return $result;
                    }

                    //si el valor concepto es igual al valor fecha ordenpago o si el item es un item de descuento
                    if ($row2['vlr_dop'] == $row2['vlr_sub'] || $row2['item_ccp'] == $itemConceptoPeople) {
                        $item_type = $row2['item_ccp'];
                        $item_type_to = "";
                    } else {
                        //si el valor del concepto es mayor que el valor de la fecha
                        if ($row2['vlr_dop'] > $row2['vlr_sub']) {
                            $item_type = $row2['item_ccp'];
                            $item_type_to = "";
                        } else {
                            //si es un valor es diferente
                            $item_type = $row2['item_sub'];
                            $item_type_to = $row2['item_ccp'];
                        }
                    }

                    $item_nbr = "";
                    //si el valor de sub es mayor al de dop es un incremento y el valor de sub es mayor al valor de item
                    if (($row2['vlr_sub'] > $row2['vlr_dop']) && ($row2['vlr_sub'] > $valores[$due_dt2]['item_amt'])) {
                        //en caso de valores extra ordinarios debe enviar a people el valor adicional y no la sumatoria
                        $item_amt = $row2['vlr_sub'] - $row2['vlr_dop'];
                        $extraordinario = true;
                    } else {
                        //si el item es igual al del concepto de descuento
                        if ($row2['item_ccp'] == $itemConceptoPeople) {
                            $item_amt = $row2['vlr_sub'];
                        } else {
                            //si es un valor de matricula normal
                            $item_amt = $row2['vlr_dop'];
                        }
                    }

                    //si el concepto es matricula asigan los parametros en el array
                    if ($row2['codigoconcepto'] == '151') {
                        if ($extraordinario == true) {
                            $valores[$due_dt2 . "extra"] = array(
                                'item_type' => $item_type_to,
                                'item_type_to' => "",
                                'item_nbr' => $item_nbr,
                                'item_amt' => $row2['vlr_dop'],
                                'account_type_sf' => $account_type_sf,
                                'item_effective_dt' => $item_effective_dt,
                                'due_dt2' => $due_dt2);
                        }
                        $valores[$due_dt2] = array(
                            'item_type' => $item_type,
                            'item_type_to' => $item_type_to,
                            'item_nbr' => $item_nbr,
                            'item_amt' => $item_amt,
                            'account_type_sf' => $account_type_sf,
                            'item_effective_dt' => $item_effective_dt,
                            'due_dt2' => $due_dt2);
                    }

                    if ($extraordinario == false) {
                        //valida si el tipo de cuenta es un descuento para totalizar el valor de la matricula
                        //aplica para conceptos de becas
                        if ($row2['cuentaoperacionprincipal'] == '059' && isset($valores[$due_dt2])
                            && !isset($itemConceptoPeople)) {
                            //resta el valor del item del descuento al valor acumulado de de la matricula
                            $valores[$due_dt2]['item_amt'] = $valores[$due_dt2]['item_amt'] - $item_amt;
                        } else {
                            //si es concepto 059 y la fecha existe en el array y el concepto existe
                            if ($row2['cuentaoperacionprincipal'] == '059' && isset($valores[$due_dt2])
                                && isset($itemConceptoPeople)) {
                                //reasigna el valor del item de la matricula
                                $valores[$due_dt2]['item_amt'] = $item_amt;
                            }
                        }
                    }
                }//foreach            

                //asigna los parametros en el array
                foreach ($valores as $valor) {
                    $xml_det .= "	<UBI_ITEM_WRK>
                                    <ITEM_TYPE>{$valor['item_type']}</ITEM_TYPE>
                                    <ITEM_TYPE_TO>{$valor['item_type_to']}</ITEM_TYPE_TO>
                                    <ITEM_NBR>{$valor['item_nbr']}</ITEM_NBR>
                                    <ITEM_AMT>{$valor['item_amt']}</ITEM_AMT>
                                    <ACCOUNT_TYPE_SF>{$valor['account_type_sf']}</ACCOUNT_TYPE_SF>
                                    <ITEM_EFFECTIVE_DT>{$valor['item_effective_dt']}</ITEM_EFFECTIVE_DT>
                                    <DUE_DT2>{$valor['due_dt2']}</DUE_DT2>
                                </UBI_ITEM_WRK>";
                }
            }
            else {
                $items_excluir = "";
                $suma_items_excluir1 = 0;
                $suma_items_excluir2 = 0;
                foreach ($exec as $row ) {
                    // SI EL VALOR DE LOS CONCEPTOS ADICIONALES ES MENOR A CERO, SE TOMA COMO UN SALDO A FAVOR
                    if (!empty($row['itemcarreraconceptopeople'])) {
                        $items_excluir .= $row['itemcarreraconceptopeople'] . ",";
                    } else {
                        $items_excluir .= "";
                    }

                    if ($row['valorconcepto'] > 0) {
                        $auxCreacionAporte = true;
                        $suma_items_excluir2 += $row['valorconcepto'];
                        $item_type = $row['itemcarreraconceptopeople'];
                        $item_type_to = "";
                        $item_nbr = "";
                        $item_amt = $row['valorconcepto'];
                        $account_type_sf = $row['tipocuenta'];
                        if(isset($parametros['DUE_DT']) && !empty($parametros['DUE_DT'])) {
                            $due_dt2 = cambiafechaapeople($parametros['INVOICE_DT']);
                        }else{
                            $result['DESCRLONG'] = "Error de fecha de tipo cuenta - DUE_DT: ".$parametros['INVOICE_DT'];
                            $result['val'] = false;
                            return $result;
                        }

                        //se corrgie la fecha del aporte de semillas
                        //=============================
                        $fechaAporte = fechaordenpagodescuento($db, $datos['numeroordenpago']);
                        if(isset($fechaAporte) && !empty($fechaAporte)) {
                            $fechaAporte = cambiafechaapeople($fechaAporte);
                        }else{
                            $result['DESCRLONG'] = "Error de fecha de aporte - $fechaAporte";
                            $result['val'] = false;
                            return $result;
                        }
                        //=============================
                        $xml_det .= "<UBI_ITEM_WRK>
                            <ITEM_TYPE>$item_type</ITEM_TYPE>
                            <ITEM_TYPE_TO>$item_type_to</ITEM_TYPE_TO>
                            <ITEM_NBR>$item_nbr</ITEM_NBR>
                            <ITEM_AMT>$item_amt</ITEM_AMT>
                            <ACCOUNT_TYPE_SF>$account_type_sf</ACCOUNT_TYPE_SF>
                            <ITEM_EFFECTIVE_DT>$item_effective_dt</ITEM_EFFECTIVE_DT>
                            <DUE_DT2>$fechaAporte</DUE_DT2>
                        </UBI_ITEM_WRK>";
                    } else {
                        $suma_items_excluir1 += $row['valorconcepto'];
                    }
                }//foreach

                if (!empty($items_excluir)) {
                    $sqlitem = "NOT IN (" . trim($items_excluir, ',') . ")";
                } else {
                    $sqlitem = "";
                }

                //CONSULTA LOS CONCEPTOS DE MATRICULA DE LA ORDEN CREADA ORDENADOS POR CONCEPTO
                $query2 = "SELECT COALESCE(ccp.itemcarreraconceptopeople,ccp2.itemcarreraconceptopeople) AS item_ccp ".
                    " ,COALESCE(ccp.tipocuenta,ccp2.tipocuenta) AS tipocuenta, dop.valorconcepto AS vlr_dop ".
                    " ,sub.fechaordenpago ,dop.valorconcepto + " . abs($suma_items_excluir1) . " AS vlr_sub ".
                    " ,sub.itempagoextraordinario AS item_sub, dop.codigoconcepto, cp.cuentaoperacionprincipal".
                    " FROM detalleordenpago dop ".
                    " left join concepto cp on cp.codigoconcepto = dop.codigoconcepto".
                    " LEFT JOIN carreraconceptopeople ccp ON (dop.codigoconcepto=ccp.codigoconcepto and " .$datos['codigocarrera'] . "=ccp.codigocarrera) ".
                    " LEFT JOIN carreraconceptopeople ccp2 ON dop.codigoconcepto=ccp2.codigoconcepto AND 1=ccp2.codigocarrera ".
                    " LEFT JOIN (     select distinct f.numeroordenpago, f.fechaordenpago, f.porcentajefechaordenpago, ".
                    " f.valorfechaordenpago, '010210020002' as itempagoextraordinario".
                    " from fechaordenpago f ".
                    " where f.numeroordenpago='" . $datos['numeroordenpago'] . "' ".
                    " ) AS sub ON dop.numeroordenpago=sub.numeroordenpago ".
                    " WHERE dop.numeroordenpago='" . $datos['numeroordenpago'] . "' ".
                    " AND COALESCE(ccp.itemcarreraconceptopeople,ccp2.itemcarreraconceptopeople) " . $sqlitem . " ".
                    " ORDER BY sub.fechaordenpago, dop.codigoconcepto asc";
                $exec2 = $db->GetAll($query2);
                $valorCargoAdd = 0;

                $valor = 0;
                $valores = array();
                foreach ($exec2 as $row2) {
                    $vlrReal = $row2['vlr_sub'];
                    $account_type_sf = $row2['tipocuenta'];
                    if(isset($row2['fechaordenpago']) && !empty($row2['fechaordenpago'])) {
                        $due_dt2 = cambiafechaapeople($row2['fechaordenpago']);
                    }else{
                        $result['DESCRLONG'] = "Error de fecha de tipo cuenta - ".$row2['fechaordenpago'];
                        $result['val'] = false;
                        return $result;
                    }

                    if ($row2['vlr_dop'] == $vlrReal) {
                        $item_type = $row2['item_ccp'];
                        $item_type_to = "";
                        $suma_items_excluir2 = 0;
                    } else {
                        $item_type = $row2['item_sub'];
                        $item_type_to = $row2['|'];
                    }
                    $item_nbr = "";
                    $item_amt = $vlrReal;

                    //si el concepto es matricula asigan los parametros en el array
                    if($row2['codigoconcepto']== '151') {
                        //si la fecha no existe en el array define sis valores
                        if (!isset($valores[$due_dt2]) || empty($valores[$due_dt2])) {
                            $valores[$due_dt2] = array(
                                'item_type' => $item_type,
                                'item_type_to' => $item_type_to,
                                'item_nbr' => $item_nbr,
                                'item_amt' => $item_amt,
                                'account_type_sf' => $account_type_sf,
                                'item_effective_dt' => $item_effective_dt,
                                'due_dt2' => $due_dt2);
                        }
                    }

                    //valida si el tipo de cuenta es un descuento para totalizar el valor de la matricula
                    if($row2['cuentaoperacionprincipal'] == '059' && isset($valores[$due_dt2])){
                        //resta el valor del item del descuento al valor acumulado de de la matricula
                        $valores[$due_dt2]['item_amt'] = $valores[$due_dt2]['item_amt'] - $item_amt;
                    }
                }//foreach

                //asigna los parametros en el array y adiciona el valor neto del foreach anterior
                foreach($valores as $valoresfecha) {
                    $xml_det .= "	<UBI_ITEM_WRK>
                                    <ITEM_TYPE>{$valoresfecha['item_type']}</ITEM_TYPE>
                                    <ITEM_TYPE_TO>{$valoresfecha['item_type_to']}</ITEM_TYPE_TO>
                                    <ITEM_NBR>{$valoresfecha['item_nbr']}</ITEM_NBR>
                                    <ITEM_AMT>{$valoresfecha['item_amt']}</ITEM_AMT>
                                    <ACCOUNT_TYPE_SF>{$valoresfecha['account_type_sf']}</ACCOUNT_TYPE_SF>
                                    <ITEM_EFFECTIVE_DT>{$valoresfecha['item_effective_dt']}</ITEM_EFFECTIVE_DT>
                                    <DUE_DT2>{$valoresfecha['due_dt2']}</DUE_DT2>
                                </UBI_ITEM_WRK>";
                }
            }
        }
        elseif (in_array("PPA", $arrTiposCuenta)) {
            $parametros['UBI_OPERACION_ORD'] = 'F';
            $query = "select  COALESCE(ccp.itemcarreraconceptopeople,ccp2.itemcarreraconceptopeople) as itemcarreraconceptopeople ".
                " ,COALESCE(ccp.tipocuenta,ccp2.tipocuenta) as tipocuenta, dop.valorconcepto ,".
                " oppp.numerodocumentoplandepagosap as item_nbr from detalleordenpago dop ".
                " LEFT JOIN carreraconceptopeople ccp ON dop.codigoconcepto=ccp.codigoconcepto AND " .
                $datos['codigocarrera'] . "=ccp.codigocarrera".
                " LEFT JOIN carreraconceptopeople ccp2 ON dop.codigoconcepto=ccp2.codigoconcepto AND 1=ccp2.codigocarrera ".
                " join ordenpagoplandepago oppp on dop.numeroordenpago=oppp.numerorodencoutaplandepagosap and dop.codigoconcepto=oppp.cuentaxcobrarplandepagosap ".
                " WHERE numeroordenpago=" . $datos['numeroordenpago'];
            $exec = $db->GetAll($query);

            //ivan junio 17 pendiente por finalizar
            /*if(count($exec) ==  0){
               $sqlmatriculapadre = "select o.numeroordenpago from  ordenpago o ".
                " inner join detalleordenpago d on o.numeroordenpago = d.numeroordenpago and d.codigoconcepto = 151 ".
                " where o.codigoestudiante = ".$rowCodigo['codigoestudiante']." and o.codigoperiodo = ".$datos['periodo'];
                $matriculapadre = $db->GetRow($sqlmatriculapadre);

                if(isset($matriculapadre['numeroordenpago']) && !empty($matriculapadre['numeroordenpago'])){
                    $sqlinsert = "insert into ordenpagoplandepago (fechaordenpagoplandepago, ".
                    "numerodocumentoplandepagosap, numerorodenpagoplandepagosap, cuentaxcobrarplandepagosap, ".
                    " numerorodencoutaplandepagosap, codigoindicadorprocesosap, codigoestado) ".
                    " values ('".$datos['fechacreacion']."', '000000000000003','".$matriculapadre['numeroordenpago'].
                    "','C9013','".$datos['numeroordenpago']."', 100, 100)";
                }else{
                   // echo "no padre";
                }
            }*/
            if(count($exec)> 0) {
                foreach ($exec as $row) {
                    $item_type = $row['itemcarreraconceptopeople'];
                    $item_type_to = "";
                    $item_nbr = $row['item_nbr'];
                    $item_amt = $row['valorconcepto'];
                    $account_type_sf = $row['tipocuenta'];
                    if(isset($parametros['DUE_DT']) && !empty($parametros['DUE_DT'])) {
                        $due_dt2 = cambiafechaapeople($parametros['DUE_DT']);
                    }else{
                        $result['DESCRLONG'] = "Error de fecha de creacion - DUE_DT";
                        $result['val'] = false;
                        return $result;
                    }

                    $xml_det .= "	<UBI_ITEM_WRK>
                            <ITEM_TYPE>$item_type</ITEM_TYPE>
                            <ITEM_TYPE_TO>$item_type_to</ITEM_TYPE_TO>
                            <ITEM_NBR>$item_nbr</ITEM_NBR>
                            <ITEM_AMT>$item_amt</ITEM_AMT>
                            <ACCOUNT_TYPE_SF>$account_type_sf</ACCOUNT_TYPE_SF>
                            <ITEM_EFFECTIVE_DT>$item_effective_dt</ITEM_EFFECTIVE_DT>
                            <DUE_DT2>$due_dt2</DUE_DT2>
                            </UBI_ITEM_WRK>";
                }//foreach
            }else{
                $result['DESCRLONG'] = "sin registro en ordenpagoplandepago";
                $result['val'] = false;
                return $result;
            }
        }
        else {
            $sqlFechaOrdenPago="SELECT fechaordenpago  FROM ordenpago  WHERE  numeroordenpago=".$datos['numeroordenpago'];
            $execsqlFechaOrdenPago= $db->GetRow($sqlFechaOrdenPago);

            if($execsqlFechaOrdenPago['fechaordenpago'] <= '2020-09-17'){
                // SI LA CONSULTA RETORNA RESULTADOS ES PORQUE LA ORDEN ES POR CONCEPTO DE INSCRIPCION.
                $query = "select count(*) as conteo from detalleordenpago dop ".
                    " join concepto c on dop.codigoconcepto=c.codigoconcepto ".
                    " where numeroordenpago ='" . $datos['numeroordenpago'] . "' and cuentaoperacionprincipal='153' ".
                    " and cuentaoperacionparcial='0001'";
                $row = $db->GetRow($query);

                if ($row['conteo'] > 0) {
                    // PROCESO PARA DETERMINAR EL DUMMY AL QUE SE ASOCIARÁ LA ORDEN DE PAGO DE INSCRIPCIÓN
                    //************************************************************************************
                    $rowDummy = getDummy($db, $datos['numeroordenpago']);

                    if (!isset($rowDummy['idlogdummyintregracionps'])) {
                        $execPer = "select concat(substr(codigoperiodo,1,4),0,substr(codigoperiodo,5,1)) ".
                            " as codigoperiodo from periodo where codigoestadoperiodo=1";
                        $rowPer = $db->GetRow($execPer);
                        $NATIONAL_ID = "PER" . $rowPer["codigoperiodo"] . date("Ymd");
                        $cadenaDummy = "insert into logdummyintregracionps (dummy,contador,codigoestado,".
                            " numeroordenpagoinicial,numeroordenpagofinal) ".
                            " values ('" . $NATIONAL_ID . "',1,'100'," . $datos['numeroordenpago'] . ",9999999)";
                    } else {
                        if ($rowDummy["contador"] >= 799 && $rowDummy["codigoestado"] == 100) {
                            $cadenaDummy = "update logdummyintregracionps set contador=contador+1," .
                                " numeroordenpagofinal=" . $datos['numeroordenpago'] . ",codigoestado='200' " .
                                " where idlogdummyintregracionps=" . $rowDummy["idlogdummyintregracionps"];
                        }
                        else {
                            $cadenaDummy = "update logdummyintregracionps set contador=contador+1 " .
                                " where idlogdummyintregracionps=" . $rowDummy["idlogdummyintregracionps"];
                        }
                        $NATIONAL_ID = $rowDummy["dummy"];
                    }
                    $db->Execute($cadenaDummy);
                    //************************************************************************************
                    $parametros['INVOICE_ID'] = $_GET['numeroordenpago'];
                    $parametros['NATIONAL_ID_TYPE'] = 'CC';
                    $parametros['NATIONAL_ID'] = $NATIONAL_ID;
                    $parametros['FIRST_NAME'] = 'DUMMY';
                    $parametros['MIDDLE_NAME'] = 'DUMMY';
                    $parametros['LAST_NAME'] = $NATIONAL_ID;
                    $parametros['SECOND_LAST_NAME'] = $NATIONAL_ID;
                    $parametros['BIRTHDATE'] = '1900-01-01';
                    $parametros['BIRTHCOUNTRY'] = 'CO';
                    $parametros['BIRTHSTATE'] = '11';
                    $parametros['BIRTHPLACE'] = '11001';
                    $parametros['SEX'] = 'F';
                    $parametros['MAR_STATUS'] = 'S';
                    $parametros['ADDRESS1'] = 'KR 7B BIS No. 132-11';
                    $parametros['PHONE'] = '57 1 6331368';
                    $parametros['EMAIL_ADDR'] = 'dummy@unbosque.edu.co';
                    $parametros['INVOICE_ID'] = $datos['numeroordenpago'] . "-" . $datos['tipodocumento'] . $datos['documento'];
                }
            }

            $query2 = "SELECT COALESCE(ccp.itemcarreraconceptopeople,ccp2.itemcarreraconceptopeople) ".
                " as itemcarreraconceptopeople ,COALESCE(ccp.tipocuenta,ccp2.tipocuenta) as tipocuenta ".
                " ,dop.valorconcepto FROM detalleordenpago dop ".
                " LEFT JOIN carreraconceptopeople ccp ON dop.codigoconcepto=ccp.codigoconcepto AND " .
                $datos['codigocarrera'] . "=ccp.codigocarrera ".
                " LEFT JOIN carreraconceptopeople ccp2 ON dop.codigoconcepto=ccp2.codigoconcepto AND 1=ccp2.codigocarrera ".
                " WHERE numeroordenpago=" . $datos['numeroordenpago'];
            $exec2 = $db->GetAll($query2);

            foreach ($exec2 as $row2) {
                $item_type = $row2['itemcarreraconceptopeople'];
                $item_type_to = "";
                $item_nbr = "";
                $item_amt = $row2['valorconcepto'];
                $account_type_sf = $row2['tipocuenta'];
                if(isset($parametros['DUE_DT']) && !empty($parametros['DUE_DT'])) {
                    $due_dt2 = cambiafechaapeople($parametros['DUE_DT']);
                }else{
                    $result['DESCRLONG'] = "Error de fecha de tipo cuenta - DUE_DT";
                    $result['val'] = false;
                    return $result;
                }

                $xml_det .= "	<UBI_ITEM_WRK>
                                <ITEM_TYPE>$item_type</ITEM_TYPE>
                                <ITEM_TYPE_TO>$item_type_to</ITEM_TYPE_TO>
                                <ITEM_NBR>$item_nbr</ITEM_NBR>
                                <ITEM_AMT>$item_amt</ITEM_AMT>
                                <ACCOUNT_TYPE_SF>$account_type_sf</ACCOUNT_TYPE_SF>
                                <ITEM_EFFECTIVE_DT>$item_effective_dt</ITEM_EFFECTIVE_DT>
                                <DUE_DT2>$due_dt2</DUE_DT2>
                            </UBI_ITEM_WRK>";
            }
        }

        $rowAporte = getAportes($db, $datos['numeroordenpago']);

        if (isset($rowAporte['item_sub']) && !empty($rowAporte['item_sub']) && !$auxCreacionAporte) {
            //=============================
            $fechaAporte = fechaordenpagodescuento($db, $datos['numeroordenpago']);
            if(isset($fechaAporte) && !empty($fechaAporte)) {
                $fechaAporte = cambiafechaapeople($fechaAporte);
            }else{
                $result['DESCRLONG'] = "Error de fecha de aporte - $fechaAporte";
                $result['val'] = false;
                return $result;
            }
            //=============================

            if(isset($fechaAporte) && !empty($fechaAporte)) {
                $xml_det .= "<UBI_ITEM_WRK>
                    <ITEM_TYPE>{$rowAporte['item_sub']}</ITEM_TYPE>
                    <ITEM_TYPE_TO></ITEM_TYPE_TO>
                    <ITEM_NBR></ITEM_NBR>
                    <ITEM_AMT>{$rowAporte['valorpecuniario']}</ITEM_AMT>
                    <ACCOUNT_TYPE_SF>{$rowAporte['tipocuenta']}</ACCOUNT_TYPE_SF>
                    <ITEM_EFFECTIVE_DT>$item_effective_dt</ITEM_EFFECTIVE_DT>
                    <DUE_DT2>$fechaAporte</DUE_DT2>
                </UBI_ITEM_WRK>";
            }
        }

        if(isset($parametros['BIRTHDATE']) && !empty($parametros['BIRTHDATE'])) {
            $birthday = cambiafechaapeople($parametros['BIRTHDATE']);
        }else{
            $result['DESCRLONG'] = "Error de fecha de cumpleaños - BIRTHDATE";
            $result['val'] = false;
            return $result;
        }

        $xml = "<m:messageRequest xmlns:m=\"http://xmlns.oracle.com/Enterprise/Tools/schemas/UBI_CREA_ORDENPAG_REQ_MSG.VERSION_1\">
                <UBI_OPERACION_ORD>{$parametros['UBI_OPERACION_ORD']}</UBI_OPERACION_ORD>
                <NATIONAL_ID_TYPE>{$parametros['NATIONAL_ID_TYPE']}</NATIONAL_ID_TYPE>
                <NATIONAL_ID>{$parametros['NATIONAL_ID']}</NATIONAL_ID>
                <NATIONAL_ID_TYPE_OLD>{$parametros['NATIONAL_ID_TYPE_OLD']}</NATIONAL_ID_TYPE_OLD>
                <NATIONAL_ID_OLD>{$parametros['NATIONAL_ID_OLD']}</NATIONAL_ID_OLD>
                <FIRST_NAME>" . utf8_encode($parametros['FIRST_NAME']) . "</FIRST_NAME>
                <MIDDLE_NAME>" . utf8_encode($parametros['MIDDLE_NAME']) . "</MIDDLE_NAME>
                <LAST_NAME>" . utf8_encode($parametros['LAST_NAME']) . "</LAST_NAME>
                <SECOND_LAST_NAME>" . utf8_encode($parametros['SECOND_LAST_NAME']) . "</SECOND_LAST_NAME>
                <BIRTHDATE>$birthday</BIRTHDATE>
                <BIRTHCOUNTRY>{$parametros['BIRTHCOUNTRY']}</BIRTHCOUNTRY>
                <BIRTHSTATE>{$parametros['BIRTHSTATE']}</BIRTHSTATE>
                <BIRTHPLACE>{$parametros['BIRTHPLACE']}</BIRTHPLACE>
                <SEX>{$parametros['SEX']}</SEX>
                <MAR_STATUS>{$parametros['MAR_STATUS']}</MAR_STATUS>
                <ADDRESS1>" . utf8_encode($parametros['ADDRESS1']) . "</ADDRESS1>
                <PHONE>{$parametros['PHONE']}</PHONE>
                <EMAIL_ADDR>" . utf8_encode($parametros['EMAIL_ADDR']) . "</EMAIL_ADDR>
                <BUSINESS_UNIT>{$parametros['BUSINESS_UNIT']}</BUSINESS_UNIT>
                <INVOICE_ID>{$parametros['INVOICE_ID']}</INVOICE_ID>
                <INVOICE_DT>$item_effective_dt</INVOICE_DT>
                <DUE_DT1>{$parametros['DUE_DT']}</DUE_DT1>
                <TOTAL_BILL>{$parametros['TOTAL_BILL']}</TOTAL_BILL>
                <STRM>{$parametros['STRM']}</STRM>
                <UBI_ESTADO>I</UBI_ESTADO>
                <UBI_ITEMS_WRK>
                    " . $xml_det . "
                </UBI_ITEMS_WRK>
                </m:messageRequest>";

        if ($servicioPS) {
            if(!isset($client) || empty($client)){
                $client = new nusoap_client(WEBORDENDEPAGO, true, false, false, false, false, 0, 200);
            }
            $hayResultado = false;
            for ($i = 0; $i <= 5 && !$hayResultado; $i++) {
                // Envio de parametros por xml
                $start = time();
                $result = $client->call('UBI_CREA_ORDENPAG1_OPR_SRV', $xml);
                $soapError = $client->getError();
                $time = time() - $start;
                $envio = 1;
                if ($time >= 40 || $result === false) {
                    $envio = 0;
                    if ($i >= 5) {
                        reportarCaida(1, 'Creacion Orden Pago');
                        $result['ERRNUM'] = 0;
                    }
                } else {
                    $hayResultado = true;
                }
                sleep(3); // this should halt for 3 seconds for every loop
            }
        } else {
            //para que si la cree en SALA de todas formas
            $result['ERRNUM'] = 0;
        }

        $parametro = "id:".$result['ERRNUM']." descripcion: ".$result['DESCRLONG'];
        $transaccion= "Creacion Orden Pago";
        $log = new \Sala\entidadDAO\LogTraceIntegracionPsDAO();
        $log->setLog($datos['numeroordenpago'],$xml,$transaccion, $parametro, $envio);
    }
    else{
        $result['DESCRLONG'] = "datos incompletos";
        $result['val'] = false;
    }

    return $result;
}
function OtherOrdenes($db) {
    $SQL = "SELECT
                eg.numerodocumento,
                o.codigoestudiante,
                o.numeroordenpago,
                l.StaCode
            FROM ordenpago o
            INNER JOIN estudiante e ON e.codigoestudiante = o.codigoestudiante
            INNER JOIN estudiantegeneral eg ON eg.idestudiantegeneral = e.idestudiantegeneral
            INNER JOIN LogPagos l ON l.reference1 = o.numeroordenpago
            WHERE
                o.codigoestadoordenpago = 60
            AND l.SoliciteDate >=NOW()            
            GROUP BY o.numeroordenpago";
    if ($Data = $db->Execute($SQL) === false) {
        echo 'Error en el Sistema.....';
        die;
    }

    if (!$Data->EOF) {
        while (!$Data->EOF) {
            $Orden = $Data->fields['numeroordenpago'];
            $StadeCode = $Data->fields['StaCode'];
            switch ($StadeCode) {
                case 'NOT_AUTHORIZED': {
                    $SQL_1 = 'UPDATE `ordenpago` SET `codigoestadoordenpago`=10 WHERE `numeroordenpago`="' . $Orden . '"';
                    if ($Cambio = $db->Execute($SQL_1) === false) {
                        echo 'Error en el Sistema ....';
                        die;
                    }
                }break;
                case 'OK': {
                    $SQL_1 = 'UPDATE `ordenpago` SET `codigoestadoordenpago`=40 WHERE `numeroordenpago`="' . $Orden . '"';
                    if ($Cambio = $db->Execute($SQL_1) === false) {
                        echo 'Error en el Sistema ....';
                        die;
                    }
                }break;
            }//switch
            $Data->MoveNext();
        }//while
    }//if
}

//consulta de estados
function buscarOrdenesPSE($db) {
    $SQL = 'SELECT reference1 AS ordenpago, log.respuestalogtraceintegracionps '.
        ' FROM LogPagos l '.
        ' LEFT JOIN logtraceintegracionps log on log.documentologtraceintegracionps=l.Reference1 AND '.
        ' log.transaccionlogtraceintegracionps like "%PSE%" '.
        ' WHERE  solicitedate BETWEEN "' . date("Y") . '-' . date('m') . '-01" '.
        ' AND "' . date("Y") . '-' . date('m') . '-31 23:59:59" '.
        ' AND StaCode="OK" AND (log.documentologtraceintegracionps IS NULL '.
        ' OR log.respuestalogtraceintegracionps like "1 - No existe la Factura (Concepto) asociada al estudiante%") '.
        ' AND PaymentSystem<>100 GROUP BY Reference1 ORDER BY Reference1 DESC ';
    if ($Data = $db->Execute($SQL) === false) {
        echo 'Error en el SQL de Buscar Data...<br><br>' . $SQL;
        die;
    }

    if (!$Data->EOF) {
        return $Data;
    } else {
        return false;
    }
}
function buscarOrdenesAgentBank($db) {
    $SQL = 'SELECT * FROM (
                            SELECT
                            NumeroOrdenPago AS ordenpago,
                            TicketID,
                            NULL as respuestalogtraceintegracionps
                                FROM
                                    ColaNotificacionPagoPS c 
                                WHERE
                                    EstadoEnvio=0 
                                    GROUP BY NumeroOrdenPago
                            UNION
                            SELECT
                                NumeroOrdenPago AS ordenpago,
                                c.TicketID,
                                log.respuestalogtraceintegracionps
                            FROM
                                ColaNotificacionPagoPS c 
                            INNER JOIN logtraceintegracionps log on log.documentologtraceintegracionps=c.NumeroOrdenPago AND 
                            log.transaccionlogtraceintegracionps like "%AgentBank%" 
                            WHERE 
                                FechaRegistro BETWEEN "' . date("Y") . '-' . date('m') . '-01"
                                AND "' . date("Y") . '-' . date('m') . '-31 23:59:59" 
                            AND (log.respuestalogtraceintegracionps like "1 - No existe la Factura (Concepto) asociada al estudiante%")
                            AND c.EstadoEnvio<>0
                            GROUP BY NumeroOrdenPago
                        ) x 
                        GROUP BY x.ordenpago 
                        ORDER BY x.ordenpago DESC ';
    if ($Data = $db->Execute($SQL) === false) {
        echo 'Error en el SQL de Buscar Data...<br><br>' . $SQL;
        die;
    }

    if (!$Data->EOF) {
        return $Data;
    } else {
        return false;
    }
}
function buscarOrdenesEstadoMalo($db) {
    $SQL = 'SELECT
                        NumeroOrdenPago AS ordenpago,
                        TicketID
                    FROM
                        LogPagos c 
                        INNER JOIN ordenpago o on o.numeroordenpago=c.reference1 
                    WHERE
                        solicitedate BETWEEN "' . date("Y") . '-' . date('m') . '-01"
                        AND "' . date("Y") . '-' . date('m') . '-31 23:59:59" 
                    AND StaCode="OK" 
                        AND o.codigoestadoordenpago=10 
                    GROUP BY NumeroOrdenPago';

    if ($Data = $db->Execute($SQL) === false) {
        echo 'Error en el SQL de Buscar Data...<br><br>';
        die;
    }

    if (!$Data->EOF) {
        return $Data;
    } else {
        return false;
    }
}
function fechaordenpagodescuento($db, $orden){
    $sql = "SELECT fechaordenpago from fechaordenpago where numeroordenpago = ".$orden." ".
        "order by fechaordenpago desc limit 1";
    $row = $db->GetRow($sql);
    if(isset($row['fechaordenpago']) && !empty($row['fechaordenpago'])){
        return $row['fechaordenpago'];
    }
}
function ValidacionTrace($db, $orden) {
    $SQL_n = "SELECT l.documentologtraceintegracionps FROM logtraceintegracionps l ".
        " WHERE l.documentologtraceintegracionps = '" . $orden . "' ".
        " AND l.transaccionlogtraceintegracionps = 'Pago Caja-Bancos' ".
        " AND SUBSTR(l.respuestalogtraceintegracionps,1,8)='ERRNUM=0'";
    $ValidacionLog = $db->GetRow($SQL_n);

    if (!isset($ValidacionLog['documentologtraceintegracionps']) || empty($ValidacionLog['documentologtraceintegracionps'])) {
        $ValidacionLogTrace = false;
    } else {
        $ValidacionLogTrace = true;
    }
    $ValidacionLogTrace = true;
    return $ValidacionLogTrace;
}

//cambios de estados
function Anular($db, $xml, $id, $numeroorden) {
    $client = new nusoap_client(WEBORDENDEPAGO, true, false, false, false, false, 0, 100);
    $start = time();
    $result = $client->call('UBI_CREA_ORDENPAG1_OPR_SRV', $xml);
    $soapError = $client->getError();
    $time = time() - $start;
    $parametro = 'id:' . $result['ERRNUM'] . ' descripcion:' . $result['DESCRLONG'];

    //si no la puede anular en people, la vuelve a activar en SALA
    if ($result['ERRNUM'] != 0) {
        $orden = new \Sala\entidadDAO\OrdenPagoDAO();
        $orden->update($numeroorden,'10');
    }

    $msg = ActualizarEstudiante($parametro, $id);
    if(isset($result['DESCRLONG'])) {
        $result['DESCRLONG'] .= $msg;
    }else{
        $result['DESCRLONG'] = $msg;
    }
    return $result;
}
function PagosPSE($db, $param2, $id, $estado) {
    if (verificarInformaPSE()) {
        $client = new nusoap_client(WEBREPORTAPAGOPSE, true, false, false, false, false, 0, 200);
        $result = $client->call('UBI_PAGO_PSE_OPR_SRV', $param2);
        $parametro = $result['detail']['IBResponse']['DefaultMessage'];

        if($estado == 'Update'){
            $msg = ActualizarEstudiante($parametro, $id);
        }
        if($estado == 'Create'){
            $msg = CreacionSQL($db, $param2, $parametro, $id);
        }
        if(isset($result['DESCRLONG'])) {
            $result['DESCRLONG'] .= $msg;
        }else{
            $result['DESCRLONG'] = $msg;
        }

        return $result;
    }
}
function ActualizarEstudiante($xml, $id) {
    $client = new nusoap_client(WEBORDENDEPAGO, true, false, false, false, false, 0, 200);
    $result = $client->call('UBI_CREA_ORDENPAG1_OPR_SRV', $xml);
    $parametro = 'id:' . $result['ERRNUM'] . ' descripcion:' . $result['DESCRLONG'];
    $log = new \Sala\entidadDAO\LogTraceIntegracionPsDAO();
    $log->update($parametro, $id);
    $msg = "Registro actualizado";
    return $msg;
}
function AplicarPagoSala($db, $detalleOrden){
    $result = "";
    //valida si la orden esta pagada
    if($detalleOrden['codigoestadoordenpago']==40 || $detalleOrden['codigoestadoordenpago']==41){
        //si el id de prematricula es diferente a 1
        if($detalleOrden['idprematricula'] != '1'){
            $sqlpremtraicula = "select codigoestadoprematricula from prematricula where idprematricula = '".$detalleOrden['idprematricula']."'";
            $estadoprematricula = $db->GetRow($sqlpremtraicula);

            if($estadoprematricula['codigoestadoprematricula'] == '10' || $estadoprematricula['codigoestadoprematricula'] == '30'){
                $preMatricula = new \Sala\entidadDAO\PrematriculaDAO();
                $preMatricula->update($detalleOrden['idprematricula'], 40);
                $result.= "Prematricula Actualizada ";
                $estadoprematricula['codigoestadoprematricula'] = '40';
            }

            if($estadoprematricula['codigoestadoprematricula'] == '40' || $estadoprematricula['codigoestadoprematricula'] == '41'){
                //si el detalleprematricula esta pagado
                $sqldetalleprematricula = "select idDetallePrematricula, codigoestadodetalleprematricula from detalleprematricula ".
                    " where idprematricula = '".$detalleOrden['idprematricula']."' and numeroordenpago =".$db->qstr($detalleOrden['numeroordenpago']);
                $materias = $db->GetAll($sqldetalleprematricula);
                foreach($materias as $materia){
                    //valida si la materia esta activa
                    if($materia['codigoestadodetalleprematricula'] == '10'){
                        //matricula la materia
                        $detalleprematricula = new \Sala\entidadDAO\DetallePrematriculaDAO();
                        $detalleprematricula->update($detalleOrden['numeroordenpago'],30, $detalleOrden['idprematricula'], 10, null, $materia['idDetallePrematricula']);
                        $result.= " - Detalleprematricula :".$materia['idDetallePrematricula']." ";
                    }
                }//foreach
            }//if
            else{
                $result.= "codigoestadoprematricula ".$estadoprematricula['codigoestadoprematricula'] ;
            }
        }//if
        else{
            $result.= "idprematricula = 1 ";
        }
    }//if
    return $result;
}
function ActualizarCarga($db, $orden, $codigoestudiante, $idprematricula){
    //busca la carga academica del estudiante, para esa matricula en ordenes diferentes ya existentes del mismo estudiante
    $slqdetalleprematricula = "select d.numeroordenpago, d.codigomateria, d.idgrupo, ".
        " d.codigoestadodetalleprematricula from ordenpago o ".
        " left join detalleprematricula d on (o.idprematricula = d.idprematricula and d.codigoestadodetalleprematricula in (10, 30)) ".
        " where o.idprematricula = $idprematricula and o.codigoestudiante = $codigoestudiante ".
        " and d.numeroordenpago not in (".$orden.")";
    $materias = $db->GetAll($slqdetalleprematricula);

    //conteo de ordenes con carga academica
    if(count($materias)> 0) {
        $i = 0;
        foreach ($materias as $materia) {
            if(isset($materia['numeroordenpago']) && !empty($materia['numeroordenpago'])){
                $sqlupdate = "update detalleprematricula set numeroordenpago = $orden  " .
                    " where idprematricula = $idprematricula and numeroordenpago = ".$materia['numeroordenpago']." " .
                    " and codigomateria = '" . $materia['codigomateria'] . "' ";
                $db->Execute($sqlupdate);

                $detallepre = new \Sala\entidadDAO\DetallePrematriculaDAO();
                $detallepre->update($orden, '30', $idprematricula,
                    $materia['codigoestadodetalleprematricula'], $materia['codigomateria']);
                $i=1;
            }//if
        }//foreach
        if($i==1){
            return "Detalleprematricula actualizada";
        }
    }else{
        //si la carga academica no esta en otras ordenes
        //Se valida si esta inactiva o anulada para la orden ya pagada
        $sqlvalidar = "select codigoestadodetalleprematricula from detalleprematricula ".
            " where numeroordenpago = ".$orden." and idprematricula = ".$idprematricula." ";
        $estadodetalle = $db->GetAll($sqlvalidar);

        $k =0;
        foreach($estadodetalle as $estados){
            //si existe la carga y se encuentra en un estado diferernte a pagada
            if(isset($estados['codigoestadodetalleprematricula']) && !empty($estados['codigoestadodetalleprematricula'])){
                if($estados['codigoestadodetalleprematricula'] != '30'){
                    //actualiza la carga academica a pagada
                    $detallepre = new \Sala\entidadDAO\DetallePrematriculaDAO();
                    $detallepre->update($orden, '30', $idprematricula, $estados['codigoestadodetalleprematricula']);
                    $k=1;
                }
            }else{
                return "Sin carga academida existente, se debe crear la carga nuevamente";
            }
        }//foreach

        if($k==1){
            return "Detalleprematricula actualizada";
        }
    }

}

//ColaNotificacionPagoPS
function updateColaNotificacion($db, $numeroorden, $result){
    $query_logps = "UPDATE ColaNotificacionPagoPS SET EstadoEnvio='1', ResultadoNotificacion='".$result."' ".
        " WHERE NumeroOrdenPago='" . $numeroorden . "' ";
    $db->Execute($query_logps);
}

//conceptos
function getAportes($db, $ordenpago){
    $queryAporte = "SELECT ccp.itemcarreraconceptopeople as item_sub, ccp.tipocuenta, v.valorpecuniario ".
        " FROM AportesBecas a ".
        " LEFT JOIN valorpecuniario v ON v.idvalorpecuniario = a.idvalorpecuniario ".
        " LEFT JOIN carreraconceptopeople ccp ON ccp.codigoconcepto = v.codigoconcepto ".
        " WHERE a.numeroordenpago = ' ". $ordenpago . "' LIMIT 1";
    $rowAporte = $db->GetRow($queryAporte);
    return $rowAporte;
}

//busqueda de estado
function estudianteOrden($db, $numeroorden, $modulo=null, $idgrupo=null){
    $query_data = "SELECT DISTINCT eg.idestudiantegeneral, doc.codigodocumentopeople  as tipodocumento, ".
        " eg.numerodocumento as documento, ".
        " case  when locate(' ', trim(apellidosestudiantegeneral)) = 0 then trim(apellidosestudiantegeneral) ".
        " else substring(trim(apellidosestudiantegeneral), 1, ".
        " locate(' ', trim(apellidosestudiantegeneral))) end as primerapellido, ".
        " case  when locate(' ', trim(apellidosestudiantegeneral)) = 0 then '' ".
        " else substring(trim(apellidosestudiantegeneral) from ".
        " locate(' ', trim(apellidosestudiantegeneral))) end as segundoapellido, ".
        " case when locate(' ', trim(nombresestudiantegeneral)) = 0 then trim(nombresestudiantegeneral) ".
        " else substring(trim(nombresestudiantegeneral), 1, ".
        " locate(' ', trim(nombresestudiantegeneral))) end   as primernombre, ".
        " case  when locate(' ', trim(nombresestudiantegeneral)) = 0 then '' ".
        " else substring(trim(nombresestudiantegeneral)".
        " from ".
        " locate(' ', trim(nombresestudiantegeneral))) end   as segundonombre, ".
        " direccionresidenciaestudiantegeneral as direccion, ".
        " e.codigocarrera as codigocarrera, doc.codigodocumentopeople, sp.codigopeoplesexo as genero, ".
        " eg.celularestudiantegeneral, ciu.nombreciudad  as ciudadnacionalidad, ".
        " pai.codigosappais as paisnacionalidad, dep.codigosapdepartamento  as departamentonacionalidad, ".
        " ciu.codigosapciudad, prema.semestreprematricula,  telefonoresidenciaestudiantegeneral  as telefono, ".
        " emailestudiantegeneral as email, c.codigoconcepto, dop.valorconcepto, s.fechainiciofinancierosubperiodo, ".
        " s.fechafinalfinancierosubperiodo, cuentaoperacionprincipal, cuentaoperacionparcial, ".
        " fechanacimientoestudiantegeneral as fechanacimiento, valorfechaordenpago, ".
        " o.codigoperiodo  as periodo, o.numeroordenpago as numeroordenpago, e.codigoestudiante, ".
        " ecp.codigoestadocivilpeople  as estadocivil, o.fechaordenpago  as fechacreacion, ".
        " f.fechaordenpago as fechavencimiento, f.valorfechaordenpago as totalordenpago, ".
        " dop.codigotipodetalleordenpago ".
        " FROM ordenpago o ".
        " INNER JOIN estudiante e on  e.codigoestudiante = o.codigoestudiante ".
        " INNER JOIN estudiantegeneral eg on eg.idestudiantegeneral=e.idestudiantegeneral ".
        " INNER JOIN detalleordenpago dop on o.numeroordenpago = dop.numeroordenpago ".
        " INNER JOIN fechaordenpago f on f.numeroordenpago = dop.numeroordenpago ".
        " INNER JOIN concepto c on dop.codigoconcepto = c.codigoconcepto ".
        " INNER JOIN subperiodo s on o.idsubperiododestino = s.idsubperiodo ".
        " INNER JOIN documentopeople doc on doc.tipodocumentosala = eg.tipodocumento ".
        " INNER JOIN prematricula prema on prema.idprematricula = o.idprematricula ".
        " INNER JOIN estadocivilpeople ecp on eg.idestadocivil = ecp.idestadocivil ".
        " INNER JOIN sexopeople sp on eg.codigogenero=sp.codigosexo ".
        " LEFT JOIN ciudad ciu on ciu.idciudad = eg.ciudadresidenciaestudiantegeneral ".
        " LEFT JOIN departamento dep on  ciu.iddepartamento = dep.iddepartamento".
        " LEFT JOIN pais pai on dep.idpais = pai.idpais WHERE o.numeroordenpago =  $numeroorden  limit 1";
    $datos = $db->GetRow($query_data);
    if (isset($datos['idestudiantegeneral']) && !empty($datos['idestudiantegeneral'])) {
        $sqlfechaordenpago = "select f.numeroordenpago from fechaordenpago f ".
            " where f.numeroordenpago =$numeroorden";
        $fechaorden = $db->GetRow($sqlfechaordenpago);
        if (!isset($fechaorden['numeroordenpago']) || empty($fechaorden['numeroordenpago'])) {
            $result['DESCRLONG'] = "datos incompletos, No cuenta con fecha la orden pago";
            $result['val'] = false;
            return $result;
        }else{
            $result= reportarCreacionPeople($db, $datos, $modulo, $idgrupo);
            if (isset($result) && !empty($result)) {
                return $result;
            } else {
                $result['DESCRLONG'] = "Sin datos en resultado";
                return $result;
            }
        }
    } else {
        $msg = "";
        $sqldetalleordenpago = "select d.numeroordenpago from detalleordenpago d ".
            " where d.numeroordenpago =$numeroorden";
        $detalleorden = $db->GetRow($sqldetalleordenpago);
        if (!isset($detalleorden['numeroordenpago']) || empty($detalleorden['numeroordenpago'])) {
            $msg.= " No cuenta con detalle la orden pago / ";
        }

        $sqlprematricula = "select o.numeroordenpago from prematricula p ".
            " inner join ordenpago o on p.idprematricula = o.idprematricula".
            " where o.numeroordenpago =$numeroorden";
        $prematricula = $db->GetRow($sqlprematricula);
        if (!isset($prematricula['numeroordenpago']) || empty($prematricula['numeroordenpago'])) {
            $msg.= " No cuenta con prematricula definida / ";
        }

        $sqlfechaordenpago = "select f.numeroordenpago from fechaordenpago f ".
            " where f.numeroordenpago =$numeroorden";
        $fechaorden = $db->GetRow($sqlfechaordenpago);
        if (!isset($fechaorden['numeroordenpago']) || empty($fechaorden['numeroordenpago'])) {
            $msg.= " No cuenta con fecha la orden pago / ";
        }

        $result['DESCRLONG'] = "datos incompletos, $msg ";
        $result['val'] = false;
        return $result;
    }
}
function getDummy($db, $numeroorden){
    if(isset($numeroorden) && !empty($numeroorden)){
        $execDummy = "select dummy, idlogdummyintregracionps, contador, codigoestado from logdummyintregracionps where ".$numeroorden." ".
            " between numeroordenpagoinicial and numeroordenpagofinal";
        $rowDummy = $db->GetRow($execDummy);
        return $rowDummy;
    }
}

function getXML($accion, $datos=null){
    if(isset($accion) && !empty($accion)){
        switch($accion){
            case 'EstadoCuenta':{
                $param2 = "<UB_DATOSCONS_WK>
                          <NATIONAL_ID_TYPE>CC</NATIONAL_ID_TYPE>
                          <NATIONAL_ID>1070944994</NATIONAL_ID>
                          <DEPTID></DEPTID>		 
                        </UB_DATOSCONS_WK>";
            }break;
            case 'PagoPse':{
                $param2 = "<UB_INFOPAGO_WK><NATIONAL_ID_TYPE>".$datos['NATIONAL_ID_TYPE']."</NATIONAL_ID_TYPE>".
                    "<NATIONAL_ID>".$datos['NATIONAL_ID']."</NATIONAL_ID>".
                    "<INVOICE_ID>".$datos['INVOICE_ID']."</INVOICE_ID> ".
                    "<ACCOUNT_TYPE_SF>".$datos['ACCOUNT_TYPE_SF']."</ACCOUNT_TYPE_SF> ".
                    "<ITEM_TYPE>".$datos['ITEM_TYPE']."</ITEM_TYPE> ".
                    "<PAYMENT_METHOD>".$datos['PAYMENT_METHOD']."</PAYMENT_METHOD> ".
                    "<ITEM_AMT>".$datos['ITEM_AMT']."</ITEM_AMT>".
                    "<ITEM_EFFECTIVE_DT>".$datos['ITEM_EFFECTIVE_DT']."</ITEM_EFFECTIVE_DT>".
                    "</UB_INFOPAGO_WK>";
            }break;
            case 'Aporte':{}break;
            case '':{}break;
        }
        return $param2;
    }
}

//limpieza de variables
function limpiar_string($string) {
    $string = trim($string);
    $string = str_replace( array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'), array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'), $string);
    $string = str_replace( array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'), array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'), $string);
    $string = str_replace( array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'), array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'), $string);
    $string = str_replace( array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'), array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'), $string);
    $string = str_replace( array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'), array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'), $string);
    $string = str_replace( array('ñ', 'Ñ', 'ç', 'Ç'), array('n', 'N', 'c', 'C',), $string);
    return $string;
}
function tipo_documento($tipo) {
    $td ="";
    switch ($tipo) {
        case '01': $td='CC';break;
        case '02': $td='TI';break;
        case '03': $td='CE';break;
        case '04': $td='RC';break;
        case '05': $td='PS';break;
        case '06': $td='NI';break;
        case '07': $td='NI';break;
        case '08': $td='NI';break;
        case '09': $td='NI';break;
        case '10': $td='NI';break;
        case '11': $td='NI';break;
        case '12': $td='NI';break;
    }
    return $td;
}
function genero($gen) {
    return ($gen==100)?'02':'01';
}

function EnvioColaPagoPeople($numeroorden, $tiketid){

    $colaNotificacionPago = new \Sala\entidadDAO\ColaNotificacionPagoPsDAO();
    $banderaEnvioPeople = $colaNotificacionPago->getOrderInProcess($numeroorden);

    if($banderaEnvioPeople == 0)
    {
        $colaNotificacionobj = new \ColaNotificacionPagoPs();
        $colaNotificacionobj->setNumeroOrdenPago($numeroorden);
        $colaNotificacionobj->setTicketId($tiketid);
        $colaNotificacionobj->setEstadoEnvio(1);
        $colaNotificacionobj->setResultadoNotificacion(1);
        $colaNotificacionobj->setProcesoEnvio(1);
        $colaNotificacionobj->setResultadoProcesoEnvio(1);

        $colaNotificacionPagoDAO = new \Sala\entidadDAO\ColaNotificacionPagoPsDAO($colaNotificacionobj);
        $colaNotificacionPagoDAO->save(); 
        $idColaNotificacion = $colaNotificacionobj->getIdColaNotificacionPagoPS();

        return $idColaNotificacion;
        
    }elseif($banderaEnvioPeople == 1){

        $colaObtenerId= new \Sala\entidadDAO\ColaNotificacionPagoPsDAO();;
        $idColaNotificacion = $colaObtenerId->getIdColaByOrderNumber($numeroorden);
        
        $colaNotificacionobj = new \ColaNotificacionPagoPs();
        $colaNotificacionobj->setProcesoEnvio(1);
        $colaNotificacionobj->setResultadoProcesoEnvio(1);
        $colaNotificacionobj->setIdColaNotificacionPagoPS($idColaNotificacion);
       
        $colaNotificacionPagoDAO = new \Sala\entidadDAO\ColaNotificacionPagoPsDAO($colaNotificacionobj);
        $colaNotificacionPagoDAO->update();

        return $idColaNotificacion;

    }else{
        
        return false;
    }
}

function ActualizacionEnvioColaPagoPeople($numeroorden,$procesoenvio, $resultadoprocesoenvio,$idcolanotificacion){

    $colaNotificacionobj = new \ColaNotificacionPagoPs();
    $colaNotificacionobj->setProcesoEnvio($procesoenvio);
    $colaNotificacionobj->setResultadoProcesoEnvio($resultadoprocesoenvio);
    $colaNotificacionobj->setIdColaNotificacionPagoPS($idcolanotificacion);

    $colaNotificacionPagoDAO = new \Sala\entidadDAO\ColaNotificacionPagoPsDAO($colaNotificacionobj);
    $colaNotificacionPagoDAO->update();
}