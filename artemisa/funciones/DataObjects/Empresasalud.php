<?php
/**
 * Table Definition for empresasalud
 */
require_once 'DB/DataObject.php';

class DataObjects_Empresasalud extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'empresasalud';                    // table name
    var $idempresasalud;                  // int(11)  not_null primary_key auto_increment
    var $nombreempresasalud;              // string(50)  not_null
    var $direccionempresasalud;           // string(50)  not_null
    var $telefonoempresasalud;            // string(30)  not_null
    var $contactoempresasalud;            // string(50)  not_null
    var $codigotipoempresasalud;          // string(3)  not_null multiple_key

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Empresasalud',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
