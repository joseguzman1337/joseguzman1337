<?php
/**
 * Table Definition for estadoperiodo
 */
require_once '../funciones/pear/DB/DataObject.php';

class DataObjects_Autorizaconcepto extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */


	var $__table = 'autorizaconcepto';                // table name
    var $idautorizaconcepto;              // int(11)  not_null primary_key auto_increment
    var $fechaautorizaconcepto;           // date(10)  not_null binary
    var $fechavencimientoautorizaconcepto;    // date(10)  not_null binary
    var $idusuario;                       // int(11)  not_null multiple_key
    var $ip;                              // string(50)  not_null
    var $codigoestudiante;                // int(11)  not_null multiple_key
    var $codigoconcepto;                  // string(3)  not_null multiple_key
    var $observacionautorizaconcepto;     // string(100)  not_null

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Autorizaconcepto',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
