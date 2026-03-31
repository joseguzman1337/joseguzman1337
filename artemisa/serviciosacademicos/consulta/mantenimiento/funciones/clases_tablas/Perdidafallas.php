<?php
/**
 * Table Definition for perdidafallas
 */
require_once 'DB/DataObject.php';

class DataObjects_Perdidafallas extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'perdidafallas';                   // table name
    public $idperdidafallas;                 // int(11)  not_null primary_key auto_increment
    public $fechaperdidafallas;              // datetime(19)  not_null binary
    public $codigoestudiante;                // int(11)  not_null multiple_key
    public $codigoperiodo;                   // string(8)  not_null multiple_key
    public $numeroautorizaperdidafallas;     // int(6)  not_null
    public $fechainicioautorizaperdidafallas;    // datetime(19)  not_null binary
    public $fechafinalautorizaperdidafallas;    // datetime(19)  not_null binary
    public $usuario;                         // string(50)  not_null multiple_key

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Perdidafallas',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
