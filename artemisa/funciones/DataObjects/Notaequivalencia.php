<?php
/**
 * Table Definition for notaequivalencia
 */
require_once 'DB/DataObject.php';

class DataObjects_Notaequivalencia extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'notaequivalencia';                // table name
    var $idnotaequivalencia;              // int(11)  not_null primary_key auto_increment
    var $nombrenotaequivalencia;          // string(100)  not_null
    var $nombrecortoequivalencia;         // string(10)  not_null
    var $fechanotaequivalencia;           // datetime(19)  not_null binary
    var $idusuario;                       // int(11)  not_null multiple_key
    var $ip;                              // string(50)  not_null
    var $notainicionotaequivalencia;      // unknown(7)  not_null
    var $notafinalnotaequivalencia;       // unknown(7)  not_null
    var $codigomateria;                   // int(11)  not_null multiple_key
    var $codigocarrera;                   // int(11)  not_null multiple_key
    var $codigotipoequivalencianota;      // string(2)  not_null multiple_key
    var $fechainicionotaequivalencia;     // date(10)  not_null binary
    var $fechafinalnotaequivalencia;      // date(10)  not_null binary

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Notaequivalencia',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
