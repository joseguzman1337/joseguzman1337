<?php
/**
 * Table Definition for aplicabloqueodeuda
 */
require_once 'DB/DataObject.php';

class DataObjects_Aplicabloqueodeuda extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'aplicabloqueodeuda';              // table name
    var $codigoaplicabloqueodeuda;        // string(3)  not_null primary_key
    var $nombreaplicabloqueodeuda;        // string(100)  not_null
    var $codigoestado;                    // string(3)  not_null multiple_key

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Aplicabloqueodeuda',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
