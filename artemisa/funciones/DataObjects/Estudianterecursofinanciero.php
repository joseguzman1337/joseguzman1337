<?php
/**
 * Table Definition for estudianterecursofinanciero
 */
require_once 'DB/DataObject.php';

class DataObjects_Estudianterecursofinanciero extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'estudianterecursofinanciero';     // table name
    var $idestudianterecursofinanciero;    // int(11)  not_null primary_key auto_increment
    var $idinscripcion;                   // int(11)  not_null multiple_key
    var $idestudiantegeneral;             // int(11)  not_null multiple_key
    var $idtipoestudianterecursofinanciero;    // int(11)  not_null multiple_key
    var $descripcionestudianterecursofinanciero;    // string(100)  not_null
    var $codigoestado;                    // string(3)  not_null multiple_key

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Estudianterecursofinanciero',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
