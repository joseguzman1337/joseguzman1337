<?php
/**
 * Table Definition for estudianteidioma
 */
require_once 'DB/DataObject.php';

class DataObjects_Estudianteidioma extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'estudianteidioma';                // table name
    public $idestudianteidioma;              // int(11)  not_null primary_key auto_increment
    public $idestudiantegeneral;             // int(11)  not_null multiple_key
    public $idinscripcion;                   // int(11)  not_null multiple_key
    public $ididioma;                        // int(11)  not_null multiple_key
    public $porcentajeleeestudianteidioma;    // string(3)  not_null
    public $porcentajeescribeestudianteidioma;    // string(3)  not_null
    public $porcentajehablaestudianteidioma;    // string(3)  not_null
    public $descripcionestudianteidioma;     // string(100)  not_null
    public $codigoestado;                    // string(3)  not_null multiple_key

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Estudianteidioma',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
