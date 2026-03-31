<?php
/**
 * Table Definition for estadoprioridadsoportetecnico
 */
require_once 'DB/DataObject.php';

class DataObjects_Estadoprioridadsoportetecnico extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'estadoprioridadsoportetecnico';    // table name
    var $codigoestadoprioridadsoportetecnico;    // string(3)  not_null primary_key
    var $nombreestadoprioridadsoportetecnico;    // string(50)  not_null
    var $codigoestado;                    // string(3)  not_null multiple_key
    var $idtiposubperiodo;                // int(11)  not_null multiple_key
    var $tiemporespuestaestadoprioridadsoportetecnico;    // unknown(7)  not_null

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Estadoprioridadsoportetecnico',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
