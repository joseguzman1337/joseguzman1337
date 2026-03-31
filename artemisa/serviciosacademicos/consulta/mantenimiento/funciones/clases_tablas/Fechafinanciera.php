<?php
/**
 * Table Definition for fechafinanciera
 */
require_once '../funciones/pear/DB/DataObject.php';

class DataObjects_Fechafinanciera extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

   	var $__table = 'fechafinanciera';                 // table name
    var $idfechafinanciera;               // int(11)  not_null primary_key auto_increment
    var $codigocarrera;                   // int(11)  not_null multiple_key
    var $codigoperiodo;                   // string(8)  not_null multiple_key
    var $idsubperiodo;                    // int(11)  not_null multiple_key
    var $codigoestado;                    // string(3)  not_null multiple_key
    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Fechafinanciera',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
