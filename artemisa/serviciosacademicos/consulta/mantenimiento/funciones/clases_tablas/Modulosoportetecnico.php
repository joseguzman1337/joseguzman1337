<?php
/**
 * Table Definition for modulosoportetecnico
 */
require_once '../funciones/pear/DB/DataObject.php';

class DataObjects_Modulosoportetecnico extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'modulosoportetecnico';            // table name
    var $idmodulosoportetecnico;          // int(11)  not_null primary_key auto_increment
    var $nombremodulosoportetecnico;      // string(50)  not_null
    var $codigoestado;                    // string(3)  not_null multiple_key
    var $idaplicacion;                    // int(11)  not_null multiple_key
    var $iddirectivo;                     // int(11)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Modulosoportetecnico',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
