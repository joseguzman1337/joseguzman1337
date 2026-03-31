<?php
/**
 * Table Definition for tipoaplicaarp
 */
require_once 'DB/DataObject.php';

class DataObjects_Tipoaplicaarp extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'tipoaplicaarp';                   // table name
    var $codigotipoaplicaarp;             // string(3)  not_null primary_key
    var $nombretipoaplicaarp;             // string(50)  not_null

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Tipoaplicaarp',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
