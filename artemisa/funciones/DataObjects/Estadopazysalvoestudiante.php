<?php
/**
 * Table Definition for estadopazysalvoestudiante
 */
require_once 'DB/DataObject.php';

class DataObjects_Estadopazysalvoestudiante extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'estadopazysalvoestudiante';       // table name
    var $codigoestadopazysalvoestudiante;    // string(3)  not_null primary_key
    var $nombreestadopazysalvoestudiante;    // string(50)  not_null

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Estadopazysalvoestudiante',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
