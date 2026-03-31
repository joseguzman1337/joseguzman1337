<?php
/**
 * Table Definition for cuentabancoordenpago
 */
require_once 'DB/DataObject.php';

class DataObjects_Cuentabancoordenpago extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'cuentabancoordenpago';            // table name
    public $numeroordenpago;                 // int(11)  not_null multiple_key
    public $idcuentabanco;                   // int(11)  not_null multiple_key

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Cuentabancoordenpago',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
