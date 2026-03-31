<?php
/**
 * Table Definition for estadomenuopcion
 */
require_once 'DB/DataObject.php';

class DataObjects_Estadomenuopcion extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'estadomenuopcion';                // table name
    var $codigoestadomenuopcion;          // string(2)  not_null primary_key
    var $nombreestadomenuopcion;          // string(50)  not_null

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Estadomenuopcion',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
