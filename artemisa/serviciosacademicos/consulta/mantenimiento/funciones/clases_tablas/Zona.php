<?php
/**
 * Table Definition for zona
 */
require_once 'DB/DataObject.php';

class DataObjects_Zona extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'zona';                            // table name
    public $codigozona;                      // string(3)  not_null primary_key
    public $nombrezona;                      // string(50)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Zona',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
