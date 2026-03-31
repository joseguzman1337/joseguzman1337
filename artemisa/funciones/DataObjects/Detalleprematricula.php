<?php
/**
 * Table Definition for detalleprematricula
 */
require_once 'DB/DataObject.php';

class DataObjects_Detalleprematricula extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'detalleprematricula';             // table name
    var $idprematricula;                  // int(11)  not_null multiple_key
    var $codigomateria;                   // int(11)  not_null multiple_key
    var $codigomateriaelectiva;           // int(11)  multiple_key
    var $codigoestadodetalleprematricula;    // string(2)  not_null multiple_key
    var $codigotipodetalleprematricula;    // string(2)  not_null multiple_key
    var $idgrupo;                         // int(11)  not_null multiple_key
    var $numeroordenpago;                 // int(11)  not_null multiple_key

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Detalleprematricula',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
