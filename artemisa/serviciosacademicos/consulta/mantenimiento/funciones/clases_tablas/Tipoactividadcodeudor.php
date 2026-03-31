<?php
/**
 * Table Definition for tipoactividadcodeudor
 */
require_once 'DB/DataObject.php';

class DataObjects_Tipoactividadcodeudor extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'tipoactividadcodeudor';           // table name
    public $codigotipoactividadcodeudor;     // string(2)  not_null primary_key
    public $nombretipoactividadcodeudor;     // string(30)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Tipoactividadcodeudor',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
