<?php
/**
 * Table Definition for tipoinstitucioneducativa
 */
require_once 'DB/DataObject.php';

class DataObjects_Tipoinstitucioneducativa extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'tipoinstitucioneducativa';        // table name
    public $codigotipoinstitucioneducativa;    // string(3)  not_null primary_key
    public $nombretipoinstitucioneducativa;    // string(50)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Tipoinstitucioneducativa',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
