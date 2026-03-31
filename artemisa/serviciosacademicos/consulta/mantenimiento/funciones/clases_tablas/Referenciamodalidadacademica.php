<?php
/**
 * Table Definition for referenciamodalidadacademica
 */
require_once 'DB/DataObject.php';

class DataObjects_Referenciamodalidadacademica extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'referenciamodalidadacademica';    // table name
    public $codigoreferenciamodalidadacademica;    // string(3)  not_null primary_key
    public $nombrereferenciamodalidadacademica;    // string(50)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Referenciamodalidadacademica',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
