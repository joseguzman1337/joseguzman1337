<?php
/**
 * Table Definition for indicadorcambioclave
 */
require_once 'DB/DataObject.php';

class DataObjects_Indicadorcambioclave extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'indicadorcambioclave';            // table name
    public $codigoindicadorcambioclave;      // string(3)  not_null primary_key
    public $nombreindicadorcambioclave;      // string(50)  not_null
    public $numerodiasindicadorcambioclave;    // int(6)  not_null
    public $codigoestado;                    // string(3)  not_null multiple_key

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Indicadorcambioclave',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
