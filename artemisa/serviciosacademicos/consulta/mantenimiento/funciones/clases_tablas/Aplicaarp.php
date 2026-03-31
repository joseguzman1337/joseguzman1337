<?php
/**
 * Table Definition for aplicaarp
 */
require_once 'DB/DataObject.php';

class DataObjects_Aplicaarp extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'aplicaarp';                       // table name
    public $idaplicaarp;                     // int(11)  not_null primary_key auto_increment
    public $nombreaplicaarp;                 // string(100)  not_null
    public $codigocarrera;                   // int(11)  not_null multiple_key
    public $codigoperiodo;                   // string(8)  not_null multiple_key
    public $idempresasalud;                  // int(11)  not_null
    public $valorbaseaplicaarp;              // int(11)  not_null
    public $porcentajeaplicaarp;             // int(6)  not_null
    public $valorfijoaplicaarp;              // int(11)  not_null
    public $fechaaplicaarp;                  // datetime(19)  not_null binary
    public $fechainicioaplicaarp;            // datetime(19)  not_null binary
    public $fechafinalaplicaarp;             // datetime(19)  not_null binary
    public $codigotipoaplicaarp;             // string(3)  not_null multiple_key
    public $codigoconcepto;                  // string(3)  not_null multiple_key
    public $semestreinicioaplicaarp;         // int(6)  not_null
    public $semestrefinalaplicaarp;          // int(6)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Aplicaarp',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
