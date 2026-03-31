<?php
/**
 * Table Definition for admision
 */
require_once 'DB/DataObject.php';

class DataObjects_Admision extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'admision';                        // table name
    var $idadmision;                      // int(11)  not_null primary_key auto_increment
    var $nombreadmision;                  // string(100)  not_null
    var $codigoperiodo;                   // string(8)  not_null multiple_key
    var $codigocarrera;                   // int(11)  not_null multiple_key
    var $codigoestado;                    // string(3)  not_null multiple_key
    var $cantidadseleccionadoadmision;    // int(6)  not_null

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Admision',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
