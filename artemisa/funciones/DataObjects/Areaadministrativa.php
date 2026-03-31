<?php
/**
 * Table Definition for areaadministrativa
 */
require_once 'DB/DataObject.php';

class DataObjects_Areaadministrativa extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'areaadministrativa';              // table name
    var $codigoareaadministrativa;        // string(15)  not_null primary_key
    var $nombreareaadministrativa;        // string(50)  not_null
    var $encargadoareaadministrativa;     // string(50)  not_null
    var $fechainicioareaadministrativa;    // datetime(19)  not_null binary
    var $fechavencimientoareaadministrativa;    // datetime(19)  not_null binary
    var $centrocosto;                     // string(15)  not_null
    var $codigosucursal;                  // string(2)  not_null multiple_key

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Areaadministrativa',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
