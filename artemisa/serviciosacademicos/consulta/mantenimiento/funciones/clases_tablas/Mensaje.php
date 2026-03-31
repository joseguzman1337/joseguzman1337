<?php
/**
 * Table Definition for mensaje
 */
require_once 'DB/DataObject.php';

class DataObjects_Mensaje extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'mensaje';                         // table name
    public $idmensaje;                       // int(11)  not_null primary_key auto_increment
    public $asuntomensaje;                   // string(50)  not_null
    public $descripcionmensaje;              // blob(-1)  not_null blob
    public $fechamensaje;                    // datetime(19)  not_null binary
    public $fechainiciomensaje;              // datetime(19)  not_null binary
    public $fechafinalmensaje;               // datetime(19)  not_null binary
    public $codigocarrera;                   // int(11)  not_null multiple_key
    public $codigoestudiante;                // int(11)  not_null multiple_key
    public $numerodocumento;                 // string(15)  not_null multiple_key
    public $usuario;                         // string(50)  not_null multiple_key
    public $codigodirigidomensaje;           // string(3)  not_null multiple_key
    public $codigoestadomensaje;             // string(3)  not_null multiple_key

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Mensaje',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
