<?php
/**
 * Table Definition for bienesraicescodeudor
 */
require_once 'DB/DataObject.php';

class DataObjects_Bienesraicescodeudor extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'bienesraicescodeudor';            // table name
    var $idsolicitudcredito;              // int(11)  not_null multiple_key
    var $codigotipoactivoscodeudor;       // string(2)  not_null multiple_key
    var $direccionbienesraicescodeudor;    // string(30)  not_null
    var $escriturabienesraicescodeudor;    // string(20)  not_null
    var $valorbienesraicescodeudor;       // int(11)  not_null

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Bienesraicescodeudor',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
