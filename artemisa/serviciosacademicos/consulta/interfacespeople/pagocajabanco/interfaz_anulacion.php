<?php
$ruta = "../../../";
//require_once('../../../consulta/generacionclaves.php');
//require_once('../lib/nusoap.php');
/*ini_set('display_errors', 'On');
error_reporting(E_ALL);*/
require_once(dirname(__FILE__).'/../../../../nusoap/lib/nusoap.php');
require_once('../../../Connections/sala2.php');
$rutaado = "../../../funciones/adodb/";
require_once('../../../Connections/salaado.php');
require_once('anulacionPlanPagosSala.php');


function cambiaf_a_sala($fecha) {
    ereg("([0-9]{2,4})([0-9]{1,2})([0-9]{1,2})", $fecha, $mifecha);
    $lafecha = $mifecha[1] . "-" . $mifecha[2] . "-" . $mifecha[3];
    return $lafecha;
    }

//$ns="https://artemisa.unbosque.edu.co/serviciosacademicospruebas/serviciosacademicos/consulta/webservicepeople/";
//$ns="http://172.16.3.202/~dmolano/desarrollo/serviciosacademicos/consulta/interfacespeople/pagocajabanco/";
$ns="https://artemisa.unbosque.edu.co/serviciosacademicos/consulta/interfacespeople/pagocajabanco/";
$server = new soap_server();
$server->configureWSDL('Interfaz Anulacion Plan de Pagos',$ns);
$server->wsdl->schemaTargetNamespace=$ns;
$server->wsdl->addComplexType(
    'respuesta',
    'complexType',
    'struct',
    'all',
    '',
    array(
        'ERRNUM' => array('name' => 'ERRNUM', 'type' => 'xsd:string'),
        'DESCRLONG' => array('name' => 'DESCRLONG', 'type' => 'xsd:string')
    )
);
$server->register('InformacionAnulacion',
        array('INVOICE_ID' => 'xsd:string','TRANSFER_DT' => 'xsd:string' ),
        array('UBI_ERROR_WRK'=>'tns:respuesta'),
        $ns);

InformacionAnulacion($invoice_id, $transfer_dt);

$server->service($HTTP_RAW_POST_DATA);
?>
