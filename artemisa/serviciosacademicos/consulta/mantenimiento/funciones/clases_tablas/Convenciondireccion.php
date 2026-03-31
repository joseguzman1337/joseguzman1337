<?php
/**
 * Table Definition for convenciondireccion
 */
require_once 'DB/DataObject.php';

class DataObjects_Convenciondireccion extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'convenciondireccion';             // table name
    public $idconvenciondireccion;           // int(11)  not_null primary_key auto_increment
    public $nombrecortoconvenciondireccion;    // string(10)  not_null unique_key
    public $nombreconvenciondireccion;       // string(50)  not_null
    public $fechainicioconvenciondireccion;    // datetime(19)  not_null binary
    public $fechafinalconvenciondireccion;    // datetime(19)  not_null binary
    public $codigotipoconvenciondireccion;    // string(3)  not_null multiple_key

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Convenciondireccion',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
