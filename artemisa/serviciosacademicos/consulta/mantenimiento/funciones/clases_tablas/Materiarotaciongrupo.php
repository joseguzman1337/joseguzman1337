<?php
/**
 * Table Definition for materiarotaciongrupo
 */
require_once 'DB/DataObject.php';

class DataObjects_Materiarotaciongrupo extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'materiarotaciongrupo';            // table name
    public $idmateriarotaciongrupo;          // int(11)  not_null primary_key auto_increment
    public $idmateriarotacion;               // int(11)  not_null multiple_key
    public $nombremateriarotaciongrupo;      // string(100)  not_null multiple_key
    public $fechamateriarotaciongrupo;       // date(10)  not_null binary
    public $fechadesdemateriarotaciongrupo;    // date(10)  not_null binary
    public $fechahastamateriarotaciongrupo;    // date(10)  not_null binary
    public $codigoperiodo;                   // string(8)  not_null multiple_key
    public $numerocreditosmateriarotaciongrupo;    // int(6)  not_null
    public $minimogrupomateriarotaciongrupo;    // int(6)  not_null
    public $maximogrupomateriarotaciongrupo;    // int(6)  not_null
    public $matriculadosgrupomateriarotaciongrupo;    // int(6)  not_null
    public $idlugarorigennota;               // int(11)  not_null multiple_key

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Materiarotaciongrupo',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
