<?php
/**
 * Table Definition for referenciacobromatriculacarrera
 */
require_once 'DB/DataObject.php';

class DataObjects_Referenciacobromatriculacarrera extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'referenciacobromatriculacarrera';    // table name
    public $codigoreferenciacobromatriculacarrera;    // string(3)  not_null primary_key
    public $nombrereferenciacobromatriculacarrera;    // string(50)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Referenciacobromatriculacarrera',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
