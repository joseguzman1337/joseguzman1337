<?php
/**
 * Table Definition for documentacionestudiante
 */
require_once 'DB/DataObject.php';

class DataObjects_Documentacionestudiante extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'documentacionestudiante';         // table name
    public $iddocumentacionestudiante;       // int(11)  not_null primary_key auto_increment
    public $codigoestudiante;                // int(11)  not_null multiple_key
    public $iddocumentacion;                 // int(11)  not_null multiple_key
    public $codigoperiodo;                   // string(8)  not_null multiple_key
    public $fechainiciodocumentacionestudiante;    // datetime(19)  not_null binary
    public $fechavencimientodocumentacionestudiante;    // datetime(19)  not_null binary
    public $codigotipodocumentovencimiento;    // string(3)  not_null multiple_key
    public $idempresasalud;                  // int(11)  not_null multiple_key

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Documentacionestudiante',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
