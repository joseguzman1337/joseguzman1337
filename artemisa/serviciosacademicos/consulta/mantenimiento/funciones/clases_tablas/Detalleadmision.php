<?php
/**
 * Table Definition for detalleadmision
 */
require_once 'DB/DataObject.php';

class DataObjects_Detalleadmision extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'detalleadmision';                 // table name
    public $iddetalleadmision;               // int(11)  not_null primary_key auto_increment
    public $idadmision;                      // int(11)  not_null multiple_key
    public $numeroprioridaddetalleadmision;    // string(3)  not_null
    public $nombredetalleadmision;           // string(100)  not_null
    public $porcentajedetalleadmision;       // int(6)  not_null
    public $totalpreguntasdetalleadmision;    // int(6)  not_null
    public $codigoestado;                    // string(3)  not_null multiple_key
    public $codigotipodetalleadmision;       // int(11)  not_null multiple_key
    public $codigorequierepreselecciondetalleadmision;    // string(3)  not_null multiple_key

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Detalleadmision',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
