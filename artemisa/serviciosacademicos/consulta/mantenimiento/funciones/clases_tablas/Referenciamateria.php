<?php
/**
 * Table Definition for referenciamateria
 */
require_once 'DB/DataObject.php';

class DataObjects_Referenciamateria extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'referenciamateria';               // table name
    public $codigoreferenciamateria;         // string(3)  not_null primary_key
    public $nombrereferenciamateria;         // string(100)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Referenciamateria',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
