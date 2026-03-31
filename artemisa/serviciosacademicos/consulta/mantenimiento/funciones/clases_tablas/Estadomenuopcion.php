<?php
/**
 * Table Definition for estadomenuopcion
 */
require_once 'DB/DataObject.php';

class DataObjects_Estadomenuopcion extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'estadomenuopcion';                // table name
    public $codigoestadomenuopcion;          // string(2)  not_null primary_key
    public $nombreestadomenuopcion;          // string(50)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Estadomenuopcion',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
