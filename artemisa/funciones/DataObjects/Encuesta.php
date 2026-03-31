<?php
/**
 * Table Definition for encuesta
 */
require_once 'DB/DataObject.php';

class DataObjects_Encuesta extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'encuesta';                        // table name
    var $idencuesta;                      // int(11)  not_null primary_key auto_increment
    var $fechaencuesta;                   // datetime(19)  not_null binary
    var $nombreencuesta;                  // string(200)  not_null
    var $responsableencuesta;             // string(100)  not_null
    var $codigoperiodo;                   // string(8)  not_null multiple_key
    var $codigocarrera;                   // int(11)  not_null multiple_key
    var $codigoestado;                    // string(3)  not_null multiple_key
    var $fechainicialencuesta;            // datetime(19)  not_null binary
    var $fechafinalencuesta;              // datetime(19)  not_null binary
    var $diriguidoencuesta;               // string(80)  not_null

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Encuesta',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
