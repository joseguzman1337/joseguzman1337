<?php
/**
 * Table Definition for estudianteestudio
 */
require_once 'DB/DataObject.php';

class DataObjects_Estudianteestudio extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'estudianteestudio';               // table name
    public $idestudianteestudio;             // int(11)  not_null primary_key auto_increment
    public $idestudiantegeneral;             // int(11)  not_null multiple_key
    public $idinscripcion;                   // int(11)  not_null multiple_key
    public $idniveleducacion;                // int(11)  not_null multiple_key
    public $anogradoestudianteestudio;       // int(6)  not_null
    public $idinstitucioneducativa;          // int(11)  not_null multiple_key
    public $codigotitulo;                    // int(11)  not_null multiple_key
    public $observacionestudianteestudio;    // string(100)  not_null
    public $codigoestado;                    // string(3)  not_null multiple_key

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Estudianteestudio',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
