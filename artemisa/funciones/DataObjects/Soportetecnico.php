<?php
/**
 * Table Definition for soportetecnico
 */
require_once 'DB/DataObject.php';

class DataObjects_Soportetecnico extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'soportetecnico';                  // table name
    var $idsoportetecnico;                // int(11)  not_null primary_key auto_increment
    var $fechasoportetecnico;             // datetime(19)  not_null binary
    var $fechacierresoportetecnico;       // datetime(19)  not_null binary
    var $codigoestadoprioridadsoportetecnico;    // string(3)  not_null multiple_key
    var $codigoestadosoportetecnico;      // string(3)  not_null multiple_key
    var $idmodulosoportetecnico;          // int(11)  not_null multiple_key

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Soportetecnico',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
