<?php
/**
 * Table Definition for tipogeneracionhorariositioadmision
 */
require_once 'DB/DataObject.php';

class DataObjects_Tipogeneracionhorariositioadmision extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'tipogeneracionhorariositioadmision';    // table name
    public $codigotipogeneracionhorariositioadmision;    // string(3)  not_null primary_key
    public $nombretipogeneracionhorariositioadmision;    // string(50)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Tipogeneracionhorariositioadmision',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
