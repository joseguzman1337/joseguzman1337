<?php
/**
 * Table Definition for tmp_pazysalvo
 */
require_once 'DB/DataObject.php';

class DataObjects_Tmp_pazysalvo extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'tmp_pazysalvo';                   // table name
    public $codigo;                          // string(255)  
    public $descripcion;                     // string(255)  
    public $tipo;                            // real(22)  

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Tmp_pazysalvo',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
