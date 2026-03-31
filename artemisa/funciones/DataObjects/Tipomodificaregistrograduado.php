<?php
/**
 * Table Definition for tipomodificaregistrograduado
 */
require_once 'DB/DataObject.php';

class DataObjects_Tipomodificaregistrograduado extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'tipomodificaregistrograduado';    // table name
    var $codigotipomodificaregistrograduado;    // string(3)  not_null primary_key
    var $nombretipomodificaregistrograduado;    // string(100)  not_null

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Tipomodificaregistrograduado',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
