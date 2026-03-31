<?php
$ruta = "../../../";
require_once('../../../consulta/generacionclaves.php');
//require_once('../lib/nusoap.php');
require_once('../../../../libsoap/nusoap.php');
require_once('../../../Connections/sala2.php');
$rutaado = "../../../funciones/adodb/";
require_once('../../../Connections/salaado.php');
require_once('reportarpagoasala.php');

/*function cambiaf_a_sala($fecha) {
  //  echo "<H1>fecha=".$fecha."</H1>";
    //ereg("([0-9]{2,4})([0-9]{1,2})([0-9]{1,2})", $fecha, $mifecha);
    $lafecha = $fecha[6].$fecha[7].$fecha[8].$fecha[9]. "-" . $fecha[3].$fecha[4] . "-" . $fecha[0].$fecha[1];
//echo "<H1>lafecha=".$lafecha."</H1>";
    return $lafecha;

    }*/

function cambiaf_a_sala($fecha) {
    ereg("([0-9]{2,4})([0-9]{1,2})([0-9]{1,2})", $fecha, $mifecha);
    $lafecha = $mifecha[1] . "-" . $mifecha[2] . "-" . $mifecha[3];
    return $lafecha;
    }

//$ns="https://artemisa.unbosque.edu.co/serviciosacademicospruebas/serviciosacademicos/consulta/webservicepeople/";
//$ns="http://172.16.3.202/~dmolano/desarrollo/serviciosacademicos/consulta/interfacespeople/pagocajabanco/";
$ns="https://artemisa.unbosque.edu.co/serviciosacademicos/consulta/interfacespeople/pagocajabanco/";
$server = new soap_server();
$server->configureWSDL('Interfaz Envio de Informacion de Pago por Caja y Bancos',$ns);
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
$server->register('InformacionCajaBancos',
        array('INVOICE_ID' => 'xsd:string','TRANSFER_DT' => 'xsd:string' ),
        array('UBI_ERROR_WRK'=>'tns:respuesta'),
        $ns);

InformacionCajaBancos($invoice_id, $transfer_dt);

$server->service($HTTP_RAW_POST_DATA);
?>
