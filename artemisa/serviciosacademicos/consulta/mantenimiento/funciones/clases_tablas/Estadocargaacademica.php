<?php
/**
 * Table Definition for estadocargaacademica
 */
require_once 'DB/DataObject.php';

class DataObjects_Estadocargaacademica extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'estadocargaacademica';            // table name
    public $codigoestadocargaacademica;      // string(3)  not_null primary_key
    public $nombreestadocargaacademica;      // string(50)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Estadocargaacademica',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
