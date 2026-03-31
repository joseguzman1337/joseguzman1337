<?php
/**
 * Table Definition for inscripcionformulario
 */
require_once 'DB/DataObject.php';

class DataObjects_Inscripcionformulario extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'inscripcionformulario';           // table name
    public $idinscripcionformulario;         // int(11)  not_null primary_key auto_increment
    public $codigomodalidadacademica;        // string(3)  not_null multiple_key
    public $idinscripcionmodulo;             // int(11)  not_null multiple_key
    public $codigoestado;                    // string(3)  not_null multiple_key
    public $posicioninscripcionformulario;    // int(6)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Inscripcionformulario',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
