<?php

    require(realpath(dirname(__FILE__)."/../../../../sala/config/Configuration.php"));
    $Configuration = Configuration::getInstance();

    if($Configuration->getEntorno()=="local"||$Configuration->getEntorno()=="pruebas"
        ||$Configuration->getEntorno()=="Preproduccion"){
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_WARNING);
        require_once (PATH_ROOT.'/kint/Kint.class.php');
    }

    require (PATH_SITE.'/lib/Factory.php');

    $db = Factory::createDbo();
    require_once(PATH_ROOT.'/serviciosacademicos/Connections/sala2.php');

    $ruta = "../../../";
    require_once(PATH_ROOT.'/serviciosacademicos/consulta/generacionclaves.php');
    require_once(PATH_ROOT.'/nusoap/lib/nusoap.php');
    require_once('reportarpagoasala.php');

    function cambiaf_a_sala($fecha) {
        preg_match("/([0-9]{2,4})([0-9]{1,2})([0-9]{1,2})/", $fecha, $mifecha);
        $lafecha = $mifecha[1] . "-" . $mifecha[2] . "-" . $mifecha[3];
        return $lafecha;
    }

    $xml = file_get_contents('php://input');

    $ns=HTTP_ROOT."/serviciosacademicos/consulta/interfacespeople/pagocajabanco/";
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
        array('INVOICE_ID' => 'xsd:string','TRANSFER_DT' => 'xsd:string','TOTAL_BILL' => 'xsd:string' ),
        array('UBI_ERROR_WRK'=>'tns:respuesta'),
        $ns);

    $server->service($xml);
?>
