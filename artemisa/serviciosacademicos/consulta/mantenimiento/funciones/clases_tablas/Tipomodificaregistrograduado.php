<?php
/**
 * Table Definition for tipomodificaregistrograduado
 */
require_once 'DB/DataObject.php';

class DataObjects_Tipomodificaregistrograduado extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'tipomodificaregistrograduado';    // table name
    public $codigotipomodificaregistrograduado;    // string(3)  not_null primary_key
    public $nombretipomodificaregistrograduado;    // string(100)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Tipomodificaregistrograduado',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
