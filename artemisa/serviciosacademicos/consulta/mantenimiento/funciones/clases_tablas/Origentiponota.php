<?php
/**
 * Table Definition for origentiponota
 */
require_once 'DB/DataObject.php';

class DataObjects_Origentiponota extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'origentiponota';                  // table name
    public $codigoorigentiponota;            // string(2)  not_null primary_key
    public $nombreorigentiponota;            // string(50)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Origentiponota',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
