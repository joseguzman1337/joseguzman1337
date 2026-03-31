<?php
/**
 * Table Definition for tmp_modificamatriculado
 */
require_once 'DB/DataObject.php';

class DataObjects_Tmp_modificamatriculado extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'tmp_modificamatriculado';         // table name
    public $codigo;                          // string(255)  
    public $orden;                           // string(255)  
    public $valor;                           // real(22)  
    public $indicador;                       // real(22)  

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Tmp_modificamatriculado',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
