<?php
/**
 * Table Definition for detalleordenpago
 */
require_once 'DB/DataObject.php';

class DataObjects_Detalleordenpago extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'detalleordenpago';                // table name
    var $numeroordenpago;                 // int(11)  not_null multiple_key
    var $codigoconcepto;                  // string(8)  not_null multiple_key
    var $cantidaddetalleordenpago;        // int(6)  not_null
    var $valorconcepto;                   // int(11)  not_null
    var $codigotipodetalleordenpago;      // string(2)  not_null multiple_key

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Detalleordenpago',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
