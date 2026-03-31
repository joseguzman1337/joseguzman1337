<?php
/**
 * Table Definition for estadoinstitucioneducativa
 */
require_once 'DB/DataObject.php';

class DataObjects_Estadoinstitucioneducativa extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'estadoinstitucioneducativa';      // table name
    public $codigoestadoinstitucioneducativa;    // string(3)  not_null primary_key
    public $nombreestadoinstitucioneducativa;    // string(50)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Estadoinstitucioneducativa',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
