<?php
/**
 * Table Definition for tipomenuboton
 */
require_once 'DB/DataObject.php';

class DataObjects_Tipomenuboton extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'tipomenuboton';                   // table name
    var $codigotipomenuboton;             // string(3)  not_null primary_key
    var $nombretipomenuboton;             // string(100)  not_null

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Tipomenuboton',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
