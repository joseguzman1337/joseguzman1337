<?php
/**
 * Table Definition for rol
 */
require_once 'DB/DataObject.php';

class DataObjects_Rol extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'rol';                             // table name
    var $idrol;                           // int(11)  not_null primary_key multiple_key
    var $nombrerol;                       // string(50)  not_null
    var $codigogerarquiarol;              // string(2)  not_null primary_key multiple_key
    var $codigoaccesoarea;                // string(2)  not_null multiple_key

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Rol',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
