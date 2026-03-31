<?php
/**
 * Table Definition for sitiorotacionpasantiaconvenio
 */
require_once 'DB/DataObject.php';

class DataObjects_Sitiorotacionpasantiaconvenio extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'sitiorotacionpasantiaconvenio';    // table name
    var $idsitiorotacionpasantiaconvenio;    // int(11)  not_null primary_key auto_increment
    var $numerositiorotacionpasantiaconvenio;    // string(20)  not_null
    var $contactositiorotacionpasantiaconvenio;    // string(50)  not_null
    var $direccionsitiorotacionpasantiaconvenio;    // string(50)  not_null
    var $telefonositiorotacionpasantiaconvenio;    // string(20)  not_null
    var $emailsitiorotacionpasantiaconvenio;    // string(50)  not_null
    var $descripcionsitiorotacionpasantiaconvenio;    // blob(16777215)  not_null blob
    var $fechasitiorotacionpasantiaconvenio;    // date(10)  not_null binary
    var $fechainiciositiorotacionpasantiaconvenio;    // date(10)  not_null binary
    var $fechafinalsitiorotacionpasantiaconvenio;    // date(10)  not_null binary
    var $idtipositiorotacionpasantiaconvenio;    // int(11)  not_null multiple_key

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Sitiorotacionpasantiaconvenio',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
