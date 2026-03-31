<?php
/**
 * Table Definition for estudiantearp
 */
require_once 'DB/DataObject.php';

class DataObjects_Estudiantearp extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'estudiantearp';                   // table name
    var $idestudiantearp;                 // int(11)  not_null primary_key auto_increment
    var $idestudiantegeneral;             // int(11)  not_null multiple_key
    var $idempresasalud;                  // int(11)  not_null multiple_key
    var $fechainicioestudiantearp;        // datetime(19)  not_null binary
    var $fechafinalestudiantearp;         // datetime(19)  not_null binary
    var $observacionarp;                  // string(100)  not_null

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Estudiantearp',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
