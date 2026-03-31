<?php
/**
 * Table Definition for lineaacademica
 */
require_once 'DB/DataObject.php';

class DataObjects_Lineaacademica extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'lineaacademica';                  // table name
    public $codigolineaacademica;            // string(3)  not_null primary_key
    public $nombrelineaacademica;            // string(50)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Lineaacademica',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
