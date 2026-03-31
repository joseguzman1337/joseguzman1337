<?php
/**
 * Se incluye el archivo adaptador para tener acceso a las funciones basicas de
 * del nuevo sala si la aplicacion se corre en un entorno local o de pruebas 
 * se activa la visualizacion de todos los errores de php
 * @modified Andres Ariza <andresariza@unbosque.edu.do>.
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @since 30 de enero de 2019.
 */
//home/arizaandres/Documentos/proyectoSala/nusoap/webServiceAgentBankNusoap.php
require_once(realpath(dirname(__FILE__) . "/../sala/includes/adaptador.php"));
/**
 * Si la aplicacion se corre en un entorno local o de pruebas se activa la visualizacion 
 * de todos los errores de php
 */
$pos = strpos($Configuration->getEntorno(), "local");
if ($Configuration->getEntorno() == "local" || $Configuration->getEntorno() == "pruebas" || $pos !== false) {
    //@error_reporting(1023); // NOT FOR PRODUCTION SERVERS!
    //@ini_set('display_errors', '1'); // NOT FOR PRODUCTION SERVERS!
    /**
     * Se incluye la libreria Kint para hacer debug controlado de variables y objetos
     */
    require_once (PATH_ROOT . '/kint/Kint.class.php');
}
/* ini_set('mysql.connect_timeout', 200);
  ini_set('default_socket_timeout', 200); */
require_once (PATH_ROOT."/nusoap/lib/nusoap.php");
require_once (PATH_ROOT."/serviciosacademicos/consulta/interfacespeople/pagocajabanco/reportarpagoasala.php");

//require_once('../serviciosacademicos/consulta/generacionclaves.php');

class RecordResponsePayment {

    public $ServiceCode;
    public $FlagDBCR;
    public $ReferenceArray;
    public $ItemArray;
    public $MaxDateArray;
    public $ValueDateArray;
    public $IssueDate;
    public $DueDate;
    public $BalanceValue;
    public $SrvCurrency;
    public $CurrencyRate;
    public $xml;

}

class DesgloseOrdenPago {

    public $Item;
    public $ItemDesc;
    public $FlagDBCR;
    public $Value;

}

$URL = "webServiceAgentBankNusoap.php";
$namespace = $URL . '?wsdl';
//using soap_server to create server object
$server = new soap_server;
$server->configureWSDL('AgentBank', $namespace);
$server->wsdl->schemaTargetNamespace = "urn:AgentBank";
$server->soap_defencoding = 'UTF-8';
$server->decode_utf8 = false;
//$server->encode_utf8 = true;
$server->debug_flag = false;
//Para enviar la respuesta directamente como xml
//$server->methodreturnisliteralxml = true;

$server->wsdl->addComplexType(
        'getRecordsForPaymentType', 'complexType', 'array', 'sequence', '', array(
    'EntityCode' => array('name' => 'EntityCode', 'type' => 'xsd:string', 'minOccurs' => '1',
        'maxOccurs' => '1'),
    'Reference1' => array('name' => 'Reference1', 'type' => 'xsd:string', 'minOccurs' => '0',
        'maxOccurs' => '1'),
    'Reference2' => array('name' => 'Reference2', 'type' => 'xsd:string', 'minOccurs' => '0',
        'maxOccurs' => '1')
        )
);

$server->wsdl->addComplexType(
        'arregloString', 'complexType', 'array', 'sequence', '', array(
    'ReferenceArray' => array(
        'name' => 'ReferenceArray',
        'type' => 'xsd:string',
        'minOccurs' => '0',
        'maxOccurs' => 'unbounded'
    )
        )
);

$server->wsdl->addComplexType(
        'DesgloseOrdenPago', 'complexType', 'array', 'sequence', '', array(
    'Item' => array('name' => 'Item', 'type' => 'xsd:string'),
    'ItemDesc' => array('name' => 'ItemDesc', 'type' => 'xsd:string'),
    'FlagDBCR' => array('name' => 'FlagDBCR', 'type' => 'xsd:string'),
    'Value' => array('name' => 'Value', 'type' => 'xsd:decimal')
        )
);

$server->wsdl->addComplexType(
        'DesglosesOrdenPago', 'complexType', 'array', '', 'SOAP-ENC:Array', array(), array(
    array('ref' => 'SOAP-ENC:arrayType', 'wsdl:arrayType' => 'tns:DesgloseOrdenPago[]')
        ), 'tns:DesgloseOrdenPago'
);

$server->wsdl->addComplexType(
        'arregloFecha', 'complexType', 'array', 'sequence', '', array(
    'MaxDateArray' => array(
        'name' => 'MaxDateArray',
        'type' => 'xsd:date',
        'minOccurs' => '0',
        'maxOccurs' => 'unbounded'
    )
        )
);

$server->wsdl->addComplexType(
        'arregloDecimal', 'complexType', 'array', 'sequence', '', array(
    'ValueDateArray' => array(
        'name' => 'ValueDateArray',
        'type' => 'xsd:decimal',
        'minOccurs' => '0',
        'maxOccurs' => 'unbounded'
    )
        )
);

$server->wsdl->addComplexType(
        'RecordResponsePayment', 'complexType', 'struct', 'all', '', array(
    'ServiceCode' => array('name' => 'ServiceCode', 'type' => 'xsd:string',
        'minOccurs' => '0',
        'maxOccurs' => '1'),
    'FlagDBCR' => array('name' => 'FlagDBCR', 'type' => 'xsd:string',
        'minOccurs' => '0',
        'maxOccurs' => '1'),
    'ReferenceArray' => array('name' => 'ReferenceArray', 'type' => 'tns:arregloString',
        'minOccurs' => '0',
        'maxOccurs' => '1'),
    'ItemArray' => array('name' => 'ItemArray', 'type' => 'tns:DesgloseOrdenPago',
        'minOccurs' => '0',
        'maxOccurs' => '1'),
    'MaxDateArray' => array('name' => 'MaxDateArray', 'type' => 'tns:arregloFecha',
        'minOccurs' => '0',
        'maxOccurs' => '1'),
    'ValueDateArray' => array('name' => 'ValueDateArray', 'type' => 'tns:arregloDecimal',
        'minOccurs' => '0',
        'maxOccurs' => '1'),
    'IssueDate' => array('name' => 'IssueDate', 'type' => 'xsd:dateTime',
        'minOccurs' => '0',
        'maxOccurs' => '1'),
    'DueDate' => array('name' => 'DueDate', 'type' => 'xsd:dateTime',
        'minOccurs' => '0',
        'maxOccurs' => '1'),
    'BalanceValue' => array('name' => 'BalanceValue', 'type' => 'xsd:decimal',
        'minOccurs' => '0',
        'maxOccurs' => '1'),
    'SrvCurrency' => array('name' => 'SrvCurrency', 'type' => 'xsd:string',
        'minOccurs' => '0',
        'maxOccurs' => '1'),
    'CurrencyRate' => array('name' => 'CurrencyRate', 'type' => 'xsd:decimal',
        'minOccurs' => '0',
        'maxOccurs' => '1')
        )
);

$server->wsdl->addComplexType(
        'RecordsResponsePayment', 'complexType', 'array', '', 'SOAP-ENC:Array', array(), array(
    array('ref' => 'SOAP-ENC:arrayType', 'wsdl:arrayType' => 'tns:RecordResponsePayment[]')
        ), 'tns:RecordResponsePayment'
);

$server->wsdl->addComplexType(
        'GetRecordsForPaymentResponseType', 'complexType', 'struct', 'sequence', '', array(
    'RecordsArray' => array('name' => 'RecordsArray', 'type' => 'tns:RecordsResponsePayment', 'minOccurs' => '0', 'maxOccurs' => '1'),
    'ReturnCode' => array('name' => 'ReturnCode', 'type' => 'xsd:string', 'minOccurs' => '0', 'maxOccurs' => '1'),
    'ReturnDesc' => array('name' => 'ReturnDesc', 'type' => 'xsd:string', 'minOccurs' => '0', 'maxOccurs' => '1')
        )
);

$server->wsdl->addComplexType(
        'notifyPaymentsResultType', 'complexType', 'struct', 'all', '', array(
    'ReturnCode' => array('name' => 'ReturnCode', 'type' => 'xsd:string', 'minOccurs' => '0',
        'maxOccurs' => '1'),
    'ReturnDesc' => array('name' => 'ReturnDesc', 'type' => 'xsd:string', 'minOccurs' => '0',
        'maxOccurs' => '1')
        )
);

$server->wsdl->addComplexType(
        'DesgloseOperacionPago', 'complexType', 'struct', 'all', '', array(
    'operationCode' => array('name' => 'operationCode', 'type' => 'xsd:string'),
    'operationValue' => array('name' => 'operationValue', 'type' => 'xsd:decimal')
        )
);

$server->wsdl->addComplexType(
        'DesglosesOperacionPago', 'complexType', 'array', '', 'SOAP-ENC:Array', array(), array(
    array('ref' => 'SOAP-ENC:arrayType', 'wsdl:arrayType' => 'tns:DesgloseOperacionPago[]')
        ), 'tns:DesgloseOperacionPago'
);

$server->wsdl->addComplexType(
        'agentNotifyPaymentsType', 'complexType', 'struct', 'all', '', array(
    'EntityCode' => array('name' => 'EntityCode', 'type' => 'xsd:string',
        'minOccurs' => '1',
        'maxOccurs' => '1'),
    'TicketId' => array('name' => 'TicketId', 'type' => 'xsd:string',
        'minOccurs' => '1',
        'maxOccurs' => '1'),
    'TrazabilityCode' => array('name' => 'TrazabilityCode', 'type' => 'xsd:string',
        'minOccurs' => '0',
        'maxOccurs' => '1'),
    'ServiceCode' => array('name' => 'ServiceCode', 'type' => 'xsd:string',
        'minOccurs' => '0',
        'maxOccurs' => '1'),
    'FlagDBCR' => array('name' => 'FlagDBCR', 'type' => 'xsd:string',
        'minOccurs' => '0',
        'maxOccurs' => '1'),
    'ReferenceArray' => array('name' => 'ReferenceArray', 'type' => 'tns:arregloString',
        'minOccurs' => '0',
        'maxOccurs' => '1'),
    'TransValue' => array('name' => 'TransValue', 'type' => 'xsd:decimal',
        'minOccurs' => '0',
        'maxOccurs' => '1'),
    'TransVatValue' => array('name' => 'TransVatValue', 'type' => 'xsd:decimal',
        'minOccurs' => '0',
        'maxOccurs' => '1'),
    'TransCashValue' => array('name' => 'TransCashValue', 'type' => 'xsd:decimal',
        'minOccurs' => '0',
        'maxOccurs' => '1'),
    'TransCheckValue' => array('name' => 'TransCheckValue', 'type' => 'xsd:decimal',
        'minOccurs' => '0',
        'maxOccurs' => '1'),
    'TranState' => array('name' => 'TranState', 'type' => 'xsd:string',
        'minOccurs' => '0',
        'maxOccurs' => '1'),
    'FIName' => array('name' => 'FIName', 'type' => 'xsd:string',
        'minOccurs' => '0',
        'maxOccurs' => '1'),
    'BankProcessDate' => array('name' => 'BankProcessDate', 'type' => 'xsd:dateTime',
        'minOccurs' => '0',
        'maxOccurs' => '1'),
    'PaymentSystem' => array('name' => 'PaymentSystem', 'type' => 'xsd:string',
        'minOccurs' => '0',
        'maxOccurs' => '1'),
    'TransCycle' => array('name' => 'TransCycle', 'type' => 'xsd:string',
        'minOccurs' => '0',
        'maxOccurs' => '1'),
    'OperationArray' => array('name' => 'OperationArray', 'type' => 'tns:DesglosesOperacionPago',
        'minOccurs' => '0',
        'maxOccurs' => '1'),
    'PayCurrency' => array('name' => 'PayCurrency', 'type' => 'xsd:string',
        'minOccurs' => '0',
        'maxOccurs' => '1'),
    'AccountingDate' => array('name' => 'AccountingDate', 'type' => 'xsd:dateTime',
        'minOccurs' => '0',
        'maxOccurs' => '1')
        )
);

//cambio original rpc / encoded, prueba document / literal, otra prueba rpc / literal
$server->register("GetRecordsForPayment", //Nombre del metodo
        array('request' => 'xsd:string'), //Parametros de entrada
        array('response' => 'xsd:string'), //Parametros de salida
        'urn:AgentBank', // Nombre del workspace
        'urn:AgentBank#GetRecordsForPayment', // Accipn soap
        'rpc', // Estilo
        'encoded', // Uso
        'Consulta de Transacciones'      // Documentacion
);
$server->register("NotifyPayments", //Nombre del metodo
        array('request' => 'xsd:string'), //Parametros de entrada
        array('response' => 'xsd:string'), //Parametros de salida
        'urn:AgentBank', // Nombre del workspace
        'urn:AgentBank#NotifyPayments', // Accion soap
        'rpc', // Estilo
        'encoded', // Uso
        'Aplicacion de pagos'      // Documentacion
);
$HTTP_RAW_POST_DATA = isset($GLOBALS['HTTP_RAW_POST_DATA']) ? $GLOBALS['HTTP_RAW_POST_DATA'] : '';
$server->service($HTTP_RAW_POST_DATA);

function doLog($text) {
    // open log file
    $filename = "form_ipn.log";
    $fh = fopen($filename, "a") or die("Could not open log file.");
    fwrite($fh, date("d-m-Y, H:i") . " - $text\n") or die("Could not write file!");
    fclose($fh);
}

function consultarOrden($numeroorden, $numerodocumento) {
    $consultaDoc = "";
    if ($numerodocumento != null && $numerodocumento != "" && $numerodocumento != "?") {
        $consultaDoc = " AND eg.numerodocumento=" . $numerodocumento;
    }
    //enviaron el numero de orden
    $sql = "select DISTINCT o.numeroordenpago,o.fechaordenpago,o.codigoperiodo,o.codigoestadoordenpago,
						o.observacionordenpago,c.nombreconcepto,dp.cantidaddetalleordenpago,
						dp.valorconcepto,dp.codigotipodetalleordenpago,fo.fechaordenpago as fecha_limite,
						fo.porcentajefechaordenpago,fo.valorfechaordenpago,eg.numerodocumento,doc.nombrecortodocumento,
						eg.idestudiantegeneral 
						FROM ordenpago o 
						inner join detalleordenpago dp on dp.numeroordenpago=o.numeroordenpago
						inner join concepto c on c.codigoconcepto=dp.codigoconcepto
						inner join estudiante e on e.codigoestudiante=o.codigoestudiante
						inner join estudiantegeneral eg on eg.idestudiantegeneral=e.idestudiantegeneral 
						inner join fechaordenpago fo on fo.numeroordenpago=o.numeroordenpago
						inner join documento doc on doc.tipodocumento=eg.tipodocumento 
						WHERE o.codigoestadoordenpago IN (10,11,14) 
						AND o.numeroordenpago=" . $numeroorden . " AND fo.fechaordenpago>=CURDATE() $consultaDoc 
						ORDER BY fo.fechaordenpago ASC";

    return $sql;
}

function consultarOrdenReferenciaPago($referenciapago, $fecha = null) {
    
    $db = Factory::createDbo();
    
    /**
     * @modified Andres Ariza <arizaandres@unbosque.edu.do>
     * Se modifica el orden de la referencia de modo que el primer digito indica
     * si es o no con aporte (referencias completas del codigo de barras osea de mas de 17 digitos)
     * de modo que tambien cambia el modo de identifcar sus componentes (idestudiante y numeroordenpago)
     * @since Enero 31, 2019
    */
    $valorAporte = 0;
    $aporteSemillas = 0; 
    
    if(strlen($referenciapago) > 17){
        $aporteSemillas = (int) substr($referenciapago, 0,1 ); 
        $referenciapago = substr($referenciapago, 1 );
    }
    
    $tamano = strlen($referenciapago);
    
    if ($tamano >= 8 && $tamano <= 20) {
        $diferencia = $tamano - 15;
        $limite = 8 + $diferencia;
        $numeroordenpago = substr($referenciapago, $limite);
        $idestudiantegeneral = (int) substr($referenciapago, 0, $limite);
        
        //echo $aporteSemillas; exit; 
    } else {
        $numeroordenpago = null;
    } 
    //echo $idestudiantegeneral;
    $fechaComparacion = "CURDATE()";
    if ($fecha !== null && $fecha != "") {
        if (strpos($fecha, 'T') !== false) {
            $fechas = explode("T", $fecha);
        } else {
            $fechas = explode(" ", $fecha);
        }
        $fechaComparacion = "'" . $fechas[0] . "'";
    }
    
    if(!empty($aporteSemillas) && $aporteSemillas==1){
        
        /**
         * @modified Andres Ariza <arizaandres@unbosque.edu.do>
         * Se agrega consulta a base de datos para obtener el valor del aporte
         * a semillas 
         * @since Enero 31, 2019
        */
        $query = "
            SELECT vp.valorpecuniario
            FROM  valorpecuniario vp  
            INNER JOIN concepto c ON (c.codigoconcepto = vp.codigoconcepto)
            INNER JOIN ordenpago op ON (vp.codigoperiodo = op.codigoperiodo)
            WHERE  vp.codigoestado = 100
                AND c.codigoestado = 100 
                AND c.codigoconcepto = 'C9106' 
                AND op.numeroordenpago = ".$db->qstr($numeroordenpago)." 
            ORDER BY vp.idvalorpecuniario DESC 
            LIMIT 0,1";
        
        $valoresP = $db->getCol($query);
        
        if(!empty($valoresP)){
            $valorAporte = (int) $valoresP[0];
        }
        
    }
    
    //echo "a.".$aporteSemillas." - ref.".$referenciapago." - nop.".$numeroordenpago." - ideg.".$idestudiantegeneral;
    	
    if ($numeroordenpago === "" || $numeroordenpago === null) {
        return false;
    } else {
        
        /**
         * @modified Andres Ariza <arizaandres@unbosque.edu.do>
         * Cuando el pago sea con aporte, se suma al valor el valor del aporte
         * @since Enero 31, 2019
        */
        //enviaron el numero de orden
        $sql = "SELECT DISTINCT o.numeroordenpago,o.fechaordenpago,o.codigoperiodo,o.codigoestadoordenpago,
                o.observacionordenpago,c.nombreconcepto,dp.cantidaddetalleordenpago,
                (dp.valorconcepto + ".$valorAporte.") valorconcepto,dp.codigotipodetalleordenpago,fo.fechaordenpago as fecha_limite,
                fo.porcentajefechaordenpago,(fo.valorfechaordenpago + ".$valorAporte.") valorfechaordenpago ,eg.numerodocumento,doc.nombrecortodocumento,
                eg.idestudiantegeneral
            FROM ordenpago o
            INNER JOIN detalleordenpago dp ON ( dp.numeroordenpago=o.numeroordenpago )
            INNER JOIN concepto c ON ( c.codigoconcepto=dp.codigoconcepto )
            INNER JOIN estudiante e ON ( e.codigoestudiante=o.codigoestudiante )
            INNER JOIN estudiantegeneral eg ON ( eg.idestudiantegeneral=e.idestudiantegeneral )
            INNER JOIN fechaordenpago fo ON ( fo.numeroordenpago=o.numeroordenpago )
            INNER JOIN documento doc ON ( doc.tipodocumento=eg.tipodocumento )
            WHERE o.codigoestadoordenpago IN (10,11,14)
                AND o.numeroordenpago=". $db->qstr($numeroordenpago) . " AND fo.fechaordenpago>=" . $fechaComparacion . " 
                AND o.fechaordenpago<=" . $fechaComparacion . "  
                AND e.idestudiantegeneral=" . $db->qstr($idestudiantegeneral) . " 
            ORDER BY fo.fechaordenpago ASC";
        //echo $sql;exit;
        
        return $sql;
    }
}

function consultarOrdenes($numerodocumento, $fecha = null) {
    $db = Factory::createDbo();
    $fechaComparacion = "CURDATE()";
    if ($fecha !== null && $fecha != "") {
        $fechas = explode(" ", $fecha);
        $fechaComparacion = "'" . $fechas[0] . "'";
    }
    //enviaron el numero de orden
    $sql = "select DISTINCT o.numeroordenpago,o.fechaordenpago,o.codigoperiodo,eg.numerodocumento,eg.idestudiantegeneral
						FROM ordenpago o 
						inner join estudiante e on e.codigoestudiante=o.codigoestudiante
						inner join estudiantegeneral eg on eg.idestudiantegeneral=e.idestudiantegeneral 
						inner join fechaordenpago fo on fo.numeroordenpago=o.numeroordenpago
						WHERE o.codigoestadoordenpago IN (10,11,14) 
						AND eg.numerodocumento=" . $db->qstr($numerodocumento) . " AND fo.fechaordenpago>=" . $db->qstr($fechaComparacion) . "  
							AND o.fechaordenpago<=" . $db->qstr($fechaComparacion) . "  
						ORDER BY fo.fechaordenpago ASC";
    //doLog("sql ->".$sql);	
    return $sql;
}

function contruirArregloPorOrdenPago($detalleOrden) {
    $infoOrden = new RecordResponsePayment();
    $xml = '<GetRecordsForPaymentResponseType><RecordsArray><ServiceCode>10003</ServiceCode>
					<FlagDBCR>0</FlagDBCR>';
    $infoOrden->ServiceCode = "10003";
    $infoOrden->FlagDBCR = "0";
    $referencias = array();
    $referencias[] = $detalleOrden[0]["numerodocumento"];
    $referencias[] = $detalleOrden[0]["idestudiantegeneral"] . $detalleOrden[0]["numeroordenpago"];
    $xml .= '<ReferenceArray>' . $detalleOrden[0]["numerodocumento"] . '</ReferenceArray>
					<ReferenceArray>' . $referencias[1] . '</ReferenceArray>';
    $infoOrden->ReferenceArray = $referencias;
    $item = new DesgloseOrdenPago();
    $item->Item = "00";
    $item->ItemDesc = "0rden de pago por concepto de " . $detalleOrden[0]["nombreconcepto"];
    $item->FlagDBCR = "0";
    $item->Value = $detalleOrden[0]["valorfechaordenpago"];
    $xml .= '<ItemArray>
						<Item>00</Item>
						<ItemDesc>' . $item->ItemDesc . '</ItemDesc>
						<FlagDBCR>0</FlagDBCR>
						<Value>' . $item->Value . '</Value></ItemArray>';
    $arregloItems[] = (array) $item;
    $infoOrden->ItemArray = $arregloItems;
    $arregloFechas = array();
    $arregloValores = array();
    $infoOrden->IssueDate = $detalleOrden[0]["fechaordenpago"];
    $infoOrden->DueDate = $detalleOrden[0]["fecha_limite"];
    $infoOrden->BalanceValue = $detalleOrden[0]["valorfechaordenpago"];
    $infoOrden->SrvCurrency = "COP";
    $firstRow = true;
    foreach ($detalleOrden as $fechaOrden) {
        if ($firstRow) {
            $arregloFechas[] = $fechaOrden["fecha_limite"];
            $xml .= '<MaxDateArray>' . $fechaOrden["fecha_limite"] . '</MaxDateArray>';
            $arregloValores[] = $fechaOrden["valorfechaordenpago"];
            $xml .= '<MaxValueArray>' . $fechaOrden["valorfechaordenpago"] . '</MaxValueArray>';
            //para que solo devuelva el valor de la proxima fecha y ya
            $firstRow = false;
        }
    }
    $xml .= '<BalanceValue>' . $detalleOrden[0]["valorfechaordenpago"] . '</BalanceValue>';
    $xml .= '<IssueDate>' . $detalleOrden[0]["fechaordenpago"] . '</IssueDate>';
    $xml .= '<DueDate>' . $detalleOrden[0]["fecha_limite"] . '</DueDate>';
    $xml .= '<SrvCurrency>COP</SrvCurrency></RecordsArray>
					<ReturnCode>SUCCESS</ReturnCode>
					<ReturnDesc></ReturnDesc></GetRecordsForPaymentResponseType>';
    $infoOrden->MaxDateArray = $arregloFechas;
    $infoOrden->ValueDateArray = $arregloValores;
    $infoOrden->xml = $xml;
    return $infoOrden;
}

function registrarLogAgentBank($db, $transaccion, $respuesta, $orden = 1, $documento = "NULL") {

    $query_logps = "INSERT INTO `LogTraceIntegracionAgentBank` (`Transaccion`, `NumeroOrdenPago`,
									`DocumentoEstudiante`, `RespuestaTransaccion`)
								VALUES( " . $transaccion . "," . $orden . ", " . $documento . ", '" . $respuesta . "')";
    $logps = $db->Execute($query_logps);
    return $logps;
}

function GetRecordsForPayment($request) {
    $entity = null;
    $reference1 = null;
    $reference2 = null;
    if ($request->EntityCode == null && is_array($request)) {
        $entity = $request["EntityCode"];
        $reference1 = $request["Reference1"];
        $reference2 = $request["Reference2"];
        $fecha = $request["BankProcessDate"];
    } else if ($request->EntityCode == null) {
        $xml = simplexml_load_string(trim((string) $request));
        $json = json_encode($xml);
        $request = json_decode($json, TRUE);
        $entity = $request["EntityCode"];
        $reference1 = $request["Reference1"];
        $reference2 = $request["Reference2"];
        $fecha = $request["BankProcessDate"];
    } else {
        $entity = $request->EntityCode;
        $reference1 = $request->Reference1;
        $reference2 = $request->Reference2;
        $fecha = $request->BankProcessDate;
    }
    $db = Factory::createDbo();

    if ($entity != 10017) {
        //no es la universidad el bosque
        $xml = '<GetRecordsForPaymentResponseType><ReturnCode>FAIL_INVALIDENTITYCODE</ReturnCode>
						<ReturnDesc>Falla o el Codigo de la Entidad no existe.</ReturnDesc></GetRecordsForPaymentResponseType>';
        return $xml;
    } else {
        if ($reference2 != null && $reference2 != "" && $reference2 != "?") {

            $sql = consultarOrdenReferenciaPago($reference2, $fecha);
            //echo $sql;

            if ($sql === false && $sql === "") {
                $ordenes = 0;
            } else {
                $ordenes = $db->GetArray($sql);
            }
                //print_r($ordenes);
            if (count($ordenes) > 0 && $ordenes !== false) {
                registrarLogAgentBank($db, 1, serialize($request), $ordenes[0]["numeroordenpago"]);
                $infoOrden = contruirArregloPorOrdenPago($ordenes);
                return $infoOrden->xml;
            } else {
                $xml = '<GetRecordsForPaymentResponseType><ReturnCode>NO_RECORDS</ReturnCode>
						<ReturnDesc>No existen registros para esta(s) Referencia(s).</ReturnDesc></GetRecordsForPaymentResponseType>';
                return $xml;
            }
        } else if ($reference1 != null && $reference1 != "" && $reference1 != "?") {
            //enviaron el numero de documento				
            $sql = consultarOrdenes($reference1, $fecha);
            echo $sql;
            $ordenes = $db->GetArray($sql);
            if (count($ordenes) > 0) {
                //$RecordsArray = array();
                registrarLogAgentBank($db, 1, "varias ordenes " . base64_encode(serialize($request)), $ordenes[0]["numeroordenpago"], $ordenes[0]["numerodocumento"]);
                foreach ($ordenes as $orden) {
                    $sql = consultarOrden($orden["numeroordenpago"], $orden["numerodocumento"]);
                    $detalleOrden = $db->GetArray($sql);
                    if (count($detalleOrden) > 0) {
                        $infoOrden = contruirArregloPorOrdenPago($detalleOrden);
                    }
                }
                return $infoOrden->xml;
            } else {
                $xml = '<GetRecordsForPaymentResponseType><ReturnCode>NO_RECORDS</ReturnCode>
						<ReturnDesc>No existen registros para esta(s) Referencia(s).</ReturnDesc></GetRecordsForPaymentResponseType>';
                return $xml;
            }
        } else {
            //no enviaron ni la factura ni el documento
            $xml = '<GetRecordsForPaymentResponseType><ReturnCode>FAIL_INVALIDREFERENCE2</ReturnCode>
						<ReturnDesc>Falla en el campo Reference2 o no existe.</ReturnDesc></GetRecordsForPaymentResponseType>';
            return $xml;
        }
    }
    $xml = '<GetRecordsForPaymentResponseType><ReturnCode>FAIL_SYSTEM</ReturnCode>
						<ReturnDesc>Requerimiento fallido o se presento excepcion generada en SALA.</ReturnDesc></GetRecordsForPaymentResponseType>';

    return $xml;
}

function NotifyPayments($request) {
    $entity = null;
    $notificaciones = array();
    
    //$x = unserialize('a:19:{s:10:"EntityCode";s:5:"10017";s:8:"TicketId";s:7:"6567824";s:15:"TrazabilityCode";s:20:"17061310190888010430";s:11:"ServiceCode";s:5:"10003";s:14:"ReferenceArray";a:2:{i:0;s:10:"1018462850";i:1;s:12:"994792140605";}s:10:"TransValue";s:8:"15282000";s:13:"TransVatValue";s:6:"0.0000";s:14:"TransCashValue";s:1:"0";s:15:"TransCheckValue";s:1:"0";s:9:"TranState";s:2:"OK";s:6:"FIName";s:20:"1001-BANCO DE BOGOTA";s:15:"BankProcessDate";s:19:"2017-06-13T15:32:03";s:13:"PaymentSystem";s:3:"100";s:10:"TransCycle";s:1:"0";s:14:"OperationArray";a:4:{s:13:"operationCode";s:2:"00";s:14:"operationValue";s:8:"15282000";s:13:"operationDesc";s:1:"0";s:13:"operationDBCR";s:1:"0";}s:11:"PayCurrency";s:3:"COP";s:14:"AccountingDate";s:19:"0001-01-01T00:00:00";s:10:"Reference2";s:12:"994792140605";s:10:"Reference1";s:10:"1018462850";}');
    
    $arregloPagos = false;
    if ($request->ArrayOfAgentNotifyPaymentsType == null && is_array($request)) {
        $arregloPagos = $request["ArrayOfAgentNotifyPaymentsType"];
        //$entity = $pagos[0]["EntityCode"];
        //doLog("puerta numero 1");			
    } else if ($request->agentNotifyPaymentsType == null) {
        //doLog("puerta numero 2");	
        $xml = simplexml_load_string(trim((string) $request));
        $json = json_encode($xml);
        $request = json_decode($json, TRUE);
        $arregloPagos[] = $request; ///?????????? 
        //$entity = $pagos[0]["EntityCode"];
    } else {
        //doLog("puerta numero 3");	
        $arregloPagos[] = $request->agentNotifyPaymentsType;
        /* $entity = $request->agentNotifyPaymentsType;   
          $reference1 = $request->Reference1;
          $reference2 = $request->Reference2; */
    }
    
    if (is_array($arregloPagos)) {
        foreach ($arregloPagos as $pagos) {
            $todobien = notificacionPagos($pagos, $db);
        }
    } else {
        if ($request->agentNotifyPaymentsType == null && is_array($request)) {
            $pagos = $request["agentNotifyPaymentsType"];
            //$entity = $pagos[0]["EntityCode"];
            //doLog("puerta numero 1");		
        } else if ($request->agentNotifyPaymentsType == null) {
            //doLog("puerta numero 2");	
            $xml = simplexml_load_string(trim((string) $request));
            $json = json_encode($xml);
            $request = json_decode($json, TRUE);
            $pagos[] = $request;
            //$entity = $pagos[0]["EntityCode"];
        } else {
            //doLog("puerta numero 3");	
            $pagos[] = $request->agentNotifyPaymentsType;
            /* $entity = $request->agentNotifyPaymentsType;   
              $reference1 = $request->Reference1;
              $reference2 = $request->Reference2; */
        }
        $todobien = notificacionPagos($pagos, $db);
    }


    if ($todobien["resultado"]) {
        $xml = '<notifyPaymentsResultType><ReturnCode>SUCCESS</ReturnCode>
						<ReturnDesc>' . $todobien["mensaje"] . '</ReturnDesc></notifyPaymentsResultType>';
    } else {
        $xml = '<notifyPaymentsResultType><ReturnCode>FAIL_SYSTEM</ReturnCode>
						<ReturnDesc>' . serialize($todobien) . '</ReturnDesc></notifyPaymentsResultType>';
    }

    return $xml;
}

function notificacionPagos($pagos, $db) {
    $orden = "";
    /**
     * @modified Andres Ariza <arizaandres@unbosque.edu.do>
     * Se agrega el llamado al singleton de conexion a base de datos
     * @since Enero 31, 2019
    */
    $db = Factory::createDbo();
    //var_dump($pagos);
    if ($pagos["EntityCode"] != null) {
        $resultado = hacerPago($pagos, $db);
    } else {
        //mandaron varios pagos
        foreach ($pagos as $pago) {
            $resultado = hacerPago($pago, $db);
        }
    }

    return $resultado;
}

function hacerPago($pago, $db) {
    $entity = $pago["EntityCode"];
    $pago["Reference2"] = $pago["ReferenceArray"][1];
    $pago["Reference1"] = $pago["ReferenceArray"][0];
    
    
    if(strlen($pago["Reference2"]) > 17){ 
        $pago["Reference2"] = (int)substr($pago["Reference2"], 1 );
    }
    
    $todobien = true;
    
    if ($entity != 10017) {
        //no es la universidad el bosque, no hay necesidad de volver a notificar
        $todobien = true;
        $mensaje = "No es la universidad El Bosque " . $entity;
    } else {
        //verificar que no falten datos
        if ($pago["TrazabilityCode"] == null || $pago["TrazabilityCode"] == "" || $pago["TicketId"] == null || $pago["TicketId"] == "" || $pago["FIName"] == null || $pago["FIName"] == "" || ($pago["Reference1"] == null && $pago["Reference2"] == null)) {
            //no hay necesidad de volver a notificar
            $todobien = true;
            $mensaje = "Faltan datos " . $pago["Reference1"];
        } else {
            //intentamos hacer el pago
            if ($pago["Reference2"] != null && $pago["Reference2"] != "" && $pago["Reference2"] != "?") {
                
                $sql = consultarOrdenReferenciaPago($pago["Reference2"], $pago["BankProcessDate"]);
                if ($sql === false && $sql === "") {
                    $ordenes = 0;
                } else {
                    $ordenes = $db->GetArray($sql);
                }
                //print_r($sql);
                if (count($ordenes) > 0 && $ordenes !== false) {
                    //se puede hacer el pago
                    registrarLogAgentBank($db, 2, "valor orden: " . $ordenes[0]["valorfechaordenpago"] . " valor pago: " . $pago["TransValue"] . " pago -> " . serialize($pago), $ordenes[0]["numeroordenpago"], $ordenes[0]["numerodocumento"]);
                    
                    if ($ordenes[0]["valorfechaordenpago"] > $pago["TransValue"]) {
                        //TRATAN DE PAGARLA POR MENOS PLATA *** no hay necesidad de volver a notificar
                        $todobien = true;
                        $mensaje = "Tratan de pagar la orden por menos dinero " . $ordenes[0]["valorfechaordenpago"] . " vs " . $pago["TransValue"];
                    } else {
                        //hacer el pago
                        $mensaje = "Orden " . $ordenes[0]["numeroordenpago"] . " pagada";
                        reportarPagoSALA($ordenes[0], $db, $pago);
                    }
                } else {
                    // no hay necesidad de volver a notificar
                    $todobien = true;
                    $mensaje = "No se encontro ninguna orden con la referencia " . $pago["Reference2"];
                }
            } else if ($pago["Reference1"] != null && $pago["Reference1"] != "" && $pago["Reference1"] != "?") {
                //enviaron el numero de documento		¿
                registrarLogAgentBank($db, 2, "numero documento: " . $pago["Reference1"] . " pago -> " . serialize($pago), 1, $pago["Reference1"]);
                $sql = consultarOrdenes($pago["Reference1"], $pago["BankProcessDate"]);
                $ordenes = $db->GetArray($sql);
                if (count($ordenes) > 0) {
                    $RecordsArray = array();
                    foreach ($ordenes as $orden) {
                        $sql = consultarOrden($orden["numeroordenpago"], $orden["numerodocumento"]);
                        $detalleOrden = $db->GetArray($sql);
                        if (count($detalleOrden) > 0) {
                            //se puede hacer el pago
                            registrarLogAgentBank($db, 2, "valor orden: " . $detalleOrden[0]["valorfechaordenpago"] . " valor pago: " . $pago["TransValue"], $detalleOrden[0]["numeroordenpago"], $detalleOrden[0]["numerodocumento"]);
                            if ($detalleOrden[0]["valorfechaordenpago"] > $pago["TransValue"]) {
                                //TRATAN DE PAGARLA POR MENOS PLATA *** no hay necesidad de volver a notificar
                                $todobien = true;
                                $mensaje = "Tratan de pagar la orden por menos dinero " . $detalleOrden[0]["valorfechaordenpago"] . " vs " . $pago["TransValue"];
                            } else {
                                //hacer el pago
                                reportarPagoSALA($detalleOrden, $db, $pago);
                                $mensaje = "Orden " . $detalleOrden[0]["numeroordenpago"] . " pagada";
                            }
                        }
                    }
                } else {
                    //no tiene ordenes que pagar *** no hay necesidad de volver a notificar
                    $todobien = true;
                    $mensaje = "No se encontro ninguna orden activa para el estudiante " . $pago["Reference1"];
                }
            } else {
                // no lee las referencias, *** no hay necesidad de volver a notificar
                $todobien = true;
                $mensaje = "No llego el mensaje de forma correcta.";
            }
        }
    }
    //var_dump(array("resultado"=>$todobien,"mensaje"=>$mensaje));
    return array("resultado" => $todobien, "mensaje" => $mensaje);
}

function reportarPagoSALA($orden, $db, $pago) {
    $d = new DateTime($pago['BankProcessDate']);
    $strDate = date_format($d, "d-M-y");
    
    
    /**
     * @modified Andres Ariza <arizaandres@unbosque.edu.do>
     * Se reutiliza el metodo de reportar el pago de una orden de pago en sala 
     * utilizado en el webservice interfaz_pago_caja_bancos
     * @since Enero 31, 2019
    */
    $response = InformacionCajaBancos($orden['numeroordenpago'], $strDate,$pago['TransValue'], "pse");


    registrarLogAgentBank($db, 2, "orden pagada en sala", $orden["numeroordenpago"]);


    $sqlI = "INSERT INTO `ColaNotificacionPagoPS` (`NumeroOrdenPago`, `TicketID`, `ResultadoNotificacion`) 
			VALUES ('" . $orden["numeroordenpago"] . "','" . $pago["TicketId"] . "', '3')";
    $result = $db->Execute($sqlI);
    
    return true;
}

function registrarPagoAgentBank($db, $orden, $pago) {
    //doLog("agentbank sala");	
    $query_pago = "SELECT * FROM LogPagos
								WHERE TicketId = '" . $pago["TicketId"] . "'";
    //echo $query_data,"<br>";
    $plan = $db->Execute($query_pago) or die(mysql_error());
    $row_pago = $plan->FetchRow();
    $totalRows_pago = $plan->RecordCount();
    if ($row_pago <> "") {
        $sqlU = "UPDATE `LogPagos` SET `Reference1`='" . $orden["numeroordenpago"] . "', `Reference2`='" . $orden["numerodocumento"] . "', `Reference3`='" . $orden["nombrecortodocumento"] . "', 
			`TransValue`='" . $pago["TransValue"] . "', `BankProcessDate`='" . $pago["BankProcessDate"] . "', `FIName`='" . $pago["FIName"] . "', `StaCode`='" . $pago["TranState"] . "', 
			`TrazabilityCode`='" . $pago["TrazabilityCode"] . "', `PaymentSystem`='" . $pago["PaymentSystem"] . "' WHERE (`TicketId`='" . $pago["TicketId"] . "')";
        $result = $db->Execute($sqlU);
    } else {
        $sqlI = "INSERT INTO `LogPagos` (`TicketId`, `SrvCode`, `Reference1`, `Reference2`, `Reference3`, `TransValue`, `SoliciteDate`, `BankProcessDate`, `FIName`, `StaCode`, `TrazabilityCode`, `FlagButton`, `PaymentSystem`) 
			VALUES ('" . $pago["TicketId"] . "', '" . $pago["ServiceCode"] . "', '" . $orden["numeroordenpago"] . "', '" . $orden["numerodocumento"] . "', '" . $orden["nombrecortodocumento"] . "', '" . $pago["TransValue"] . "', '" . $pago["BankProcessDate"] . "', '" . $pago["BankProcessDate"] . "', '" . $pago["FIName"] . "', '" . $pago["TranState"] . "', '" . $pago["TrazabilityCode"] . "', '0', '" . $pago["PaymentSystem"] . "')";
        $result = $db->Execute($sqlI);
    }
    return true;
}
