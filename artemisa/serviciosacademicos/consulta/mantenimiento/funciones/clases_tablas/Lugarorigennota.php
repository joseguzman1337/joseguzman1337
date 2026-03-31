<?php
/**
 * Table Definition for lugarorigennota
 */
require_once 'DB/DataObject.php';

class DataObjects_Lugarorigennota extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'lugarorigennota';                 // table name
    public $idlugarorigennota;               // int(11)  not_null primary_key auto_increment
    public $nombrelugarorigennota;           // string(100)  not_null
    public $direccionlugarorigennota;        // string(50)  not_null
    public $telefonolugarorigennota;         // string(20)  not_null
    public $emaillugarorigennota;            // string(30)  not_null
    public $contactolugarorigennota;         // string(30)  not_null
    public $fechainiciolugarorigennota;      // date(10)  not_null binary
    public $fechafinallugarorigennota;       // date(10)  not_null binary
    public $idtipolugarorigennota;           // int(11)  not_null multiple_key
    public $codigocarrera;                   // int(11)  not_null multiple_key

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Lugarorigennota',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
