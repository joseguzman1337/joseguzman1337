<?php
/**
 * Table Definition for indicadorcambioclave
 */
require_once 'DB/DataObject.php';

class DataObjects_Indicadorcambioclave extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'indicadorcambioclave';            // table name
    var $codigoindicadorcambioclave;      // string(3)  not_null primary_key
    var $nombreindicadorcambioclave;      // string(50)  not_null
    var $numerodiasindicadorcambioclave;    // int(6)  not_null
    var $codigoestado;                    // string(3)  not_null multiple_key

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Indicadorcambioclave',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
