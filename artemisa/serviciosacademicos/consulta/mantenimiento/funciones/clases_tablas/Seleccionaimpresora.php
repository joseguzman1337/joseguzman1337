<?php
/**
 * Table Definition for seleccionaimpresora
 */
require_once 'DB/DataObject.php';

class DataObjects_Seleccionaimpresora extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'seleccionaimpresora';             // table name
    public $idseleccionaimpresora;           // int(11)  not_null primary_key auto_increment
    public $nombreseleccionaimpresora;       // string(100)  not_null
    public $ubicacionseleccionaimpresora;    // string(100)  not_null
    public $destinoseleccionaimpresora;      // string(100)  not_null
    public $tiposeleccionaimpresora;         // string(50)  not_null
    public $ipseleccionaimpresora;           // string(50)  not_null
    public $mascaraseleccionaimpresora;      // string(50)  not_null
    public $fechainicioseleccionaimpresora;    // datetime(19)  not_null binary
    public $fechafinalseleccionaimpresora;    // datetime(19)  not_null binary

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Seleccionaimpresora',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
