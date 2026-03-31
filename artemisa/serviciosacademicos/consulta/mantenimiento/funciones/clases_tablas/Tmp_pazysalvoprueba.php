<?php
/**
 * Table Definition for tmp_pazysalvoprueba
 */
require_once 'DB/DataObject.php';

class DataObjects_Tmp_pazysalvoprueba extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'tmp_pazysalvoprueba';             // table name
    public $codigo;                          // string(255)  
    public $descripcion;                     // string(255)  
    public $tipo;                            // real(22)  

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Tmp_pazysalvoprueba',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
