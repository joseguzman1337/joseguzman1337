<?php
/**
 * Table Definition for logdetalleprematricula
 */
require_once 'DB/DataObject.php';

class DataObjects_Logdetalleprematricula extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'logdetalleprematricula';          // table name
    public $idprematricula;                  // int(11)  not_null multiple_key
    public $codigomateria;                   // int(11)  not_null multiple_key
    public $codigomateriaelectiva;           // int(11)  multiple_key
    public $codigoestadodetalleprematricula;    // string(2)  not_null multiple_key
    public $codigotipodetalleprematricula;    // string(2)  not_null multiple_key
    public $idgrupo;                         // string(10)  not_null multiple_key
    public $numeroordenpago;                 // int(11)  not_null multiple_key
    public $fechalogfechadetalleprematricula;    // datetime(19)  not_null binary
    public $usuario;                         // string(50)  not_null multiple_key
    public $ip;                              // string(50)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Logdetalleprematricula',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
