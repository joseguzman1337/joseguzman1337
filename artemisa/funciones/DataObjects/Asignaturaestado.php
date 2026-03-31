<?php
/**
 * Table Definition for asignaturaestado
 */
require_once 'DB/DataObject.php';

class DataObjects_Asignaturaestado extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'asignaturaestado';                // table name
    var $idasignaturaestado;              // int(11)  not_null primary_key auto_increment
    var $nombreasignaturaestado;          // string(50)  not_null
    var $puntajeminimoasignaturaestado;    // int(6)  not_null
    var $puntajemaximoasignaturaestado;    // int(6)  not_null
    var $codigoestado;                    // string(3)  not_null multiple_key

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Asignaturaestado',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
