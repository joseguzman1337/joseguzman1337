<?php
/**
 * Table Definition for tipoestudianteaspectospersonales
 */
require_once 'DB/DataObject.php';

class DataObjects_Tipoestudianteaspectospersonales extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'tipoestudianteaspectospersonales';    // table name
    var $idtipoestudianteaspectospersonales;    // int(11)  not_null primary_key auto_increment
    var $nombretipoestudianteaspectospersonales;    // string(100)  not_null

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Tipoestudianteaspectospersonales',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
