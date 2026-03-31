<?php
/**
 * Table Definition for generodocumento
 */
require_once 'DB/DataObject.php';

class DataObjects_Generodocumento extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'generodocumento';                 // table name
    public $codigogenerodocumento;           // string(3)  not_null primary_key
    public $nombregenerodocumento;           // string(50)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Generodocumento',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
