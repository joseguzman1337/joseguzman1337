<?php
/**
 * Table Definition for tipoestudiante
 */
require_once 'DB/DataObject.php';

class DataObjects_Tipoestudiante extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'tipoestudiante';                  // table name
    var $codigotipoestudiante;            // string(2)  not_null primary_key
    var $nombretipoestudiante;            // string(25)  not_null
    var $codigoreferenciatipoestudiante;    // string(3)  not_null multiple_key

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Tipoestudiante',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
