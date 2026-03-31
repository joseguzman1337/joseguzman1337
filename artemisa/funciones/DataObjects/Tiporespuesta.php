<?php
/**
 * Table Definition for tiporespuesta
 */
require_once 'DB/DataObject.php';

class DataObjects_Tiporespuesta extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'tiporespuesta';                   // table name
    var $idtiporespuesta;                 // int(11)  not_null primary_key auto_increment
    var $nombrerespuesta;                 // string(80)  not_null
    var $codigoestado;                    // string(3)  not_null multiple_key

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Tiporespuesta',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
