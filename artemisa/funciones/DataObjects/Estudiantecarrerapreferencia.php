<?php
/**
 * Table Definition for estudiantecarrerapreferencia
 */
require_once 'DB/DataObject.php';

class DataObjects_Estudiantecarrerapreferencia extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'estudiantecarrerapreferencia';    // table name
    var $idestudiantecarrerapreferencia;    // int(11)  not_null primary_key auto_increment
    var $nombreestudiantecarrerapreferencia;    // string(50)  not_null
    var $porqueestudiantecarrerapreferencia;    // string(100)  not_null
    var $idestudiantegeneral;             // int(11)  not_null multiple_key
    var $idinscripcion;                   // int(11)  not_null multiple_key
    var $codigoestado;                    // string(3)  not_null multiple_key

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Estudiantecarrerapreferencia',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
