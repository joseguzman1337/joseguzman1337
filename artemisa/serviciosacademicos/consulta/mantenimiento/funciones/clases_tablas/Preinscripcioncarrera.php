<?php
/**
 * Table Definition for preinscripcioncarrera
 */
require_once 'DB/DataObject.php';

class DataObjects_Preinscripcioncarrera extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'preinscripcioncarrera';           // table name
    public $idpreinscripcion;                // int(11)  not_null primary_key
    public $codigocarrera;                   // int(11)  not_null primary_key multiple_key

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Preinscripcioncarrera',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
