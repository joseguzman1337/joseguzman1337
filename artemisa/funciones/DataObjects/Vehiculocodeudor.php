<?php
/**
 * Table Definition for vehiculocodeudor
 */
require_once 'DB/DataObject.php';

class DataObjects_Vehiculocodeudor extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'vehiculocodeudor';                // table name
    var $idsolicitudcredito;              // int(11)  not_null multiple_key
    var $marcavehiculocodeudor;           // string(20)  not_null
    var $modelovehiculocodeudor;          // string(4)  not_null
    var $placavehiculocodeudor;           // string(8)  not_null
    var $valorvehiculocodeudor;           // int(11)  not_null

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Vehiculocodeudor',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
