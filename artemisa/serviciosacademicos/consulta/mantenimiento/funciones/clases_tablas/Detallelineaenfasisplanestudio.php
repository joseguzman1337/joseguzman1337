<?php
/**
 * Table Definition for detallelineaenfasisplanestudio
 */
require_once 'DB/DataObject.php';

class DataObjects_Detallelineaenfasisplanestudio extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'detallelineaenfasisplanestudio';    // table name
    public $idlineaenfasisplanestudio;       // int(11)  not_null multiple_key
    public $idplanestudio;                   // int(11)  not_null multiple_key
    public $codigomateria;                   // int(11)  not_null multiple_key
    public $codigomateriadetallelineaenfasisplanestudio;    // int(11)  not_null multiple_key
    public $codigotipomateria;               // string(3)  not_null multiple_key
    public $valormateriadetallelineaenfasisplanestudio;    // int(11)  not_null
    public $semestredetallelineaenfasisplanestudio;    // int(6)  not_null
    public $numerocreditosdetallelineaenfasisplanestudio;    // int(6)  not_null
    public $fechacreaciondetallelineaenfasisplanestudio;    // datetime(19)  not_null binary
    public $fechainiciodetallelineaenfasisplanestudio;    // datetime(19)  not_null binary
    public $fechavencimientodetallelineaenfasisplanestudio;    // datetime(19)  not_null binary
    public $codigoestadodetallelineaenfasisplanestudio;    // string(3)  not_null multiple_key

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Detallelineaenfasisplanestudio',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
