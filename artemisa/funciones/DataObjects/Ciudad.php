<?php
/**
 * Table Definition for ciudad
 */
require_once 'DB/DataObject.php';

class DataObjects_Ciudad extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'ciudad';                          // table name
    var $idciudad;                        // int(11)  not_null primary_key auto_increment
    var $nombrecortociudad;               // string(100)  not_null
    var $nombreciudad;                    // string(100)  not_null
    var $iddepartamento;                  // int(11)  not_null multiple_key
    var $codigosapciudad;                 // string(20)  not_null
    var $codigoestado;                    // string(3)  not_null multiple_key

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Ciudad',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
