<?php
/**
 * Table Definition for evaluacioncarrera
 */
require_once 'DB/DataObject.php';

class DataObjects_Evaluacioncarrera extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'evaluacioncarrera';               // table name
    public $carrera;                         // string(100)  

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Evaluacioncarrera',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
