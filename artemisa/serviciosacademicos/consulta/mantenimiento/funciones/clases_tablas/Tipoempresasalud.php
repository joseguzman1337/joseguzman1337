<?php
/**
 * Table Definition for tipoempresasalud
 */
require_once 'DB/DataObject.php';

class DataObjects_Tipoempresasalud extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'tipoempresasalud';                // table name
    public $codigotipoempresasalud;          // string(3)  not_null primary_key
    public $nombretipoempresasalud;          // string(50)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Tipoempresasalud',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
