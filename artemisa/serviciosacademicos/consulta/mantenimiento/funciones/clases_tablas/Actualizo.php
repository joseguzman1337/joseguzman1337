<?php
/**
 * Table Definition for actualizo
 */
require_once 'DB/DataObject.php';

class DataObjects_Actualizo extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'actualizo';                       // table name
    public $codigoactualizo;                 // string(2)  not_null primary_key
    public $nombreactualizo;                 // string(25)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Actualizo',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
