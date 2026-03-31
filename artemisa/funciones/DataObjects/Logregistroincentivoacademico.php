<?php
/**
 * Table Definition for logregistroincentivoacademico
 */
require_once 'DB/DataObject.php';

class DataObjects_Logregistroincentivoacademico extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'logregistroincentivoacademico';    // table name
    var $idlogregistroincentivoacademico;    // int(11)  not_null primary_key auto_increment
    var $idregistroincentivoacademico;    // int(11)  not_null multiple_key
    var $idincentivoacademico;            // int(11)  not_null multiple_key
    var $fechalogregistroincentivoacademico;    // date(10)  not_null binary
    var $nombrelogregistroincentivoacademico;    // string(100)  not_null
    var $numeroacuerdologregistroincentivoacademico;    // string(15)  not_null
    var $fechaacuerdologregistroincentivoacademico;    // date(10)  not_null binary
    var $numeroactalogregistroincentivoacademico;    // string(15)  not_null
    var $fechaactalogregistroincentivoacademico;    // date(10)  not_null binary
    var $observacionlogregistroincentivoacademico;    // string(200)  not_null
    var $codigoestado;                    // string(3)  not_null multiple_key
    var $idusuario;                       // int(11)  not_null multiple_key

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Logregistroincentivoacademico',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
