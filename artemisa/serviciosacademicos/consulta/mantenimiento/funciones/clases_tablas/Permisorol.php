<?php
/**
 * Table Definition for permisorol
 */
require_once 'DB/DataObject.php';

class DataObjects_Permisorol extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'permisorol';                      // table name
    public $idrol;                           // int(11)  not_null primary_key multiple_key
    public $idmenuopcion;                    // int(11)  not_null primary_key multiple_key

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Permisorol',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
