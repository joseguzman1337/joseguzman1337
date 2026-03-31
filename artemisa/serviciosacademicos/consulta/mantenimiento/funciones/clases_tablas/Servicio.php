<?php
/**
 * Table Definition for servicio
 */
require_once 'DB/DataObject.php';

class DataObjects_Servicio extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'servicio';                        // table name
    public $codigoservicio;                  // int(11)  not_null primary_key auto_increment
    public $codigotipoinventarioservicio;    // string(3)  not_null multiple_key
    public $codigogruposervicio;             // string(3)  not_null multiple_key
    public $nombreservicio;                  // string(100)  not_null
    public $fechaservicio;                   // datetime(19)  not_null binary
    public $fechainicioservicio;             // date(10)  not_null binary
    public $fechafinalservicio;              // date(10)  not_null binary
    public $ivaservicio;                     // int(11)  not_null
    public $codigoestado;                    // string(3)  not_null multiple_key

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Servicio',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
