<?php
/**
 * Table Definition for estudiantedecisionuniversidad
 */
require_once 'DB/DataObject.php';

class DataObjects_Estudiantedecisionuniversidad extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'estudiantedecisionuniversidad';    // table name
    var $idestudiantedecisionuniversidad;    // int(11)  not_null primary_key auto_increment
    var $idestudiantegeneral;             // int(11)  not_null multiple_key
    var $codigodecisionuniversidad;       // string(3)  not_null multiple_key
    var $codigoestadoestudiantedecisionuniversidad;    // string(50)  not_null multiple_key
    var $idinscripcion;                   // int(11)  not_null multiple_key

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Estudiantedecisionuniversidad',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
