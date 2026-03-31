<?php
/**
 * Table Definition for preinscripcionseguimiento
 */
require_once 'DB/DataObject.php';

class DataObjects_Preinscripcionseguimiento extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'preinscripcionseguimiento';       // table name
    public $idpreinscripcion;                // int(11)  not_null multiple_key
    public $observacionpreinscripcionseguimiento;    // blob(-1)  not_null blob
    public $fechapreinscripcionseguimiento;    // datetime(19)  not_null binary
    public $username;                        // string(50)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Preinscripcionseguimiento',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
