<?php
/**
 * Table Definition for estadomenuboton
 */
require_once 'DB/DataObject.php';

class DataObjects_Estadomenuboton extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'estadomenuboton';                 // table name
    public $codigoestadomenuboton;           // string(2)  not_null primary_key
    public $nombreestadomenuboton;           // string(50)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Estadomenuboton',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
