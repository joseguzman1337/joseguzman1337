<?php
/**
 * Table Definition for sitioadmision
 */
require_once 'DB/DataObject.php';

class DataObjects_Sitioadmision extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'sitioadmision';                   // table name
    var $idsitioadmision;                 // int(11)  not_null primary_key auto_increment
    var $nombresitioadmision;             // string(100)  not_null
    var $direccionsitioadmision;          // string(100)  not_null
    var $telefonositioadmision;           // string(30)  not_null
    var $nombreresponsablesitioadmision;    // string(100)  not_null
    var $codigoestado;                    // string(3)  not_null multiple_key
    var $capacidadsitioadmision;          // int(6)  not_null
    var $codigocarrera;                   // int(11)  not_null multiple_key

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Sitioadmision',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
