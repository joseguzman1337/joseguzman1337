<?php
/**
 * Table Definition for claveusuariopreinscripcion
 */
require_once 'DB/DataObject.php';

class DataObjects_Claveusuariopreinscripcion extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'claveusuariopreinscripcion';      // table name
    public $idclaveusuariopreinscripcion;    // int(11)  not_null primary_key auto_increment
    public $idusuariopreinscripcion;         // int(11)  not_null multiple_key
    public $fechaclaveusuariopreinscripcion;    // datetime(19)  not_null binary
    public $recordarclaveusuariopreinscripcion;    // string(100)  not_null
    public $claveusuariopreinscripcion;      // string(50)  not_null
    public $codigoestadoclaveusuariopreinscripcion;    // string(3)  not_null multiple_key

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Claveusuariopreinscripcion',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
