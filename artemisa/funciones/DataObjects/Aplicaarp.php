<?php
/**
 * Table Definition for aplicaarp
 */
require_once 'DB/DataObject.php';

class DataObjects_Aplicaarp extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'aplicaarp';                       // table name
    var $idaplicaarp;                     // int(11)  not_null primary_key auto_increment
    var $nombreaplicaarp;                 // string(100)  not_null
    var $codigocarrera;                   // int(11)  not_null multiple_key
    var $codigoperiodo;                   // string(8)  not_null multiple_key
    var $idempresasalud;                  // int(11)  not_null
    var $valorbaseaplicaarp;              // int(11)  not_null
    var $porcentajeaplicaarp;             // int(6)  not_null
    var $valorfijoaplicaarp;              // int(11)  not_null
    var $fechaaplicaarp;                  // datetime(19)  not_null binary
    var $fechainicioaplicaarp;            // datetime(19)  not_null binary
    var $fechafinalaplicaarp;             // datetime(19)  not_null binary
    var $codigotipoaplicaarp;             // string(3)  not_null multiple_key
    var $codigoconcepto;                  // string(8)  not_null multiple_key
    var $semestreinicioaplicaarp;         // int(6)  not_null
    var $semestrefinalaplicaarp;          // int(6)  not_null

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Aplicaarp',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
