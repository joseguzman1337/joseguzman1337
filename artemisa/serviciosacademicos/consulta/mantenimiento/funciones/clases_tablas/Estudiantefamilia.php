<?php
/**
 * Table Definition for estudiantefamilia
 */
require_once 'DB/DataObject.php';

class DataObjects_Estudiantefamilia extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'estudiantefamilia';               // table name
    public $idestudiantefamilia;             // int(11)  not_null primary_key auto_increment
    public $apellidosestudiantefamilia;      // string(50)  not_null
    public $nombresestudiantefamilia;        // string(50)  not_null
    public $edadestudiantefamilia;           // int(6)  not_null
    public $direccionestudiantefamilia;      // string(50)  not_null
    public $idciudadestudiantefamilia;       // int(11)  not_null multiple_key
    public $telefonoestudiantefamilia;       // string(25)  not_null
    public $telefono2estudiantefamilia;      // string(25)  
    public $celularestudiantefamilia;        // string(25)  
    public $emailestudiantefamilia;          // string(50)  
    public $direccioncorrespondenciaestudiantefamilia;    // string(50)  
    public $idestudiantegeneral;             // int(11)  not_null multiple_key
    public $idinscripcion;                   // int(11)  not_null multiple_key
    public $idtipoestudiantefamilia;         // int(11)  not_null multiple_key
    public $profesionestudiantefamilia;      // string(50)  not_null
    public $ocupacionestudiantefamilia;      // string(50)  not_null
    public $idniveleducacion;                // int(11)  not_null multiple_key
    public $codigoestado;                    // string(3)  not_null multiple_key

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Estudiantefamilia',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
