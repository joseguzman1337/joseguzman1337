<?php
/**
 * Table Definition for estudiantedecisionuniversidad
 */
require_once 'DB/DataObject.php';

class DataObjects_Estudiantedecisionuniversidad extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'estudiantedecisionuniversidad';    // table name
    public $idestudiantedecisionuniversidad;    // int(11)  not_null primary_key auto_increment
    public $idestudiantegeneral;             // int(11)  not_null multiple_key
    public $codigodecisionuniversidad;       // string(3)  not_null multiple_key
    public $codigoestadoestudiantedecisionuniversidad;    // string(50)  not_null multiple_key
    public $idinscripcion;                   // int(11)  not_null multiple_key

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Estudiantedecisionuniversidad',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
