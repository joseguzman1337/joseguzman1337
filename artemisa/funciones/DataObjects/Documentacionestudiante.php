<?php
/**
 * Table Definition for documentacionestudiante
 */
require_once 'DB/DataObject.php';

class DataObjects_Documentacionestudiante extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'documentacionestudiante';         // table name
    var $iddocumentacionestudiante;       // int(11)  not_null primary_key auto_increment
    var $codigoestudiante;                // int(11)  not_null multiple_key
    var $iddocumentacion;                 // int(11)  not_null multiple_key
    var $codigoperiodo;                   // string(8)  not_null multiple_key
    var $fechainiciodocumentacionestudiante;    // datetime(19)  not_null binary
    var $fechavencimientodocumentacionestudiante;    // datetime(19)  not_null binary
    var $codigotipodocumentovencimiento;    // string(3)  not_null multiple_key
    var $idempresasalud;                  // int(11)  not_null multiple_key

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Documentacionestudiante',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
