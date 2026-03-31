<?php
/**
 * Table Definition for estadomateria
 */
require_once 'DB/DataObject.php';

class DataObjects_Estadomateria extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'estadomateria';                   // table name
    public $codigoestadomateria;             // string(2)  not_null primary_key
    public $nombreestadomateria;             // string(30)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Estadomateria',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
