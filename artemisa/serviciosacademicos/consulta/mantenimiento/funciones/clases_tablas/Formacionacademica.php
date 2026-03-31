<?php
/**
 * Table Definition for formacionacademica
 */
require_once 'DB/DataObject.php';

class DataObjects_Formacionacademica extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'formacionacademica';              // table name
    public $codigoformacionacademica;        // string(3)  not_null primary_key
    public $nombreformacionacademica;        // string(50)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Formacionacademica',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
