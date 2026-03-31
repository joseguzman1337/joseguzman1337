<?php
/**
 * Table Definition for ordenpagodevolucion
 */
require_once 'DB/DataObject.php';

class DataObjects_Ordenpagodevolucion extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'ordenpagodevolucion';             // table name
    public $idordenpagodevolucion;           // int(11)  not_null primary_key auto_increment
    public $fechaordenpagodevolucion;        // date(10)  not_null binary
    public $numeroordenpago;                 // int(11)  not_null multiple_key
    public $numerodocumentosap;              // string(30)  not_null
    public $fechadevolucionsap;              // date(10)  not_null binary
    public $valordevolucionsap;              // unknown(15)  not_null
    public $codigoconcepto;                  // string(3)  not_null multiple_key
    public $codigoestado;                    // string(3)  not_null multiple_key

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Ordenpagodevolucion',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
