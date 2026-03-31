<?php
/**
 * Table Definition for pazysalvoestudiante
 */
require_once 'DB/DataObject.php';

class DataObjects_Pazysalvoestudiante extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'pazysalvoestudiante';             // table name
    public $idpazysalvoestudiante;           // int(11)  not_null primary_key auto_increment
    public $idestudiantegeneral;             // int(11)  not_null multiple_key
    public $codigocarrera;                   // int(11)  not_null multiple_key
    public $codigoperiodo;                   // string(8)  not_null multiple_key

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Pazysalvoestudiante',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
