<?php
/**
 * Table Definition for contestoencuesta
 */
require_once 'DB/DataObject.php';

class DataObjects_Contestoencuesta extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'contestoencuesta';                // table name
    var $idcontestoencuesta;              // int(11)  not_null primary_key auto_increment
    var $idencuesta;                      // int(11)  not_null multiple_key
    var $codigoquiencontesto;             // int(15)  not_null
    var $codigoperiodo;                   // string(8)  not_null multiple_key

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Contestoencuesta',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
