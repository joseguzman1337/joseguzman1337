<?php
/**
 * Table Definition for indicadorplanestudio
 */
require_once 'DB/DataObject.php';

class DataObjects_Indicadorplanestudio extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'indicadorplanestudio';            // table name
    var $codigoindicadorplanestudio;      // string(3)  not_null primary_key
    var $nombreindicadorplanestudio;      // string(50)  not_null

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Indicadorplanestudio',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
