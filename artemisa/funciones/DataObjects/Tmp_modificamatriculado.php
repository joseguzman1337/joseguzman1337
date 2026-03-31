<?php
/**
 * Table Definition for tmp_modificamatriculado
 */
require_once 'DB/DataObject.php';

class DataObjects_Tmp_modificamatriculado extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'tmp_modificamatriculado';         // table name
    var $codigo;                          // string(255)  
    var $orden;                           // string(255)  
    var $valor;                           // real(22)  
    var $indicador;                       // real(22)  

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Tmp_modificamatriculado',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
