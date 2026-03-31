<?php
/**
 * Table Definition for salon
 */
require_once 'DB/DataObject.php';

class DataObjects_Salon extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'salon';                           // table name
    var $codigosalon;                     // string(4)  not_null primary_key
    var $nombresalon;                     // string(30)  not_null
    var $cupomaximosalon;                 // int(6)  not_null
    var $codigotiposalon;                 // string(2)  not_null multiple_key
    var $codigosede;                      // string(2)  not_null multiple_key

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Salon',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
