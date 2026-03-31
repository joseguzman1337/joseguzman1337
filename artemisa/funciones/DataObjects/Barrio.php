<?php
/**
 * Table Definition for barrio
 */
require_once 'DB/DataObject.php';

class DataObjects_Barrio extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'barrio';                          // table name
    var $idbarrio;                        // int(11)  not_null primary_key auto_increment
    var $nombrecortobarrio;               // string(10)  not_null
    var $nombrebarrio;                    // string(100)  not_null
    var $idciudad;                        // int(11)  not_null multiple_key

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Barrio',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
