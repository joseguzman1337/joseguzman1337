<?php
/**
 * Table Definition for estadopazysalvoestudiante
 */
require_once 'DB/DataObject.php';

class DataObjects_Estadopazysalvoestudiante extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'estadopazysalvoestudiante';       // table name
    public $codigoestadopazysalvoestudiante;    // string(3)  not_null primary_key
    public $nombreestadopazysalvoestudiante;    // string(50)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Estadopazysalvoestudiante',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
