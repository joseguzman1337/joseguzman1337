<?php
/**
 * Table Definition for indicarcredito
 */
require_once 'DB/DataObject.php';

class DataObjects_Indicarcredito extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'indicarcredito';                  // table name
    public $codigoindicarcredito;            // string(3)  not_null primary_key
    public $nombreindicarcredito;            // string(50)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Indicarcredito',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
