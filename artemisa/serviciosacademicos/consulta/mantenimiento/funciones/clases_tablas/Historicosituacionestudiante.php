<?php
/**
 * Table Definition for historicosituacionestudiante
 */
require_once 'DB/DataObject.php';

class DataObjects_Historicosituacionestudiante extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'historicosituacionestudiante';    // table name
    public $idhistoricosituacionestudiante;    // int(11)  not_null primary_key auto_increment
    public $codigoestudiante;                // int(11)  not_null multiple_key
    public $codigosituacioncarreraestudiante;    // string(3)  not_null multiple_key
    public $codigoperiodo;                   // string(8)  not_null multiple_key
    public $fechahistoricosituacionestudiante;    // string(50)  not_null
    public $fechainiciohistoricosituacionestudiante;    // datetime(19)  not_null binary
    public $fechafinalhistoricosituacionestudiante;    // string(50)  not_null
    public $usuario;                         // string(50)  not_null multiple_key

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Historicosituacionestudiante',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
