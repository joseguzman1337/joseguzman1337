<?php
/**
 * Table Definition for tarjeta
 */
require_once 'DB/DataObject.php';

class DataObjects_Tarjeta extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'tarjeta';                         // table name
    var $idtarjeta;                       // int(11)  not_null primary_key auto_increment
    var $codigoestadotarjeta;             // string(3)  not_null multiple_key
    var $idestudiantegeneral;             // int(11)  not_null multiple_key
    var $fechatarjeta;                    // datetime(19)  not_null binary
    var $fechavencetarjeta;               // datetime(19)  not_null binary
    var $valortarjeta;                    // int(11)  not_null
    var $saldoanteriortarjeta;            // int(11)  not_null
    var $numerorecibocaja;                // string(15)  not_null

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Tarjeta',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
