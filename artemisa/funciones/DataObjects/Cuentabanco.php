<?php
/**
 * Table Definition for cuentabanco
 */
require_once 'DB/DataObject.php';

class DataObjects_Cuentabanco extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'cuentabanco';                     // table name
    var $idcuentabanco;                   // int(11)  not_null primary_key auto_increment
    var $numerocuentabanco;               // string(30)  not_null multiple_key
    var $codigoperiodo;                   // string(8)  not_null
    var $codigobanco;                     // string(3)  not_null multiple_key
    var $codigocarrera;                   // int(11)  not_null multiple_key

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Cuentabanco',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
