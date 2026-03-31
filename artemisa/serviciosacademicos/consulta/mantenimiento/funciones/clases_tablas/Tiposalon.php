<?php
/**
 * Table Definition for tiposalon
 */
require_once 'DB/DataObject.php';

class DataObjects_Tiposalon extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'tiposalon';                       // table name
    public $codigotiposalon;                 // string(2)  not_null primary_key
    public $nombretiposalon;                 // string(30)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Tiposalon',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
