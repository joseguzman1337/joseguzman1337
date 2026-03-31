<?php
/**
 * Table Definition for usuariorol
 */
require_once 'DB/DataObject.php';

class DataObjects_Usuariorol extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'usuariorol';                      // table name
    public $idrol;                           // int(11)  not_null primary_key
    //public $usuario;                         // string(50)  not_null primary_key unique_key

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Usuariorol',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
