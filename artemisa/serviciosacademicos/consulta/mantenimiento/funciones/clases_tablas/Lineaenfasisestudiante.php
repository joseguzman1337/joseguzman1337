<?php
/**
 * Table Definition for lineaenfasisestudiante
 */
require_once 'DB/DataObject.php';

class DataObjects_Lineaenfasisestudiante extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'lineaenfasisestudiante';          // table name
    public $idplanestudio;                   // int(11)  not_null primary_key multiple_key
    public $idlineaenfasisplanestudio;       // int(11)  not_null primary_key multiple_key
    public $codigoestudiante;                // int(11)  not_null primary_key multiple_key
    public $fechaasignacionfechainiciolineaenfasisestudiante;    // datetime(19)  not_null binary
    public $fechainiciolineaenfasisestudiante;    // datetime(19)  not_null binary
    public $fechavencimientolineaenfasisestudiante;    // datetime(19)  not_null binary

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Lineaenfasisestudiante',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
