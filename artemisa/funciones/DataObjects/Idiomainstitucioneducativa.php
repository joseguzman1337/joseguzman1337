<?php
/**
 * Table Definition for idiomainstitucioneducativa
 */
require_once 'DB/DataObject.php';

class DataObjects_Idiomainstitucioneducativa extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'idiomainstitucioneducativa';      // table name
    var $codigoidiomainstitucioneducativa;    // string(3)  not_null primary_key
    var $nombreidiomainstitucioneducativa;    // string(50)  not_null

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Idiomainstitucioneducativa',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
