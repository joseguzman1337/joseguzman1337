<?php
/**
 * Table Definition for auditoriahistoricotipoestudiante
 */
require_once 'DB/DataObject.php';

class DataObjects_Auditoriahistoricotipoestudiante extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'auditoriahistoricotipoestudiante';    // table name
    var $idauditoriahistoricotipoestudiante;    // int(11)  not_null primary_key auto_increment
    var $codigoestudiante;                // int(11)  not_null multiple_key
    var $codigotipoestudiante;            // string(2)  not_null multiple_key
    var $fechainicioauditoriahistoricotipoestudiante;    // datetime(19)  not_null binary
    var $fechafinalauditoriahistoricotipoestudiante;    // datetime(19)  not_null binary
    var $usuario;                         // string(50)  not_null
    var $codigotipotransaccion;           // string(3)  not_null multiple_key

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Auditoriahistoricotipoestudiante',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
