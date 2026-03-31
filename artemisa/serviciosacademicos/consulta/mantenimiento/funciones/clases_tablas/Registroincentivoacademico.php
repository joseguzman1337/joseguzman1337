<?php
/**
 * Table Definition for registroincentivoacademico
 */
require_once 'DB/DataObject.php';

class DataObjects_Registroincentivoacademico extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'registroincentivoacademico';      // table name
    public $idregistroincentivoacademico;    // int(11)  not_null primary_key auto_increment
    public $idregistrograduado;              // int(11)  not_null multiple_key
    public $idincentivoacademico;            // int(11)  not_null multiple_key
    public $fecharegistroincentivoacademico;    // date(10)  not_null binary
    public $nombreregistroincentivoacademico;    // string(100)  not_null
    public $numeroacuerdoregistroincentivoacademico;    // string(15)  not_null
    public $fechaacuerdoregistroincentivoacademico;    // date(10)  not_null binary
    public $numeroactaregistroincentivoacademico;    // string(15)  not_null
    public $fechaactaregistroincentivoacademico;    // date(10)  not_null binary
    public $observacionregistroincentivoacademico;    // string(200)  not_null
    public $codigoestado;                    // string(3)  not_null multiple_key
    public $idusuario;                       // int(11)  not_null multiple_key

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Registroincentivoacademico',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
