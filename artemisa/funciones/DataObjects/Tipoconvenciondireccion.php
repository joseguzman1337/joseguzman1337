<?php
/**
 * Table Definition for tipoconvenciondireccion
 */
require_once 'DB/DataObject.php';

class DataObjects_Tipoconvenciondireccion extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'tipoconvenciondireccion';         // table name
    var $codigotipoconvenciondireccion;    // string(3)  not_null primary_key
    var $nombretipoconvenciondireccion;    // string(50)  not_null

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Tipoconvenciondireccion',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
