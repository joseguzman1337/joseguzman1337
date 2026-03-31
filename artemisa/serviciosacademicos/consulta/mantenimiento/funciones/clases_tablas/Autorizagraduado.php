<?php
/**
 * Table Definition for autorizagraduado
 */
require_once 'DB/DataObject.php';

class DataObjects_Autorizagraduado extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'autorizagraduado';                // table name
    public $idautorizagraduado;              // int(11)  not_null primary_key auto_increment
    public $iddirectivo;                     // int(11)  not_null multiple_key
    public $fechainicioautorizagraduado;     // date(10)  not_null binary
    public $fechafinalautorizagraduado;      // date(10)  not_null binary

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Autorizagraduado',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
