<?php
/**
 * Table Definition for referenciaplanestudio
 */
require_once 'DB/DataObject.php';

class DataObjects_Referenciaplanestudio extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'referenciaplanestudio';           // table name
    var $idplanestudio;                   // int(11)  not_null primary_key multiple_key
    var $idlineaenfasisplanestudio;       // int(11)  not_null primary_key multiple_key
    var $codigomateria;                   // int(11)  not_null primary_key multiple_key
    var $codigomateriareferenciaplanestudio;    // int(11)  not_null primary_key multiple_key
    var $codigotiporeferenciaplanestudio;    // string(3)  not_null multiple_key
    var $fechacreacionreferenciaplanestudio;    // datetime(19)  not_null binary
    var $fechainicioreferenciaplanestudio;    // datetime(19)  not_null binary
    var $fechavencimientoreferenciaplanestudio;    // datetime(19)  not_null binary
    var $codigoestadoreferenciaplanestudio;    // string(3)  not_null multiple_key

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Referenciaplanestudio',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
