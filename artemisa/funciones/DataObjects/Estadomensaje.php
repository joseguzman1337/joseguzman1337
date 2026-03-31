<?php
/**
 * Table Definition for estadomensaje
 */
require_once 'DB/DataObject.php';

class DataObjects_Estadomensaje extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'estadomensaje';                   // table name
    var $codigoestadomensaje;             // string(3)  not_null primary_key
    var $nombreestadomensaje;             // string(50)  not_null

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Estadomensaje',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
