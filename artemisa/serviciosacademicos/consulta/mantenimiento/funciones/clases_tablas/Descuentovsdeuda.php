<?php
/**
 * Table Definition for descuentovsdeuda
 */
require_once 'DB/DataObject.php';

class DataObjects_Descuentovsdeuda extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'descuentovsdeuda';                // table name
    public $iddescuentovsdeuda;              // int(11)  not_null primary_key auto_increment
    public $fechadescuentovsdeuda;           // datetime(19)  not_null binary
    public $codigoestudiante;                // int(11)  not_null multiple_key
    public $codigoconcepto;                  // string(3)  not_null multiple_key
    public $valordescuentovsdeuda;           // int(11)  not_null
    public $codigoperiodo;                   // string(8)  not_null multiple_key
    public $codigoactualizo;                 // string(2)  not_null multiple_key
    public $codigoestadodescuentovsdeuda;    // string(2)  not_null multiple_key
    public $observaciondescuentovsdeuda;     // string(200)  not_null
    public $idusuario;                       // int(11)  not_null
    public $direccionip;                     // string(50)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Descuentovsdeuda',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
