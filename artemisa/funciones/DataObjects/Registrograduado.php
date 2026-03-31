<?php
/**
 * Table Definition for registrograduado
 */
require_once 'DB/DataObject.php';

class DataObjects_Registrograduado extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'registrograduado';                // table name
    var $idregistrograduado;              // int(11)  not_null primary_key auto_increment
    var $codigoestudiante;                // int(11)  not_null multiple_key
    var $fecharegistrograduado;           // datetime(19)  not_null binary
    var $numeropromocion;                 // string(15)  not_null
    var $numeroacuerdoregistrograduado;    // string(15)  not_null
    var $fechaacuerdoregistrograduado;    // date(10)  not_null binary
    var $responsableacuerdoregistrograduado;    // string(100)  not_null binary
    var $numeroactaregistrograduado;      // string(15)  not_null
    var $fechaactaregistrograduado;       // date(10)  not_null binary
    var $numerodiplomaregistrograduado;    // string(15)  not_null
    var $fechadiplomaregistrograduado;    // date(10)  not_null binary
    var $fechagradoregistrograduado;      // date(10)  not_null binary
    var $lugarregistrograduado;           // string(100)  not_null
    var $presidioregistrograduado;        // string(50)  not_null
    var $observacionregistrograduado;     // string(150)  not_null
    var $codigoestado;                    // string(3)  not_null multiple_key
    var $codigotiporegistrograduado;      // string(3)  not_null multiple_key
    var $direccionipregistrograduado;     // string(50)  not_null
    var $usuario;                         // string(50)  not_null multiple_key
    var $iddirectivo;                     // int(11)  not_null multiple_key
    var $codigoautorizacionregistrograduado;    // string(3)  not_null multiple_key
    var $fechaautorizacionregistrograduado;    // datetime(19)  not_null binary
    var $codigotipomodificaregistrograduado;    // string(3)  not_null multiple_key
    var $idtipogrado;                     // int(11)  not_null multiple_key

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Registrograduado',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
