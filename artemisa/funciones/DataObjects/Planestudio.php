<?php
/**
 * Table Definition for planestudio
 */
require_once 'DB/DataObject.php';

class DataObjects_Planestudio extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'planestudio';                     // table name
    var $idplanestudio;                   // int(11)  not_null primary_key auto_increment
    var $nombreplanestudio;               // string(50)  not_null
    var $codigocarrera;                   // int(11)  not_null multiple_key
    var $responsableplanestudio;          // string(50)  not_null
    var $cargoresponsableplanestudio;     // string(50)  not_null
    var $numeroautorizacionplanestudio;    // string(50)  not_null
    var $cantidadsemestresplanestudio;    // string(3)  not_null
    var $fechacreacionplanestudio;        // datetime(19)  not_null binary
    var $fechainioplanestudio;            // datetime(19)  not_null binary
    var $fechavencimientoplanestudio;     // datetime(19)  not_null binary
    var $codigoestadoplanestudio;         // string(3)  not_null multiple_key
    var $codigotipocantidadelectivalibre;    // string(3)  not_null multiple_key
    var $cantidadelectivalibre;           // int(6)  not_null

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Planestudio',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
