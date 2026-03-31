<?php
/**
 * Table Definition for autorizacionreferenciaconcepto
 */
require_once 'DB/DataObject.php';

class DataObjects_Autorizacionreferenciaconcepto extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'autorizacionreferenciaconcepto';    // table name
    public $codigoautorizacionreferenciaconcepto;    // string(3)  not_null primary_key
    public $nombreautorizacionreferenciaconcepto;    // string(50)  not_null
    public $codigoestado;                    // string(3)  not_null multiple_key

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Autorizacionreferenciaconcepto',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
