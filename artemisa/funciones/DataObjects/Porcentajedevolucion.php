<?php
/**
 * Table Definition for porcentajedevolucion
 */
require_once 'DB/DataObject.php';

class DataObjects_Porcentajedevolucion extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'porcentajedevolucion';            // table name
    var $idporcentajedevolucion;          // int(11)  not_null primary_key auto_increment
    var $nombreporcentajedevolucion;      // string(100)  not_null
    var $numeroordenpago;                 // int(11)  not_null multiple_key
    var $fechaporcentajedevolucion;       // date(10)  not_null binary
    var $fechadesdeporcentajedevolucion;    // date(10)  not_null binary
    var $fechahastaporcentajedevolucion;    // date(10)  not_null binary
    var $codigoestado;                    // string(3)  not_null multiple_key
    var $codigoindicadoraplicareglamento;    // string(3)  not_null multiple_key

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Porcentajedevolucion',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
