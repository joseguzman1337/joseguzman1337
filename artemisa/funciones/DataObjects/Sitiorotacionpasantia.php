<?php
/**
 * Table Definition for sitiorotacionpasantia
 */
require_once 'DB/DataObject.php';

class DataObjects_Sitiorotacionpasantia extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'sitiorotacionpasantia';           // table name
    var $idsitiorotacionpasantia;         // int(11)  not_null primary_key auto_increment
    var $idsitiorotacionpasantiaconvenio;    // int(11)  not_null multiple_key
    var $nombresitiorotacionpasantia;     // string(100)  not_null unique_key
    var $direccionsitiorotacionpasantia;    // string(100)  not_null
    var $idpais;                          // int(11)  not_null multiple_key
    var $telefonositiorotacionpasantia;    // string(20)  not_null
    var $emailsitiorotacionpasantia;      // string(30)  not_null
    var $responsablesitiorotacionpasantia;    // string(50)  not_null

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Sitiorotacionpasantia',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
