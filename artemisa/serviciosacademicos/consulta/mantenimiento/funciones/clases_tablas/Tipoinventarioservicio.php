<?php
/**
 * Table Definition for tipoinventarioservicio
 */
require_once 'DB/DataObject.php';

class DataObjects_Tipoinventarioservicio extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'tipoinventarioservicio';          // table name
    public $codigotipoinventarioservicio;    // string(3)  not_null primary_key
    public $nombretipoinventarioservicio;    // string(50)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Tipoinventarioservicio',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
