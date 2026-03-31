<?php
/**
 * Table Definition for cargaacademica
 */
require_once 'DB/DataObject.php';

class DataObjects_Cargaacademica extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'cargaacademica';                  // table name
    public $idcargaacademica;                // int(11)  not_null primary_key auto_increment
    public $codigoestudiante;                // int(11)  not_null multiple_key
    public $codigomateria;                   // int(11)  not_null multiple_key
    public $codigoperiodo;                   // string(8)  not_null multiple_key
    public $idplanestudio;                   // int(11)  not_null multiple_key
    public $usuario;                         // string(50)  not_null multiple_key
    public $fechacargaacademica;             // datetime(19)  not_null binary
    public $codigoestadocargaacademica;      // string(3)  not_null multiple_key

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Cargaacademica',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
