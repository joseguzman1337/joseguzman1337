<?php
/**
 * Table Definition for numeroopcion
 */
require_once 'DB/DataObject.php';

class DataObjects_Numeroopcion extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'numeroopcion';                    // table name
    public $idnumeroopcion;                  // int(11)  not_null primary_key auto_increment
    public $nombrenumeroopcion;              // string(50)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Numeroopcion',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
