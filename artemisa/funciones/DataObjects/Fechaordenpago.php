<?php
/**
 * Table Definition for fechaordenpago
 */
require_once 'DB/DataObject.php';

class DataObjects_Fechaordenpago extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'fechaordenpago';                  // table name
    var $numeroordenpago;                 // int(11)  not_null multiple_key
    var $fechaordenpago;                  // date(10)  not_null binary
    var $porcentajefechaordenpago;        // int(6)  not_null
    var $valorfechaordenpago;             // int(11)  not_null

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Fechaordenpago',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
