<?php
/**
 * Table Definition for fechaactualizacion
 */
require_once 'DB/DataObject.php';

class DataObjects_Fechaactualizacion extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'fechaactualizacion';              // table name
    var $idfechaactualizacion;            // int(11)  not_null primary_key auto_increment
    var $fechaactualizacion;              // datetime(19)  not_null binary
    var $codigoaplicacion;                // string(2)  

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Fechaactualizacion',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
