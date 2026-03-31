<?php
/**
 * Table Definition for calendarioestudiante
 */
require_once 'DB/DataObject.php';

class DataObjects_Calendarioestudiante extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'calendarioestudiante';            // table name
    public $codigocalendarioestudiante;      // string(3)  not_null primary_key
    public $nombrecalendarioestudiante;      // string(50)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Calendarioestudiante',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
