<?php
/**
 * Table Definition for detalleplanestudio
 */
require_once 'DB/DataObject.php';

class DataObjects_Detalleplanestudio extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'detalleplanestudio';              // table name
    public $idplanestudio;                   // int(11)  not_null multiple_key
    public $codigomateria;                   // int(11)  not_null multiple_key
    public $semestredetalleplanestudio;      // string(3)  not_null
    public $valormateriadetalleplanestudio;    // int(11)  not_null
    public $numerocreditosdetalleplanestudio;    // int(6)  not_null
    public $codigoformacionacademica;        // string(3)  not_null multiple_key
    public $codigoareaacademica;             // string(3)  not_null multiple_key
    public $fechacreaciondetalleplanestudio;    // datetime(19)  not_null binary
    public $fechainiciodetalleplanestudio;    // datetime(19)  not_null binary
    public $fechavencimientodetalleplanestudio;    // datetime(19)  not_null binary
    public $codigoestadodetalleplanestudio;    // string(3)  not_null multiple_key
    public $codigotipomateria;               // string(50)  not_null multiple_key

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Detalleplanestudio',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
