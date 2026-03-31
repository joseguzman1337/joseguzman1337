<?php
/**
 * Table Definition for estudiantemediocomunicacion
 */
require_once 'DB/DataObject.php';

class DataObjects_Estudiantemediocomunicacion extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'estudiantemediocomunicacion';     // table name
    var $idestudiantemediocomunicacion;    // int(11)  not_null primary_key auto_increment
    var $idestudiantegeneral;             // int(11)  not_null multiple_key
    var $idinscripcion;                   // int(11)  not_null multiple_key
    var $codigomediocomunicacion;         // string(3)  not_null multiple_key
    var $codigoestadoestudiantemediocomunicacion;    // string(3)  not_null multiple_key
    var $observacionestudiantemediocomunicacion;    // string(100)  not_null

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Estudiantemediocomunicacion',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
