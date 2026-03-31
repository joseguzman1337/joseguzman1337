<?php
/**
 * Table Definition for estadoprocesoperiodo
 */
require_once 'DB/DataObject.php';

class DataObjects_Estadoprocesoperiodo extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'estadoprocesoperiodo';            // table name
    public $codigoestadoprocesoperiodo;      // string(3)  not_null primary_key
    public $nombreestadoprocesoperiodo;      // string(50)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Estadoprocesoperiodo',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
