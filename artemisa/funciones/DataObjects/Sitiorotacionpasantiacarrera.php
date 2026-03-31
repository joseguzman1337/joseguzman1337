<?php
/**
 * Table Definition for sitiorotacionpasantiacarrera
 */
require_once 'DB/DataObject.php';

class DataObjects_Sitiorotacionpasantiacarrera extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'sitiorotacionpasantiacarrera';    // table name
    var $idsitiorotacionpasantiacarrera;    // int(11)  not_null primary_key auto_increment
    var $idsitiorotacionpasantiaconvenio;    // int(11)  not_null multiple_key
    var $idsitiorotacionpasantia;         // int(11)  not_null multiple_key
    var $codigocarrera;                   // int(11)  not_null multiple_key

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Sitiorotacionpasantiacarrera',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
