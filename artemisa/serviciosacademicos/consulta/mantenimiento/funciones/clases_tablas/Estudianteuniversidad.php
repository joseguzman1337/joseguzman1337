<?php
/**
 * Table Definition for estudianteuniversidad
 */
require_once 'DB/DataObject.php';

class DataObjects_Estudianteuniversidad extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'estudianteuniversidad';           // table name
    public $idestudianteuniversidad;         // int(11)  not_null primary_key auto_increment
    public $idestudiantegeneral;             // int(11)  not_null multiple_key
    public $idinscripcion;                   // int(11)  not_null multiple_key
    public $institucioneducativaestudianteuniversidad;    // string(100)  not_null
    public $programaacademicoestudianteuniversidad;    // string(100)  not_null
    public $anoestudianteuniversidad;        // string(10)  not_null
    public $codigoestado;                    // string(3)  not_null multiple_key

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Estudianteuniversidad',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
