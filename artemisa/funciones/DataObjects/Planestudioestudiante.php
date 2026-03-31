<?php
/**
 * Table Definition for planestudioestudiante
 */
require_once 'DB/DataObject.php';

class DataObjects_Planestudioestudiante extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'planestudioestudiante';           // table name
    var $idplanestudio;                   // int(11)  not_null primary_key multiple_key
    var $codigoestudiante;                // int(11)  not_null primary_key multiple_key
    var $fechaasignacionplanestudioestudiante;    // datetime(19)  not_null binary
    var $fechainicioplanestudioestudiante;    // datetime(19)  not_null binary
    var $fechavencimientoplanestudioestudiante;    // datetime(19)  not_null binary
    var $codigoestadoplanestudioestudiante;    // string(3)  not_null multiple_key

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Planestudioestudiante',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
