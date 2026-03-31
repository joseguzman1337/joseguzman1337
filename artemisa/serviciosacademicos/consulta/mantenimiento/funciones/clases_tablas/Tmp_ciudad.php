<?php
/**
 * Table Definition for tmp_ciudad
 */
require_once 'DB/DataObject.php';

class DataObjects_Tmp_ciudad extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'tmp_ciudad';                      // table name
    public $codigociudad;                    // string(255)  
    public $nombreciudad;                    // string(255)  
    public $departamento;                    // string(255)  

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Tmp_ciudad',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
