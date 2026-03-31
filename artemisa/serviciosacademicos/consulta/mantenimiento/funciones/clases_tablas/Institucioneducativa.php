<?php
/**
 * Table Definition for institucioneducativa
 */
require_once 'DB/DataObject.php';

class DataObjects_Institucioneducativa extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'institucioneducativa';            // table name
    public $idinstitucioneducativa;          // int(11)  not_null primary_key auto_increment
    public $nombrecortoinstitucioneducativa;    // string(15)  unique_key
    public $nombreinstitucioneducativa;      // string(150)  
    public $codigojornada;                   // string(2)  multiple_key
    public $paisinstitucioneducativa;        // string(50)  
    public $municipioinstitucioneducativa;    // string(50)  
    public $departamentoinstitucioneducativa;    // string(50)  
    public $direccioninstitucioneducativa;    // string(50)  
    public $telefono1;                       // string(20)  
    public $telefono2;                       // string(20)  
    public $codigocalendarioestudiante;      // string(3)  multiple_key
    public $codigotipoinstitucioneducativa;    // string(3)  multiple_key
    public $codigoidiomainstitucioneducativa;    // string(3)  multiple_key
    public $codigoestadoinstitucioneducativa;    // string(3)  multiple_key
    public $codigogenero;                    // string(3)  multiple_key
    public $tarifainstitucioneducativa;      // string(25)  
    public $codigozona;                      // string(3)  multiple_key
    public $localizacioninstitucioneducativa;    // string(50)  
    public $numerofaxinstitucioneducativa;    // string(20)  
    public $apartadoaereoinstitucioneducativa;    // string(20)  
    public $cdaneinstitucioneducativa;       // string(30)  
    public $representateinstitucioneducativa;    // string(50)  
    public $codigonaturaleza;                // string(3)  multiple_key
    public $personajuridicainstitucioneducativa;    // string(50)  
    public $emailinstitucioneducativa;       // string(50)  
    public $httpnstitucioneducativa;         // string(50)  
    public $codigomodalidadacademica;        // string(3)  not_null multiple_key

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Institucioneducativa',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
