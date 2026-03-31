<?php
/**
 * Table Definition for usuariopreinscripcion
 */
require_once 'DB/DataObject.php';

class DataObjects_Usuariopreinscripcion extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'usuariopreinscripcion';           // table name
    public $idusuariopreinscripcion;         // int(11)  not_null primary_key auto_increment
    public $idestudiantegeneral;             // int(11)  not_null unique_key
    public $usuariopreinscripcion;           // string(15)  not_null multiple_key
    public $claveusuariopreinscripcion;      // string(50)  not_null
    public $fechavencimientoclaveusuariopresinscripcion;    // date(10)  not_null binary
    public $fechavencimientousuariopresinscripcion;    // date(10)  not_null binary

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Usuariopreinscripcion',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
