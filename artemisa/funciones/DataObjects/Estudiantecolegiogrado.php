<?php
/**
 * Table Definition for estudiantecolegiogrado
 */
require_once 'DB/DataObject.php';

class DataObjects_Estudiantecolegiogrado extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'estudiantecolegiogrado';          // table name
    var $idestudiantecolegiogrado;        // int(11)  not_null primary_key auto_increment
    var $codigoestudiante;                // int(11)  not_null multiple_key
    var $codigoperiodo;                   // string(8)  not_null multiple_key
    var $codigoestado;                    // string(3)  not_null multiple_key
    var $idgrado;                         // int(11)  not_null multiple_key

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Estudiantecolegiogrado',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
