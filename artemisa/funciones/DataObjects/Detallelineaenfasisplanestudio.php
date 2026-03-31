<?php
/**
 * Table Definition for detallelineaenfasisplanestudio
 */
require_once 'DB/DataObject.php';

class DataObjects_Detallelineaenfasisplanestudio extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'detallelineaenfasisplanestudio';    // table name
    var $idlineaenfasisplanestudio;       // int(11)  not_null multiple_key
    var $idplanestudio;                   // int(11)  not_null multiple_key
    var $codigomateria;                   // int(11)  not_null multiple_key
    var $codigomateriadetallelineaenfasisplanestudio;    // int(11)  not_null multiple_key
    var $codigotipomateria;               // string(3)  not_null multiple_key
    var $valormateriadetallelineaenfasisplanestudio;    // int(11)  not_null
    var $semestredetallelineaenfasisplanestudio;    // int(6)  not_null
    var $numerocreditosdetallelineaenfasisplanestudio;    // int(6)  not_null
    var $fechacreaciondetallelineaenfasisplanestudio;    // datetime(19)  not_null binary
    var $fechainiciodetallelineaenfasisplanestudio;    // datetime(19)  not_null binary
    var $fechavencimientodetallelineaenfasisplanestudio;    // datetime(19)  not_null binary
    var $codigoestadodetallelineaenfasisplanestudio;    // string(3)  not_null multiple_key

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Detallelineaenfasisplanestudio',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
