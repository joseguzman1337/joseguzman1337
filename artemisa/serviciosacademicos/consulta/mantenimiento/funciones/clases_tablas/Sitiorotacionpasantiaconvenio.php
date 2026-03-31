<?php
/**
 * Table Definition for sitiorotacionpasantiaconvenio
 */
require_once 'DB/DataObject.php';

class DataObjects_Sitiorotacionpasantiaconvenio extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'sitiorotacionpasantiaconvenio';    // table name
    public $idsitiorotacionpasantiaconvenio;    // int(11)  not_null primary_key auto_increment
    public $numerositiorotacionpasantiaconvenio;    // string(20)  not_null
    public $contactositiorotacionpasantiaconvenio;    // string(50)  not_null
    public $direccionsitiorotacionpasantiaconvenio;    // string(50)  not_null
    public $telefonositiorotacionpasantiaconvenio;    // string(20)  not_null
    public $emailsitiorotacionpasantiaconvenio;    // string(50)  not_null
    public $descripcionsitiorotacionpasantiaconvenio;    // blob(16777215)  not_null blob
    public $fechasitiorotacionpasantiaconvenio;    // date(10)  not_null binary
    public $fechainiciositiorotacionpasantiaconvenio;    // date(10)  not_null binary
    public $fechafinalsitiorotacionpasantiaconvenio;    // date(10)  not_null binary
    public $idtipositiorotacionpasantiaconvenio;    // int(11)  not_null multiple_key

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Sitiorotacionpasantiaconvenio',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
