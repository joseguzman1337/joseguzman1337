<?php
/**
 * Table Definition for estudianteestudio
 */
require_once 'DB/DataObject.php';

class DataObjects_Estudianteestudio extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'estudianteestudio';               // table name
    var $idestudianteestudio;             // int(11)  not_null primary_key auto_increment
    var $idestudiantegeneral;             // int(11)  not_null multiple_key
    var $idinscripcion;                   // int(11)  not_null multiple_key
    var $idniveleducacion;                // int(11)  not_null multiple_key
    var $anogradoestudianteestudio;       // int(6)  not_null
    var $idinstitucioneducativa;          // int(11)  not_null multiple_key
    var $codigotitulo;                    // int(11)  not_null multiple_key
    var $observacionestudianteestudio;    // string(100)  not_null
    var $codigoestado;                    // string(3)  not_null multiple_key

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Estudianteestudio',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
