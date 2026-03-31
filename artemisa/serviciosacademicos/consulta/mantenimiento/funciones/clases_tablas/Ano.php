<?php
/**
 * Table Definition for estadoperiodo
 */
require_once '../funciones/pear/DB/DataObject.php';

class DataObjects_Ano extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'ano';                             // table name
    var $idano;                           // int(11)  not_null primary_key auto_increment
    var $codigoano;                       // string(6)  not_null
    var $nombreano;                       // string(50)  not_null
    var $codigoestado;                    // string(3)  not_null multiple_key

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Ano',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
