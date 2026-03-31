<?php
/**
 * Table Definition for indicadoretiquetamateria
 */
require_once 'DB/DataObject.php';

class DataObjects_Indicadoretiquetamateria extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'indicadoretiquetamateria';        // table name
    public $codigoindicadoretiquetamateria;    // string(3)  not_null primary_key
    public $nombreindicadoretiquetamateria;    // string(50)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Indicadoretiquetamateria',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
