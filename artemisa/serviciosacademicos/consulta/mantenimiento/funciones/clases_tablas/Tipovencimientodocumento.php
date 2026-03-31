<?php
/**
 * Table Definition for tipovencimientodocumento
 */
require_once 'DB/DataObject.php';

class DataObjects_Tipovencimientodocumento extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'tipovencimientodocumento';        // table name
    public $codigotipovencimientodocumento;    // string(3)  not_null primary_key
    public $nombretipodocumentovencimiento;    // string(50)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Tipovencimientodocumento',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
