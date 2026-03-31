<?php
/**
 * Table Definition for prematricula
 */
require_once 'DB/DataObject.php';

class DataObjects_Prematricula extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'prematricula';                    // table name
    var $idprematricula;                  // int(11)  not_null primary_key auto_increment
    var $fechaprematricula;               // date(10)  not_null binary
    var $codigoestudiante;                // int(11)  not_null multiple_key
    var $codigoperiodo;                   // string(8)  not_null multiple_key
    var $codigoestadoprematricula;        // string(2)  not_null multiple_key
    var $observacionprematricula;         // string(100)  
    var $semestreprematricula;            // string(2)  not_null

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Prematricula',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
