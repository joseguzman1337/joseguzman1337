<?php
/**
 * Table Definition for descuentoestudianteeducacioncontinuada
 */
require_once '../funciones/pear/DB/DataObject.php';

class DataObjects_Descuentoestudianteeducacioncontinuada extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'descuentoestudianteeducacioncontinuada';    // table name
    var $iddescuentoestudianteeducacioncontinuada;    // int(11)  not_null primary_key auto_increment
    var $descripciondescuentoestudianteeducacioncontinuada;    // string(100)  not_null
    var $fechadescuentoestudianteeducacioncontinuada;    // date(10)  not_null binary
    var $codigoestudiante;                // int(11)  not_null multiple_key
    var $iddescuentoeducacioncontinuada;    // int(11)  not_null multiple_key
    var $fechadesdedescuentoestudianteeducacioncontinuada;    // date(10)  not_null binary
    var $fechahastadescuentoestudianteeducacioncontinuada;    // date(10)  not_null binary
    var $idusuario;                       // int(11)  not_null multiple_key
    var $ip;                              // string(50)  not_null
    var $iddirectivo;                     // int(11)  not_null multiple_key

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Descuentoestudianteeducacioncontinuada',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
