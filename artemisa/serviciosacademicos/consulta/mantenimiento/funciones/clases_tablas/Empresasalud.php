<?php
/**
 * Table Definition for empresasalud
 */
require_once 'DB/DataObject.php';

class DataObjects_Empresasalud extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'empresasalud';                    // table name
    public $idempresasalud;                  // int(11)  not_null primary_key auto_increment
    public $nombreempresasalud;              // string(50)  not_null
    public $direccionempresasalud;           // string(50)  not_null
    public $telefonoempresasalud;            // string(30)  not_null
    public $contactoempresasalud;            // string(50)  not_null
    public $codigotipoempresasalud;          // string(3)  not_null multiple_key

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Empresasalud',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
