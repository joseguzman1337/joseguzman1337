<?php
/**
 * Table Definition for universidades
 */
require_once 'DB/DataObject.php';

class DataObjects_Universidades extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'universidades';                   // table name
    public $idinstitucioneducativa;          // real(22)  
    public $nombrecortoinstitucioneducativa;    // string(255)  
    public $nombreinstitucioneducativa;      // string(255)  
    public $codigojornada;                   // string(255)  
    public $paisinstitucioneducativa;        // string(255)  
    public $municipioinstitucioneducativa;    // string(255)  
    public $departamentoinstitucioneducativa;    // string(255)  
    public $direccioninstitucioneducativa;    // string(255)  
    public $telefono1;                       // string(255)  
    public $telefono2;                       // string(255)  
    public $codigocalendarioestudiante;      // string(255)  
    public $codigotipoinstitucioneducativa;    // string(255)  
    public $codigoidiomainstitucioneducativa;    // string(255)  
    public $codigoestadoinstitucioneducativa;    // real(22)  
    public $codigogenero;                    // real(22)  
    public $tarifainstitucioneducativa;      // real(22)  
    public $codigozona;                      // real(22)  
    public $localizacioninstitucioneducativa;    // string(255)  
    public $numerofaxinstitucioneducativa;    // string(255)  
    public $apartadoaereoinstitucioneducativa;    // string(255)  
    public $cdaneinstitucioneducativa;       // real(22)  
    public $representateinstitucioneducativa;    // string(255)  
    public $codigonaturaleza;                // string(255)  
    public $personajuridicainstitucioneducativa;    // real(22)  
    public $emailinstitucioneducativa;       // string(255)  
    public $httpnstitucioneducativa;         // string(255)  
    public $codigomodalidadacademica;        // string(255)  

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Universidades',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
