<?php
/**
 * Table Definition for inscripcion
 */
require_once '../funciones/pear/DB/DataObject.php';

class DataObjects_Inscripcion extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'inscripcion';                     // table name
    var $idinscripcion;                   // int(11)  not_null primary_key auto_increment
    var $numeroinscripcion;               // string(15)  not_null
    var $fotoinscripcion;                 // string(100)  not_null
    var $fechainscripcion;                // datetime(19)  not_null binary
    var $codigomodalidadacademica;        // string(3)  not_null multiple_key
    var $codigoperiodo;                   // string(8)  not_null multiple_key
    var $anoaspirainscripcion;            // string(4)  not_null
    var $periodoaspirainscripcion;        // string(2)  not_null
    var $idestudiantegeneral;             // int(11)  not_null multiple_key
    var $codigosituacioncarreraestudiante;    // string(3)  not_null multiple_key
    var $codigoestado;                    // string(3)  not_null multiple_key

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Inscripcion',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
