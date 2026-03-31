<?php
/**
 * Table Definition for festivo
 */
require_once 'DB/DataObject.php';

class DataObjects_Festivo extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'festivo';                         // table name
    var $idfestivo;                       // int(11)  not_null primary_key auto_increment
    var $nombrefestivo;                   // string(50)  not_null
    var $diafestivo;                      // date(10)  not_null binary

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Festivo',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
