<?php
/**
 * Table Definition for vehiculocodeudor
 */
require_once 'DB/DataObject.php';

class DataObjects_Vehiculocodeudor extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'vehiculocodeudor';                // table name
    public $idsolicitudcredito;              // int(11)  not_null multiple_key
    public $marcavehiculocodeudor;           // string(20)  not_null
    public $modelovehiculocodeudor;          // string(4)  not_null
    public $placavehiculocodeudor;           // string(8)  not_null
    public $valorvehiculocodeudor;           // int(11)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Vehiculocodeudor',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
