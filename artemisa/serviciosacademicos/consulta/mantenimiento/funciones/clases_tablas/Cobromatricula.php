<?php
/**
 * Table Definition for cobromatricula
 */
require_once 'DB/DataObject.php';

class DataObjects_Cobromatricula extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'cobromatricula';                  // table name
    public $codigoperiodo;                   // string(8)  not_null multiple_key
    public $porcentajecreditosdesde;         // int(11)  not_null
    public $porcentajecreditoshasta;         // int(11)  not_null
    public $porcentajecobromatricula;        // int(11)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Cobromatricula',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
