<?php
/**
 * Table Definition for tipoestudianteaspectospersonales
 */
require_once 'DB/DataObject.php';

class DataObjects_Tipoestudianteaspectospersonales extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'tipoestudianteaspectospersonales';    // table name
    public $idtipoestudianteaspectospersonales;    // int(11)  not_null primary_key auto_increment
    public $nombretipoestudianteaspectospersonales;    // string(100)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Tipoestudianteaspectospersonales',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
