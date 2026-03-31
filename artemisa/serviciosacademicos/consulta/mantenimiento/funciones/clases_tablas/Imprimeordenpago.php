<?php
/**
 * Table Definition for imprimeordenpago
 */
require_once 'DB/DataObject.php';

class DataObjects_Imprimeordenpago extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'imprimeordenpago';                // table name
    public $codigoimprimeordenpago;          // string(2)  not_null primary_key
    public $nombreimprimeordenpago;          // string(15)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Imprimeordenpago',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
