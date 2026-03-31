<?php
/**
 * Table Definition for descuentogrupoeducacioncontinuada
 */
require_once '../funciones/pear/DB/DataObject.php';

class DataObjects_Descuentogrupoeducacioncontinuada extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'descuentogrupoeducacioncontinuada';    // table name
    var $iddescuentogrupoeducacioncontinuada;    // int(11)  not_null primary_key auto_increment
    var $descripciondescuentogrupoeducacioncontinuada;    // string(100)  not_null
    var $fechadescuentogrupoeducacioncontinuada;    // date(10)  not_null binary
    var $idgrupo;                         // int(11)  not_null multiple_key
    var $iddescuentoeducacioncontinuada;    // int(11)  not_null multiple_key
    var $fechadesdedescuentogrupoeducacioncontinuada;    // date(10)  not_null binary
    var $fechahastadescuentogrupoeducacioncontinuada;    // date(10)  not_null binary
    var $idusuario;                       // int(11)  not_null multiple_key
    var $ip;                              // string(50)  not_null
    var $iddirectivo;                     // int(11)  not_null multiple_key

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Descuentogrupoeducacioncontinuada',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
