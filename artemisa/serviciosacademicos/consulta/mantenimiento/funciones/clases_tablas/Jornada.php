<?php
/**
 * Table Definition for jornada
 */
require_once '../funciones/pear/DB/DataObject.php';

class DataObjects_Jornada extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'jornada';                         // table name
    var $codigojornada;                   // string(2)  not_null primary_key
    var $nombrejornada;                   // string(25)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Jornada',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
