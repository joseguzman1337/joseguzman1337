<?php
/**
 * Table Definition for indicadorhorario
 */
require_once 'DB/DataObject.php';

class DataObjects_Indicadorhorario extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'indicadorhorario';                // table name
    public $codigoindicadorhorario;          // string(3)  not_null primary_key
    public $nombreindicadorhorario;          // string(50)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Indicadorhorario',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
