<?php
/**
 * Table Definition for estadoperiodo
 */
require_once '../funciones/pear/DB/DataObject.php';

class DataObjects_Estado extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */


    var $__table = 'estado';                          // table name
    var $codigoestado;                    // string(3)  not_null primary_key
    var $nombreestado;                    // string(50)  not_null

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Estado',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
