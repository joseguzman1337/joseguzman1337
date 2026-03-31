<?php
/**
 * Table Definition for estadodetalleprematricula
 */
require_once 'DB/DataObject.php';

class DataObjects_Estadodetalleprematricula extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'estadodetalleprematricula';       // table name
    var $codigoestadodetalleprematricula;    // string(2)  not_null primary_key
    var $nombreestadodetalleprematricula;    // string(25)  not_null

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Estadodetalleprematricula',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
