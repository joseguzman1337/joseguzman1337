<?php
/**
 * Table Definition for estudiantelaboral
 */
require_once 'DB/DataObject.php';

class DataObjects_Estudiantelaboral extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'estudiantelaboral';               // table name
    var $idestudiantelaboral;             // int(11)  not_null primary_key auto_increment
    var $idestudiantegeneral;             // int(11)  not_null multiple_key
    var $idinscripcion;                   // int(11)  not_null multiple_key
    var $descripcionestudiantelaboral;    // string(200)  not_null
    var $cargoestudiantelaboral;          // string(50)  not_null
    var $empresaestudiantelaboral;        // string(50)  not_null
    var $idciudad;                        // int(11)  not_null multiple_key
    var $codigoestado;                    // string(3)  not_null multiple_key
    var $idtipoestudiantelaboral;         // int(11)  not_null multiple_key

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Estudiantelaboral',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
