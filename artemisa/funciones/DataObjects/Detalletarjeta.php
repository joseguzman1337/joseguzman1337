<?php
/**
 * Table Definition for detalletarjeta
 */
require_once 'DB/DataObject.php';

class DataObjects_Detalletarjeta extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'detalletarjeta';                  // table name
    var $codigoservicio;                  // int(11)  not_null multiple_key
    var $idtarjetaservicio;               // int(11)  not_null multiple_key
    var $idtarjeta;                       // int(11)  not_null multiple_key
    var $valordetalletarjeta;             // int(10)  not_null unsigned
    var $cantidaddetalletarjeta;          // int(5)  not_null unsigned

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Detalletarjeta',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
