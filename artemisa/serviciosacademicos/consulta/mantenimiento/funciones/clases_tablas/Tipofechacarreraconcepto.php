<?php
/**
 * Table Definition for estadoperiodo
 */
require_once '../funciones/pear/DB/DataObject.php';

class DataObjects_Tipofechacarreraconcepto extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */


    var $__table = 'tipofechacarreraconcepto';        // table name
    var $codigotipofechacarreraconcepto;    // string(3)  not_null primary_key
    var $nombretipofechacarreraconcepto;    // string(50)  not_null
    var $codigoestado;                    // string(3)  not_null multiple_key
    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Tipofechacarreraconcepto',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
