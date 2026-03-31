<?php
/**
 * Table Definition for requierepreselecciondetalleadmision
 */
require_once 'DB/DataObject.php';

class DataObjects_Requierepreselecciondetalleadmision extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'requierepreselecciondetalleadmision';    // table name
    public $codigorequierepreselecciondetalleadmision;    // string(3)  not_null primary_key
    public $nombrerequierepreselecciondetalleadmision;    // string(50)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Requierepreselecciondetalleadmision',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
