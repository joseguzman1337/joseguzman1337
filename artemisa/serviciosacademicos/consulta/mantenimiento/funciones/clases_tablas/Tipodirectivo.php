<?php
/**
 * Table Definition for tipodirectivo
 */
require_once '../funciones/pear/DB/DataObject.php';

class DataObjects_Tipodirectivo extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'tipodirectivo';                   // table name
    var $codigotipodirectivo;             // string(3)  not_null primary_key
    var $nombretipodirectivo;             // string(50)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Tipodirectivo',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
