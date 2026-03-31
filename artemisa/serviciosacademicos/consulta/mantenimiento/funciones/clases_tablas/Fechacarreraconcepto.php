<?php
/**
 * Table Definition for estadoperiodo
 */
require_once '../funciones/pear/DB/DataObject.php';

class DataObjects_Fechacarreraconcepto extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'fechacarreraconcepto';            // table name
    var $idfechacarreraconcepto;          // int(11)  not_null primary_key auto_increment
    var $nombrefechacarreraconcepto;      // string(50)  not_null
    var $fechafechacarreraconcepto;       // date(10)  not_null binary
    var $fechainiciofechacarreraconcepto;    // date(10)  not_null binary
    var $fechavencimientofechacarreraconcepto;    // date(10)  not_null binary
    var $numerodiasvencimientofechacarreraconcepto;    // string(50)  
    var $idusuario;                       // int(11)  not_null multiple_key
    var $ip;                              // string(50)  not_null
    var $codigocarrera;                   // int(11)  not_null multiple_key
    var $codigoconcepto;                  // string(3)  not_null multiple_key
    var $codigotipofechacarreraconcepto;    // string(3)  not_null

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Fechacarreraconcepto',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
