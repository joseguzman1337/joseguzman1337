<?php
/**
 * Table Definition for reemplazatiponota
 */
require_once 'DB/DataObject.php';

class DataObjects_Reemplazatiponota extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'reemplazatiponota';               // table name
    public $codigoreemplazatiponota;         // string(2)  not_null primary_key
    public $nombrereemplazatiponota;         // string(50)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Reemplazatiponota',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
