<?php
/**
 * Table Definition for detalletiporespuesta
 */
require_once 'DB/DataObject.php';

class DataObjects_Detalletiporespuesta extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'detalletiporespuesta';            // table name
    var $iddetalletiporespuesta;          // int(11)  not_null primary_key auto_increment
    var $idtiporespuesta;                 // int(11)  not_null multiple_key
    var $nombrecortodetalletiporepuesta;    // string(20)  not_null
    var $codigoestado;                    // string(3)  not_null multiple_key

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Detalletiporespuesta',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
