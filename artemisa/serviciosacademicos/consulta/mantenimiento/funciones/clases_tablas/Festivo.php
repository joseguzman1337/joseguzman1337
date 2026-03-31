<?php
/**
 * Table Definition for festivo
 */
require_once 'DB/DataObject.php';

class DataObjects_Festivo extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'festivo';                         // table name
    public $idfestivo;                       // int(11)  not_null primary_key auto_increment
    public $nombrefestivo;                   // string(50)  not_null
    public $diafestivo;                      // date(10)  not_null binary

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Festivo',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
