<?php
/**
 * Table Definition for cargaacademica
 */
require_once 'DB/DataObject.php';

class DataObjects_Cargaacademica extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'cargaacademica';                  // table name
    var $idcargaacademica;                // int(11)  not_null primary_key auto_increment
    var $codigoestudiante;                // int(11)  not_null multiple_key
    var $codigomateria;                   // int(11)  not_null multiple_key
    var $codigoperiodo;                   // string(8)  not_null multiple_key
    var $idplanestudio;                   // int(11)  not_null multiple_key
    var $usuario;                         // string(50)  not_null multiple_key
    var $fechacargaacademica;             // datetime(19)  not_null binary
    var $codigoestadocargaacademica;      // string(3)  not_null multiple_key

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Cargaacademica',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
