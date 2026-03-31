<?php
/**
 * Table Definition for tmp_estudiante
 */
require_once 'DB/DataObject.php';

class DataObjects_Tmp_estudiante extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'tmp_estudiante';                  // table name
    var $tipodocumento;                   // string(255)  
    var $numerodocumento;                 // string(255)  
    var $apellidosestudiante;             // string(255)  
    var $nombresestudiante;               // string(255)  
    var $codigogenero;                    // real(22)  
    var $codigocarrera;                   // real(22)  
    var $semestre;                        // real(22)  
    var $direccionresidenciaestudiante;    // string(255)  
    var $telefonoresidenciaestudiante;    // string(255)  
    var $codigoperiodo;                   // real(22)  

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Tmp_estudiante',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
