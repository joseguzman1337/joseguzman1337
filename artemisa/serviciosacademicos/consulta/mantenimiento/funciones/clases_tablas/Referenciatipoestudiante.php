<?php
/**
 * Table Definition for referenciatipoestudiante
 */
require_once 'DB/DataObject.php';

class DataObjects_Referenciatipoestudiante extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'referenciatipoestudiante';        // table name
    public $codigoreferenciatipoestudiante;    // string(3)  not_null primary_key
    public $nombrereferenciatipoestudiante;    // string(50)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Referenciatipoestudiante',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
