<?php
/**
 * Table Definition for materiarotacion
 */
require_once 'DB/DataObject.php';

class DataObjects_Materiarotacion extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'materiarotacion';                 // table name
    public $idmateriarotacion;               // int(11)  not_null primary_key auto_increment
    public $fechamateriarotacion;            // date(10)  not_null binary
    public $nombrecortomateriarotacion;      // string(15)  not_null
    public $nombremateriarotacion;           // string(100)  not_null
    public $codigomateria;                   // int(11)  not_null multiple_key
    public $codigoestado;                    // string(3)  not_null multiple_key

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Materiarotacion',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
