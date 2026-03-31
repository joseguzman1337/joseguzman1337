<?php
/**
 * Table Definition for usuariorol
 */
require_once 'DB/DataObject.php';

class DataObjects_Usuariorol extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'usuariorol';                      // table name
    var $idrol;                           // int(11)  not_null primary_key
    //var $usuario;                         // string(50)  not_null primary_key unique_key

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Usuariorol',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
