<?php
/**
 * Table Definition for historicosituacionestudiante
 */
require_once 'DB/DataObject.php';

class DataObjects_Historicosituacionestudiante extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'historicosituacionestudiante';    // table name
    var $idhistoricosituacionestudiante;    // int(11)  not_null primary_key auto_increment
    var $codigoestudiante;                // int(11)  not_null multiple_key
    var $codigosituacioncarreraestudiante;    // string(3)  not_null multiple_key
    var $codigoperiodo;                   // string(8)  not_null multiple_key
    var $fechahistoricosituacionestudiante;    // string(50)  not_null
    var $fechainiciohistoricosituacionestudiante;    // datetime(19)  not_null binary
    var $fechafinalhistoricosituacionestudiante;    // string(50)  not_null
    var $usuario;                         // string(50)  not_null multiple_key

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Historicosituacionestudiante',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
