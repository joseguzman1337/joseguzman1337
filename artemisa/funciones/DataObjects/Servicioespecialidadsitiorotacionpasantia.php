<?php
/**
 * Table Definition for servicioespecialidadsitiorotacionpasantia
 */
require_once 'DB/DataObject.php';

class DataObjects_Servicioespecialidadsitiorotacionpasantia extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'servicioespecialidadsitiorotacionpasantia';    // table name
    var $idservicioespecialidadsitiorotacionpasantia;    // int(11)  not_null primary_key auto_increment
    var $fechaservicioespecialidadsitiorotacionpasantia;    // date(10)  not_null binary
    var $codigocarrera;                   // int(11)  not_null multiple_key
    var $idservicioespecialidadrotacionpasantia;    // int(11)  not_null multiple_key
    var $idsitiorotacionpasantia;         // int(11)  not_null multiple_key
    var $codigoestado;                    // string(3)  not_null multiple_key

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Servicioespecialidadsitiorotacionpasantia',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
