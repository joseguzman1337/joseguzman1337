<?php
/**
 * Table Definition for tipoconvenciondireccion
 */
require_once 'DB/DataObject.php';

class DataObjects_Tipoconvenciondireccion extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'tipoconvenciondireccion';         // table name
    public $codigotipoconvenciondireccion;    // string(3)  not_null primary_key
    public $nombretipoconvenciondireccion;    // string(50)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Tipoconvenciondireccion',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
