<?php
/**
 * Table Definition for cambiovalorconcepto
 */
require_once '../funciones/pear/DB/DataObject.php';

class DataObjects_Cambiovalorconcepto extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'cambiovalorconcepto';             // table name
    var $codigocambiovalorconcepto;       // string(3)  not_null primary_key
    var $nombrecambiovalorconcepto;       // string(50)  not_null
    var $codigoestado;                    // string(3)  not_null multiple_key

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Cambiovalorconcepto',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
