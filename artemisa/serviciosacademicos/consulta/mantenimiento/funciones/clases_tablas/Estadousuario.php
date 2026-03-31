<?php
/**
 * Table Definition for estadousuario
 */
require_once 'DB/DataObject.php';

class DataObjects_Estadousuario extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'estadousuario';                   // table name
    public $codigoestadousuario;             // string(3)  not_null primary_key
    public $nombreestadousuario;             // string(50)  not_null
    public $codigoestado;                    // string(3)  not_null multiple_key

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Estadousuario',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
