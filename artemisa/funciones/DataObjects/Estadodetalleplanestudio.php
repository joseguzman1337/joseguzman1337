<?php
/**
 * Table Definition for estadodetalleplanestudio
 */
require_once 'DB/DataObject.php';

class DataObjects_Estadodetalleplanestudio extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'estadodetalleplanestudio';        // table name
    var $codigoestadodetalleplanestudio;    // string(3)  not_null primary_key
    var $nombreestadodetalleplanestudio;    // string(50)  not_null

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Estadodetalleplanestudio',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
