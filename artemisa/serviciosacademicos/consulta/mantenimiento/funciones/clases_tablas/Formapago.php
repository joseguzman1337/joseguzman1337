<?php
/**
 * Table Definition for formapago
 */
require_once 'DB/DataObject.php';

class DataObjects_Formapago extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'formapago';                       // table name
    public $codigoformapago;                 // string(2)  not_null primary_key
    public $nombreformapago;                 // string(30)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Formapago',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
