<?php
/**
 * Table Definition for documentacion
 */
require_once 'DB/DataObject.php';

class DataObjects_Documentacion extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'documentacion';                   // table name
    public $iddocumentacion;                 // int(11)  not_null primary_key auto_increment
    public $nombredocumentacion;             // string(100)  not_null unique_key

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Documentacion',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
