<?php
/**
 * Table Definition for estadoestudiantedecisionuniversidad
 */
require_once 'DB/DataObject.php';

class DataObjects_Estadoestudiantedecisionuniversidad extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'estadoestudiantedecisionuniversidad';    // table name
    var $codigoestadoestudiantedecisionuniversidad;    // string(3)  not_null primary_key
    var $nombreestadoestudiantedecisionuniversidad;    // string(50)  not_null

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Estadoestudiantedecisionuniversidad',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
