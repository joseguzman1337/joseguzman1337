<?php
/**
 * Table Definition for detallefechafinanciera
 */
require_once 'DB/DataObject.php';

class DataObjects_Detallefechafinanciera extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'detallefechafinanciera';          // table name
    var $iddetallefechafinanciera;        // int(11)  not_null primary_key auto_increment
    var $idfechafinanciera;               // int(11)  not_null multiple_key
    var $numerodetallefechafinanciera;    // string(3)  not_null
    var $nombredetallefechafinanciera;    // string(20)  not_null
    var $fechadetallefechafinanciera;     // date(10)  not_null binary
    var $porcentajedetallefechafinanciera;    // int(6)  not_null
    var $codigoconceptodetallefechafinanciera;    // string(2)  not_null multiple_key

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Detallefechafinanciera',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
