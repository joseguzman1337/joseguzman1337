<?php
/**
 * Table Definition for estudianteadmision
 */
require_once 'DB/DataObject.php';

class DataObjects_Estudianteadmision extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'estudianteadmision';              // table name
    var $idestudianteadmision;            // int(11)  not_null primary_key auto_increment
    var $horainicioestudianteadmision;    // time(8)  not_null binary
    var $horafinalestudianteadmision;     // time(8)  not_null binary
    var $idestudiantegeneral;             // int(11)  not_null multiple_key
    var $idinscripcion;                   // int(11)  not_null multiple_key
    var $iddetalleadmision;               // int(11)  not_null multiple_key
    var $codigoestado;                    // string(3)  not_null multiple_key
    var $idhorariositioadmision;          // int(11)  not_null multiple_key

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Estudianteadmision',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
