<?php
/**
 * Table Definition for detalleadmision
 */
require_once 'DB/DataObject.php';

class DataObjects_Detalleadmision extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'detalleadmision';                 // table name
    var $iddetalleadmision;               // int(11)  not_null primary_key auto_increment
    var $idadmision;                      // int(11)  not_null multiple_key
    var $numeroprioridaddetalleadmision;    // string(3)  not_null
    var $nombredetalleadmision;           // string(100)  not_null
    var $porcentajedetalleadmision;       // int(6)  not_null
    var $totalpreguntasdetalleadmision;    // int(6)  not_null
    var $codigoestado;                    // string(3)  not_null multiple_key
    var $codigotipodetalleadmision;       // int(11)  not_null multiple_key
    var $codigorequierepreselecciondetalleadmision;    // string(3)  not_null multiple_key

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Detalleadmision',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
