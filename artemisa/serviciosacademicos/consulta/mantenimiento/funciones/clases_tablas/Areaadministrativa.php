<?php
/**
 * Table Definition for areaadministrativa
 */
require_once 'DB/DataObject.php';

class DataObjects_Areaadministrativa extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'areaadministrativa';              // table name
    public $codigoareaadministrativa;        // string(15)  not_null primary_key
    public $nombreareaadministrativa;        // string(50)  not_null
    public $encargadoareaadministrativa;     // string(50)  not_null
    public $fechainicioareaadministrativa;    // datetime(19)  not_null binary
    public $fechavencimientoareaadministrativa;    // datetime(19)  not_null binary
    public $centrocosto;                     // string(15)  not_null
    public $codigosucursal;                  // string(2)  not_null multiple_key

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Areaadministrativa',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
