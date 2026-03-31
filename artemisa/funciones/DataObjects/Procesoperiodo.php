<?php
/**
 * Table Definition for procesoperiodo
 */
require_once 'DB/DataObject.php';

class DataObjects_Procesoperiodo extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'procesoperiodo';                  // table name
    var $idprocesoperiodo;                // int(11)  not_null primary_key auto_increment
    var $idproceso;                       // int(11)  not_null multiple_key
    var $fechainicioprocesoperiodo;       // date(10)  not_null binary
    var $fechafinalprocesoperiodo;        // date(10)  not_null binary
    var $fecharealizoprocesoperiodo;      // date(10)  not_null binary
    var $usuario;                         // string(50)  not_null multiple_key
    var $codigoestadoprocesoperiodo;      // string(50)  not_null multiple_key
    var $codigocarrera;                   // int(11)  not_null multiple_key
    var $codigoperiodo;                   // string(8)  not_null multiple_key

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Procesoperiodo',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
