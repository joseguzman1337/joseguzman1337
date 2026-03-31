<?php
/**
 * Table Definition for trato
 */
require_once 'DB/DataObject.php';

class DataObjects_Trato extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'trato';                           // table name
    var $idtrato;                         // int(11)  not_null primary_key auto_increment
    var $inicialestrato;                  // string(10)  not_null
    var $nombretrato;                     // string(50)  not_null

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Trato',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
