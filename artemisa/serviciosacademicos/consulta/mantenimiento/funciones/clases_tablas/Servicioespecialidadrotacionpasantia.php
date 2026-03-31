<?php
/**
 * Table Definition for servicioespecialidadrotacionpasantia
 */
require_once 'DB/DataObject.php';

class DataObjects_Servicioespecialidadrotacionpasantia extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'servicioespecialidadrotacionpasantia';    // table name
    public $idservicioespecialidadrotacionpasantia;    // int(11)  not_null primary_key auto_increment
    public $nombreservicioespecialidadrotacionpasantia;    // string(100)  not_null
    public $fechaservicioespecialidadrotacionpasantia;    // date(10)  not_null binary
    public $idtiposervicioespecialidadrotacionpasantia;    // int(11)  not_null multiple_key
    public $codigoestado;                    // string(3)  not_null multiple_key

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Servicioespecialidadrotacionpasantia',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
