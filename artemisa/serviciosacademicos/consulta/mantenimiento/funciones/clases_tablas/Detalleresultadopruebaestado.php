<?php
/**
 * Table Definition for detalleresultadopruebaestado
 */
require_once 'DB/DataObject.php';

class DataObjects_Detalleresultadopruebaestado extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'detalleresultadopruebaestado';    // table name
    public $iddetalleresultadopruebaestado;    // int(11)  not_null primary_key auto_increment
    public $idresultadopruebaestado;         // int(11)  not_null multiple_key
    public $idasignaturaestado;              // int(11)  not_null multiple_key
    public $notadetalleresultadopruebaestado;    // string(5)  not_null
    public $codigoestado;                    // string(3)  not_null multiple_key

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Detalleresultadopruebaestado',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
