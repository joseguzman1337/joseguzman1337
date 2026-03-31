<?php
/**
 * Table Definition for mensaje
 */
require_once 'DB/DataObject.php';

class DataObjects_Mensaje extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'mensaje';                         // table name
    var $idmensaje;                       // int(11)  not_null primary_key auto_increment
    var $asuntomensaje;                   // string(50)  not_null
    var $descripcionmensaje;              // blob(-1)  not_null blob
    var $fechamensaje;                    // datetime(19)  not_null binary
    var $fechainiciomensaje;              // datetime(19)  not_null binary
    var $fechafinalmensaje;               // datetime(19)  not_null binary
    var $codigocarrera;                   // int(11)  not_null multiple_key
    var $codigoestudiante;                // int(11)  not_null multiple_key
    var $numerodocumento;                 // string(15)  not_null multiple_key
    var $usuario;                         // string(50)  not_null multiple_key
    var $codigodirigidomensaje;           // string(3)  not_null multiple_key
    var $codigoestadomensaje;             // string(3)  not_null multiple_key

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Mensaje',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
