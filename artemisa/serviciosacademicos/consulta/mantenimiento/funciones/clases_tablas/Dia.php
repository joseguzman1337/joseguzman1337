<?php
/**
 * Table Definition for dia
 */
require_once 'DB/DataObject.php';

class DataObjects_Dia extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'dia';                             // table name
    public $codigodia;                       // string(2)  not_null primary_key
    public $nombredia;                       // string(15)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Dia',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
