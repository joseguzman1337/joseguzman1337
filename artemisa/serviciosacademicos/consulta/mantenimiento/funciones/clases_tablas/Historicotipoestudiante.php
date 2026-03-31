<?php
/**
 * Table Definition for historicotipoestudiante
 */
require_once 'DB/DataObject.php';

class DataObjects_Historicotipoestudiante extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'historicotipoestudiante';         // table name
    public $idhistoricotipoestudiante;       // int(11)  not_null primary_key multiple_key auto_increment
    public $codigoestudiante;                // int(11)  not_null multiple_key
    public $codigotipoestudiante;            // string(2)  not_null multiple_key
    public $codigoperiodo;                   // string(8)  not_null multiple_key
    public $fechahistoricotipoestudiante;    // datetime(19)  not_null binary
    public $fechainiciohistoricotipoestudiante;    // datetime(19)  not_null binary
    public $fechafinalhistoricotipoestudiante;    // datetime(19)  not_null binary
    public $usuario;                         // string(50)  not_null multiple_key
    public $iphistoricotipoestudiante;       // string(50)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Historicotipoestudiante',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
