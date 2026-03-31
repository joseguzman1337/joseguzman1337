<?php
/**
 * Table Definition for estudiantearp
 */
require_once 'DB/DataObject.php';

class DataObjects_Estudiantearp extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'estudiantearp';                   // table name
    public $idestudiantearp;                 // int(11)  not_null primary_key auto_increment
    public $idestudiantegeneral;             // int(11)  not_null multiple_key
    public $idempresasalud;                  // int(11)  not_null multiple_key
    public $fechainicioestudiantearp;        // datetime(19)  not_null binary
    public $fechafinalestudiantearp;         // datetime(19)  not_null binary
    public $observacionarp;                  // string(100)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Estudiantearp',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
