<?php
/**
 * Table Definition for valoreducacioncontinuada
 */
require_once 'DB/DataObject.php';

class DataObjects_Valoreducacioncontinuada extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'valoreducacioncontinuada';        // table name
    var $idvaloreducacioncontinuada;      // int(11)  not_null primary_key auto_increment
    var $nombrevaloreducacioncontinuada;    // string(50)  not_null
    var $fechavaloreducacioncontinuada;    // datetime(19)  not_null binary
    var $codigocarrera;                   // int(11)  not_null multiple_key
    var $codigoconcepto;                  // string(8)  not_null multiple_key
    var $preciovaloreducacioncontinuada;    // int(11)  not_null
    var $fechainiciovaloreducacioncontinuada;    // datetime(19)  not_null binary
    var $fechafinalvaloreducacioncontinuada;    // datetime(19)  not_null binary

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Valoreducacioncontinuada',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
