<?php
/**
 * Table Definition for documentocredito
 */
require_once 'DB/DataObject.php';

class DataObjects_Documentocredito extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'documentocredito';                // table name
    public $codigodocumentocredito;          // string(2)  not_null primary_key
    public $nombredocumentocredito;          // string(30)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Documentocredito',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
