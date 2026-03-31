<?php
/**
 * Table Definition for grupo
 */
require_once '../funciones/pear/DB/DataObject.php';

class DataObjects_Grupo extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'grupo';                           // table name
    var $idgrupo;                         // int(11)  not_null primary_key auto_increment
    var $codigogrupo;                     // string(5)  not_null multiple_key
    var $nombregrupo;                     // string(30)  not_null
    var $codigomateria;                   // int(11)  not_null multiple_key
    var $codigoperiodo;                   // string(8)  not_null multiple_key
    var $numerodocumento;                 // string(15)  not_null multiple_key
    var $maximogrupo;                     // int(6)  not_null
    var $matriculadosgrupo;               // int(6)  not_null
    var $maximogrupoelectiva;             // int(6)  not_null
    var $matriculadosgrupoelectiva;       // int(6)  not_null
    var $codigoestadogrupo;               // string(2)  not_null multiple_key
    var $codigoindicadorhorario;          // string(3)  not_null multiple_key
    var $fechainiciogrupo;                // date(10)  not_null binary
    var $fechafinalgrupo;                 // date(10)  not_null binary
    var $numerodiasconservagrupo;         // int(6)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Grupo',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
