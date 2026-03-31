<?php
ini_set('max_execution_time', 0);
define("CADENAADMINLDAP",'cn=Manager,dc=unbosque,dc=edu,dc=co');
define("RAIZDIRECTORIO",'dc=unbosque,dc=edu,dc=co');

$fecha = date('Y-m-d h:m:s');

//Rutas de produccion
define("WEBESTADOCUENTA","http://campus.unbosque.edu.co:8000/PSIGW/PeopleSoftServiceListeningConnector/PSFT_CS/UBI_ESTADO_CUENTA_SRV.2.wsdl");
define("WEBORDENDEPAGO","http://campus.unbosque.edu.co:8000/PSIGW/PeopleSoftServiceListeningConnector/PSFT_CS/UBI_CREA_ORDENPAG_SRV.1.wsdl");
define("WEBPLANDEPAGO","http://campus.unbosque.edu.co:8000/PSIGW/PeopleSoftServiceListeningConnector/PSFT_CS/UBI_CONS_PLANPAGO_SRV.1.wsdl");
if ($fecha >= '2020-09-30 00:00:00' && $fecha <= '2020-09-30 23:59:59') {
    // se inactiva pro proceso de facturacion electronica de cierre de nmes
    //define("WEBREPORTAPAGOPSE", "http://campus.unbosque.edu.co:8000/PSIGW/PeopleSoftServiceListeningConnector/PSFT_CS/UBI_PAGO_PSE_SRV.1.wsdl");
}else{
    define("WEBREPORTAPAGOPSE","http://campus.unbosque.edu.co:8000/PSIGW/PeopleSoftServiceListeningConnector/PSFT_CS/UBI_PAGO_PSE_SRV.1.wsdl");
}
