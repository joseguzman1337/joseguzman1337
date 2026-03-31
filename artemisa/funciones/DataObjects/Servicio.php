<?php
/**
 * Table Definition for servicio
 */
require_once 'DB/DataObject.php';

class DataObjects_Servicio extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'servicio';                        // table name
    var $codigoservicio;                  // int(11)  not_null primary_key auto_increment
    var $codigotipoinventarioservicio;    // string(3)  not_null multiple_key
    var $codigogruposervicio;             // string(3)  not_null multiple_key
    var $nombreservicio;                  // string(100)  not_null
    var $fechaservicio;                   // datetime(19)  not_null binary
    var $fechainicioservicio;             // date(10)  not_null binary
    var $fechafinalservicio;              // date(10)  not_null binary
    var $ivaservicio;                     // int(11)  not_null
    var $codigoestado;                    // string(3)  not_null multiple_key

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Servicio',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
