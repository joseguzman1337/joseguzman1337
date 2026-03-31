<?php
/**
 * Table Definition for detalleseguimientoacademico
 */
require_once 'DB/DataObject.php';

class DataObjects_Detalleseguimientoacademico extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'detalleseguimientoacademico';     // table name
    public $iddetalleseguimientoacademico;    // int(11)  not_null primary_key auto_increment
    public $idseguimientoacademico;          // int(11)  not_null multiple_key
    public $notadesdedetalleseguimientoacademico;    // unknown(7)  not_null
    public $notahastadetalleseguimientoacademico;    // unknown(7)  not_null
    public $descripciondetalleseguimientoacademico;    // blob(-1)  not_null blob
    public $codigotipodetalleseguimientoacademico;    // string(3)  not_null multiple_key
    public $codigoestado;                    // string(3)  not_null multiple_key

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Detalleseguimientoacademico',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
