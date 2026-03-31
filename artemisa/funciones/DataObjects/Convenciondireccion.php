<?php
/**
 * Table Definition for convenciondireccion
 */
require_once 'DB/DataObject.php';

class DataObjects_Convenciondireccion extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'convenciondireccion';             // table name
    var $idconvenciondireccion;           // int(11)  not_null primary_key auto_increment
    var $nombrecortoconvenciondireccion;    // string(10)  not_null unique_key
    var $nombreconvenciondireccion;       // string(50)  not_null
    var $fechainicioconvenciondireccion;    // datetime(19)  not_null binary
    var $fechafinalconvenciondireccion;    // datetime(19)  not_null binary
    var $codigotipoconvenciondireccion;    // string(3)  not_null multiple_key

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Convenciondireccion',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
