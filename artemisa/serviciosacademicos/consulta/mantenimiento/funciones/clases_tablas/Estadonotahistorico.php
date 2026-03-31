<?php
/**
 * Table Definition for estadonotahistorico
 */
require_once 'DB/DataObject.php';

class DataObjects_Estadonotahistorico extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'estadonotahistorico';             // table name
    public $codigoestadonotahistorico;       // string(3)  not_null primary_key
    public $nombreestadonotahistorico;       // string(50)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Estadonotahistorico',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
