<?php
/**
 * Table Definition for descuentoeducacioncontinuada
 */
require_once '../funciones/pear/DB/DataObject.php';

class DataObjects_Descuentoeducacioncontinuada extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'descuentoeducacioncontinuada';    // table name
    var $iddescuentoeducacioncontinuada;    // int(11)  not_null primary_key auto_increment
    var $fechadescuentoeducacioncontinuada;    // date(10)  not_null binary
    var $nombredescuentoeducacioncontinuada;    // string(100)  not_null
    var $porcentajedescuentoeducacioncontinuada;    // int(11)  not_null
    var $codigotipodescuentoeducacioncontinuada;    // string(3)  not_null multiple_key
    var $fechadesdedescuentoeducacioncontinuada;    // date(10)  not_null binary
    var $fechahastadescuentoeducacioncontinuada;    // date(10)  not_null binary
    var $codigoconcepto;                  // string(8)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Descuentoeducacioncontinuada',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
