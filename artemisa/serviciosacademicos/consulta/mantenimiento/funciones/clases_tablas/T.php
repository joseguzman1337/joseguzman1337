<?php
/**
 * Table Definition for t
 */
require_once 'DB/DataObject.php';

class DataObjects_T extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 't';                               // table name
    public $s1;                              // int(11)  
    public $fd;                              // datetime(19)  not_null binary
    public $fh;                              // date(10)  not_null binary

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_T',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
