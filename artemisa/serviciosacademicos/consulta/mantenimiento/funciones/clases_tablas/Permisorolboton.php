<?php
/**
 * Table Definition for permisorolboton
 */
require_once 'DB/DataObject.php';

class DataObjects_Permisorolboton extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'permisorolboton';                 // table name
    public $idrol;                           // int(11)  not_null primary_key multiple_key
    public $idmenuboton;                     // int(11)  not_null primary_key multiple_key

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Permisorolboton',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
