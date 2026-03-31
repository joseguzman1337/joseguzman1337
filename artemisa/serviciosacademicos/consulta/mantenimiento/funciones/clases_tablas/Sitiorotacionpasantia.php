<?php
/**
 * Table Definition for sitiorotacionpasantia
 */
require_once 'DB/DataObject.php';

class DataObjects_Sitiorotacionpasantia extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'sitiorotacionpasantia';           // table name
    public $idsitiorotacionpasantia;         // int(11)  not_null primary_key auto_increment
    public $idsitiorotacionpasantiaconvenio;    // int(11)  not_null multiple_key
    public $nombresitiorotacionpasantia;     // string(100)  not_null unique_key
    public $direccionsitiorotacionpasantia;    // string(100)  not_null
    public $idpais;                          // int(11)  not_null multiple_key
    public $telefonositiorotacionpasantia;    // string(20)  not_null
    public $emailsitiorotacionpasantia;      // string(30)  not_null
    public $responsablesitiorotacionpasantia;    // string(50)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Sitiorotacionpasantia',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
