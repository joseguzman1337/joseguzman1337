<?php
/**
 * Table Definition for tmp_ciudad
 */
require_once 'DB/DataObject.php';

class DataObjects_Tmp_ciudad extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'tmp_ciudad';                      // table name
    var $codigociudad;                    // string(255)  
    var $nombreciudad;                    // string(255)  
    var $departamento;                    // string(255)  

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Tmp_ciudad',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
