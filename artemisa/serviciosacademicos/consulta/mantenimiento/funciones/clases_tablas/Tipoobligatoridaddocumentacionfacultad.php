<?php
/**
 * Table Definition for tipoobligatoridaddocumentacionfacultad
 */
require_once 'DB/DataObject.php';

class DataObjects_Tipoobligatoridaddocumentacionfacultad extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'tipoobligatoridaddocumentacionfacultad';    // table name
    public $codigotipoobligatoridaddocumentacionfacultad;    // string(3)  not_null primary_key
    public $nombretipoobligatoridaddocumentacionfacultad;    // string(100)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Tipoobligatoridaddocumentacionfacultad',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
