<?php
/**
 * Table Definition for situacioncarreraestudiante
 */
require_once 'DB/DataObject.php';

class DataObjects_Situacioncarreraestudiante extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'situacioncarreraestudiante';      // table name
    var $codigosituacioncarreraestudiante;    // string(3)  not_null primary_key
    var $nombresituacioncarreraestudiante;    // string(100)  not_null

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Situacioncarreraestudiante',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
