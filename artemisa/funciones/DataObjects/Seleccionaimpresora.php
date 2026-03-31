<?php
/**
 * Table Definition for seleccionaimpresora
 */
require_once 'DB/DataObject.php';

class DataObjects_Seleccionaimpresora extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'seleccionaimpresora';             // table name
    var $idseleccionaimpresora;           // int(11)  not_null primary_key auto_increment
    var $nombreseleccionaimpresora;       // string(100)  not_null
    var $ubicacionseleccionaimpresora;    // string(100)  not_null
    var $destinoseleccionaimpresora;      // string(100)  not_null
    var $tiposeleccionaimpresora;         // string(50)  not_null
    var $ipseleccionaimpresora;           // string(50)  not_null
    var $mascaraseleccionaimpresora;      // string(50)  not_null
    var $fechainicioseleccionaimpresora;    // datetime(19)  not_null binary
    var $fechafinalseleccionaimpresora;    // datetime(19)  not_null binary

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Seleccionaimpresora',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
