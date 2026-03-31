<?php
/**
 * Table Definition for tarjeta
 */
require_once 'DB/DataObject.php';

class DataObjects_Tarjeta extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'tarjeta';                         // table name
    public $idtarjeta;                       // int(11)  not_null primary_key auto_increment
    public $codigoestadotarjeta;             // string(3)  not_null multiple_key
    public $idestudiantegeneral;             // int(11)  not_null multiple_key
    public $fechatarjeta;                    // datetime(19)  not_null binary
    public $fechavencetarjeta;               // datetime(19)  not_null binary
    public $valortarjeta;                    // int(11)  not_null
    public $saldoanteriortarjeta;            // int(11)  not_null
    public $numerorecibocaja;                // string(15)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Tarjeta',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
