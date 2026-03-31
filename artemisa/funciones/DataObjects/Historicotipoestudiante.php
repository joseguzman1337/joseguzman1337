<?php
/**
 * Table Definition for historicotipoestudiante
 */
require_once 'DB/DataObject.php';

class DataObjects_Historicotipoestudiante extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'historicotipoestudiante';         // table name
    var $idhistoricotipoestudiante;       // int(11)  not_null primary_key multiple_key auto_increment
    var $codigoestudiante;                // int(11)  not_null multiple_key
    var $codigotipoestudiante;            // string(2)  not_null multiple_key
    var $codigoperiodo;                   // string(8)  not_null multiple_key
    var $fechahistoricotipoestudiante;    // datetime(19)  not_null binary
    var $fechainiciohistoricotipoestudiante;    // datetime(19)  not_null binary
    var $fechafinalhistoricotipoestudiante;    // datetime(19)  not_null binary
    var $usuario;                         // string(50)  not_null multiple_key
    var $iphistoricotipoestudiante;       // string(50)  not_null

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Historicotipoestudiante',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
