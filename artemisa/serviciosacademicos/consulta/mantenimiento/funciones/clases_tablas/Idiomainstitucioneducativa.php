<?php
/**
 * Table Definition for idiomainstitucioneducativa
 */
require_once 'DB/DataObject.php';

class DataObjects_Idiomainstitucioneducativa extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'idiomainstitucioneducativa';      // table name
    public $codigoidiomainstitucioneducativa;    // string(3)  not_null primary_key
    public $nombreidiomainstitucioneducativa;    // string(50)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Idiomainstitucioneducativa',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
