<?php
/**
 * Table Definition for tipogrupomateria
 */
require_once 'DB/DataObject.php';

class DataObjects_Tipogrupomateria extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'tipogrupomateria';                // table name
    var $codigotipogrupomateria;          // string(3)  not_null primary_key
    var $nombretipogrupomateria;          // string(50)  not_null

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Tipogrupomateria',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
