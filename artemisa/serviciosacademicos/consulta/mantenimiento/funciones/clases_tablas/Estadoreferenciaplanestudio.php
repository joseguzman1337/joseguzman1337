<?php
/**
 * Table Definition for estadoreferenciaplanestudio
 */
require_once 'DB/DataObject.php';

class DataObjects_Estadoreferenciaplanestudio extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'estadoreferenciaplanestudio';     // table name
    public $codigoestadoreferenciaplanestudio;    // string(3)  not_null primary_key
    public $nombreestadoreferenciaplanestudio;    // string(50)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Estadoreferenciaplanestudio',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
