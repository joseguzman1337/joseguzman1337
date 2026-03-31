<?php
/**
 * Table Definition for facultad
 */
require_once 'DB/DataObject.php';

class DataObjects_Facultad extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'facultad';                        // table name
    public $codigofacultad;                  // string(4)  not_null primary_key
    public $nombrefacultad;                  // string(40)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Facultad',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
