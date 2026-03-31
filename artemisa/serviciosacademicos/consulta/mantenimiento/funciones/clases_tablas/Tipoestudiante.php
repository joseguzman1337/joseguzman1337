<?php
/**
 * Table Definition for tipoestudiante
 */
require_once 'DB/DataObject.php';

class DataObjects_Tipoestudiante extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'tipoestudiante';                  // table name
    public $codigotipoestudiante;            // string(2)  not_null primary_key
    public $nombretipoestudiante;            // string(25)  not_null
    public $codigoreferenciatipoestudiante;    // string(3)  not_null multiple_key

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Tipoestudiante',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
