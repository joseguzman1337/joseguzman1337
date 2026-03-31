<?php
/**
 * Table Definition for tiposervicioespecialidadrotacionpasantia
 */
require_once 'DB/DataObject.php';

class DataObjects_Tiposervicioespecialidadrotacionpasantia extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'tiposervicioespecialidadrotacionpasantia';    // table name
    public $idtiposervicioespecialidadrotacionpasantia;    // int(11)  not_null primary_key auto_increment
    public $nombretiposervicioespecialidadrotacionpasantia;    // string(50)  not_null
    public $codigoestado;                    // string(3)  not_null multiple_key

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Tiposervicioespecialidadrotacionpasantia',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
