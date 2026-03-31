<?php
/**
 * Table Definition for tmp_admitidos
 */
require_once 'DB/DataObject.php';

class DataObjects_Tmp_admitidos extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'tmp_admitidos';                   // table name
    public $idestudiantegeneral;             // string(5)  
    public $codigocarrera;                   // string(50)  

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Tmp_admitidos',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
