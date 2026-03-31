<?php
/**
 * Table Definition for referenciaplanestudio
 */
require_once 'DB/DataObject.php';

class DataObjects_Referenciaplanestudio extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'referenciaplanestudio';           // table name
    public $idplanestudio;                   // int(11)  not_null primary_key multiple_key
    public $idlineaenfasisplanestudio;       // int(11)  not_null primary_key multiple_key
    public $codigomateria;                   // int(11)  not_null primary_key multiple_key
    public $codigomateriareferenciaplanestudio;    // int(11)  not_null primary_key multiple_key
    public $codigotiporeferenciaplanestudio;    // string(3)  not_null multiple_key
    public $fechacreacionreferenciaplanestudio;    // datetime(19)  not_null binary
    public $fechainicioreferenciaplanestudio;    // datetime(19)  not_null binary
    public $fechavencimientoreferenciaplanestudio;    // datetime(19)  not_null binary
    public $codigoestadoreferenciaplanestudio;    // string(3)  not_null multiple_key

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Referenciaplanestudio',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
