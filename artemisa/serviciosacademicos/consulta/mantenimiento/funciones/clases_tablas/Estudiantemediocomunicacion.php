<?php
/**
 * Table Definition for estudiantemediocomunicacion
 */
require_once 'DB/DataObject.php';

class DataObjects_Estudiantemediocomunicacion extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'estudiantemediocomunicacion';     // table name
    public $idestudiantemediocomunicacion;    // int(11)  not_null primary_key auto_increment
    public $idestudiantegeneral;             // int(11)  not_null multiple_key
    public $idinscripcion;                   // int(11)  not_null multiple_key
    public $codigomediocomunicacion;         // string(3)  not_null multiple_key
    public $codigoestadoestudiantemediocomunicacion;    // string(3)  not_null multiple_key
    public $observacionestudiantemediocomunicacion;    // string(100)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Estudiantemediocomunicacion',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
