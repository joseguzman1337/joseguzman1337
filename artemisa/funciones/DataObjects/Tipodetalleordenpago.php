<?php
/**
 * Table Definition for tipodetalleordenpago
 */
require_once 'DB/DataObject.php';

class DataObjects_Tipodetalleordenpago extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'tipodetalleordenpago';            // table name
    var $codigotipodetalleordenpago;      // string(2)  not_null primary_key
    var $nombretipodetalleordenpago;      // string(25)  not_null

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Tipodetalleordenpago',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
