<?php
/**
 * Table Definition for actividadcodeudor
 */
require_once 'DB/DataObject.php';

class DataObjects_Actividadcodeudor extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'actividadcodeudor';               // table name
    var $idsolicitudcredito;              // int(11)  not_null multiple_key
    var $codigotipoactividadcodeudor;     // string(2)  not_null multiple_key
    var $empresaactividadcodeudor;        // string(30)  
    var $tiponegocioactividadcodeudor;    // string(30)  not_null
    var $direccionactividadcodeudor;      // string(30)  not_null
    var $ciudadactividadcodeudor;         // string(20)  not_null
    var $telefono1actividadcodeudor;      // string(20)  not_null
    var $telefono2actividadcodeudor;      // string(20)  
    var $cargoactividadcodeudor;          // string(30)  
    var $ingresosactividadcodeudor;       // int(11)  not_null

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Actividadcodeudor',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
