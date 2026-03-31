<?php
/**
 * Table Definition for carrera
 */
require_once '../funciones/pear/DB/DataObject.php';

class DataObjects_Carrera extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'carrera';                         // table name
    var $codigocarrera;                   // int(11)  not_null primary_key unique_key auto_increment
    var $codigocortocarrera;              // string(15)  not_null unique_key
    var $nombrecortocarrera;              // string(50)  not_null
    var $nombrecarrera;                   // string(100)  not_null
    var $codigofacultad;                  // string(4)  not_null multiple_key
    var $centrocosto;                     // string(15)  not_null
    var $codigocentrobeneficio;           // string(20)  not_null
    var $codigosucursal;                  // string(2)  not_null multiple_key
    var $minimonumerocredito;             // int(6)  not_null
    var $maximonumerocredito;             // int(6)  not_null
    var $codigomodalidadacademica;        // string(3)  not_null
    var $fechainiciocarrera;              // datetime(19)  not_null binary
    var $fechavencimientocarrera;         // datetime(19)  not_null binary
    var $abreviaturacodigocarrera;        // string(5)  not_null
    var $iddirectivo;                     // int(11)  not_null multiple_key
    var $codigotitulo;                    // int(11)  not_null multiple_key
    var $codigotipocosto;                 // string(3)  not_null multiple_key
    var $codigoindicadorcobroinscripcioncarrera;    // string(3)  not_null multiple_key
    var $codigoindicadorprocesoadmisioncarrera;    // string(3)  not_null multiple_key
    var $codigoindicadorplanestudio;      // string(3)  not_null multiple_key
    var $codigoindicadortipocarrera;      // string(3)  not_null multiple_key
    var $codigoreferenciacobromatriculacarrera;    // string(3)  not_null multiple_key

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Carrera',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
