<?php
/**
 * Table Definition for lugarorigennotacarrera
 */
require_once 'DB/DataObject.php';

class DataObjects_Lugarorigennotacarrera extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'lugarorigennotacarrera';          // table name
    public $idlugarorigennotacarrera;        // int(11)  not_null primary_key auto_increment
    public $idlugarorigenotaconvenio;        // int(11)  not_null multiple_key
    public $idlugarorigennota;               // int(11)  not_null multiple_key
    public $codigocarrera;                   // int(11)  not_null multiple_key

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Lugarorigennotacarrera',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
