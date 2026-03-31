<?php
/**
 * Table Definition for actualizo
 */
require_once 'DB/DataObject.php';

class DataObjects_Actualizo extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'actualizo';                       // table name
    var $codigoactualizo;                 // string(2)  not_null primary_key
    var $nombreactualizo;                 // string(25)  not_null

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Actualizo',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
