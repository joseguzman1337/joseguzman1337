<?php
/**
 * Table Definition for grupomateria
 */
require_once '../funciones/pear/DB/DataObject.php';

class DataObjects_Grupomateria extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'grupomateria';                    // table name
    var $idgrupomateria;                  // int(11)  not_null primary_key auto_increment
    var $nombregrupomateria;              // string(30)  not_null
    var $codigoperiodo;                   // string(8)  not_null multiple_key
    var $codigotipogrupomateria;          // string(3)  not_null multiple_key

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Grupomateria',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
