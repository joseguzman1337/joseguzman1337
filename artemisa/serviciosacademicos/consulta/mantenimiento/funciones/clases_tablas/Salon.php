<?php
/**
 * Table Definition for salon
 */
require_once 'DB/DataObject.php';

class DataObjects_Salon extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'salon';                           // table name
    public $codigosalon;                     // string(4)  not_null primary_key
    public $nombresalon;                     // string(30)  not_null
    public $cupomaximosalon;                 // int(6)  not_null
    public $codigotiposalon;                 // string(2)  not_null multiple_key
    public $codigosede;                      // string(2)  not_null multiple_key

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Salon',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
