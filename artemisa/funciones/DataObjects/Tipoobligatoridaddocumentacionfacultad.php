<?php
/**
 * Table Definition for tipoobligatoridaddocumentacionfacultad
 */
require_once 'DB/DataObject.php';

class DataObjects_Tipoobligatoridaddocumentacionfacultad extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'tipoobligatoridaddocumentacionfacultad';    // table name
    var $codigotipoobligatoridaddocumentacionfacultad;    // string(3)  not_null primary_key
    var $nombretipoobligatoridaddocumentacionfacultad;    // string(100)  not_null

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Tipoobligatoridaddocumentacionfacultad',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
