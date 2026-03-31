<?php
/**
 * Table Definition for estudiantecarrerainscripcion
 */
require_once 'DB/DataObject.php';

class DataObjects_Estudiantecarrerainscripcion extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'estudiantecarrerainscripcion';    // table name
    public $idestudiantecarrerainscripcion;    // int(11)  not_null primary_key auto_increment
    public $codigocarrera;                   // int(11)  not_null multiple_key
    public $idnumeroopcion;                  // int(11)  not_null multiple_key
    public $idinscripcion;                   // int(11)  not_null multiple_key
    public $idestudiantegeneral;             // int(11)  not_null multiple_key
    public $codigoestado;                    // string(3)  not_null multiple_key

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Estudiantecarrerainscripcion',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
