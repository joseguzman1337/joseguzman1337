<?php
/**
 * Table Definition for porcentajedevolucionestudiante
 */
require_once '../funciones/pear/DB/DataObject.php';

class DataObjects_Porcentajedevolucionestudiante extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'porcentajedevolucionestudiante';    // table name
    var $idporcentajedevolucionestudiante;    // int(11)  not_null primary_key auto_increment
    var $nombreporcentajedevolucionestudiante;    // string(100)  not_null
    var $fechaporcentajedevolucionestudiante;    // date(10)  not_null binary
    var $numeroordenpago;                 // int(11)  not_null multiple_key
    var $porcentajedevolucionestudiante;    // int(6)  not_null
    var $codigoconcepto;                  // string(8)  not_null multiple_key
    var $codigoperiodo;                   // string(8)  not_null multiple_key
    var $fechadesdeporcentajedevolucionestudiante;    // date(10)  not_null binary
    var $fechahastaporcentajedevolucionestudiante;    // date(10)  not_null binary
    var $codigoestado;                    // string(3)  not_null multiple_key

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Porcentajedevolucionestudiante',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
