<?php
/**
 * Table Definition for carreraregistro
 */
require_once 'DB/DataObject.php';

class DataObjects_Carreraregistro extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'carreraregistro';                 // table name
    var $idcarreraregistro;               // int(11)  not_null primary_key auto_increment
    var $numeroregistrocarreraregistro;    // string(50)  not_null unique_key
    var $codigocarrera;                   // int(11)  not_null multiple_key
    var $fechainiciocarreraregistro;      // date(10)  not_null binary
    var $fechafinalcarreraregistro;       // date(10)  not_null binary

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Carreraregistro',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
