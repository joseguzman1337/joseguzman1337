<?php
/**
 * Table Definition for valorserviciotarjeta
 */
require_once 'DB/DataObject.php';

class DataObjects_Valorserviciotarjeta extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'valorserviciotarjeta';            // table name
    var $idvalorserviciotarjeta;          // int(11)  not_null primary_key auto_increment
    var $codigoservicio;                  // int(11)  not_null multiple_key
    var $cantidadinicialvalorserviciotarjeta;    // int(6)  not_null
    var $cantidadfinalvalorserviciotarjeta;    // int(6)  not_null
    var $valorserviciotarjeta;            // int(11)  not_null
    var $codigotipocobro;                 // string(3)  not_null multiple_key

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Valorserviciotarjeta',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
