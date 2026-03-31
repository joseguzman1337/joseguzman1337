<?php
/**
 * Table Definition for preinscripcion
 */
require_once 'DB/DataObject.php';

class DataObjects_Preinscripcion extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'preinscripcion';                  // table name
    var $idpreinscripcion;                // int(11)  not_null primary_key auto_increment
    var $fechapreinscripcion;             // date(10)  not_null binary
    var $numerodocumento;                 // string(15)  
    var $tipodocumento;                   // string(2)  multiple_key
    var $codigoperiodo;                   // string(8)  not_null multiple_key
    var $apellidosestudiante;             // string(25)  not_null
    var $nombresestudiante;               // string(50)  not_null
    var $direccionestudiante;             // string(50)  
    var $ciudadestudiante;                // string(50)  
    var $barrioestudiante;                // string(50)  
    var $telefonoestudiante;              // string(15)  
    var $celularestudiante;               // string(15)  
    var $emailestudiante;                 // string(50)  
    var $institucionpreinscripcionestudiante;    // string(50)  
    var $gradoestudiante;                 // string(3)  
    var $codigocalendarioestudiante;      // string(3)  multiple_key
    var $codigoestadopreinscripcionestudiante;    // string(3)  not_null multiple_key
    var $idusuario;                       // int(11)  multiple_key
    var $ip;                              // string(50)  not_null

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Preinscripcion',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
