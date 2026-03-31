<?php
/**
 * Table Definition for concepto
 */
require_once 'DB/DataObject.php';

class DataObjects_Concepto extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'concepto';                        // table name
    var $codigoconcepto;                  // string(8)  not_null primary_key
    var $nombreconcepto;                  // string(100)  not_null
    var $codigotipoconcepto;              // string(2)  not_null multiple_key
    var $codigoaplicarecargo;             // string(2)  not_null multiple_key
    var $cuentaoperacionprincipal;        // string(20)  not_null
    var $cuentaoperacionparcial;          // string(20)  not_null
    var $codigoreferenciaconcepto;        // string(3)  not_null multiple_key
    var $codigoaplicabloqueodeuda;        // string(3)  not_null multiple_key
    var $codigocambiovalorconcepto;       // string(3)  not_null multiple_key
    var $codigoindicadorestadocuentaconcepto;    // string(3)  not_null multiple_key
    var $codigoestado;                    // string(3)  not_null multiple_key

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Concepto',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
