<?php
/**
 * Table Definition for estadogrupo
 */
require_once 'DB/DataObject.php';

class DataObjects_Estadogrupo extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'estadogrupo';                     // table name
    public $codigoestadogrupo;               // string(2)  not_null primary_key
    public $nombreestadogrupo;               // string(50)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Estadogrupo',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
