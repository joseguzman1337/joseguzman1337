<?php
/**
 * Table Definition for incentivoacademico
 */
require_once 'DB/DataObject.php';

class DataObjects_Incentivoacademico extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'incentivoacademico';              // table name
    public $idincentivoacademico;            // int(11)  not_null primary_key auto_increment
    public $nombreincentivoacademico;        // string(100)  not_null
    public $codigoestado;                    // string(3)  not_null multiple_key

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Incentivoacademico',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
