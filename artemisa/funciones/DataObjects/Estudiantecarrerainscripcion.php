<?php
/**
 * Table Definition for estudiantecarrerainscripcion
 */
require_once 'DB/DataObject.php';

class DataObjects_Estudiantecarrerainscripcion extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'estudiantecarrerainscripcion';    // table name
    var $idestudiantecarrerainscripcion;    // int(11)  not_null primary_key auto_increment
    var $codigocarrera;                   // int(11)  not_null multiple_key
    var $idnumeroopcion;                  // int(11)  not_null multiple_key
    var $idinscripcion;                   // int(11)  not_null multiple_key
    var $idestudiantegeneral;             // int(11)  not_null multiple_key
    var $codigoestado;                    // string(3)  not_null multiple_key

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Estudiantecarrerainscripcion',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
