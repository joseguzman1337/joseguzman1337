<?php
/**
 * Table Definition for usuariopreinscripcion
 */
require_once 'DB/DataObject.php';

class DataObjects_Usuariopreinscripcion extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'usuariopreinscripcion';           // table name
    var $idusuariopreinscripcion;         // int(11)  not_null primary_key auto_increment
    var $idestudiantegeneral;             // int(11)  not_null unique_key
    var $usuariopreinscripcion;           // string(15)  not_null multiple_key
    var $claveusuariopreinscripcion;      // string(50)  not_null
    var $fechavencimientoclaveusuariopresinscripcion;    // date(10)  not_null binary
    var $fechavencimientousuariopresinscripcion;    // date(10)  not_null binary

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Usuariopreinscripcion',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
