<?php
/**
 * Table Definition for tipodetalleadmision
 */
require_once 'DB/DataObject.php';

class DataObjects_Tipodetalleadmision extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'tipodetalleadmision';             // table name
    var $codigotipodetalleadmision;       // int(11)  not_null primary_key auto_increment
    var $nombretipodetalleadmision;       // string(100)  not_null

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Tipodetalleadmision',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
