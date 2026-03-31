<?php
/**
 * Table Definition for estadonotaarea
 */
require_once 'DB/DataObject.php';

class DataObjects_Estadonotaarea extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'estadonotaarea';                  // table name
    public $codigoestadonotaarea;            // string(3)  not_null primary_key
    public $nombreestadonotaarea;            // string(50)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Estadonotaarea',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
