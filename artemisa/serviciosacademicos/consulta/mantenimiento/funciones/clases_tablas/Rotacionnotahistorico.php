<?php
/**
 * Table Definition for rotacionnotahistorico
 */
require_once 'DB/DataObject.php';

class DataObjects_Rotacionnotahistorico extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'rotacionnotahistorico';           // table name
    public $idrotacionnotahistorico;         // int(11)  not_null primary_key auto_increment
    public $idnotahistorico;                 // int(11)  not_null multiple_key
    public $idlugarorigennota;               // int(11)  not_null multiple_key

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Rotacionnotahistorico',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
