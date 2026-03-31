<?php
/**
 * Table Definition for detalleseguimientoacademico
 */
require_once 'DB/DataObject.php';

class DataObjects_Detalleseguimientoacademico extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'detalleseguimientoacademico';     // table name
    var $iddetalleseguimientoacademico;    // int(11)  not_null primary_key auto_increment
    var $idseguimientoacademico;          // int(11)  not_null multiple_key
    var $notadesdedetalleseguimientoacademico;    // unknown(7)  not_null
    var $notahastadetalleseguimientoacademico;    // unknown(7)  not_null
    var $descripciondetalleseguimientoacademico;    // blob(-1)  not_null blob
    var $codigotipodetalleseguimientoacademico;    // string(3)  not_null multiple_key
    var $codigoestado;                    // string(3)  not_null multiple_key

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Detalleseguimientoacademico',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
