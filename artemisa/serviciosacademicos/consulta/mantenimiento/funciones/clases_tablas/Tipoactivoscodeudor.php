<?php
/**
 * Table Definition for tipoactivoscodeudor
 */
require_once 'DB/DataObject.php';

class DataObjects_Tipoactivoscodeudor extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'tipoactivoscodeudor';             // table name
    public $codigotipoactivoscodeudor;       // string(2)  not_null primary_key
    public $nombretipoactivoscodeudor;       // string(30)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Tipoactivoscodeudor',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
