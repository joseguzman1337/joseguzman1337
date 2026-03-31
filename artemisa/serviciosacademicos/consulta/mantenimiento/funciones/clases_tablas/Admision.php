<?php
/**
 * Table Definition for admision
 */
require_once 'DB/DataObject.php';

class DataObjects_Admision extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'admision';                        // table name
    public $idadmision;                      // int(11)  not_null primary_key auto_increment
    public $nombreadmision;                  // string(100)  not_null
    public $codigoperiodo;                   // string(8)  not_null multiple_key
    public $codigocarrera;                   // int(11)  not_null multiple_key
    public $codigoestado;                    // string(3)  not_null multiple_key
    public $cantidadseleccionadoadmision;    // int(6)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Admision',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
