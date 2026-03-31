<?php
/**
 * Table Definition for estadotarjeta
 */
require_once 'DB/DataObject.php';

class DataObjects_Estadotarjeta extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'estadotarjeta';                   // table name
    public $codigoestadotarjeta;             // string(3)  not_null primary_key
    public $nombreestadotarjeta;             // string(100)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Estadotarjeta',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
