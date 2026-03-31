<?php
/**
 * Table Definition for estudiantefamilia
 */
require_once 'DB/DataObject.php';

class DataObjects_Estudiantefamilia extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'estudiantefamilia';               // table name
    var $idestudiantefamilia;             // int(11)  not_null primary_key auto_increment
    var $apellidosestudiantefamilia;      // string(50)  not_null
    var $nombresestudiantefamilia;        // string(50)  not_null
    var $edadestudiantefamilia;           // int(6)  not_null
    var $direccionestudiantefamilia;      // string(50)  not_null
    var $idciudadestudiantefamilia;       // int(11)  not_null multiple_key
    var $telefonoestudiantefamilia;       // string(25)  not_null
    var $telefono2estudiantefamilia;      // string(25)  
    var $celularestudiantefamilia;        // string(25)  
    var $emailestudiantefamilia;          // string(50)  
    var $direccioncorrespondenciaestudiantefamilia;    // string(50)  
    var $idestudiantegeneral;             // int(11)  not_null multiple_key
    var $idinscripcion;                   // int(11)  not_null multiple_key
    var $idtipoestudiantefamilia;         // int(11)  not_null multiple_key
    var $profesionestudiantefamilia;      // string(50)  not_null
    var $ocupacionestudiantefamilia;      // string(50)  not_null
    var $idniveleducacion;                // int(11)  not_null multiple_key
    var $codigoestado;                    // string(3)  not_null multiple_key

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Estudiantefamilia',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
