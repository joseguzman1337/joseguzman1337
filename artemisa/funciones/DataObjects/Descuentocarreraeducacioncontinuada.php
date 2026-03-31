<?php
/**
 * Table Definition for descuentocarreraeducacioncontinuada
 */
require_once 'DB/DataObject.php';

class DataObjects_Descuentocarreraeducacioncontinuada extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'descuentocarreraeducacioncontinuada';    // table name
    var $iddescuentocarreraeducacioncontinuada;    // int(11)  not_null primary_key auto_increment
    var $descripciondescuentocarreraeducacioncontinuada;    // string(100)  not_null
    var $fechadescuentocarreraeducacioncontinuada;    // date(10)  not_null binary
    var $codigocarrera;                   // int(11)  not_null multiple_key
    var $iddescuentoeducacioncontinuada;    // int(11)  not_null multiple_key
    var $fechadesdedescuentocarreraeducacioncontinuada;    // date(10)  not_null binary
    var $fechahastadescuentocarreraeducacioncontinuada;    // date(10)  not_null binary
    var $idusuario;                       // int(11)  not_null multiple_key
    var $ip;                              // string(50)  not_null
    var $iddirectivo;                     // int(11)  not_null multiple_key
    var $codigoindicadordescuentouniversidad;    // string(3)  not_null multiple_key

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Descuentocarreraeducacioncontinuada',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
