<?php
/**
 * Table Definition for tipoinstitucioneducativa
 */
require_once 'DB/DataObject.php';

class DataObjects_Tipoinstitucioneducativa extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'tipoinstitucioneducativa';        // table name
    var $codigotipoinstitucioneducativa;    // string(3)  not_null primary_key
    var $nombretipoinstitucioneducativa;    // string(50)  not_null

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Tipoinstitucioneducativa',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
