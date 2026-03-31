<?php
/**
 * Table Definition for inscripcionformulario
 */
require_once 'DB/DataObject.php';

class DataObjects_Inscripcionformulario extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'inscripcionformulario';           // table name
    var $idinscripcionformulario;         // int(11)  not_null primary_key auto_increment
    var $codigomodalidadacademica;        // string(3)  not_null multiple_key
    var $idinscripcionmodulo;             // int(11)  not_null multiple_key
    var $codigoestado;                    // string(3)  not_null multiple_key
    var $posicioninscripcionformulario;    // int(6)  not_null

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Inscripcionformulario',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
