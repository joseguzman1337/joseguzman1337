<?php
/**
 * Table Definition for tipocantidadelectivalibre
 */
require_once 'DB/DataObject.php';

class DataObjects_Tipocantidadelectivalibre extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'tipocantidadelectivalibre';       // table name
    public $codigotipocantidadelectivalibre;    // string(3)  not_null primary_key
    public $nombretipocantidadelectivalibre;    // string(50)  not_null
    public $fechainiciotipocantidadelectivalibre;    // datetime(19)  not_null binary
    public $fechavencimientotipocantidadelectivalibre;    // datetime(19)  not_null binary

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Tipocantidadelectivalibre',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
