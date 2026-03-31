<?php
/**
 * Table Definition for periodo
 */
require_once 'DB/DataObject.php';

class DataObjects_Periodo extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'periodo';                         // table name
    var $codigoperiodo;                   // string(8)  not_null primary_key
    var $nombreperiodo;                   // string(100)  not_null
    var $codigoestadoperiodo;             // string(2)  not_null multiple_key
    var $fechainicioperiodo;              // datetime(19)  not_null binary
    var $fechavencimientoperiodo;         // datetime(19)  not_null binary
    var $numeroperiodo;                   // int(6)  not_null

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Periodo',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
