<?php
/**
 * Table Definition for cedulas
 */
require_once 'DB/DataObject.php';

class DataObjects_Cedulas extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'cedulas';                         // table name
    public $CEDULA;                          // string(255)  
    public $ID;                              // string(255)  

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Cedulas',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
