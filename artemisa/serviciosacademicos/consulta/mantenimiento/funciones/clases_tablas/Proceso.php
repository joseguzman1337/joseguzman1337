<?php
/**
 * Table Definition for proceso
 */
require_once 'DB/DataObject.php';

class DataObjects_Proceso extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'proceso';                         // table name
    public $idproceso;                       // int(11)  not_null primary_key auto_increment
    public $nombrecortoproceso;              // string(15)  not_null
    public $nombreproceso;                   // string(50)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Proceso',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
