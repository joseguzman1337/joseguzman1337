<?php
/**
 * Table Definition for lugarorigennota
 */
require_once 'DB/DataObject.php';

class DataObjects_Lugarorigennota extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'lugarorigennota';                 // table name
    var $idlugarorigennota;               // int(11)  not_null primary_key auto_increment
    var $nombrelugarorigennota;           // string(100)  not_null
    var $direccionlugarorigennota;        // string(50)  not_null
    var $telefonolugarorigennota;         // string(20)  not_null
    var $emaillugarorigennota;            // string(30)  not_null
    var $contactolugarorigennota;         // string(30)  not_null
    var $fechainiciolugarorigennota;      // date(10)  not_null binary
    var $fechafinallugarorigennota;       // date(10)  not_null binary
    var $idtipolugarorigennota;           // int(11)  not_null multiple_key
    var $codigocarrera;                   // int(11)  not_null multiple_key

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Lugarorigennota',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
