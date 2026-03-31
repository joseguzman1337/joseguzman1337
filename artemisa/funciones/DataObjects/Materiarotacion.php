<?php
/**
 * Table Definition for materiarotacion
 */
require_once 'DB/DataObject.php';

class DataObjects_Materiarotacion extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'materiarotacion';                 // table name
    var $idmateriarotacion;               // int(11)  not_null primary_key auto_increment
    var $fechamateriarotacion;            // date(10)  not_null binary
    var $nombrecortomateriarotacion;      // string(15)  not_null
    var $nombremateriarotacion;           // string(100)  not_null
    var $codigomateria;                   // int(11)  not_null multiple_key
    var $codigoestado;                    // string(3)  not_null multiple_key

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Materiarotacion',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
