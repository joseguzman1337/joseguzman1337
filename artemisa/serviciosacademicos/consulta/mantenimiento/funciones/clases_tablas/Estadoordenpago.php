<?php
/**
 * Table Definition for estadoordenpago
 */
require_once 'DB/DataObject.php';

class DataObjects_Estadoordenpago extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'estadoordenpago';                 // table name
    public $codigoestadoordenpago;           // string(2)  not_null primary_key
    public $nombreestadoordenpago;           // string(50)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Estadoordenpago',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
