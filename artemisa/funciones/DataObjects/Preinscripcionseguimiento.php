<?php
/**
 * Table Definition for preinscripcionseguimiento
 */
require_once 'DB/DataObject.php';

class DataObjects_Preinscripcionseguimiento extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'preinscripcionseguimiento';       // table name
    var $idpreinscripcion;                // int(11)  not_null multiple_key
    var $observacionpreinscripcionseguimiento;    // blob(-1)  not_null blob
    var $fechapreinscripcionseguimiento;    // datetime(19)  not_null binary
    var $username;                        // string(50)  not_null

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Preinscripcionseguimiento',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
