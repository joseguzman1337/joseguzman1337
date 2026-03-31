<?php
/**
 * Table Definition for tipodetalleprematricula
 */
require_once 'DB/DataObject.php';

class DataObjects_Tipodetalleprematricula extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'tipodetalleprematricula';         // table name
    var $codigotipodetalleprematricula;    // string(2)  not_null primary_key
    var $nombretipodetalleprematricula;    // string(25)  not_null

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Tipodetalleprematricula',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
