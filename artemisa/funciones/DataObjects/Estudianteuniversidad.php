<?php
/**
 * Table Definition for estudianteuniversidad
 */
require_once 'DB/DataObject.php';

class DataObjects_Estudianteuniversidad extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'estudianteuniversidad';           // table name
    var $idestudianteuniversidad;         // int(11)  not_null primary_key auto_increment
    var $idestudiantegeneral;             // int(11)  not_null multiple_key
    var $idinscripcion;                   // int(11)  not_null multiple_key
    var $institucioneducativaestudianteuniversidad;    // string(100)  not_null
    var $programaacademicoestudianteuniversidad;    // string(100)  not_null
    var $anoestudianteuniversidad;        // string(10)  not_null
    var $codigoestado;                    // string(3)  not_null multiple_key

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Estudianteuniversidad',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
