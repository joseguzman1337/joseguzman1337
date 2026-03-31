<?php
/**
 * Table Definition for asignaturaestado
 */
require_once 'DB/DataObject.php';

class DataObjects_Asignaturaestado extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'asignaturaestado';                // table name
    public $idasignaturaestado;              // int(11)  not_null primary_key auto_increment
    public $nombreasignaturaestado;          // string(50)  not_null
    public $puntajeminimoasignaturaestado;    // int(6)  not_null
    public $puntajemaximoasignaturaestado;    // int(6)  not_null
    public $codigoestado;                    // string(3)  not_null multiple_key

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Asignaturaestado',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
