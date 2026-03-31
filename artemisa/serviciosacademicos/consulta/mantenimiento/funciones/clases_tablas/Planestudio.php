<?php
/**
 * Table Definition for planestudio
 */
require_once 'DB/DataObject.php';

class DataObjects_Planestudio extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'planestudio';                     // table name
    public $idplanestudio;                   // int(11)  not_null primary_key auto_increment
    public $nombreplanestudio;               // string(50)  not_null
    public $codigocarrera;                   // int(11)  not_null multiple_key
    public $responsableplanestudio;          // string(50)  not_null
    public $cargoresponsableplanestudio;     // string(50)  not_null
    public $numeroautorizacionplanestudio;    // string(50)  not_null
    public $cantidadsemestresplanestudio;    // string(3)  not_null
    public $fechacreacionplanestudio;        // datetime(19)  not_null binary
    public $fechainioplanestudio;            // datetime(19)  not_null binary
    public $fechavencimientoplanestudio;     // datetime(19)  not_null binary
    public $codigoestadoplanestudio;         // string(3)  not_null multiple_key
    public $codigotipocantidadelectivalibre;    // string(3)  not_null multiple_key
    public $cantidadelectivalibre;           // int(6)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Planestudio',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
