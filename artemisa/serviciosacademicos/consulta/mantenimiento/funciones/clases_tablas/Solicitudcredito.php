<?php
/**
 * Table Definition for solicitudcredito
 */
require_once 'DB/DataObject.php';

class DataObjects_Solicitudcredito extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'solicitudcredito';                // table name
    public $idsolicitudcredito;              // int(11)  not_null primary_key auto_increment
    public $codigoestudiante;                // int(11)  not_null multiple_key
    public $codigoperiodo;                   // string(8)  not_null multiple_key
    public $numeroordenpago;                 // int(11)  not_null multiple_key
    public $fechasolicitudcredito;           // date(10)  not_null binary
    public $valorsolicitudcredito;           // int(11)  not_null
    public $valoraprobadosolicitudcredito;    // int(11)  
    public $fechaaprobacionsolicitudcredito;    // date(10)  binary
    public $observacionsolicitudcredito;     // string(50)  
    public $observacionaprobacionsolicitudcredito;    // string(100)  not_null
    public $codigoestadosolicitudcredito;    // string(2)  not_null multiple_key
    public $primeravezsolicitudcredito;      // string(2)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Solicitudcredito',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
