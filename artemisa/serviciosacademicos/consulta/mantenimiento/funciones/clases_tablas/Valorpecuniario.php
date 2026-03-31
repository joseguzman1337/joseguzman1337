<?php
/**
 * Table Definition for valorpecuniario
 */
require_once '../funciones/pear/DB/DataObject.php';

class DataObjects_Valorpecuniario extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'valorpecuniario';                 // table name
    var $idvalorpecuniario;               // int(11)  not_null primary_key auto_increment
    var $codigoperiodo;                   // string(8)  not_null multiple_key
    var $codigoconcepto;                  // string(8)  not_null multiple_key
    var $valorpecuniario;                 // int(11)  not_null
    var $codigoindicadorprocesointernet;    // string(3)  not_null multiple_key
    var $codigoestado;                    // string(3)  not_null multiple_key

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Valorpecuniario',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
