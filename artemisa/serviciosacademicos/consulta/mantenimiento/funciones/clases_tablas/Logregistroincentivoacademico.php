<?php
/**
 * Table Definition for logregistroincentivoacademico
 */
require_once 'DB/DataObject.php';

class DataObjects_Logregistroincentivoacademico extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'logregistroincentivoacademico';    // table name
    public $idlogregistroincentivoacademico;    // int(11)  not_null primary_key auto_increment
    public $idregistroincentivoacademico;    // int(11)  not_null multiple_key
    public $idincentivoacademico;            // int(11)  not_null multiple_key
    public $fechalogregistroincentivoacademico;    // date(10)  not_null binary
    public $nombrelogregistroincentivoacademico;    // string(100)  not_null
    public $numeroacuerdologregistroincentivoacademico;    // string(15)  not_null
    public $fechaacuerdologregistroincentivoacademico;    // date(10)  not_null binary
    public $numeroactalogregistroincentivoacademico;    // string(15)  not_null
    public $fechaactalogregistroincentivoacademico;    // date(10)  not_null binary
    public $observacionlogregistroincentivoacademico;    // string(200)  not_null
    public $codigoestado;                    // string(3)  not_null multiple_key
    public $idusuario;                       // int(11)  not_null multiple_key

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Logregistroincentivoacademico',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
