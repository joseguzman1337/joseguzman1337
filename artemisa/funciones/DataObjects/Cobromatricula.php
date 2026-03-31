<?php
/**
 * Table Definition for cobromatricula
 */
require_once 'DB/DataObject.php';

class DataObjects_Cobromatricula extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'cobromatricula';                  // table name
    var $codigoperiodo;                   // string(8)  not_null multiple_key
    var $porcentajecreditosdesde;         // int(11)  not_null
    var $porcentajecreditoshasta;         // int(11)  not_null
    var $porcentajecobromatricula;        // int(11)  not_null

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Cobromatricula',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
