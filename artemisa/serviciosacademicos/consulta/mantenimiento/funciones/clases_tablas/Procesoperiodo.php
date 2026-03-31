<?php
/**
 * Table Definition for procesoperiodo
 */
require_once 'DB/DataObject.php';

class DataObjects_Procesoperiodo extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'procesoperiodo';                  // table name
    public $idprocesoperiodo;                // int(11)  not_null primary_key auto_increment
    public $idproceso;                       // int(11)  not_null multiple_key
    public $fechainicioprocesoperiodo;       // date(10)  not_null binary
    public $fechafinalprocesoperiodo;        // date(10)  not_null binary
    public $fecharealizoprocesoperiodo;      // date(10)  not_null binary
    public $usuario;                         // string(50)  not_null multiple_key
    public $codigoestadoprocesoperiodo;      // string(50)  not_null multiple_key
    public $codigocarrera;                   // int(11)  not_null multiple_key
    public $codigoperiodo;                   // string(8)  not_null multiple_key

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Procesoperiodo',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
