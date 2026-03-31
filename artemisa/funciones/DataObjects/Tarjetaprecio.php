<?php
/**
 * Table Definition for tarjetaprecio
 */
require_once 'DB/DataObject.php';

class DataObjects_Tarjetaprecio extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'tarjetaprecio';                   // table name
    var $idtarjetaprecio;                 // int(11)  not_null primary_key auto_increment
    var $nombretarjetaprecio;             // string(50)  not_null
    var $valortarjetaprecio;              // int(11)  not_null
    var $fechainiciotarjetaprecio;        // datetime(19)  not_null binary
    var $fechafinaltarjetaprecio;         // datetime(19)  not_null binary

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Tarjetaprecio',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
