<?php
/**
 * Table Definition for estadodetalleprematricula
 */
require_once 'DB/DataObject.php';

class DataObjects_Estadodetalleprematricula extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'estadodetalleprematricula';       // table name
    public $codigoestadodetalleprematricula;    // string(2)  not_null primary_key
    public $nombreestadodetalleprematricula;    // string(25)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Estadodetalleprematricula',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
