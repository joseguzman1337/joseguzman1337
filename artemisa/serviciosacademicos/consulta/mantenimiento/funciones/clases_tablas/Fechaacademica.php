<?php
/**
 * Table Definition for fechaacademica
 */
require_once '../funciones/pear/DB/DataObject.php';

class DataObjects_Fechaacademica extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'fechaacademica';                  // table name
    var $idfechaacademica;                // int(11)  not_null primary_key auto_increment
    var $codigoperiodo;                   // string(8)  not_null multiple_key
    var $codigocarrera;                   // int(11)  not_null multiple_key
    var $fechacortenotas;                 // date(10)  not_null binary
    var $fechacargaacademica;             // date(10)  not_null binary
    var $fechainicialprematricula;        // date(10)  not_null binary
    var $fechafinalprematricula;          // date(10)  not_null binary
    var $fechainicialentregaordenpago;    // date(10)  not_null binary
    var $fechafinalentregaordenpago;      // date(10)  not_null binary

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Fechaacademica',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
