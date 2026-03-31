<?php
/**
 * Table Definition for estudiantedocumento
 */
require_once 'DB/DataObject.php';

class DataObjects_Estudiantedocumento extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'estudiantedocumento';             // table name
    var $idestudiantedocumento;           // int(11)  not_null primary_key auto_increment
    var $idestudiantegeneral;             // int(11)  not_null multiple_key
    var $tipodocumento;                   // string(2)  not_null multiple_key
    var $numerodocumento;                 // string(15)  not_null multiple_key
    var $expedidodocumento;               // string(30)  not_null
    var $fechainicioestudiantedocumento;    // date(10)  not_null binary
    var $fechavencimientoestudiantedocumento;    // date(10)  not_null binary

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Estudiantedocumento',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
