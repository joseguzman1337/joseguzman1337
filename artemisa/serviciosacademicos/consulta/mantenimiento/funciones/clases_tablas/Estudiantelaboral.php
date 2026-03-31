<?php
/**
 * Table Definition for estudiantelaboral
 */
require_once 'DB/DataObject.php';

class DataObjects_Estudiantelaboral extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'estudiantelaboral';               // table name
    public $idestudiantelaboral;             // int(11)  not_null primary_key auto_increment
    public $idestudiantegeneral;             // int(11)  not_null multiple_key
    public $idinscripcion;                   // int(11)  not_null multiple_key
    public $descripcionestudiantelaboral;    // string(200)  not_null
    public $cargoestudiantelaboral;          // string(50)  not_null
    public $empresaestudiantelaboral;        // string(50)  not_null
    public $idciudad;                        // int(11)  not_null multiple_key
    public $codigoestado;                    // string(3)  not_null multiple_key
    public $idtipoestudiantelaboral;         // int(11)  not_null multiple_key

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Estudiantelaboral',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
