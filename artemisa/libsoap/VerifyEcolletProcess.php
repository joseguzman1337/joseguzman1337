<?php
require_once(dirname(__FILE__) . '/../nusoap/lib/nusoap.php');
require_once(dirname(__FILE__) . "/../serviciosacademicos/Connections/conexionECollect.php");
require_once(dirname(__FILE__) . "/../sala/esquemaComposer/vendor/autoload.php");
require_once(dirname(__FILE__) . '/controladorFunciones.php');

require_once(dirname(__FILE__) . "/../serviciosacademicos/consulta/interfacespeople/informacionpagosalasf/informa_pago_sala_sf.php");

/**
 * Class VerifyEcolletProcess
 * @author Jesus Jimenez
 */
class VerifyEcolletProcess
{

    private $db;
    private $controlador;
    private $pagosalasf;
    private $result;
    private $initialStaCode;
    /**
     * @var
     * activar el seguimiento de codigo
     */
    private $trace;

    const ENTITY_CODE = "10017";
    const PAYMENT_SYSTEM = "0";
    const USER_TYPE = "1";
    const SRV_CODE = "10001";

    /*
        *  ReturnCode
        */
    const RC_SUCCESS = 'SUCCESS';
    const RC_FAIL_INVALIDTICKETID = 'FAIL_INVALIDTICKETID';
    const RC_FAIL_INVALIDENTITYCODE = 'FAIL_INVALIDENTITYCODE';
    const RC_FAIL_TICKETIDNOTFOUND = 'FAIL_TICKETIDNOTFOUND';
    /*
     * TranState
     */
    const TRAN_STATE_OK = 'OK';
    const TRAN_STATE_NA = 'NOT_AUTHORIZED';
    const TRAN_STATE_EX = 'EXPIRED';
    const TRAN_STATE_FA = 'FAILED';
    const TRAN_STATE_BP = 'BANK';
    const TRAN_STATE_PEND = 'PENDING';
    const TRAN_STATE_PEND_BANK = 'BANK PENDING';
    const TRAN_STATE_CREATED = 'CREATED';
    /**
     * @var array
     */
    private $codsEstadoOrdenPago = array(10, 11, 60, 61);
    private $codsEstadoOrdenPago2 = array(40, 41, 44, 51, 52);
    #variable para logs trace de codigo
    private $responseProcess = array('status' => null, 'message' => null, 'descriptionTec' => null, 'trace' => array('valids' => array()));

    public function __construct($databaseConect, $row, $c, $trace = null)
    {
        $this->trace = $trace;
        $this->db = $databaseConect;
        $this->controlador = new controladorFunciones();
        $this->pagosalasf = new pagosalasf();

        $this->dispararServicio($row, $c);
        $this->returnLog();

    }


    //funcion que inicia el proceso de actualizacion de la orden
    public function dispararServicio($row, $c)
    {
        //Declara la clase del servicio
        $client = new nusoap_client(WEBSERVICEPSE, true);
        $fecha = date("d-m-Y");
        //Asignacion de resultados de error del cliente
        $err = $client->getError();

        if ($err) {

            $this->lineTrace(__LINE__, true, "trace");

            echo "<td>" . $err . "</td></tr>";
            $c++;
        }

        //Parametros de envio
        $param = array("request" => array('EntityCode' => self::ENTITY_CODE, 'TicketId' => $row['TicketId']));
        //Asignacion de resultado de informacion de la transaccion usando el ticketid
        $resultado = $client->call('getTransactionInformation', $param);
        $this->initialStaCode = $this->controlador->estadolog($this->db, $row["Reference1"], $row['TicketId']);
        //SE ASIGNAS LOS RESULTADOS DE RESPUESTA DEL METODO DEL WEBSERVICE
        if (isset($resultado["getTransactionInformationResult"]) && !is_null($resultado["getTransactionInformationResult"]["TranState"])) {

            $this->lineTrace(__LINE__, true, "trace");

            $result['Reference1'] = $row["Reference1"];
            $result['Reference2'] = $row["Reference2"];
            $result['Reference3'] = $row["Reference3"];
            $result['TranState'] = $resultado["getTransactionInformationResult"]['TranState'];
            $result['ReturnCode'] = $resultado["getTransactionInformationResult"]['ReturnCode'];
            $result['BankProcessDate'] = $resultado["getTransactionInformationResult"]['BankProcessDate'];
            $result['BankName'] = $resultado["getTransactionInformationResult"]['BankName'];
            $result['TrazabilityCode'] = $resultado["getTransactionInformationResult"]['TrazabilityCode'];
            $result['TransValue'] = $resultado["getTransactionInformationResult"]['TransValue'];
            $result['TicketId'] = $row['TicketId'];

        } else {

            $this->lineTrace(__LINE__, false, "trace");

            $result['Reference1'] = $row["Reference1"];
            $result['Reference2'] = $row["Reference2"];
            $result['Reference3'] = $row["Reference3"];
            $result['TranState'] = $this->whitoutResponseWs();
            $result['ReturnCode'] = $this->whitoutResponseWs();
            $result['BankProcessDate'] = $this->whitoutResponseWs();
            $result['BankName'] = $this->whitoutResponseWs();
            $result['TrazabilityCode'] = $this->whitoutResponseWs();
            $result['TransValue'] = $this->whitoutResponseWs();
            $result['TicketId'] = $row['TicketId'];
        }

        $this->result = $result;
        //VARIABLE DE CICLO DEL PROCESO
        $sigue = 0;
        if (!in_array($result['TranState'], array(self::TRAN_STATE_BP, self::TRAN_STATE_OK))
            || $result['TranState'] == ""
            || $result['TranState'] == null) {
            $this->lineTrace(__LINE__, true, "trace");
            $sigue = 1;
        }
        //si el valor es negativo
        if ($sigue == 1) {
            $this->lineTrace(__LINE__, true, "trace");
            #valida si el web service respondio.
            if (isset($resultado["getTransactionInformationResult"]) && !is_null($resultado["getTransactionInformationResult"]["TranState"])) {
                $this->lineTrace(__LINE__, true, "trace");
                //si el codigo de retorno es fallido por no identificacion
                if ($result['ReturnCode'] != self::RC_SUCCESS) {

                    $this->lineTrace(__LINE__, true, "trace");

                    echo "<td>" . $result['ReturnCode'] . " <br> ";
                    //valida que la orden esta pagada en la anterior pasarela de pagos
                    $listadoorden = $this->controlador->ordenpagada($this->db, $result['Reference1']);
                    $fallo = '1';
                    if (count($listadoorden) > 0) {

                        $this->lineTrace(__LINE__, true, "trace");

                        foreach ($listadoorden as $estadoorden) {
                            //si los datos estan pagados
                            if ($estadoorden['StaCode'] == self::TRAN_STATE_OK) {

                                $this->lineTrace(__LINE__, true, "trace");

                                //consulta el mensaje por medio del estado
                                $strMensaje = $this->controlador->ReturnCodeDesc($estadoorden['StaCode'], $result['Reference1'], $row['TicketId'], '1');
                                echo $strMensaje . " - ";
                                //valida si la orden esta pendiente de pagar o activa
                                if (in_array($estadoorden['codigoestadoordenpago'], $this->codsEstadoOrdenPago)) {

                                    $this->lineTrace(__LINE__, true, "trace");

                                    $digitoorden = substr($estadoorden['codigoestadoordenpago'], 1);
                                    $queryTrace = $this->controlador->updateEstadoPago($this->db, $result['Reference1'], $digitoorden, '4');
                                    $this->lineTrace(__LINE__, $queryTrace, "query");
                                    $queryTrace = $this->controlador->updateFechaPagoU($this->db, $estadoorden['TicketId']);
                                    $this->lineTrace(__LINE__, $queryTrace, "query");
                                }
                                $fallo = '0';
                            }//ok
                            else {
                                $this->lineTrace(__LINE__, false, "trace");
                                #si stacode es igual a [PENDIENTE , CREADO, BANCO]
                                if (in_array($estadoorden['StaCode'], array(self::TRAN_STATE_PEND, self::TRAN_STATE_CREATED, self::TRAN_STATE_BP, self::TRAN_STATE_PEND_BANK))) {
                                    $this->lineTrace(__LINE__, true, "trace");
                                    $queryTrace = $this->controlador->updatePagoLog($this->db, $row['TicketId'], $result['Reference1'], self::TRAN_STATE_EX, $result['BankProcessDate'], $result['BankName'], $result['TrazabilityCode']);
                                    $this->lineTrace(__LINE__, $queryTrace, "query");
                                    echo "Orden Expirada";
                                    if (!in_array($estadoorden['codigoestadoordenpago'], array(40, 41, 20, 21))) {
                                        $this->lineTrace(__LINE__, true, "trace");
                                        $digitoorden = substr($estadoorden['codigoestadoordenpago'], 1);
                                        $queryTrace = $this->controlador->updateEstadoPago($this->db, $result['Reference1'], $digitoorden, '1');
                                        $this->lineTrace(__LINE__, $queryTrace, "query");
                                        $queryTrace = $this->controlador->updateFechaPagoU($this->db, $estadoorden['TicketId']);
                                        $this->lineTrace(__LINE__, $queryTrace, "query");
                                        echo "Orden Actualizada a estado activo";
                                    }
                                }
                            }
                        }//foreach
                    } else {
                        $this->lineTrace(__LINE__, false, "trace");

                        echo " Fallo " . $fallo . ": ";
                        if ($fallo == '1') {

                            $this->lineTrace(__LINE__, true, "trace");

                            $estadoorden = $this->controlador->estadoOrden($this->db, $result['Reference1']);

                            if (!isset($estadoorden) || in_array($estadoorden, $this->codsEstadoOrdenPago)) {

                                $this->lineTrace(__LINE__, true, "trace");

                                $digitoorden = substr($estadoorden, 1);
                                $queryTrace = $this->controlador->updateEstadoPago($this->db, $result['Reference1'], $digitoorden, '1');
                                $this->lineTrace(__LINE__, $queryTrace, "query");
                                echo "Orden reactivada<br>";
                            } else {
                                $this->lineTrace(__LINE__, false, "trace");
                                echo "Orden sin modificación " . $estadoorden . "<br>";
                            }


                            $queryTrace = $this->controlador->updatePagoLog($this->db, $row['TicketId'], $result['Reference1'], self::TRAN_STATE_EX, $result['BankProcessDate'], $result['BankName'], $result['TrazabilityCode']);
                            $this->lineTrace(__LINE__, $queryTrace, "query");
                            echo " Actualizacion de estado del logopagos A EXPIRED </td></tr>";
                        }
                    }
                }//FAIL
                else {
                    $this->lineTrace(__LINE__, false, "trace");

                    if ($result['TranState'] != self::TRAN_STATE_OK) {
                        $estadoorden = $this->controlador->estadoOrden($this->db, $result['Reference1']);
                        if (!in_array($estadoorden, $this->codsEstadoOrdenPago2)) {
                            $queryTrace = $this->controlador->updateEstadoPago($this->db, $result['Reference1'], '0', '1');
                            $this->lineTrace(__LINE__, $queryTrace, "query");
                        }

                        echo "<td>Resultado: - ";
                        $queryTrace = $this->controlador->updatePagoLog($this->db, $row['TicketId'], $result['Reference1'], $result['TranState'], $result['BankProcessDate'], $result['BankName'], $result['TrazabilityCode']);
                        $this->lineTrace(__LINE__, $queryTrace, "query");
                        echo " Actualizacion de estado del log a  " . $result['ReturnCode'] . "- " . $result['TranState'] . "</td></tr>";
                    }

                }
            }else
                {
                    #si no hay datos del ws no realiza nada solo agrega datos al log
                    $this->lineTrace(__LINE__, false, "trace");
                    $this->lineTrace(__LINE__, 'no hay respuesta del ws para el Transtate', "message");
                }
        } else {

            $this->lineTrace(__LINE__, false, "trace");

            if (!isset($resultado["getTransactionInformationResult"])) {

                $this->lineTrace(__LINE__, true, "trace");
                $this->lineTrace(__LINE__, 'no hay respuesta del ws para el Transtate', "message");
                echo "<td>Datos de error : " . $result . " puede que el web service no haya retornado respuesta</td></tr>";
            } else {

                $this->lineTrace(__LINE__, false, "trace");

                echo "<td>Resultados:<br>";
                //consulta de estado de la orden y datos del usuario
                $row_selestadoorden = $this->controlador->estadoOrden($this->db, $result['Reference1']);

                //VALIDA EL ESTADO DE LA ORDEN
                $digitoorden = substr($row_selestadoorden['codigoestadoordenpago'], 1);

                if (isset($result['BankName']) && !empty($result['BankName'])) {
                    $this->lineTrace(__LINE__, true, "trace");
                    $FIName = $result['BankName'];
                } else {
                    $this->lineTrace(__LINE__, false, "trace");
                    $banco = $this->controlador->ordenpagada($this->db, $result['Reference1']);
                    $FIName = $banco['FIName'];
                }

                $TrazabilityCode = $result['TrazabilityCode'];
                //consulta el mesaje del estado
                $strMensaje = $this->controlador->ReturnCodeDesc($result['TranState'], $result['Reference1'], $result['TicketId'], '1');
                $FlagButton = "0";

                //SI EL ESTADO DE RESPUESTA ES OK
                if ($result['TranState'] == self::TRAN_STATE_OK) {
                    $this->lineTrace(__LINE__, true, "trace");
                    echo " OK - ";
                    //Consulta de estado de la orden
                    $row_selestadoorden = $this->controlador->estadoOrden($this->db, $result['Reference1']);
                    //identificacion del digito del estado de la orden
                    $digitoorden = substr($row_selestadoorden, 1);
                    //consulta el tipo de orden
                    $tipoorden = $this->controlador->tipoorden($this->db, $result['Reference1']);

                    switch ($tipoorden) {
                        case '153':
                            {
                                $this->lineTrace(__LINE__, true, "trace");
                                $valor = 'Inscripcion';
                                //Actualizacion de la orden en la tabla orden a pagada
                                $queryTrace = $this->controlador->updateEstadoPago($this->db, $result['Reference1'], $digitoorden, '4');
                                $this->lineTrace(__LINE__, $queryTrace, "query");
                                //inicia proceso de inscripcion y sus detalles
                                require_once('../serviciosacademicos/funciones/inscribir.php');
                                $inscribir = new inscribirEstudiante();
                                $this->lineTrace(__LINE__, true, "trace");
                                $inscribir->hacerInscripcion($this->db, $result['Reference1']);
                            }
                            break;
                        case '151':
                            {
                                $this->lineTrace(__LINE__, true, "trace");
                                $valor = 'Matricula';
                                //Consulta el estado de la orden de prematricula
                                $row_selestadoprematricula = $this->controlador->estadoprematricula($this->db, $result['Reference1']);

                                //identificacion del digito del estado de la orden
                                $digitoprematricula = substr($row_selestadoprematricula, 1);
                                //Actualiza la prematricula y la orden de pago a pagar
                                $queryTrace = $this->controlador->updateprematricula($this->db, $result['Reference1'], $digitoprematricula);
                                $this->lineTrace(__LINE__, $queryTrace, "query");
                                //Actualiza el detalleprematricula
                                $queryTrace = $this->controlador->updatedetalleprematricula($this->db, $result['Reference1'], '30');
                                $this->lineTrace(__LINE__, $queryTrace, "query");
                            }
                            break;
                        case '0080':
                            {
                                $this->lineTrace(__LINE__, true, "trace");
                                $valor = 'PlanPagos';
                                echo $valor . " / ";
                                // Consulta si la orden pertenece a un plan de pagos
                                $row_plan = $this->controlador->consultaplanpagos($this->db, $result['Reference1']);
                                //Valida si el codigoestado existe y es diferente de vacio
                                if (isset($row_plan['codigoestado']) && !empty($row_plan['codigoestado'])) {

                                    $this->lineTrace(__LINE__, true, "trace");

                                    //asignacion de la orden de pago a numeroordenpagohijo
                                    $numeroordenpagohijo = $result['Reference1'];

                                    echo "Orden Hijo:" . $numeroordenpagohijo;
                                    //Define el numero de plan de pago como numero de orden padre
                                    $numeroordenpagopadre = $row_plan['numerorodenpagoplandepagosap'];
                                    echo " Orden Padre:" . $numeroordenpagopadre;
                                    //consulta el estado de la orden
                                    $estadoordenpadre = $this->controlador->estadoOrden($this->db, $numeroordenpagopadre);
                                    echo " Estado padre:" . $estadoordenpadre;

                                    //si el estado de la orden es diferente a pagada
                                    if (!in_array($estadoordenpadre, $this->codsEstadoOrdenPago2)) {
                                        $this->lineTrace(__LINE__, true, "trace");
                                        //Obtiene el indicativo del estado de la orden
                                        $digitoorden = substr($estadoordenpadre, 1);
                                        //Actualizacion de la orden en la tabla orden a pagada
                                        $queryTrace = $this->controlador->updateEstadoPago($this->db, $numeroordenpagopadre, $digitoorden, '4');
                                        $this->lineTrace(__LINE__, $queryTrace, "query");
                                        //Actualiza el registro de la tala de ordendenpago la fecha actual
                                        $queryTrace = $this->controlador->updateFechaPagoU($this->db, $numeroordenpagopadre);
                                        $this->lineTrace(__LINE__, $queryTrace, "query");
                                    }//if

                                    //consulta el estado de la prematricula
                                    $estadoprematricula = $this->controlador->estadoprematricula($this->db, $numeroordenpagopadre);
                                    //si el estado de la premtraicula es difrente a pagado
                                    if (!in_array($estadoprematricula, array('40', '41'))) {
                                        $this->lineTrace(__LINE__, true, "trace");
                                        //obtiene el indicativo del estado de la orden
                                        $digitoprematricula = substr($estadoprematricula, 1);
                                        //Actualiza la prematricula y la orden de pago a pagar
                                        $queryTrace = $this->controlador->updateprematricula($this->db, $numeroordenpagopadre, $digitoprematricula);
                                        $this->lineTrace(__LINE__, $queryTrace, "query");
                                        //Actualiza el detalleprematricula
                                        $queryTrace = $this->controlador->updatedetalleprematricula($this->db, $numeroordenpagopadre, '30');
                                        $this->lineTrace(__LINE__, $queryTrace, "query");
                                    }
                                    //Actualiza el estado del plan de pago a 300
                                    $queryTrace = $this->controlador->updateplanpagos($this->db, $numeroordenpagohijo, '300');
                                    $this->lineTrace(__LINE__, $queryTrace, "query");
                                    //actualizacion de estado estudiante a "matriculado"
                                    $codigoestudiante = $this->controlador->consultaestudiante($this->db, $result['Reference1'], $result['Reference2'], $result['Reference3']);
                                    $this->controlador->estadomatriculado($this->db, $codigoestudiante['codigoestudiante']);
                                }
                            }
                            break;
                    }//swicth

                    //Actualizacion de la orden en logpagos a estado OK
                    $queryTrace = $this->controlador->updatePagoLog($this->db, $result['TicketId'], $result['Reference1'], self::TRAN_STATE_OK, $result['BankProcessDate'], $result['BankName'], $result['TrazabilityCode']);
                    $this->lineTrace(__LINE__, $queryTrace, "query");
                    //Actualizacion de la orden en la tabla orden a pagada
                    $queryTrace = $this->controlador->updateEstadoPago($this->db, $result['Reference1'], $digitoorden, '4');
                    $this->lineTrace(__LINE__, $queryTrace, "query");
                    //registrar en el logTrance
                    $queryTrace = $this->controlador->registrarLog($this->db, 3, $result['TicketId'], $result);
                    $this->lineTrace(__LINE__, $queryTrace, "query");
                    //Actualiza el registro de la tala de ordendenpago la fecha actual
                    $queryTrace = $this->controlador->updateFechaPagoU($this->db, $row['TicketId']);
                    $this->lineTrace(__LINE__, $queryTrace, "query");
                    // Consulta para aplicar los descuentos de la orden a validando la tabla descuento vs deudas
                    $detalleorden = $this->controlador->detalleorden($this->db, $result['Reference1']);

                    foreach ($detalleorden as $ordenes) {
                        //Consulta el descueto a aplicar
                        $this->controlador->ConsultarDescuentos($this->db, $ordenes['codigoestudiante'], $ordenes['codigoperiodo'], $ordenes['codigoconcepto'], $ordenes['valorconcepto']);
                    }//foreach

                    $queryTrace = $this->controlador->updatePagoLog($this->db, $row['TicketId'], $result['Reference1'], self::TRAN_STATE_OK, $result['BankProcessDate'], $result['BankName'], $result['TrazabilityCode'], $FlagButton);
                    $this->lineTrace(__LINE__, $queryTrace, "query");
                    //Notificacion a people del pago
//                    $this->pagosalasf->reportarPago($this->db, $result['Reference1'], $result['TransValue']);
                    $c++;
                } else {

                    $this->lineTrace(__LINE__, false, "trace");
                    //Si el estado es pendiente
                    echo $result['TranState'] . " - ";
                    if (in_array($result['TranState'], array(self::TRAN_STATE_PEND, self::TRAN_STATE_CREATED, self::TRAN_STATE_BP, self::TRAN_STATE_PEND_BANK))) {
                        $this->lineTrace(__LINE__, true, "trace");
                        //Actualiza la tabla logpagos
                        $queryTrace = $this->controlador->updatePagoLog($this->db, $result['TicketId'], $result['Reference1'], self::TRAN_STATE_PEND, $result['BankProcessDate'], $result['BankName'], $result['TrazabilityCode']);
                        $this->lineTrace(__LINE__, $queryTrace, "query");
                        echo "</td></tr>";
                    } else {
                        $this->lineTrace(__LINE__, false, "trace");
                        //consulta el estado de la prematricula
                        $row_selestadoprematricula = $this->controlador->estadoprematricula($this->db, $result['Reference1']);
                        //obtiene el id
                        $digitoprematricula = substr($row_selestadoprematricula['codigoestadoprematricula'], 1);

                        // Como la transaccion fallo vuelve y deja la orden lista para ser pagada
                        $queryTrace = $this->controlador->updateEstadoPago($this->db, $result['Reference1'], $digitoprematricula, '1');
                        $this->lineTrace(__LINE__, $queryTrace, "query");
                        // Actualiza el logpagos
                        $queryTrace = $this->controlador->updatePagoLog($this->db, $result['TicketId'], $result['Reference1'], $result['TranState'], $result['BankProcessDate'], $result['BankName'], $result['TrazabilityCode'], $FlagButton);
                        $this->lineTrace(__LINE__, $queryTrace, "query");
                        echo "</td></tr>";
                    }
                }//else
            }//else result
            $c++;
        }
    }//function disparar servicio

    /**
     * @param $line
     * @param string $message
     * @param null $type trace | query
     */
    public function lineTrace($line, $result = true, $type = "trace")
    {
        if ($type == 'trace') {
            $this->responseProcess['trace']['valids'][__FILE__ . ':' . $line] = $result;
        }
        if ($type == 'query') {
            $this->responseProcess['query']['valids'][__FILE__ . ':' . $line] = $result;
        }
        if ($type == 'message') {
            $this->responseProcess['message']['valids'][__FILE__ . ':' . $line] = $result;
        }
    }


    public function returnLog()
    {
        #obtiene el estado actual del log
        $actualStatusLog = $this->initialStaCode;
        /**
         * @author Jesus Jimenez
         * valida si el estado de ecollet es diferente al del log en base de datos para realizar
         * la generacion del log
         */
        if ($actualStatusLog != $this->result['TranState']) {
            $trace = $this->forTrace($this->responseProcess['trace']['valids']);

            $queries = $this->forTrace(isset($this->responseProcess['query']['valids']) ? $this->responseProcess['query']['valids'] : array());
            $messages = $this->forTrace(isset($this->responseProcess['message']['valids']) ? $this->responseProcess['message']['valids'] : array());

            $response =
                "Reference1: " . $this->result['Reference1'] . "\n" .
                "Reference2: " . $this->result['Reference2'] . "\n" .
                "Reference3: " . $this->result['Reference3'] . "\n" .
                "TranState: " . $this->result['TranState'] . "\n" .
                "ReturnCode: " . $this->result['ReturnCode'] . "\n" .
                "BankProcessDate: " . $this->result['BankProcessDate'] . "\n" .
                "BankName: " . $this->result['BankName'] . "\n" .
                "TrazabilityCode: " . $this->result['TrazabilityCode'] . "\n" .
                "TransValue: " . $this->result['TransValue'] . "\n" .
                "TicketId: " . $this->result['TicketId'] . "\n" .
                "traceCode:{\n" .
                "trace:" . @$trace . "\n" .
                "queries:" . @$queries . "\n" .
                "messages:" . @$messages. "\n" .
                "}\n";

            #nombre del archivo de log a generar
            $dateTime = new \DateTime();

            $file = '../libsoap/logsSondaEcollet/' .
                $dateTime->format('Y-m-d|H:i:s') .
                substr((string)microtime(), 1, 8) . '-' . $this->result['Reference1'] . '-' . $this->result['TicketId'] . '.txt';
            if ($archivo = fopen($file, "w+")) {
                fwrite($archivo, $response . "\n");
                fclose($archivo);
            }
        }
    }


    public function forTrace($traceCode)
    {
        $trace = "";
        foreach ($traceCode as $file => $val) {
            $trace .= "$file => $val \n";
        }
        return $trace;
    }

    /**
     * sin respuesta por parte del web service de ecollet
     */
    public function whitoutResponseWs()
    {
        return 'sin respuesta del ws ecollet';
    }

}

