<?php
/**
 * Table Definition for aplicacion
 */
require_once '../funciones/pear/DB/DataObject.php';

class DataObjects_Aplicacion extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'aplicacion';                      // table name
    var $idaplicacion;                    // int(11)  not_null primary_key auto_increment
    var $nombreaplicacion;                // string(100)  not_null
    var $codigoestado;                    // string(3)  not_null multiple_key

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Aplicacion',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
