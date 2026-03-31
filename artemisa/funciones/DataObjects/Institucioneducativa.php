<?php
/**
 * Table Definition for institucioneducativa
 */
require_once 'DB/DataObject.php';

class DataObjects_Institucioneducativa extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'institucioneducativa';            // table name
    var $idinstitucioneducativa;          // int(11)  not_null primary_key auto_increment
    var $nombrecortoinstitucioneducativa;    // string(15)  unique_key
    var $nombreinstitucioneducativa;      // string(150)  
    var $codigojornada;                   // string(2)  multiple_key
    var $paisinstitucioneducativa;        // string(50)  
    var $municipioinstitucioneducativa;    // string(50)  
    var $departamentoinstitucioneducativa;    // string(50)  
    var $direccioninstitucioneducativa;    // string(50)  
    var $telefono1;                       // string(20)  
    var $telefono2;                       // string(20)  
    var $codigocalendarioestudiante;      // string(3)  multiple_key
    var $codigotipoinstitucioneducativa;    // string(3)  multiple_key
    var $codigoidiomainstitucioneducativa;    // string(3)  multiple_key
    var $codigoestadoinstitucioneducativa;    // string(3)  multiple_key
    var $codigogenero;                    // string(3)  multiple_key
    var $tarifainstitucioneducativa;      // string(25)  
    var $codigozona;                      // string(3)  multiple_key
    var $localizacioninstitucioneducativa;    // string(50)  
    var $numerofaxinstitucioneducativa;    // string(20)  
    var $apartadoaereoinstitucioneducativa;    // string(20)  
    var $cdaneinstitucioneducativa;       // string(30)  
    var $representateinstitucioneducativa;    // string(50)  
    var $codigonaturaleza;                // string(3)  multiple_key
    var $personajuridicainstitucioneducativa;    // string(50)  
    var $emailinstitucioneducativa;       // string(50)  
    var $httpnstitucioneducativa;         // string(50)  
    var $codigomodalidadacademica;        // string(3)  not_null multiple_key

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Institucioneducativa',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
