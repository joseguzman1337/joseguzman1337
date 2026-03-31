<?php
/**
 * Table Definition for materia
 */
require_once '../funciones/pear/DB/DataObject.php';

class DataObjects_Materia extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'materia';                         // table name
    var $codigomateria;                   // int(11)  not_null primary_key auto_increment
    var $nombrecortomateria;              // string(15)  not_null
    var $nombremateria;                   // string(52)  not_null
    var $numerocreditos;                  // int(6)  not_null
    var $codigoperiodo;                   // string(8)  not_null multiple_key
    var $notaminimaaprobatoria;           // unknown(7)  not_null
    var $notaminimahabilitacion;          // unknown(7)  not_null
    var $numerosemana;                    // int(6)  not_null
    var $numerohorassemanales;            // int(6)  not_null
    var $porcentajeteoricamateria;        // int(3)  not_null
    var $porcentajepracticamateria;       // int(3)  not_null
    var $porcentajefallasmodalidadmateria;    // int(3)  not_null
    var $codigomodalidadmateria;          // string(2)  not_null multiple_key
    var $codigolineaacademica;            // string(3)  not_null multiple_key
    var $codigocarrera;                   // int(11)  not_null multiple_key
    var $codigoindicadorgrupomateria;     // string(3)  not_null multiple_key
    var $codigotipomateria;               // string(2)  not_null multiple_key
    var $codigoestadomateria;             // string(2)  not_null multiple_key
    var $ulasa;                           // string(10)  not_null
    var $ulasb;                           // string(10)  not_null
    var $ulasc;                           // string(10)  not_null
    var $codigoindicadorcredito;          // string(3)  not_null multiple_key
    var $codigoindicadoretiquetamateria;    // string(3)  not_null multiple_key
    var $codigotipocalificacionmateria;    // string(3)  not_null multiple_key

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Materia',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
