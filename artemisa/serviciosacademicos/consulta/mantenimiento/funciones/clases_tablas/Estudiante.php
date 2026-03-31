<?php
/**
 * Table Definition for estudiante
 */
require_once '../funciones/pear/DB/DataObject.php';

class DataObjects_Estudiante extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'estudiante';                      // table name
    var $codigoestudiante;                // int(11)  not_null primary_key auto_increment
    var $idestudiantegeneral;             // int(11)  not_null multiple_key
    var $codigocarrera;                   // int(11)  not_null multiple_key
    var $semestre;                        // string(2)  not_null
    var $numerocohorte;                   // string(3)  not_null multiple_key
    var $codigotipoestudiante;            // string(2)  not_null multiple_key
    var $codigosituacioncarreraestudiante;    // string(3)  not_null multiple_key
    var $codigoperiodo;                   // string(8)  not_null multiple_key
    var $codigojornada;                   // string(2)  not_null multiple_key

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Estudiante',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
