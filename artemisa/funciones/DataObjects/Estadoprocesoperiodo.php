<?php
/**
 * Table Definition for estadoprocesoperiodo
 */
require_once 'DB/DataObject.php';

class DataObjects_Estadoprocesoperiodo extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'estadoprocesoperiodo';            // table name
    var $codigoestadoprocesoperiodo;      // string(3)  not_null primary_key
    var $nombreestadoprocesoperiodo;      // string(50)  not_null

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Estadoprocesoperiodo',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
