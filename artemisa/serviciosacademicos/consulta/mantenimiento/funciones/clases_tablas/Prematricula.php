<?php
/**
 * Table Definition for prematricula
 */
require_once 'DB/DataObject.php';

class DataObjects_Prematricula extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'prematricula';                    // table name
    public $idprematricula;                  // int(11)  not_null primary_key auto_increment
    public $fechaprematricula;               // date(10)  not_null binary
    public $codigoestudiante;                // int(11)  not_null multiple_key
    public $codigoperiodo;                   // string(8)  not_null multiple_key
    public $codigoestadoprematricula;        // string(2)  not_null multiple_key
    public $observacionprematricula;         // string(100)  
    public $semestreprematricula;            // string(2)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Prematricula',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
