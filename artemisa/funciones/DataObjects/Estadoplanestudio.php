<?php
/**
 * Table Definition for estadoplanestudio
 */
require_once 'DB/DataObject.php';

class DataObjects_Estadoplanestudio extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'estadoplanestudio';               // table name
    var $codigoestadoplanestudio;         // string(3)  not_null primary_key
    var $nombrecodigoestadoplanestudio;    // string(50)  not_null

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Estadoplanestudio',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
