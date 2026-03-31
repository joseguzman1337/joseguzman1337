<?php
/**
 * Table Definition for detalletarjeta
 */
require_once 'DB/DataObject.php';

class DataObjects_Detalletarjeta extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'detalletarjeta';                  // table name
    public $codigoservicio;                  // int(11)  not_null multiple_key
    public $idtarjetaservicio;               // int(11)  not_null multiple_key
    public $idtarjeta;                       // int(11)  not_null multiple_key
    public $valordetalletarjeta;             // int(10)  not_null unsigned
    public $cantidaddetalletarjeta;          // int(5)  not_null unsigned

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Detalletarjeta',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
