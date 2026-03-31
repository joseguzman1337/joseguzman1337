<?php
/**
 * Table Definition for tipoconcepto
 */
require_once '../funciones/pear/DB/DataObject.php';

class DataObjects_Tipoconcepto extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'tipoconcepto';                    // table name
    var $codigotipoconcepto;              // string(2)  not_null primary_key
    var $nombretipoconcepto;              // string(25)  not_null

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Tipoconcepto',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
