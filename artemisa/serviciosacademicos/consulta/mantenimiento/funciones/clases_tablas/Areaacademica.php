<?php
/**
 * Table Definition for areaacademica
 */
require_once 'DB/DataObject.php';

class DataObjects_Areaacademica extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'areaacademica';                   // table name
    public $codigoareaacademica;             // string(3)  not_null primary_key
    public $nombreareaacademica;             // string(50)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Areaacademica',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
