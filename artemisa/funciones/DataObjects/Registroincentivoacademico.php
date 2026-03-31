<?php
/**
 * Table Definition for registroincentivoacademico
 */
require_once 'DB/DataObject.php';

class DataObjects_Registroincentivoacademico extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'registroincentivoacademico';      // table name
    var $idregistroincentivoacademico;    // int(11)  not_null primary_key auto_increment
    var $idregistrograduado;              // int(11)  not_null multiple_key
    var $idincentivoacademico;            // int(11)  not_null multiple_key
    var $fecharegistroincentivoacademico;    // date(10)  not_null binary
    var $nombreregistroincentivoacademico;    // string(100)  not_null
    var $numeroacuerdoregistroincentivoacademico;    // string(15)  not_null
    var $fechaacuerdoregistroincentivoacademico;    // date(10)  not_null binary
    var $numeroactaregistroincentivoacademico;    // string(15)  not_null
    var $fechaactaregistroincentivoacademico;    // date(10)  not_null binary
    var $observacionregistroincentivoacademico;    // string(200)  not_null
    var $codigoestado;                    // string(3)  not_null multiple_key
    var $idusuario;                       // int(11)  not_null multiple_key

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Registroincentivoacademico',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
