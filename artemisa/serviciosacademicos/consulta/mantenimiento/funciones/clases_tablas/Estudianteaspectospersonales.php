<?php
/**
 * Table Definition for estudianteaspectospersonales
 */
require_once 'DB/DataObject.php';

class DataObjects_Estudianteaspectospersonales extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'estudianteaspectospersonales';    // table name
    public $idestudianteaspectospersonales;    // int(11)  not_null primary_key auto_increment
    public $descripcionestudianteaspectospersonales;    // string(200)  not_null
    public $idestudiantegeneral;             // int(11)  not_null multiple_key
    public $idinscripcion;                   // int(11)  not_null multiple_key
    public $idtipoestudianteaspectospersonales;    // int(11)  not_null multiple_key
    public $codigoestado;                    // string(3)  not_null multiple_key

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Estudianteaspectospersonales',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
