<?php
/**
 * Table Definition for tipodocumentacionfacultad
 */
require_once 'DB/DataObject.php';

class DataObjects_Tipodocumentacionfacultad extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'tipodocumentacionfacultad';       // table name
    public $codigotipodocumentacionfacultad;    // string(3)  not_null primary_key
    public $nombretipodocumentacionfacultad;    // string(50)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Tipodocumentacionfacultad',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
