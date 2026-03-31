<?php
/**
 * Table Definition for sucursal
 */
require_once 'DB/DataObject.php';

class DataObjects_Sucursal extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'sucursal';                        // table name
    public $codigosucursal;                  // string(2)  not_null primary_key
    public $nombresucursal;                  // string(25)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Sucursal',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
