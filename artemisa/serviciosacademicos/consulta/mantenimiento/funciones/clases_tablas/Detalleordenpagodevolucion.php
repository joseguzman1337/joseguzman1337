<?php
/**
 * Table Definition for detalleordenpagodevolucion
 */
require_once 'DB/DataObject.php';

class DataObjects_Detalleordenpagodevolucion extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'detalleordenpagodevolucion';      // table name
    public $iddetalleordenpagodevolucion;    // int(11)  not_null primary_key auto_increment
    public $idordenpagodevolucion;           // int(11)  not_null
    public $codigoconcepto;                  // string(8)  not_null
    public $idporcentajedevolucion;          // int(6)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Detalleordenpagodevolucion',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
