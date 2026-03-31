<?php
/**
 * Table Definition for porcentajedevolucion
 */
require_once '../funciones/pear/DB/DataObject.php';

class DataObjects_Porcentajedevolucion extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'porcentajedevolucion';            // table name
    var $idporcentajedevolucion;          // int(11)  not_null primary_key auto_increment
    var $nombreporcentajedevolucion;      // string(100)  not_null
    var $fechaporcentajedevolucion;       // date(10)  not_null binary
    var $porcentajedevolucion;            // int(6)  not_null
    var $codigoperiodo;                   // string(8)  not_null multiple_key
    var $codigoconcepto;                  // string(8)  not_null multiple_key
    var $fechadesdeporcentajedevolucion;    // date(10)  not_null binary
    var $fechahastaporcentajedevolucion;    // date(10)  not_null binary
    var $codigoestado;                    // string(3)  not_null multiple_key

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Porcentajedevolucion',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
