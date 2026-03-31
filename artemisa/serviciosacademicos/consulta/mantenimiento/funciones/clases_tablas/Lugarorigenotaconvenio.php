<?php
/**
 * Table Definition for lugarorigenotaconvenio
 */
require_once 'DB/DataObject.php';

class DataObjects_Lugarorigenotaconvenio extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'lugarorigenotaconvenio';          // table name
    public $idlugarorigenotaconvenio;        // int(11)  not_null primary_key auto_increment
    public $idlugarorigennota;               // int(11)  not_null multiple_key
    public $numerolugarorigenotaconvenio;    // string(20)  not_null
    public $contactolugarorigenotaconvenio;    // string(50)  not_null
    public $descripcionlugarorigenotaconvenio;    // blob(16777215)  not_null blob
    public $fechalugarorigenotaconvenio;     // date(10)  not_null binary
    public $fechainiciolugarorigenotaconvenio;    // date(10)  not_null binary
    public $fechafinallugarorigenotaconvenio;    // date(10)  not_null binary

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Lugarorigenotaconvenio',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
