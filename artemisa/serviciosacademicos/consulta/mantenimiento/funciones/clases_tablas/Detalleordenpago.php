<?php
/**
 * Table Definition for detalleordenpago
 */
require_once 'DB/DataObject.php';

class DataObjects_Detalleordenpago extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'detalleordenpago';                // table name
    public $numeroordenpago;                 // int(11)  not_null multiple_key
    public $codigoconcepto;                  // string(3)  not_null multiple_key
    public $cantidaddetalleordenpago;        // int(6)  not_null
    public $valorconcepto;                   // int(11)  not_null
    public $codigotipodetalleordenpago;      // string(2)  not_null multiple_key

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Detalleordenpago',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
