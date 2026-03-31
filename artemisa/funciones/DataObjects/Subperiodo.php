<?php
/**
 * Table Definition for subperiodo
 */
require_once 'DB/DataObject.php';

class DataObjects_Subperiodo extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'subperiodo';                      // table name
    var $idsubperiodo;                    // int(11)  not_null primary_key auto_increment
    var $idcarreraperiodo;                // int(11)  not_null multiple_key
    var $nombresubperiodo;                // string(50)  not_null
    var $fechasubperiodo;                 // datetime(19)  not_null binary
    var $fechainicioacademicosubperiodo;    // date(10)  not_null binary
    var $fechafinalacademicosubperiodo;    // date(10)  not_null binary
    var $fechainiciofinancierosubperiodo;    // date(10)  not_null binary
    var $fechafinalfinancierosubperiodo;    // date(10)  not_null binary
    var $numerosubperiodo;                // string(3)  not_null
    var $idtiposubperiodo;                // int(11)  not_null multiple_key
    var $codigoestadosubperiodo;          // string(3)  not_null multiple_key
    var $idusuario;                       // int(11)  not_null multiple_key
    var $ip;                              // string(50)  not_null

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Subperiodo',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
