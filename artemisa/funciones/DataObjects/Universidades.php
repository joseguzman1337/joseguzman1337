<?php
/**
 * Table Definition for universidades
 */
require_once 'DB/DataObject.php';

class DataObjects_Universidades extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'universidades';                   // table name
    var $idinstitucioneducativa;          // real(22)  
    var $nombrecortoinstitucioneducativa;    // string(255)  
    var $nombreinstitucioneducativa;      // string(255)  
    var $codigojornada;                   // string(255)  
    var $paisinstitucioneducativa;        // string(255)  
    var $municipioinstitucioneducativa;    // string(255)  
    var $departamentoinstitucioneducativa;    // string(255)  
    var $direccioninstitucioneducativa;    // string(255)  
    var $telefono1;                       // string(255)  
    var $telefono2;                       // string(255)  
    var $codigocalendarioestudiante;      // string(255)  
    var $codigotipoinstitucioneducativa;    // string(255)  
    var $codigoidiomainstitucioneducativa;    // string(255)  
    var $codigoestadoinstitucioneducativa;    // real(22)  
    var $codigogenero;                    // real(22)  
    var $tarifainstitucioneducativa;      // real(22)  
    var $codigozona;                      // real(22)  
    var $localizacioninstitucioneducativa;    // string(255)  
    var $numerofaxinstitucioneducativa;    // string(255)  
    var $apartadoaereoinstitucioneducativa;    // string(255)  
    var $cdaneinstitucioneducativa;       // real(22)  
    var $representateinstitucioneducativa;    // string(255)  
    var $codigonaturaleza;                // string(255)  
    var $personajuridicainstitucioneducativa;    // real(22)  
    var $emailinstitucioneducativa;       // string(255)  
    var $httpnstitucioneducativa;         // string(255)  
    var $codigomodalidadacademica;        // string(255)  

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Universidades',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
