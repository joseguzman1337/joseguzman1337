<?php
/**
 * Table Definition for estadoperiodo
 */
require_once '../funciones/pear/DB/DataObject.php';

class DataObjects_Tiposubperiodo extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

	var $__table = 'tiposubperiodo';                  // table name
    var $idtiposubperiodo;                // int(11)  not_null primary_key auto_increment
    var $nombretiposubperiodo;            // string(100)  not_null
    var $fechatiposubperiodo;             // datetime(19)  not_null binary
    var $unidadhoratiposubperiodo;        // int(6)  not_null

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Tiposubperiodo',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
