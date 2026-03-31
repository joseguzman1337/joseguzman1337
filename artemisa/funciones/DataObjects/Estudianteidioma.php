<?php
/**
 * Table Definition for estudianteidioma
 */
require_once 'DB/DataObject.php';

class DataObjects_Estudianteidioma extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'estudianteidioma';                // table name
    var $idestudianteidioma;              // int(11)  not_null primary_key auto_increment
    var $idestudiantegeneral;             // int(11)  not_null multiple_key
    var $idinscripcion;                   // int(11)  not_null multiple_key
    var $ididioma;                        // int(11)  not_null multiple_key
    var $porcentajeleeestudianteidioma;    // string(3)  not_null
    var $porcentajeescribeestudianteidioma;    // string(3)  not_null
    var $porcentajehablaestudianteidioma;    // string(3)  not_null
    var $descripcionestudianteidioma;     // string(100)  not_null
    var $codigoestado;                    // string(3)  not_null multiple_key

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Estudianteidioma',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
