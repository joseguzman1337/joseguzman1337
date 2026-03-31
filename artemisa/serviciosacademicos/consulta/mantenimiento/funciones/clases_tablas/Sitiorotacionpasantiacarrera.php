<?php
/**
 * Table Definition for sitiorotacionpasantiacarrera
 */
require_once 'DB/DataObject.php';

class DataObjects_Sitiorotacionpasantiacarrera extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'sitiorotacionpasantiacarrera';    // table name
    public $idsitiorotacionpasantiacarrera;    // int(11)  not_null primary_key auto_increment
    public $idsitiorotacionpasantiaconvenio;    // int(11)  not_null multiple_key
    public $idsitiorotacionpasantia;         // int(11)  not_null multiple_key
    public $codigocarrera;                   // int(11)  not_null multiple_key

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Sitiorotacionpasantiacarrera',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
