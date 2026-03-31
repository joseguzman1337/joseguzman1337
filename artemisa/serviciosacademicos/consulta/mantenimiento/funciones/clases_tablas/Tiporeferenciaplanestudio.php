<?php
/**
 * Table Definition for tiporeferenciaplanestudio
 */
require_once 'DB/DataObject.php';

class DataObjects_Tiporeferenciaplanestudio extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'tiporeferenciaplanestudio';       // table name
    public $codigotiporeferenciaplanestudio;    // string(3)  not_null primary_key
    public $nombretiporeferenciaplanestudio;    // string(50)  not_null
    public $fechainiciotiporeferenciaplanestudio;    // datetime(19)  not_null binary
    public $fechavencimientotiporeferenciaplanestudio;    // datetime(19)  not_null binary

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Tiporeferenciaplanestudio',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
