<?php
/**
 * Table Definition for preinscripcion
 */
require_once 'DB/DataObject.php';

class DataObjects_Preinscripcion extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'preinscripcion';                  // table name
    public $idpreinscripcion;                // int(11)  not_null primary_key auto_increment
    public $fechapreinscripcion;             // date(10)  not_null binary
    public $numerodocumento;                 // string(15)  
    public $tipodocumento;                   // string(2)  multiple_key
    public $codigoperiodo;                   // string(8)  not_null multiple_key
    public $apellidosestudiante;             // string(25)  not_null
    public $nombresestudiante;               // string(50)  not_null
    public $direccionestudiante;             // string(50)  
    public $ciudadestudiante;                // string(50)  
    public $barrioestudiante;                // string(50)  
    public $telefonoestudiante;              // string(15)  
    public $celularestudiante;               // string(15)  
    public $emailestudiante;                 // string(50)  
    public $institucionpreinscripcionestudiante;    // string(50)  
    public $gradoestudiante;                 // string(3)  
    public $codigocalendarioestudiante;      // string(3)  multiple_key
    public $codigoestadopreinscripcionestudiante;    // string(3)  not_null multiple_key
    public $idusuario;                       // int(11)  multiple_key
    public $ip;                              // string(50)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Preinscripcion',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
