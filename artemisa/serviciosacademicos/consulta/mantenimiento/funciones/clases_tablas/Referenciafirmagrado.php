<?php
/**
 * Table Definition for referenciafirmagrado
 */
require_once 'DB/DataObject.php';

class DataObjects_Referenciafirmagrado extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'referenciafirmagrado';            // table name
    public $idreferenciafirmagrado;          // int(11)  not_null primary_key auto_increment
    public $iddirectivo;                     // int(11)  not_null multiple_key
    public $fechainicioreferenciafirmagrado;    // date(10)  not_null binary
    public $fechafinalreferenciafirmagrado;    // date(10)  not_null binary

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Referenciafirmagrado',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
