<?php
/**
 * Table Definition for trato
 */
require_once 'DB/DataObject.php';

class DataObjects_Trato extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'trato';                           // table name
    public $idtrato;                         // int(11)  not_null primary_key auto_increment
    public $inicialestrato;                  // string(10)  not_null
    public $nombretrato;                     // string(50)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Trato',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
