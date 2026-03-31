<?php
/**
 * Table Definition for valorserviciotarjeta
 */
require_once 'DB/DataObject.php';

class DataObjects_Valorserviciotarjeta extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'valorserviciotarjeta';            // table name
    public $idvalorserviciotarjeta;          // int(11)  not_null primary_key auto_increment
    public $codigoservicio;                  // int(11)  not_null multiple_key
    public $cantidadinicialvalorserviciotarjeta;    // int(6)  not_null
    public $cantidadfinalvalorserviciotarjeta;    // int(6)  not_null
    public $valorserviciotarjeta;            // int(11)  not_null
    public $codigotipocobro;                 // string(3)  not_null multiple_key

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Valorserviciotarjeta',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
