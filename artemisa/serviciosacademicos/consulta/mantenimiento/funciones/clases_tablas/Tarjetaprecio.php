<?php
/**
 * Table Definition for tarjetaprecio
 */
require_once 'DB/DataObject.php';

class DataObjects_Tarjetaprecio extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'tarjetaprecio';                   // table name
    public $idtarjetaprecio;                 // int(11)  not_null primary_key auto_increment
    public $nombretarjetaprecio;             // string(50)  not_null
    public $valortarjetaprecio;              // int(11)  not_null
    public $fechainiciotarjetaprecio;        // datetime(19)  not_null binary
    public $fechafinaltarjetaprecio;         // datetime(19)  not_null binary

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Tarjetaprecio',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
