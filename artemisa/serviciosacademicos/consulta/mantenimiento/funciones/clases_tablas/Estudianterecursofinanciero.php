<?php
/**
 * Table Definition for estudianterecursofinanciero
 */
require_once 'DB/DataObject.php';

class DataObjects_Estudianterecursofinanciero extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'estudianterecursofinanciero';     // table name
    public $idestudianterecursofinanciero;    // int(11)  not_null primary_key auto_increment
    public $idinscripcion;                   // int(11)  not_null multiple_key
    public $idestudiantegeneral;             // int(11)  not_null multiple_key
    public $idtipoestudianterecursofinanciero;    // int(11)  not_null multiple_key
    public $descripcionestudianterecursofinanciero;    // string(100)  not_null
    public $codigoestado;                    // string(3)  not_null multiple_key

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Estudianterecursofinanciero',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
