<?php
/**
 * Table Definition for tiponota
 */
require_once 'DB/DataObject.php';

class DataObjects_Tiponota extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'tiponota';                        // table name
    public $codigotiponota;                  // string(2)  not_null primary_key
    public $nombretiponota;                  // string(50)  not_null
    public $codigoreemplazatiponota;         // string(2)  not_null multiple_key
    public $codigoorigentiponota;            // string(6)  not_null multiple_key

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Tiponota',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
