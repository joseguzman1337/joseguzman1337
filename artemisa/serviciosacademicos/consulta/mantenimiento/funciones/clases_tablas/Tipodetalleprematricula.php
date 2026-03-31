<?php
/**
 * Table Definition for tipodetalleprematricula
 */
require_once 'DB/DataObject.php';

class DataObjects_Tipodetalleprematricula extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'tipodetalleprematricula';         // table name
    public $codigotipodetalleprematricula;    // string(2)  not_null primary_key
    public $nombretipodetalleprematricula;    // string(25)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Tipodetalleprematricula',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
