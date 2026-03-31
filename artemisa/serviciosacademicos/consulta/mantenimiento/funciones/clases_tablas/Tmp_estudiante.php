<?php
/**
 * Table Definition for tmp_estudiante
 */
require_once 'DB/DataObject.php';

class DataObjects_Tmp_estudiante extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'tmp_estudiante';                  // table name
    public $tipodocumento;                   // string(255)  
    public $numerodocumento;                 // string(255)  
    public $apellidosestudiante;             // string(255)  
    public $nombresestudiante;               // string(255)  
    public $codigogenero;                    // real(22)  
    public $codigocarrera;                   // real(22)  
    public $semestre;                        // real(22)  
    public $direccionresidenciaestudiante;    // string(255)  
    public $telefonoresidenciaestudiante;    // string(255)  
    public $codigoperiodo;                   // real(22)  

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Tmp_estudiante',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
