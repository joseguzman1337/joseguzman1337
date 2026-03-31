<?php
/**
 * Table Definition for lineaenfasisestudiante
 */
require_once 'DB/DataObject.php';

class DataObjects_Lineaenfasisestudiante extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'lineaenfasisestudiante';          // table name
    var $idplanestudio;                   // int(11)  not_null primary_key multiple_key
    var $idlineaenfasisplanestudio;       // int(11)  not_null primary_key multiple_key
    var $codigoestudiante;                // int(11)  not_null primary_key multiple_key
    var $fechaasignacionfechainiciolineaenfasisestudiante;    // datetime(19)  not_null binary
    var $fechainiciolineaenfasisestudiante;    // datetime(19)  not_null binary
    var $fechavencimientolineaenfasisestudiante;    // datetime(19)  not_null binary

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Lineaenfasisestudiante',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
