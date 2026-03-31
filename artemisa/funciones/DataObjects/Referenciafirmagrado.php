<?php
/**
 * Table Definition for referenciafirmagrado
 */
require_once 'DB/DataObject.php';

class DataObjects_Referenciafirmagrado extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'referenciafirmagrado';            // table name
    var $idreferenciafirmagrado;          // int(11)  not_null primary_key auto_increment
    var $iddirectivo;                     // int(11)  not_null multiple_key
    var $fechainicioreferenciafirmagrado;    // date(10)  not_null binary
    var $fechafinalreferenciafirmagrado;    // date(10)  not_null binary

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Referenciafirmagrado',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
