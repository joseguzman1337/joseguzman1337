<?php
/**
 * Table Definition for detallepazysalvoestudiante
 */
require_once 'DB/DataObject.php';

class DataObjects_Detallepazysalvoestudiante extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'detallepazysalvoestudiante';      // table name
    var $iddetallepazysalvoestudiante;    // int(11)  not_null primary_key auto_increment
    var $idpazysalvoestudiante;           // int(11)  not_null multiple_key
    var $descripciondetallepazysalvoestudiante;    // string(100)  not_null
    var $fechainiciodetallepazysalvoestudiante;    // datetime(19)  not_null binary
    var $fechavencimientodetallepazysalvoestudiante;    // datetime(19)  not_null binary
    var $codigotipopazysalvoestudiante;    // string(3)  not_null multiple_key
    var $codigoestadopazysalvoestudiante;    // string(3)  not_null multiple_key

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Detallepazysalvoestudiante',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
