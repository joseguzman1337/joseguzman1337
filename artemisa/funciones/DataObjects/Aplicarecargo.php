<?php
/**
 * Table Definition for aplicarecargo
 */
require_once 'DB/DataObject.php';

class DataObjects_Aplicarecargo extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'aplicarecargo';                   // table name
    var $codigoaplicarecargo;             // string(2)  not_null primary_key
    var $nombreaplicarecargo;             // string(25)  not_null

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Aplicarecargo',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
