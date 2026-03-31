<?php
/**
 * Table Definition for detallefechaeducacioncontinuada
 */
require_once '../funciones/pear/DB/DataObject.php';

class DataObjects_Detallefechaeducacioncontinuada extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'detallefechaeducacioncontinuada';    // table name
    var $iddetallefechaeducacioncontinuada;    // int(11)  not_null primary_key auto_increment
    var $idfechaeducacioncontinuada;      // int(11)  not_null multiple_key
    var $numerodetallefechaeducacioncontinuada;    // string(3)  not_null
    var $nombredetallefechaeducacioncontinuada;    // string(20)  not_null
    var $fechadetallefechaeducacioncontinuada;    // date(10)  not_null binary
    var $porcentajedetallefechaeducacioncontinuada;    // int(6)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Detallefechaeducacioncontinuada',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
