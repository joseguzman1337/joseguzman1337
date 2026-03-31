<?php
/**
 * Table Definition for bienesraicescodeudor
 */
require_once 'DB/DataObject.php';

class DataObjects_Bienesraicescodeudor extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'bienesraicescodeudor';            // table name
    public $idsolicitudcredito;              // int(11)  not_null multiple_key
    public $codigotipoactivoscodeudor;       // string(2)  not_null multiple_key
    public $direccionbienesraicescodeudor;    // string(30)  not_null
    public $escriturabienesraicescodeudor;    // string(20)  not_null
    public $valorbienesraicescodeudor;       // int(11)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Bienesraicescodeudor',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
