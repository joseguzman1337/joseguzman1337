<?php
/**
 * Table Definition for documento
 */
require_once 'DB/DataObject.php';

class DataObjects_Documento extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'documento';                       // table name
    public $tipodocumento;                   // string(2)  not_null primary_key
    public $nombredocumento;                 // string(25)  not_null
    public $nombrecortodocumento;            // string(2)  not_null
    public $tipodocumentosap;                // string(10)  not_null unique_key

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Documento',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
