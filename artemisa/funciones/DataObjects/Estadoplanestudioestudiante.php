<?php
/**
 * Table Definition for estadoplanestudioestudiante
 */
require_once 'DB/DataObject.php';

class DataObjects_Estadoplanestudioestudiante extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'estadoplanestudioestudiante';     // table name
    var $codigoestadoplanestudioestudiante;    // string(3)  not_null primary_key
    var $nombreestadoplanestudioestudiante;    // string(50)  not_null

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Estadoplanestudioestudiante',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
