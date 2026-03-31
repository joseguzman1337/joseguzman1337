<?php
/**
 * Table Definition for servicioespecialidadsitiorotacionpasantia
 */
require_once 'DB/DataObject.php';

class DataObjects_Servicioespecialidadsitiorotacionpasantia extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'servicioespecialidadsitiorotacionpasantia';    // table name
    public $idservicioespecialidadsitiorotacionpasantia;    // int(11)  not_null primary_key auto_increment
    public $fechaservicioespecialidadsitiorotacionpasantia;    // date(10)  not_null binary
    public $codigocarrera;                   // int(11)  not_null multiple_key
    public $idservicioespecialidadrotacionpasantia;    // int(11)  not_null multiple_key
    public $idsitiorotacionpasantia;         // int(11)  not_null multiple_key
    public $codigoestado;                    // string(3)  not_null multiple_key

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Servicioespecialidadsitiorotacionpasantia',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
