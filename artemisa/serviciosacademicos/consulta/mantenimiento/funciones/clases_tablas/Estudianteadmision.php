<?php
/**
 * Table Definition for estudianteadmision
 */
require_once 'DB/DataObject.php';

class DataObjects_Estudianteadmision extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'estudianteadmision';              // table name
    public $idestudianteadmision;            // int(11)  not_null primary_key auto_increment
    public $horainicioestudianteadmision;    // time(8)  not_null binary
    public $horafinalestudianteadmision;     // time(8)  not_null binary
    public $idestudiantegeneral;             // int(11)  not_null multiple_key
    public $idinscripcion;                   // int(11)  not_null multiple_key
    public $iddetalleadmision;               // int(11)  not_null multiple_key
    public $codigoestado;                    // string(3)  not_null multiple_key
    public $idhorariositioadmision;          // int(11)  not_null multiple_key

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Estudianteadmision',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
