<?php
/**
 * Table Definition for cedulas
 */
require_once 'DB/DataObject.php';

class DataObjects_Cedulas extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'cedulas';                         // table name
    var $CEDULA;                          // string(255)  
    var $ID;                              // string(255)  

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Cedulas',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
