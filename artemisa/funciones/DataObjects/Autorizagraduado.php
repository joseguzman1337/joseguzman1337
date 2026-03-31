<?php
/**
 * Table Definition for autorizagraduado
 */
require_once 'DB/DataObject.php';

class DataObjects_Autorizagraduado extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'autorizagraduado';                // table name
    var $idautorizagraduado;              // int(11)  not_null primary_key auto_increment
    var $iddirectivo;                     // int(11)  not_null multiple_key
    var $fechainicioautorizagraduado;     // date(10)  not_null binary
    var $fechafinalautorizagraduado;      // date(10)  not_null binary

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Autorizagraduado',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
