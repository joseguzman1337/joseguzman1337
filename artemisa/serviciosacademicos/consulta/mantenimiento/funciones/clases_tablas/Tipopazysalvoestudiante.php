<?php
/**
 * Table Definition for tipopazysalvoestudiante
 */
require_once 'DB/DataObject.php';

class DataObjects_Tipopazysalvoestudiante extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'tipopazysalvoestudiante';         // table name
    public $codigotipopazysalvoestudiante;    // string(3)  not_null primary_key
    public $nombretipopazysalvoestudiante;    // string(50)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Tipopazysalvoestudiante',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
