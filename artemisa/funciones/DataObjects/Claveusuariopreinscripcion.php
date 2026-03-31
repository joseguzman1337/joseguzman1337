<?php
/**
 * Table Definition for claveusuariopreinscripcion
 */
require_once 'DB/DataObject.php';

class DataObjects_Claveusuariopreinscripcion extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'claveusuariopreinscripcion';      // table name
    var $idclaveusuariopreinscripcion;    // int(11)  not_null primary_key auto_increment
    var $idusuariopreinscripcion;         // int(11)  not_null multiple_key
    var $fechaclaveusuariopreinscripcion;    // datetime(19)  not_null binary
    var $recordarclaveusuariopreinscripcion;    // string(100)  not_null
    var $claveusuariopreinscripcion;      // string(50)  not_null
    var $codigoestadoclaveusuariopreinscripcion;    // string(3)  not_null multiple_key

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Claveusuariopreinscripcion',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
