<?php
/**
 * Table Definition for estudiantedocumento
 */
require_once 'DB/DataObject.php';

class DataObjects_Estudiantedocumento extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'estudiantedocumento';             // table name
    public $idestudiantedocumento;           // int(11)  not_null primary_key auto_increment
    public $idestudiantegeneral;             // int(11)  not_null multiple_key
    public $tipodocumento;                   // string(2)  not_null multiple_key
    public $numerodocumento;                 // string(15)  not_null multiple_key
    public $expedidodocumento;               // string(30)  not_null
    public $fechainicioestudiantedocumento;    // date(10)  not_null binary
    public $fechavencimientoestudiantedocumento;    // date(10)  not_null binary

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Estudiantedocumento',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
