<?php
/**
 * Table Definition for estadopreinscripcionestudiante
 */
require_once 'DB/DataObject.php';

class DataObjects_Estadopreinscripcionestudiante extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'estadopreinscripcionestudiante';    // table name
    public $codigoestadopreinscripcionestudiante;    // string(3)  not_null primary_key
    public $nombreestadopreinscripcionestudiante;    // string(50)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Estadopreinscripcionestudiante',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
