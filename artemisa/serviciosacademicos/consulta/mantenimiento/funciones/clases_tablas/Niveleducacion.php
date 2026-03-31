<?php
/**
 * Table Definition for niveleducacion
 */
require_once 'DB/DataObject.php';

class DataObjects_Niveleducacion extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'niveleducacion';                  // table name
    public $idniveleducacion;                // int(11)  not_null primary_key auto_increment
    public $nombreniveleducacion;            // string(50)  not_null
    public $codigomodalidadacademica;        // string(3)  not_null multiple_key

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Niveleducacion',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
