<?php
/**
 * Table Definition for descuentovsdeuda
 */
require_once 'DB/DataObject.php';

class DataObjects_Descuentovsdeuda extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'descuentovsdeuda';                // table name
    var $iddescuentovsdeuda;              // int(11)  not_null primary_key auto_increment
    var $fechadescuentovsdeuda;           // datetime(19)  not_null binary
    var $codigoestudiante;                // int(11)  not_null multiple_key
    var $codigoconcepto;                  // string(8)  not_null multiple_key
    var $valordescuentovsdeuda;           // int(11)  not_null
    var $codigoperiodo;                   // string(8)  not_null multiple_key
    var $codigoactualizo;                 // string(2)  not_null multiple_key
    var $codigoestadodescuentovsdeuda;    // string(2)  not_null multiple_key
    var $observaciondescuentovsdeuda;     // string(200)  not_null
    var $idusuario;                       // int(11)  not_null
    var $direccionip;                     // string(50)  not_null

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Descuentovsdeuda',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
