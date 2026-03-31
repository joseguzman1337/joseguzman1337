<?php
/**
 * Table Definition for seguimientoacademico
 */
require_once 'DB/DataObject.php';

class DataObjects_Seguimientoacademico extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'seguimientoacademico';            // table name
    public $idseguimientoacademico;          // int(11)  not_null primary_key auto_increment
    public $fechaseguimientoacademico;       // date(10)  not_null binary
    public $codigocarrera;                   // int(11)  not_null multiple_key
    public $codigoestado;                    // string(3)  not_null multiple_key
    public $codigoperiodo;                   // string(8)  not_null multiple_key

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Seguimientoacademico',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
