<?php
/**
 * Table Definition for solicitudcredito
 */
require_once 'DB/DataObject.php';

class DataObjects_Solicitudcredito extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'solicitudcredito';                // table name
    var $idsolicitudcredito;              // int(11)  not_null primary_key auto_increment
    var $codigoestudiante;                // int(11)  not_null multiple_key
    var $codigoperiodo;                   // string(8)  not_null multiple_key
    var $numeroordenpago;                 // int(11)  not_null multiple_key
    var $fechasolicitudcredito;           // date(10)  not_null binary
    var $valorsolicitudcredito;           // int(11)  not_null
    var $valoraprobadosolicitudcredito;    // int(11)  
    var $fechaaprobacionsolicitudcredito;    // date(10)  binary
    var $observacionsolicitudcredito;     // string(50)  
    var $observacionaprobacionsolicitudcredito;    // string(100)  not_null
    var $codigoestadosolicitudcredito;    // string(2)  not_null multiple_key
    var $primeravezsolicitudcredito;      // string(2)  not_null

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Solicitudcredito',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
