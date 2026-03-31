<?php
/**
 * Table Definition for situacioncarreraestudiante
 */
require_once 'DB/DataObject.php';

class DataObjects_Situacioncarreraestudiante extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'situacioncarreraestudiante';      // table name
    public $codigosituacioncarreraestudiante;    // string(3)  not_null primary_key
    public $nombresituacioncarreraestudiante;    // string(100)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Situacioncarreraestudiante',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
