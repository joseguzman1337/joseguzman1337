<?php
/**
 * Table Definition for estadoprematricula
 */
require_once 'DB/DataObject.php';

class DataObjects_Estadoprematricula extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'estadoprematricula';              // table name
    var $codigoestadoprematricula;        // string(2)  not_null primary_key
    var $nombreestadoprematricula;        // string(30)  not_null

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Estadoprematricula',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
