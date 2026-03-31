<?php
/**
 * Table Definition for tipomateria
 */
require_once '../funciones/pear/DB/DataObject.php';

class DataObjects_Tipomateria extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'tipomateria';                     // table name
    var $codigotipomateria;               // string(2)  not_null primary_key
    var $nombretipomateria;               // string(50)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Tipomateria',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
