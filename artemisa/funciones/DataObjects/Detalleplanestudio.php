<?php
/**
 * Table Definition for detalleplanestudio
 */
require_once 'DB/DataObject.php';

class DataObjects_Detalleplanestudio extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'detalleplanestudio';              // table name
    var $idplanestudio;                   // int(11)  not_null multiple_key
    var $codigomateria;                   // int(11)  not_null multiple_key
    var $semestredetalleplanestudio;      // string(3)  not_null
    var $valormateriadetalleplanestudio;    // int(11)  not_null
    var $numerocreditosdetalleplanestudio;    // int(6)  not_null
    var $codigoformacionacademica;        // string(3)  not_null multiple_key
    var $codigoareaacademica;             // string(3)  not_null multiple_key
    var $fechacreaciondetalleplanestudio;    // datetime(19)  not_null binary
    var $fechainiciodetalleplanestudio;    // datetime(19)  not_null binary
    var $fechavencimientodetalleplanestudio;    // datetime(19)  not_null binary
    var $codigoestadodetalleplanestudio;    // string(3)  not_null multiple_key
    var $codigotipomateria;               // string(50)  not_null multiple_key

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Detalleplanestudio',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
