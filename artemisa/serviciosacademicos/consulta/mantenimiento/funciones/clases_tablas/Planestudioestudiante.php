<?php
/**
 * Table Definition for planestudioestudiante
 */
require_once 'DB/DataObject.php';

class DataObjects_Planestudioestudiante extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'planestudioestudiante';           // table name
    public $idplanestudio;                   // int(11)  not_null primary_key multiple_key
    public $codigoestudiante;                // int(11)  not_null primary_key multiple_key
    public $fechaasignacionplanestudioestudiante;    // datetime(19)  not_null binary
    public $fechainicioplanestudioestudiante;    // datetime(19)  not_null binary
    public $fechavencimientoplanestudioestudiante;    // datetime(19)  not_null binary
    public $codigoestadoplanestudioestudiante;    // string(3)  not_null multiple_key

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Planestudioestudiante',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
