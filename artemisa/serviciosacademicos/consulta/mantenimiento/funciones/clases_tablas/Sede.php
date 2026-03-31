<?php
/**
 * Table Definition for sede
 */
require_once 'DB/DataObject.php';

class DataObjects_Sede extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'sede';                            // table name
    public $codigosede;                      // string(2)  not_null primary_key
    public $nombresede;                      // string(30)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Sede',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
