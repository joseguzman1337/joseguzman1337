<?php
/**
 * Table Definition for condicioncredito
 */
require_once 'DB/DataObject.php';

class DataObjects_Condicioncredito extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'condicioncredito';                // table name
    var $idcondicioncredito;              // int(11)  not_null primary_key auto_increment
    var $codigoperiodo;                   // string(8)  not_null multiple_key
    var $fechacondicioncredito;           // datetime(19)  not_null binary
    var $fechadesdecondicioncredito;      // date(10)  not_null binary
    var $fechahastacondicioncredito;      // date(10)  not_null binary
    var $maximocoutascondicioncredito;    // int(6)  not_null
    var $porcentajefinancierocondicioncredito;    // unknown(15)  not_null
    var $valorminimocondicioncredito;     // int(11)  not_null
    var $valormaximocondicioncredito;     // int(11)  not_null
    var $codigotipoaplicacioncuotacondicioncredito;    // string(3)  not_null multiple_key
    var $codigoestado;                    // string(3)  not_null multiple_key
    var $porcentajeminimoinicialcondicioncredito;    // unknown(15)  not_null
    var $observacioncondicioncredito;     // string(500)  not_null
    var $codigoreferenciacuotainicialcodicioncredito;    // string(3)  not_null multiple_key

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Condicioncredito',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
