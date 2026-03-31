<?php
/**
 * Table Definition for registrograduado
 */
require_once 'DB/DataObject.php';

class DataObjects_Registrograduado extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'registrograduado';                // table name
    public $idregistrograduado;              // int(11)  not_null primary_key auto_increment
    public $codigoestudiante;                // int(11)  not_null multiple_key
    public $fecharegistrograduado;           // datetime(19)  not_null binary
    public $numeropromocion;                 // string(15)  not_null
    public $numeroacuerdoregistrograduado;    // string(15)  not_null
    public $fechaacuerdoregistrograduado;    // date(10)  not_null binary
    public $responsableacuerdoregistrograduado;    // string(100)  not_null binary
    public $numeroactaregistrograduado;      // string(15)  not_null
    public $fechaactaregistrograduado;       // date(10)  not_null binary
    public $numerodiplomaregistrograduado;    // string(15)  not_null
    public $fechadiplomaregistrograduado;    // date(10)  not_null binary
    public $fechagradoregistrograduado;      // date(10)  not_null binary
    public $lugarregistrograduado;           // string(100)  not_null
    public $presidioregistrograduado;        // string(50)  not_null
    public $observacionregistrograduado;     // string(150)  not_null
    public $codigoestado;                    // string(3)  not_null multiple_key
    public $codigotiporegistrograduado;      // string(3)  not_null multiple_key
    public $direccionipregistrograduado;     // string(50)  not_null
    public $usuario;                         // string(50)  not_null multiple_key
    public $iddirectivo;                     // int(11)  not_null multiple_key
    public $codigoautorizacionregistrograduado;    // string(3)  not_null multiple_key
    public $fechaautorizacionregistrograduado;    // datetime(19)  not_null binary
    public $codigotipomodificaregistrograduado;    // string(3)  not_null multiple_key
    public $idtipogrado;                     // int(11)  not_null multiple_key

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Registrograduado',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
