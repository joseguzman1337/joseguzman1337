<?php
/**
 * Table Definition for tipodetalleseguimiento
 */
require_once 'DB/DataObject.php';

class DataObjects_Tipodetalleseguimiento extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'tipodetalleseguimiento';          // table name
    public $codigotipodetalleseguimiento;    // string(3)  not_null primary_key
    public $nombretipodetalleseguimiento;    // string(50)  not_null
    public $codigoestado;                    // string(3)  not_null multiple_key

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Tipodetalleseguimiento',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
