<?php
/**
 * Table Definition for tiponota
 */
require_once 'DB/DataObject.php';

class DataObjects_Tiponota extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'tiponota';                        // table name
    var $codigotiponota;                  // string(2)  not_null primary_key
    var $nombretiponota;                  // string(50)  not_null
    var $codigoreemplazatiponota;         // string(2)  not_null multiple_key
    var $codigoorigentiponota;            // string(6)  not_null multiple_key

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Tiponota',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
