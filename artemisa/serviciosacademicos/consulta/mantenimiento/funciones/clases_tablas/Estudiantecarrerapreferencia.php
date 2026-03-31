<?php
/**
 * Table Definition for estudiantecarrerapreferencia
 */
require_once 'DB/DataObject.php';

class DataObjects_Estudiantecarrerapreferencia extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'estudiantecarrerapreferencia';    // table name
    public $idestudiantecarrerapreferencia;    // int(11)  not_null primary_key auto_increment
    public $nombreestudiantecarrerapreferencia;    // string(50)  not_null
    public $porqueestudiantecarrerapreferencia;    // string(100)  not_null
    public $idestudiantegeneral;             // int(11)  not_null multiple_key
    public $idinscripcion;                   // int(11)  not_null multiple_key
    public $codigoestado;                    // string(3)  not_null multiple_key

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Estudiantecarrerapreferencia',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
