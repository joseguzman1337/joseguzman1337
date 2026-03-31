<?php
/**
 * Table Definition for actividadcodeudor
 */
require_once 'DB/DataObject.php';

class DataObjects_Actividadcodeudor extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'actividadcodeudor';               // table name
    public $idsolicitudcredito;              // int(11)  not_null multiple_key
    public $codigotipoactividadcodeudor;     // string(2)  not_null multiple_key
    public $empresaactividadcodeudor;        // string(30)  
    public $tiponegocioactividadcodeudor;    // string(30)  not_null
    public $direccionactividadcodeudor;      // string(30)  not_null
    public $ciudadactividadcodeudor;         // string(20)  not_null
    public $telefono1actividadcodeudor;      // string(20)  not_null
    public $telefono2actividadcodeudor;      // string(20)  
    public $cargoactividadcodeudor;          // string(30)  
    public $ingresosactividadcodeudor;       // int(11)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Actividadcodeudor',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
