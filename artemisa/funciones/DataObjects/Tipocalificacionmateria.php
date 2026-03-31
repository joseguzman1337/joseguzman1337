<?php
/**
 * Table Definition for tipocalificacionmateria
 */
require_once 'DB/DataObject.php';

class DataObjects_Tipocalificacionmateria extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'tipocalificacionmateria';         // table name
    var $codigotipocalificacionmateria;    // string(3)  not_null primary_key
    var $nombretipocalificacionmateria;    // string(100)  not_null

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Tipocalificacionmateria',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
