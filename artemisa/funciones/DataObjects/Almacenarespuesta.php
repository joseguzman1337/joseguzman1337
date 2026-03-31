<?php
/**
 * Table Definition for almacenarespuesta
 */
require_once 'DB/DataObject.php';

class DataObjects_Almacenarespuesta extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'almacenarespuesta';               // table name
    var $idalmacenarespuesta;             // int(11)  not_null primary_key auto_increment
    var $iddetalletiporespuesta;          // int(11)  not_null multiple_key
    var $iddetallerespuestaencuesta;      // int(11)  not_null multiple_key
    var $descripcionalmacenarespuesta;    // blob(65535)  blob

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Almacenarespuesta',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
