<?php
/**
 * Table Definition for tipogrado
 */
require_once 'DB/DataObject.php';

class DataObjects_Tipogrado extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'tipogrado';                       // table name
    public $idtipogrado;                     // int(11)  not_null primary_key auto_increment
    public $nombretipogrado;                 // string(100)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Tipogrado',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
